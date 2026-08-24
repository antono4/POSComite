<?php

namespace App\Controllers;

use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\ProdukModel;

class Penjualan extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PenjualanModel();
    }

    public function index()
    {
        $dari = $this->request->getGet('dari') ?: date('Y-m-01');
        $sampai = $this->request->getGet('sampai') ?: date('Y-m-d');

        $db = \Config\Database::connect();
        $builder = $db->table('penjualan p')
            ->select('p.*, u.nama as kasir, pl.nama as pelanggan')
            ->join('users u', 'u.id = p.user_id')
            ->join('pelanggan pl', 'pl.id = p.pelanggan_id', 'left')
            ->where('DATE(p.tanggal) >=', $dari)
            ->where('DATE(p.tanggal) <=', $sampai)
            ->orderBy('p.id', 'DESC');

        return view('penjualan/index', [
            'title'     => 'Riwayat Penjualan',
            'penjualan' => $builder->get()->getResultArray(),
            'dari'      => $dari,
            'sampai'    => $sampai,
        ]);
    }

    public function detail($id)
    {
        $db = \Config\Database::connect();
        $penjualan = $db->table('penjualan p')
            ->select('p.*, u.nama as kasir, pl.nama as pelanggan')
            ->join('users u', 'u.id = p.user_id')
            ->join('pelanggan pl', 'pl.id = p.pelanggan_id', 'left')
            ->where('p.id', $id)->get()->getRowArray();

        if (!$penjualan) {
            return redirect()->to('/penjualan')->with('error', 'Transaksi tidak ditemukan');
        }

        $detail = (new PenjualanDetailModel())->where('penjualan_id', $id)->findAll();

        return view('penjualan/detail', [
            'title'     => 'Detail Transaksi ' . $penjualan['no_invoice'],
            'penjualan' => $penjualan,
            'detail'    => $detail,
        ]);
    }

    public function struk($id)
    {
        $penjualan = $this->model->find($id);
        if (!$penjualan) {
            return redirect()->to('/penjualan')->with('error', 'Transaksi tidak ditemukan');
        }
        $detail = (new PenjualanDetailModel())->where('penjualan_id', $id)->findAll();
        $db = \Config\Database::connect();
        $kasir = $db->table('users')->where('id', $penjualan['user_id'])->get()->getRowArray();
        $pelanggan = $penjualan['pelanggan_id'] ? $db->table('pelanggan')->where('id', $penjualan['pelanggan_id'])->get()->getRowArray() : null;

        return view('penjualan/struk', [
            'penjualan' => $penjualan,
            'detail'    => $detail,
            'kasir'     => $kasir,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function batal($id)
    {
        $penjualan = $this->model->find($id);
        if (!$penjualan || $penjualan['status'] === 'batal') {
            return redirect()->to('/penjualan')->with('error', 'Transaksi tidak valid');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Kembalikan stok
        $detail = (new PenjualanDetailModel())->where('penjualan_id', $id)->findAll();
        $produkModel = new ProdukModel();
        foreach ($detail as $d) {
            $produkModel->set('stok', 'stok + ' . (int) $d['qty'], false)->where('id', $d['produk_id'])->update();
        }

        $this->model->update($id, ['status' => 'batal']);
        $db->transComplete();

        return redirect()->to('/penjualan')->with('success', 'Transaksi dibatalkan dan stok dikembalikan');
    }
}
