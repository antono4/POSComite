<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card card-primary">
    <div class="card-header"><h3 class="card-title"><?= esc($title) ?></h3></div>
    <form action="<?= base_url('produk/simpan') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= $produk['id'] ?? '' ?>">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kode Produk *</label>
                        <input type="text" name="kode" class="form-control" value="<?= old('kode', $produk['kode'] ?? $kode) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Barcode</label>
                        <input type="text" name="barcode" class="form-control" value="<?= old('barcode', $produk['barcode'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Nama Produk *</label>
                        <input type="text" name="nama" class="form-control" value="<?= old('nama', $produk['nama'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori_id" class="form-control select2">
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $k): ?>
                            <option value="<?= $k['id'] ?>" <?= old('kategori_id', $produk['kategori_id'] ?? '') == $k['id'] ? 'selected' : '' ?>><?= esc($k['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Satuan</label>
                        <select name="satuan_id" class="form-control select2">
                            <option value="">-- Pilih Satuan --</option>
                            <?php foreach ($satuan as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= old('satuan_id', $produk['satuan_id'] ?? '') == $s['id'] ? 'selected' : '' ?>><?= esc($s['nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Harga Beli *</label>
                        <input type="number" name="harga_beli" class="form-control" value="<?= old('harga_beli', $produk['harga_beli'] ?? 0) ?>" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Jual *</label>
                        <input type="number" name="harga_jual" class="form-control" value="<?= old('harga_jual', $produk['harga_jual'] ?? 0) ?>" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Stok *</label>
                        <input type="number" name="stok" class="form-control" value="<?= old('stok', $produk['stok'] ?? 0) ?>" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Stok Minimum (peringatan)</label>
                        <input type="number" name="stok_min" class="form-control" value="<?= old('stok_min', $produk['stok_min'] ?? 5) ?>" min="0">
                    </div>
                    <div class="form-group">
                        <label>Gambar Produk</label>
                        <input type="file" name="gambar" class="form-control-file" accept="image/*">
                        <?php if (!empty($produk['gambar'])): ?>
                        <img src="<?= base_url('uploads/produk/' . $produk['gambar']) ?>" class="img-thumbnail mt-2" width="100">
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="aktif" class="custom-control-input" id="aktif" value="1" <?= old('aktif', $produk['aktif'] ?? 1) ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="aktif">Produk Aktif (dapat dijual)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="<?= base_url('produk') ?>" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
