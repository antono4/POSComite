<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner"><h3><?= rupiah($total_pendapatan) ?></h3><p>Total Pendapatan</p></div>
            <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-warning">
            <div class="inner"><h3><?= rupiah($total_diskon) ?></h3><p>Total Diskon Diberikan</p></div>
            <div class="icon"><i class="fas fa-percent"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner"><h3><?= rupiah($laba) ?></h3><p>Estimasi Laba Kotor</p></div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="get" class="form-inline">
            <label class="mr-2">Periode:</label>
            <input type="date" name="dari" class="form-control form-control-sm mr-2" value="<?= esc($dari) ?>">
            <span class="mr-2">s/d</span>
            <input type="date" name="sampai" class="form-control form-control-sm mr-2" value="<?= esc($sampai) ?>">
            <button class="btn btn-sm btn-primary mr-2"><i class="fas fa-filter"></i> Filter</button>
            <button type="button" class="btn btn-sm btn-default" onclick="window.print()"><i class="fas fa-print"></i> Cetak</button>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered datatable">
            <thead>
                <tr><th>No Invoice</th><th>Tanggal</th><th>Kasir</th><th class="text-right">Subtotal</th><th class="text-right">Diskon</th><th class="text-right">Total</th><th>Metode</th></tr>
            </thead>
            <tbody>
                <?php foreach ($penjualan as $p): ?>
                <tr>
                    <td><?= esc($p['no_invoice']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($p['tanggal'])) ?></td>
                    <td><?= esc($p['kasir']) ?></td>
                    <td class="text-right"><?= rupiah($p['subtotal']) ?></td>
                    <td class="text-right"><?= rupiah($p['diskon']) ?></td>
                    <td class="text-right"><strong><?= rupiah($p['total']) ?></strong></td>
                    <td><span class="badge badge-info"><?= strtoupper($p['metode_bayar']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="bg-light">
                    <th colspan="5" class="text-right">TOTAL PENDAPATAN</th>
                    <th class="text-right"><?= rupiah($total_pendapatan) ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
