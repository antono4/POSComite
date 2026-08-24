<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalForm" onclick="resetForm()"><i class="fas fa-plus"></i> Tambah Supplier</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered datatable">
            <thead><tr><th>Kode</th><th>Nama Supplier</th><th>Telepon</th><th>Email</th><th>Alamat</th><th width="120">Aksi</th></tr></thead>
            <tbody>
                <?php foreach ($supplier as $s): ?>
                <tr>
                    <td><?= esc($s['kode']) ?></td>
                    <td><?= esc($s['nama']) ?></td>
                    <td><?= esc($s['telepon'] ?? '-') ?></td>
                    <td><?= esc($s['email'] ?? '-') ?></td>
                    <td><?= esc($s['alamat'] ?? '-') ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalForm"
                            onclick="editForm($(this).data('row'))" data-row='<?= esc(json_encode($s), 'attr') ?>'><i class="fas fa-edit"></i></button>
                        <button onclick="confirmHapus('<?= base_url('supplier/hapus/' . $s['id']) ?>')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalForm">
    <div class="modal-dialog">
        <form action="<?= base_url('supplier/simpan') ?>" method="post" class="modal-content">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="formId">
            <div class="modal-header"><h4 class="modal-title">Form Supplier</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Nama Supplier *</label>
                    <input type="text" name="nama" id="formNama" class="form-control" required></div>
                <div class="form-group"><label>Telepon</label>
                    <input type="text" name="telepon" id="formTelepon" class="form-control"></div>
                <div class="form-group"><label>Email</label>
                    <input type="email" name="email" id="formEmail" class="form-control"></div>
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
function resetForm() { $('#formId,#formNama,#formTelepon,#formEmail,#formAlamat').val(''); }
function editForm(d) { $('#formId').val(d.id); $('#formNama').val(d.nama); $('#formTelepon').val(d.telepon); $('#formEmail').val(d.email); $('#formAlamat').val(d.alamat); }
</script>
<?= $this->endSection() ?>
