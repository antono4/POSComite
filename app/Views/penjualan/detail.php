<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Item Transaksi</h3>
                <div class="card-tools">
                    <a href="<?= base_url('penjualan/struk/' . $penjualan['id']) ?>" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-print"></i> Cetak Struk</a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped">
                    <thead><tr><th>Produk</th><th class="text-right">Harga</th><th class="text-center">Qty</th><th class="text-right">Subtotal</th></tr></thead>
                    <tbody>
                        <?php foreach ($detail as $d): ?>
                        <tr>
                            <td><strong><?= esc($d['kode_produk']) ?></strong> — <?= esc($d['nama_produk']) ?></td>
                            <td class="text-right"><?= rupiah($d['harga']) ?></td>
                            <td class="text-center"><?= $d['qty'] ?></td>
                            <td class="text-right"><?= rupiah($d['subtotal']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Informasi Transaksi</h3></div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr><td>No Invoice</td><td class="text-right"><strong><?= esc($penjualan['no_invoice']) ?></strong></td></tr>
                    <tr><td>Tanggal</td><td class="text-right"><?= date('d/m/Y H:i', strtotime($penjualan['tanggal'])) ?></td></tr>
                    <tr><td>Kasir</td><td class="text-right"><?= esc($penjualan['kasir']) ?></td></tr>
                    <tr><td>Pelanggan</td><td class="text-right"><?= esc($penjualan['pelanggan'] ?? 'Umum') ?></td></tr>
                    <tr><td>Metode</td><td class="text-right"><span class="badge badge-info"><?= strtoupper($penjualan['metode_bayar']) ?></span></td></tr>
                    <tr><td>Status</td><td class="text-right"><span class="badge badge-<?= $penjualan['status'] === 'selesai' ? 'success' : 'danger' ?>"><?= ucfirst($penjualan['status']) ?></span></td></tr>
                </table>
                <hr>
                <table class="table table-sm table-borderless">
                    <tr><td>Subtotal</td><td class="text-right"><?= rupiah($penjualan['subtotal']) ?></td></tr>
                    <tr><td>Diskon</td><td class="text-right">- <?= rupiah($penjualan['diskon']) ?></td></tr>
                    <tr><td>Pajak</td><td class="text-right">+ <?= rupiah($penjualan['pajak']) ?></td></tr>
                    <tr class="border-top"><td><strong>Total</strong></td><td class="text-right"><h5 class="text-success mb-0"><?= rupiah($penjualan['total']) ?></h5></td></tr>
                    <tr><td>Bayar</td><td class="text-right"><?= rupiah($penjualan['bayar']) ?></td></tr>
                    <tr><td>Kembali</td><td class="text-right"><?= rupiah($penjualan['kembali']) ?></td></tr>
                </table>
                <?php if ($penjualan['catatan']): ?>
                <hr><p class="text-muted mb-0"><i class="fas fa-sticky-note"></i> <?= esc($penjualan['catatan']) ?></p>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <a href="<?= base_url('penjualan') ?>" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
