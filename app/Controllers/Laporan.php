<?php

namespace App\Controllers;

class Laporan extends BaseController
{
    public function penjualan()
    {
        $dari = $this->request->getGet('dari') ?: date('Y-m-01');
        $sampai = $this->request->getGet('sampai') ?: date('Y-m-d');

        $db = \Config\Database::connect();
        $penjualan = $db->table('penjualan p')
            ->select('p.*, u.nama as kasir')
            ->join('users u', 'u.id = p.user_id')
            ->where('DATE(p.tanggal) >=', $dari)
            ->where('DATE(p.tanggal) <=', $sampai)
            ->where('p.status', 'selesai')
            ->orderBy('p.tanggal', 'DESC')->get()->getResultArray();

        $totalPendapatan = array_sum(array_column($penjualan, 'total'));
        $totalDiskon = array_sum(array_column($penjualan, 'diskon'));

        // Hitung laba (harga jual - harga beli per item)
        $laba = $db->table('penjualan_detail pd')
            ->select('SUM(pd.subtotal - (pr.harga_beli * pd.qty)) as laba')
            ->join('penjualan p', 'p.id = pd.penjualan_id')
            ->join('produk pr', 'pr.id = pd.produk_id')
            ->where('DATE(p.tanggal) >=', $dari)
            ->where('DATE(p.tanggal) <=', $sampai)
            ->where('p.status', 'selesai')->get()->getRowArray()['laba'] ?? 0;

        return view('laporan/penjualan', [
            'title'           => 'Laporan Penjualan',
            'penjualan'       => $penjualan,
            'dari'            => $dari,
            'sampai'          => $sampai,
            'total_pendapatan' => $totalPendapatan,
            'total_diskon'    => $totalDiskon,
            'laba'            => $laba,
        ]);
    }

    public function stok()
    {
        $db = \Config\Database::connect();
        $produk = $db->table('produk p')
            ->select('p.*, k.nama as kategori, s.nama as satuan, (p.stok * p.harga_beli) as nilai_stok')
            ->join('kategori k', 'k.id = p.kategori_id', 'left')
            ->join('satuan s', 's.id = p.satuan_id', 'left')
            ->orderBy('p.stok', 'ASC')->get()->getResultArray();

        return view('laporan/stok', [
            'title'  => 'Laporan Stok',
            'produk' => $produk,
        ]);
    }

    public function produkTerlaris()
    {
        $dari = $this->request->getGet('dari') ?: date('Y-m-01');
        $sampai = $this->request->getGet('sampai') ?: date('Y-m-d');

        $db = \Config\Database::connect();
        $produk = $db->table('penjualan_detail pd')
            ->select('pd.kode_produk, pd.nama_produk, SUM(pd.qty) as total_qty, SUM(pd.subtotal) as total_penjualan')
            ->join('penjualan p', 'p.id = pd.penjualan_id')
            ->where('DATE(p.tanggal) >=', $dari)
            ->where('DATE(p.tanggal) <=', $sampai)
            ->where('p.status', 'selesai')
            ->groupBy('pd.produk_id')->orderBy('total_qty', 'DESC')->get()->getResultArray();

        return view('laporan/terlaris', [
            'title'  => 'Laporan Produk Terlaris',
            'produk' => $produk,
            'dari'   => $dari,
            'sampai' => $sampai,
        ]);
    }
}
