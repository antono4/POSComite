<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::login');

// Auth
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::prosesLogin');
$routes->get('logout', 'Auth::logout');

// Area yang butuh login
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');

    // Kasir / POS
    $routes->get('kasir', 'Kasir::index');
    $routes->post('kasir/simpan', 'Kasir::simpan');

    // Produk
    $routes->get('produk', 'Produk::index');
    $routes->get('produk/tambah', 'Produk::tambah');
    $routes->get('produk/edit/(:num)', 'Produk::edit/$1');
    $routes->post('produk/simpan', 'Produk::simpan');
    $routes->get('produk/hapus/(:num)', 'Produk::hapus/$1');
    $routes->get('produk/cari', 'Produk::cariAjax');

    // Master data (CRUD sederhana via modal)
    foreach (['kategori' => 'Kategori', 'satuan' => 'Satuan', 'supplier' => 'Supplier', 'pelanggan' => 'Pelanggan', 'pengeluaran' => 'Pengeluaran'] as $uri => $ctrl) {
        $routes->get($uri, "$ctrl::index");
        $routes->post("$uri/simpan", "$ctrl::simpan");
        $routes->get("$uri/hapus/(:num)", "$ctrl::hapus/$1");
    }

    // Penjualan
    $routes->get('penjualan', 'Penjualan::index');
    $routes->get('penjualan/detail/(:num)', 'Penjualan::detail/$1');
    $routes->get('penjualan/struk/(:num)', 'Penjualan::struk/$1');
    $routes->get('penjualan/batal/(:num)', 'Penjualan::batal/$1');

    // Pembelian
    $routes->get('pembelian', 'Pembelian::index');
    $routes->get('pembelian/tambah', 'Pembelian::tambah');
    $routes->post('pembelian/simpan', 'Pembelian::simpan');
    $routes->get('pembelian/detail/(:num)', 'Pembelian::detail/$1');

    // Laporan
    $routes->get('laporan/penjualan', 'Laporan::penjualan');
    $routes->get('laporan/stok', 'Laporan::stok');
    $routes->get('laporan/terlaris', 'Laporan::produkTerlaris');

    // Admin only
    $routes->group('', ['filter' => 'auth:admin'], function ($routes) {
        $routes->get('pengguna', 'Pengguna::index');
        $routes->post('pengguna/simpan', 'Pengguna::simpan');
        $routes->get('pengguna/hapus/(:num)', 'Pengguna::hapus/$1');
        $routes->get('pengaturan', 'Pengaturan::index');
        $routes->post('pengaturan/simpan', 'Pengaturan::simpan');
    });
});
