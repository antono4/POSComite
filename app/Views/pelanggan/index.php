<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalForm" onclick="resetForm()"><i class="fas fa-plus"></i> Tambah Pelanggan</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered datatable">
            <thead><tr><th>Kode</th><th>Nama</th><th>Telepon</th><th>Alamat</th><th class="text-center">Poin</th><th width="120">Aksi</th></tr></thead>
            <tbody>
                <?php foreach ($pelanggan as $p): ?>
                <tr>
                    <td><?= esc($p['kode']) ?></td>
                    <td><?= esc($p['nama']) ?></td>
                    <td><?= esc($p['telepon'] ?? '-') ?></td>
                    <td><?= esc($p['alamat'] ?? '-') ?></td>
                    <td class="text-center"><span class="badge badge-info"><?= $p['poin'] ?></span></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalForm"
                            onclick="editForm($(this).data('row'))" data-row='<?= esc(json_encode($p), 'attr') ?>'><i class="fas fa-edit"></i></button>
                        <button onclick="confirmHapus('<?= base_url('pelanggan/hapus/' . $p['id']) ?>')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalForm">
    <div class="modal-dialog">
        <form action="<?= base_url('pelanggan/simpan') ?>" method="post" class="modal-content">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="formId">
            <div class="modal-header"><h4 class="modal-title">Form Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Nama Pelanggan *</label>
                    <input type="text" name="nama" id="formNama" class="form-control" required></div>
                <div class="form-group"><label>Telepon</label>
                    <input type="text" name="telepon" id="formTelepon" class="form-control"></div>
                <div class="form-group"><label>Alamat</label>
                    <textarea name="alamat" id="formAlamat" class="form-control" rows="2"></textarea></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
function resetForm() { $('#formId,#formNama,#formTelepon,#formAlamat').val(''); }
function editForm(d) { $('#formId').val(d.id); $('#formNama').val(d.nama); $('#formTelepon').val(d.telepon); $('#formAlamat').val(d.alamat); }
</script>
<?= $this->endSection() ?>
