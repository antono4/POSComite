<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- Hero Banner -->
<div class="hero-banner mb-4">
    <div>
        <h3 class="mb-1"><i class="fas fa-hand-sparkles"></i> Selamat datang, <?= esc(session()->get('nama')) ?>!</h3>
        <p class="mb-0" style="opacity:.85">Berikut ringkasan aktivitas <?= esc(pengaturan('nama_toko', 'toko Anda')) ?> hari ini, <?= date('d F Y') ?></p>
    </div>
    <a href="<?= base_url('kasir') ?>" class="btn btn-light btn-lg hero-btn">
        <i class="fas fa-cash-register"></i> Mulai Transaksi
    </a>
</div>

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
                <h3 class="card-title"><i class="fas fa-chart-line text-primary"></i> Grafik Penjualan 7 Hari Terakhir</h3>
                <div class="card-tools"><span class="badge badge-primary">Realtime</span></div>
            </div>
            <div class="card-body">
                <canvas id="grafikPenjualan" height="100"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-receipt text-success"></i> Transaksi Terakhir</h3>
                <div class="card-tools">
                    <a href="<?= base_url('penjualan') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr><th>No Invoice</th><th>Tanggal</th><th>Kasir</th><th class="text-right">Total</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($penjualan_terakhir as $p): ?>
                        <tr>
                            <td><a href="<?= base_url('penjualan/detail/' . $p['id']) ?>" class="font-weight-bold text-primary"><?= esc($p['no_invoice']) ?></a></td>
                            <td><i class="far fa-clock text-muted mr-1"></i><?= date('d/m/Y H:i', strtotime($p['tanggal'])) ?></td>
                            <td><?= esc($p['kasir']) ?></td>
                            <td class="text-right font-weight-bold"><?= rupiah($p['total']) ?></td>
                            <td><span class="badge badge-<?= $p['status'] === 'selesai' ? 'success' : 'danger' ?>"><?= ucfirst($p['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($penjualan_terakhir)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-4"><i class="fas fa-inbox fa-2x mb-2 d-block"></i>Belum ada transaksi</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-trophy text-warning"></i> Produk Terlaris</h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php $rank = 1; foreach ($produk_terlaris as $pt): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <span class="rank-badge rank-<?= $rank ?>"><?= $rank ?></span>
                            <?= esc($pt['nama_produk']) ?>
                        </span>
                        <span class="badge badge-primary badge-pill"><?= $pt['total_qty'] ?> terjual</span>
                    </li>
                    <?php $rank++; endforeach; ?>
                    <?php if (empty($produk_terlaris)): ?>
                    <li class="list-group-item text-muted text-center py-4"><i class="fas fa-chart-bar fa-2x mb-2 d-block"></i>Belum ada data</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="card card-outline card-danger">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-exclamation-triangle text-danger"></i> Stok Menipis</h3>
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
                    <li class="list-group-item text-center text-success py-4"><i class="fas fa-check-circle fa-2x mb-2 d-block"></i>Semua stok aman 👍</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.hero-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 26px 30px;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
    box-shadow: 0 12px 32px rgba(102,126,234,0.35);
}
.hero-btn { border-radius: 12px; font-weight: 600; color: #764ba2 !important; box-shadow: 0 6px 18px rgba(0,0,0,0.18); }
.hero-btn:hover { transform: translateY(-2px); }
.rank-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 26px; height: 26px; border-radius: 8px;
    background: #eef0f8; color: #8a8aa3; font-size: 12px; font-weight: 700;
    margin-right: 8px;
}
.rank-1 { background: linear-gradient(135deg,#f7971e,#ffd200); color: #fff; }
.rank-2 { background: linear-gradient(135deg,#bdc3c7,#e8e8e8); color: #555; }
.rank-3 { background: linear-gradient(135deg,#cd7f32,#e8b06a); color: #fff; }
</style>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
const ctx = document.getElementById('grafikPenjualan').getContext('2d');
const grad = ctx.createLinearGradient(0, 0, 0, 280);
grad.addColorStop(0, 'rgba(102,126,234,0.35)');
grad.addColorStop(1, 'rgba(102,126,234,0.01)');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($grafik['labels']) ?>,
        datasets: [{
            label: 'Penjualan (Rp)',
            data: <?= json_encode($grafik['values']) ?>,
            borderColor: '#667eea',
            backgroundColor: grad,
            pointBackgroundColor: '#764ba2',
            pointBorderColor: '#fff',
            pointRadius: 5,
            pointHoverRadius: 7,
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        legend: {display: false},
        tooltips: {
            backgroundColor: '#1e1e2d',
            callbacks: {label: (item) => ' Rp ' + Number(item.yLabel).toLocaleString('id-ID')}
        },
        scales: {
            yAxes: [{ticks: {beginAtZero: true, callback: v => 'Rp ' + v.toLocaleString('id-ID'), fontColor: '#8a8aa3'}, gridLines: {color: '#f0f1f7'}}],
            xAxes: [{ticks: {fontColor: '#8a8aa3'}, gridLines: {display: false}}]
        }
    }
});
</script>
<?= $this->endSection() ?>
