<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= rupiah($penjualan_hari) ?></h3>
                <p>Penjualan Hari Ini</p>
            </div>
            <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            <a href="<?= base_url('penjualan') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $transaksi_hari ?></h3>
                <p>Transaksi Hari Ini</p>
            </div>
            <div class="icon"><i class="fas fa-shopping-cart"></i></div>
            <a href="<?= base_url('penjualan') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $total_produk ?></h3>
                <p>Total Produk</p>
            </div>
            <div class="icon"><i class="fas fa-box"></i></div>
            <a href="<?= base_url('produk') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= count($stok_menipis) ?></h3>
                <p>Stok Menipis</p>
            </div>
            <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
            <a href="<?= base_url('laporan/stok') ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-line"></i> Grafik Penjualan 7 Hari Terakhir</h3>
            </div>
            <div class="card-body">
                <canvas id="grafikPenjualan" height="100"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-receipt"></i> Transaksi Terakhir</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped">
                    <thead>
                        <tr><th>No Invoice</th><th>Tanggal</th><th>Kasir</th><th class="text-right">Total</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($penjualan_terakhir as $p): ?>
                        <tr>
                            <td><a href="<?= base_url('penjualan/detail/' . $p['id']) ?>"><?= esc($p['no_invoice']) ?></a></td>
                            <td><?= date('d/m/Y H:i', strtotime($p['tanggal'])) ?></td>
                            <td><?= esc($p['kasir']) ?></td>
                            <td class="text-right"><?= rupiah($p['total']) ?></td>
                            <td><span class="badge badge-<?= $p['status'] === 'selesai' ? 'success' : 'danger' ?>"><?= ucfirst($p['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($penjualan_terakhir)): ?>
                        <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-star"></i> Produk Terlaris</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php foreach ($produk_terlaris as $pt): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= esc($pt['nama_produk']) ?>
                        <span class="badge badge-primary badge-pill"><?= $pt['total_qty'] ?> terjual</span>
                    </li>
                    <?php endforeach; ?>
                    <?php if (empty($produk_terlaris)): ?>
                    <li class="list-group-item text-muted text-center">Belum ada data</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Stok Menipis</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php foreach (array_slice($stok_menipis, 0, 8) as $sm): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= esc($sm['nama']) ?>
                        <span class="badge badge-danger badge-pill">sisa <?= $sm['stok'] ?></span>
                    </li>
                    <?php endforeach; ?>
                    <?php if (empty($stok_menipis)): ?>
                    <li class="list-group-item text-muted text-center">Semua stok aman</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
new Chart(document.getElementById('grafikPenjualan'), {
    type: 'line',
    data: {
        labels: <?= json_encode($grafik['labels']) ?>,
        datasets: [{
            label: 'Penjualan (Rp)',
            data: <?= json_encode($grafik['values']) ?>,
            borderColor: '#007bff',
            backgroundColor: 'rgba(0,123,255,0.1)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        scales: {y: {beginAtZero: true, ticks: {callback: v => 'Rp ' + v.toLocaleString('id-ID')}}}
    }
});
</script>
<?= $this->endSection() ?>
