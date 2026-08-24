<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\SatuanModel;

class Produk extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('q');
        $builder = $this->produkModel->select('produk.*, kategori.nama as kategori, satuan.nama as satuan')
            ->join('kategori', 'kategori.id = produk.kategori_id', 'left')
            ->join('satuan', 'satuan.id = produk.satuan_id', 'left')
            ->orderBy('produk.id', 'DESC');

        if ($keyword) {
            $builder->groupStart()->like('produk.nama', $keyword)->orLike('produk.kode', $keyword)->orLike('produk.barcode', $keyword)->groupEnd();
        }

        return view('produk/index', [
            'title'   => 'Data Produk',
            'produk'  => $builder->paginate(15, 'produk'),
            'pager'   => $this->produkModel->pager,
            'keyword' => $keyword,
        ]);
    }

    public function tambah()
    {
        return view('produk/form', [
            'title'    => 'Tambah Produk',
            'produk'   => null,
            'kategori' => (new KategoriModel())->findAll(),
            'satuan'   => (new SatuanModel())->findAll(),
            'kode'     => $this->generateKode(),
        ]);
    }

    public function edit($id)
    {
        $produk = $this->produkModel->find($id);
        if (!$produk) {
            return redirect()->to('/produk')->with('error', 'Produk tidak ditemukan');
        }
        return view('produk/form', [
            'title'    => 'Edit Produk',
            'produk'   => $produk,
            'kategori' => (new KategoriModel())->findAll(),
            'satuan'   => (new SatuanModel())->findAll(),
            'kode'     => $produk['kode'],
        ]);
    }

    public function simpan()
    {
        $id = $this->request->getPost('id');
        $rules = [
            'kode'       => "required|is_unique[produk.kode,id,$id]",
            'nama'       => 'required|max_length[150]',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok'       => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'kode'        => $this->request->getPost('kode'),
            'barcode'     => $this->request->getPost('barcode'),
            'nama'        => $this->request->getPost('nama'),
            'kategori_id' => $this->request->getPost('kategori_id') ?: null,
            'satuan_id'   => $this->request->getPost('satuan_id') ?: null,
            'harga_beli'  => $this->request->getPost('harga_beli'),
            'harga_jual'  => $this->request->getPost('harga_jual'),
            'stok'        => $this->request->getPost('stok'),
            'stok_min'    => $this->request->getPost('stok_min') ?: 5,
            'aktif'       => $this->request->getPost('aktif') ? 1 : 0,
        ];

        $gambar = $this->request->getFile('gambar');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $nama = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads/produk', $nama);
            $data['gambar'] = $nama;
            if ($id) {
                $lama = $this->produkModel->find($id);
                if ($lama['gambar'] && file_exists(FCPATH . 'uploads/produk/' . $lama['gambar'])) {
                    unlink(FCPATH . 'uploads/produk/' . $lama['gambar']);
                }
            }
        }

        if ($id) {
            $this->produkModel->update($id, $data);
            $pesan = 'Produk berhasil diperbarui';
        } else {
            $this->produkModel->insert($data);
            $pesan = 'Produk berhasil ditambahkan';
        }

        return redirect()->to('/produk')->with('success', $pesan);
    }

    public function hapus($id)
    {
        $produk = $this->produkModel->find($id);
        if ($produk) {
            if ($produk['gambar'] && file_exists(FCPATH . 'uploads/produk/' . $produk['gambar'])) {
                unlink(FCPATH . 'uploads/produk/' . $produk['gambar']);
            }
            $this->produkModel->delete($id);
        }
        return redirect()->to('/produk')->with('success', 'Produk berhasil dihapus');
    }

    public function cariAjax()
    {
        $keyword = $this->request->getGet('q');
        $produk = $this->produkModel->where('aktif', 1)->where('stok >', 0)
            ->groupStart()->like('nama', $keyword)->orLike('kode', $keyword)->orLike('barcode', $keyword)->groupEnd()
            ->limit(10)->findAll();
        return $this->response->setJSON($produk);
    }

    private function generateKode(): string
    {
        $last = $this->produkModel->orderBy('id', 'DESC')->first();
        $next = $last ? ((int) substr($last['kode'], 3)) + 1 : 1;
        return 'PRD' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
