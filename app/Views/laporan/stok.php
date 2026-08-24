<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Nilai stok berdasarkan harga beli</h3>
        <div class="card-tools">
            <button class="btn btn-sm btn-default" onclick="window.print()"><i class="fas fa-print"></i> Cetak</button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered datatable">
            <thead>
                <tr>
                    <th>Kode</th><th>Nama Produk</th><th>Kategori</th><th class="text-center">Stok</th>
                    <th class="text-right">Harga Beli</th><th class="text-right">Nilai Stok</th><th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalNilai = 0; foreach ($produk as $p): $totalNilai += $p['nilai_stok']; ?>
                <tr>
                    <td><?= esc($p['kode']) ?></td>
                    <td><?= esc($p['nama']) ?></td>
                    <td><?= esc($p['kategori'] ?? '-') ?></td>
                    <td class="text-center"><?= $p['stok'] ?> <?= esc($p['satuan'] ?? '') ?></td>
                    <td class="text-right"><?= rupiah($p['harga_beli']) ?></td>
                    <td class="text-right"><?= rupiah($p['nilai_stok']) ?></td>
                    <td class="text-center">
                        <?php if ($p['stok'] <= 0): ?>
                            <span class="badge badge-danger">Habis</span>
                        <?php elseif ($p['stok'] <= $p['stok_min']): ?>
                            <span class="badge badge-warning">Menipis</span>
                        <?php else: ?>
                            <span class="badge badge-success">Aman</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="bg-light">
                    <th colspan="5" class="text-right">TOTAL NILAI STOK</th>
                    <th class="text-right"><?= rupiah($totalNilai) ?></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
