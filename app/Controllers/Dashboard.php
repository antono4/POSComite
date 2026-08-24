<?php

namespace App\Controllers;

use App\Models\PenjualanModel;
use App\Models\ProdukModel;
use App\Models\PelangganModel;
use App\Models\PengeluaranModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $penjualan = new PenjualanModel();
        $produk = new ProdukModel();

        $hariIni = date('Y-m-d');
        $bulanIni = date('Y-m');

        $data = [
            'title'            => 'Dashboard',
            'penjualan_hari'   => $penjualan->selectSum('total')->where('DATE(tanggal)', $hariIni)->where('status', 'selesai')->first()['total'] ?? 0,
            'transaksi_hari'   => $penjualan->where('DATE(tanggal)', $hariIni)->where('status', 'selesai')->countAllResults(),
            'penjualan_bulan'  => $penjualan->selectSum('total')->like('tanggal', $bulanIni, 'after')->where('status', 'selesai')->first()['total'] ?? 0,
            'total_produk'     => $produk->where('aktif', 1)->countAllResults(),
            'total_pelanggan'  => (new PelangganModel())->countAllResults(),
            'stok_menipis'     => $produk->where('stok <= stok_min')->where('aktif', 1)->findAll(),
            'penjualan_terakhir' => $db->table('penjualan p')
                ->select('p.*, u.nama as kasir')
                ->join('users u', 'u.id = p.user_id')
                ->where('p.status', 'selesai')
                ->orderBy('p.id', 'DESC')->limit(10)->get()->getResultArray(),
            'produk_terlaris'  => $db->table('penjualan_detail pd')
                ->select('pd.nama_produk, SUM(pd.qty) as total_qty, SUM(pd.subtotal) as total_jual')
                ->join('penjualan p', 'p.id = pd.penjualan_id')
                ->where('p.status', 'selesai')
                ->groupBy('pd.produk_id')->orderBy('total_qty', 'DESC')->limit(5)->get()->getResultArray(),
            'grafik'           => $this->grafikPenjualan(),
        ];

        return view('dashboard/index', $data);
    }

    private function grafikPenjualan(): array
    {
        $db = \Config\Database::connect();
        $labels = [];
        $values = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = date('Y-m-d', strtotime("-$i days"));
            $labels[] = date('d/m', strtotime($tgl));
            $row = $db->table('penjualan')->selectSum('total')
                ->where('DATE(tanggal)', $tgl)->where('status', 'selesai')->get()->getRowArray();
            $values[] = (float) ($row['total'] ?? 0);
        }
        return ['labels' => $labels, 'values' => $values];
    }
}
