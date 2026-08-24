<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'POS') ?> | <?= esc(pengaturan('nama_toko', 'POS Comite')) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/select2/css/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/toastr/toastr.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
    <?= $this->renderSection('css') ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= base_url('dashboard') ?>" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= base_url('kasir') ?>" class="nav-link"><i class="fas fa-cash-register"></i> Kasir</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i> <?= esc(session()->get('nama')) ?>
                    <span class="badge badge-info"><?= esc(ucfirst(session()->get('role'))) ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="<?= base_url('logout') ?>" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?= base_url('dashboard') ?>" class="brand-link text-center">
            <span class="brand-text font-weight-bold"><i class="fas fa-store"></i> <?= esc(pengaturan('nama_toko', 'POS Comite')) ?></span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <?php $uri = service('uri')->getSegment(1); $uri2 = service('uri')->getSegment(2); ?>
                    <li class="nav-item">
                        <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $uri === 'dashboard' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('kasir') ?>" class="nav-link <?= $uri === 'kasir' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-cash-register"></i><p>Kasir / POS</p>
                        </a>
                    </li>
                    <li class="nav-header">MASTER DATA</li>
                    <li class="nav-item">
                        <a href="<?= base_url('produk') ?>" class="nav-link <?= $uri === 'produk' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-box"></i><p>Produk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('kategori') ?>" class="nav-link <?= $uri === 'kategori' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tags"></i><p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('satuan') ?>" class="nav-link <?= $uri === 'satuan' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-balance-scale"></i><p>Satuan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('supplier') ?>" class="nav-link <?= $uri === 'supplier' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-truck"></i><p>Supplier</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('pelanggan') ?>" class="nav-link <?= $uri === 'pelanggan' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i><p>Pelanggan</p>
                        </a>
                    </li>
                    <li class="nav-header">TRANSAKSI</li>
                    <li class="nav-item">
                        <a href="<?= base_url('penjualan') ?>" class="nav-link <?= $uri === 'penjualan' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-shopping-cart"></i><p>Penjualan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('pembelian') ?>" class="nav-link <?= $uri === 'pembelian' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-dolly"></i><p>Pembelian</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('pengeluaran') ?>" class="nav-link <?= $uri === 'pengeluaran' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-money-bill-wave"></i><p>Pengeluaran</p>
                        </a>
                    </li>
                    <li class="nav-header">LAPORAN</li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan/penjualan') ?>" class="nav-link <?= $uri === 'laporan' && $uri2 === 'penjualan' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-chart-line"></i><p>Laporan Penjualan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan/stok') ?>" class="nav-link <?= $uri === 'laporan' && $uri2 === 'stok' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-boxes"></i><p>Laporan Stok</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('laporan/terlaris') ?>" class="nav-link <?= $uri === 'laporan' && $uri2 === 'terlaris' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-star"></i><p>Produk Terlaris</p>
                        </a>
                    </li>
                    <?php if (session()->get('role') === 'admin'): ?>
                    <li class="nav-header">PENGATURAN</li>
                    <li class="nav-item">
                        <a href="<?= base_url('pengguna') ?>" class="nav-link <?= $uri === 'pengguna' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user-cog"></i><p>Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('pengaturan') ?>" class="nav-link <?= $uri === 'pengaturan' ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-cogs"></i><p>Pengaturan Toko</p>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0"><?= esc($title ?? '') ?></h1>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <?= $this->renderSection('content') ?>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>&copy; <?= date('Y') ?> <?= esc(pengaturan('nama_toko', 'POS Comite')) ?>.</strong> Point of Sale System
    </footer>
</div>

<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/select2/js/select2.full.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/toastr/toastr.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js') ?>"></script>
<script>
$(function () {
    $('.datatable').DataTable({responsive: true, autoWidth: false});
    $('.select2').select2();
    <?php if (session()->getFlashdata('success')): ?>
    toastr.success('<?= session()->getFlashdata('success') ?>');
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    toastr.error('<?= session()->getFlashdata('error') ?>');
    <?php endif; ?>
});
function confirmHapus(url) {
    if (confirm('Yakin ingin menghapus data ini?')) window.location.href = url;
}
</script>
<?= $this->renderSection('js') ?>
</body>
</html>
