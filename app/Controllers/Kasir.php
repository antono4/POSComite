<?php

namespace App\Controllers;

use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\ProdukModel;
use App\Models\PelangganModel;

class Kasir extends BaseController
{
    public function index()
    {
        return view('kasir/index', [
            'title'     => 'Kasir / Point of Sale',
            'pelanggan' => (new PelangganModel())->findAll(),
            'no_invoice' => $this->generateInvoice(),
        ]);
    }

    public function simpan()
    {
        $json = $this->request->getPost('keranjang');
        $keranjang = json_decode($json, true);

        if (empty($keranjang)) {
            return redirect()->back()->with('error', 'Keranjang belanja kosong');
        }

        $db = \Config\Database::connect();
        $produkModel = new ProdukModel();

        // Validasi stok
        foreach ($keranjang as $item) {
            $produk = $produkModel->find($item['id']);
            if (!$produk) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan: ' . $item['nama']);
            }
            if ($produk['stok'] < $item['qty']) {
                return redirect()->back()->with('error', 'Stok ' . $produk['nama'] . ' tidak cukup (sisa: ' . $produk['stok'] . ')');
            }
        }

        $subtotal = array_sum(array_column($keranjang, 'subtotal'));
        $diskon = (float) $this->request->getPost('diskon') ?: 0;
        $pajak = (float) $this->request->getPost('pajak') ?: 0;
        $total = $subtotal - $diskon + $pajak;
        $bayar = (float) $this->request->getPost('bayar');

        if ($bayar < $total) {
            return redirect()->back()->with('error', 'Jumlah bayar kurang dari total belanja');
        }

        $db->transStart();

        $penjualanModel = new PenjualanModel();
        $penjualanId = $penjualanModel->insert([
            'no_invoice'   => $this->generateInvoice(),
            'tanggal'      => date('Y-m-d H:i:s'),
            'pelanggan_id' => $this->request->getPost('pelanggan_id') ?: null,
            'user_id'      => session()->get('user_id'),
            'subtotal'     => $subtotal,
            'diskon'       => $diskon,
            'pajak'        => $pajak,
            'total'        => $total,
            'bayar'        => $bayar,
            'kembali'      => $bayar - $total,
            'metode_bayar' => $this->request->getPost('metode_bayar') ?: 'tunai',
            'status'       => 'selesai',
            'catatan'      => $this->request->getPost('catatan'),
        ]);

        $detailModel = new PenjualanDetailModel();
        foreach ($keranjang as $item) {
            $detailModel->insert([
                'penjualan_id' => $penjualanId,
                'produk_id'    => $item['id'],
                'kode_produk'  => $item['kode'],
                'nama_produk'  => $item['nama'],
                'harga'        => $item['harga'],
                'qty'          => $item['qty'],
                'diskon'       => $item['diskon'] ?? 0,
                'subtotal'     => $item['subtotal'],
            ]);
            // Kurangi stok
            $produkModel->set('stok', 'stok - ' . (int) $item['qty'], false)->where('id', $item['id'])->update();
        }

        // Tambah poin pelanggan
        $pelangganId = $this->request->getPost('pelanggan_id');
        if ($pelangganId) {
            $poin = floor($total / 10000);
            if ($poin > 0) {
                (new PelangganModel())->set('poin', 'poin + ' . $poin, false)->where('id', $pelangganId)->update();
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Transaksi gagal disimpan');
        }

        return redirect()->to('/penjualan/struk/' . $penjualanId)->with('success', 'Transaksi berhasil disimpan');
    }

    private function generateInvoice(): string
    {
        $prefix = 'INV-' . date('Ymd') . '-';
        $last = (new PenjualanModel())->like('no_invoice', $prefix, 'after')->orderBy('id', 'DESC')->first();
        $next = $last ? ((int) substr($last['no_invoice'], -4)) + 1 : 1;
        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}
