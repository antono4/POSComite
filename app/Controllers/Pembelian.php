<?php

namespace App\Controllers;

use App\Models\PembelianModel;
use App\Models\PembelianDetailModel;
use App\Models\ProdukModel;
use App\Models\SupplierModel;

class Pembelian extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PembelianModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $pembelian = $db->table('pembelian pb')
            ->select('pb.*, s.nama as supplier, u.nama as user')
            ->join('supplier s', 's.id = pb.supplier_id', 'left')
            ->join('users u', 'u.id = pb.user_id')
            ->orderBy('pb.id', 'DESC')->get()->getResultArray();

        return view('pembelian/index', [
            'title'     => 'Pembelian / Restock',
            'pembelian' => $pembelian,
        ]);
    }

    public function tambah()
    {
        return view('pembelian/form', [
            'title'     => 'Tambah Pembelian',
            'supplier'  => (new SupplierModel())->findAll(),
            'produk'    => (new ProdukModel())->where('aktif', 1)->findAll(),
            'no_faktur' => $this->generateFaktur(),
        ]);
    }

    public function simpan()
    {
        $items = json_decode($this->request->getPost('items'), true);
        if (empty($items)) {
            return redirect()->back()->with('error', 'Daftar item pembelian kosong');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $total = array_sum(array_column($items, 'subtotal'));
        $pembelianId = $this->model->insert([
            'no_faktur'   => $this->generateFaktur(),
            'tanggal'     => $this->request->getPost('tanggal') ?: date('Y-m-d'),
            'supplier_id' => $this->request->getPost('supplier_id') ?: null,
            'user_id'     => session()->get('user_id'),
            'total'       => $total,
            'status'      => 'diterima',
        ]);

        $detailModel = new PembelianDetailModel();
        $produkModel = new ProdukModel();
        foreach ($items as $item) {
            $detailModel->insert([
                'pembelian_id' => $pembelianId,
                'produk_id'    => $item['id'],
                'harga_beli'   => $item['harga_beli'],
                'qty'          => $item['qty'],
                'subtotal'     => $item['subtotal'],
            ]);
            // Tambah stok & update harga beli
            $produkModel->set('stok', 'stok + ' . (int) $item['qty'], false)
                ->set('harga_beli', $item['harga_beli'])
                ->where('id', $item['id'])->update();
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Pembelian gagal disimpan');
        }

        return redirect()->to('/pembelian')->with('success', 'Pembelian berhasil disimpan, stok diperbarui');
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();
        $pembelian = $db->table('pembelian pb')
            ->select('pb.*, s.nama as supplier, u.nama as user')
            ->join('supplier s', 's.id = pb.supplier_id', 'left')
            ->join('users u', 'u.id = pb.user_id')
            ->where('pb.id', $id)->get()->getRowArray();

        if (!$pembelian) {
            return redirect()->to('/pembelian')->with('error', 'Pembelian tidak ditemukan');
        }

        $detail = $db->table('pembelian_detail pd')
            ->select('pd.*, p.nama as produk, p.kode')
            ->join('produk p', 'p.id = pd.produk_id')
            ->where('pd.pembelian_id', $id)->get()->getResultArray();

        return view('pembelian/detail', [
            'title'     => 'Detail Pembelian ' . $pembelian['no_faktur'],
            'pembelian' => $pembelian,
            'detail'    => $detail,
        ]);
    }

    private function generateFaktur(): string
    {
        $prefix = 'PB-' . date('Ymd') . '-';
        $last = $this->model->like('no_faktur', $prefix, 'after')->orderBy('id', 'DESC')->first();
        $next = $last ? ((int) substr($last['no_faktur'], -4)) + 1 : 1;
        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}
