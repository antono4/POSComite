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
                <tr>
                    <th>No Invoice</th><th>Tanggal</th><th>Pelanggan</th><th>Kasir</th>
                    <th class="text-right">Total</th><th>Metode</th><th>Status</th><th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($penjualan as $p): ?>
                <tr>
                    <td><a href="<?= base_url('penjualan/detail/' . $p['id']) ?>"><?= esc($p['no_invoice']) ?></a></td>
                    <td><?= date('d/m/Y H:i', strtotime($p['tanggal'])) ?></td>
                    <td><?= esc($p['pelanggan'] ?? 'Umum') ?></td>
                    <td><?= esc($p['kasir']) ?></td>
                    <td class="text-right"><?= rupiah($p['total']) ?></td>
                    <td><span class="badge badge-info"><?= strtoupper($p['metode_bayar']) ?></span></td>
                    <td><span class="badge badge-<?= $p['status'] === 'selesai' ? 'success' : 'danger' ?>"><?= ucfirst($p['status']) ?></span></td>
                    <td>
                        <a href="<?= base_url('penjualan/struk/' . $p['id']) ?>" class="btn btn-sm btn-info" title="Cetak Struk" target="_blank"><i class="fas fa-print"></i></a>
                        <a href="<?= base_url('penjualan/detail/' . $p['id']) ?>" class="btn btn-sm btn-primary" title="Detail"><i class="fas fa-eye"></i></a>
                        <?php if ($p['status'] === 'selesai' && session()->get('role') === 'admin'): ?>
                        <button onclick="if(confirm('Batalkan transaksi ini? Stok akan dikembalikan.')) window.location.href='<?= base_url('penjualan/batal/' . $p['id']) ?>'"
                            class="btn btn-sm btn-danger" title="Batalkan"><i class="fas fa-ban"></i></button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
