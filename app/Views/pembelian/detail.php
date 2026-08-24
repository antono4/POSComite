<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Item Pembelian</h3></div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped">
                    <thead><tr><th>Produk</th><th class="text-right">Harga Beli</th><th class="text-center">Qty</th><th class="text-right">Subtotal</th></tr></thead>
                    <tbody>
                        <?php foreach ($detail as $d): ?>
                        <tr>
                            <td><strong><?= esc($d['kode']) ?></strong> — <?= esc($d['produk']) ?></td>
                            <td class="text-right"><?= rupiah($d['harga_beli']) ?></td>
                            <td class="text-center"><?= $d['qty'] ?></td>
                            <td class="text-right"><?= rupiah($d['subtotal']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-light"><th colspan="3" class="text-right">TOTAL</th><th class="text-right"><?= rupiah($pembelian['total']) ?></th></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Informasi</h3></div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr><td>No Faktur</td><td class="text-right"><strong><?= esc($pembelian['no_faktur']) ?></strong></td></tr>
                    <tr><td>Tanggal</td><td class="text-right"><?= tgl_indo($pembelian['tanggal']) ?></td></tr>
                    <tr><td>Supplier</td><td class="text-right"><?= esc($pembelian['supplier'] ?? '-') ?></td></tr>
                    <tr><td>Diinput Oleh</td><td class="text-right"><?= esc($pembelian['user']) ?></td></tr>
                    <tr><td>Status</td><td class="text-right"><span class="badge badge-success"><?= ucfirst($pembelian['status']) ?></span></td></tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="<?= base_url('pembelian') ?>" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
