<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <a href="<?= base_url('pembelian/tambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Pembelian</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered datatable">
            <thead>
                <tr><th>No Faktur</th><th>Tanggal</th><th>Supplier</th><th>Diinput Oleh</th><th class="text-right">Total</th><th>Status</th><th width="80">Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($pembelian as $p): ?>
                <tr>
                    <td><a href="<?= base_url('pembelian/detail/' . $p['id']) ?>"><?= esc($p['no_faktur']) ?></a></td>
                    <td><?= tgl_indo($p['tanggal']) ?></td>
                    <td><?= esc($p['supplier'] ?? '-') ?></td>
                    <td><?= esc($p['user']) ?></td>
                    <td class="text-right"><?= rupiah($p['total']) ?></td>
                    <td><span class="badge badge-<?= $p['status'] === 'diterima' ? 'success' : 'warning' ?>"><?= ucfirst($p['status']) ?></span></td>
                    <td><a href="<?= base_url('pembelian/detail/' . $p['id']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
