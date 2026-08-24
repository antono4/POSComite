<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <a href="<?= base_url('produk/tambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Produk</a>
        <div class="card-tools">
            <form method="get" class="input-group input-group-sm" style="width:250px">
                <input type="text" name="q" class="form-control" placeholder="Cari produk..." value="<?= esc($keyword ?? '') ?>">
                <div class="input-group-append"><button class="btn btn-default"><i class="fas fa-search"></i></button></div>
            </form>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Kode</th><th>Nama Produk</th><th>Kategori</th><th class="text-right">Harga Beli</th>
                    <th class="text-right">Harga Jual</th><th class="text-center">Stok</th><th class="text-center">Status</th><th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produk as $p): ?>
                <tr>
                    <td><strong><?= esc($p['kode']) ?></strong><?php if ($p['barcode']): ?><br><small class="text-muted"><?= esc($p['barcode']) ?></small><?php endif; ?></td>
                    <td><?= esc($p['nama']) ?></td>
                    <td><?= esc($p['kategori'] ?? '-') ?></td>
                    <td class="text-right"><?= rupiah($p['harga_beli']) ?></td>
                    <td class="text-right"><?= rupiah($p['harga_jual']) ?></td>
                    <td class="text-center">
                        <span class="badge badge-<?= $p['stok'] <= $p['stok_min'] ? 'danger' : 'success' ?>"><?= $p['stok'] ?> <?= esc($p['satuan'] ?? '') ?></span>
                    </td>
                    <td class="text-center"><span class="badge badge-<?= $p['aktif'] ? 'success' : 'secondary' ?>"><?= $p['aktif'] ? 'Aktif' : 'Nonaktif' ?></span></td>
                    <td>
                        <a href="<?= base_url('produk/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <button onclick="confirmHapus('<?= base_url('produk/hapus/' . $p['id']) ?>')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($produk)): ?>
                <tr><td colspan="8" class="text-center text-muted">Belum ada produk</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <?= $pager->links('produk') ?>
    </div>
</div>

<?= $this->endSection() ?>
