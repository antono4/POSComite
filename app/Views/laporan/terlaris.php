<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <form method="get" class="form-inline">
            <label class="mr-2">Periode:</label>
            <input type="date" name="dari" class="form-control form-control-sm mr-2" value="<?= esc($dari) ?>">
            <span class="mr-2">s/d</span>
            <input type="date" name="sampai" class="form-control form-control-sm mr-2" value="<?= esc($sampai) ?>">
            <button class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Filter</button>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered datatable">
            <thead>
                <tr><th width="50">#</th><th>Kode</th><th>Nama Produk</th><th class="text-center">Qty Terjual</th><th class="text-right">Total Penjualan</th></tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($produk as $p): ?>
                <tr>
                    <td>
                        <?= $no++ ?>
                        <?php if ($no <= 4): ?><span class="badge badge-warning"><i class="fas fa-trophy"></i></span><?php endif; ?>
                    </td>
                    <td><?= esc($p['kode_produk']) ?></td>
                    <td><?= esc($p['nama_produk']) ?></td>
                    <td class="text-center"><span class="badge badge-primary"><?= $p['total_qty'] ?></span></td>
                    <td class="text-right"><?= rupiah($p['total_penjualan']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($produk)): ?>
                <tr><td colspan="5" class="text-center text-muted">Belum ada data penjualan pada periode ini</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
