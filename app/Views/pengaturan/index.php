<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-store"></i> Informasi Toko</h3></div>
            <form action="<?= base_url('pengaturan/simpan') ?>" method="post">
                <?= csrf_field() ?>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Toko</label>
                        <input type="text" name="nama_toko" class="form-control" value="<?= esc($pengaturan['nama_toko'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2"><?= esc($pengaturan['alamat'] ?? '') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Telepon</label>
                        <input type="text" name="telepon" class="form-control" value="<?= esc($pengaturan['telepon'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label>Pajak Default (%)</label>
                        <input type="number" name="pajak_persen" class="form-control" value="<?= esc($pengaturan['pajak_persen'] ?? 0) ?>" min="0" max="100" step="0.1">
                    </div>
                    <div class="form-group">
                        <label>Footer Struk</label>
                        <input type="text" name="footer_struk" class="form-control" value="<?= esc($pengaturan['footer_struk'] ?? '') ?>">
                        <small class="text-muted">Teks yang muncul di bagian bawah struk belanja</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-info">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-info-circle"></i> Tentang Aplikasi</h3></div>
            <div class="card-body">
                <p><strong>POS Comite</strong> — Aplikasi Point of Sale</p>
                <ul class="pl-3">
                    <li>Framework: CodeIgniter 4</li>
                    <li>Database: MySQL</li>
                    <li>UI: AdminLTE 3</li>
                </ul>
                <hr>
                <p class="text-muted mb-0"><small>Pengaturan ini digunakan pada struk belanja dan tampilan aplikasi.</small></p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
