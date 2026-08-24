<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalForm" onclick="resetForm()"><i class="fas fa-plus"></i> Tambah Pengguna</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered datatable">
            <thead><tr><th>Username</th><th>Nama</th><th>Role</th><th class="text-center">Status</th><th width="120">Aksi</th></tr></thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= esc($u['username']) ?></td>
                    <td><?= esc($u['nama']) ?></td>
                    <td><span class="badge badge-<?= $u['role'] === 'admin' ? 'danger' : 'info' ?>"><?= ucfirst($u['role']) ?></span></td>
                    <td class="text-center"><span class="badge badge-<?= $u['aktif'] ? 'success' : 'secondary' ?>"><?= $u['aktif'] ? 'Aktif' : 'Nonaktif' ?></span></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalForm"
                            onclick="editForm($(this).data('row'))" data-row='<?= esc(json_encode($u), 'attr') ?>'><i class="fas fa-edit"></i></button>
                        <?php if ($u['id'] != session()->get('user_id')): ?>
                        <button onclick="confirmHapus('<?= base_url('pengguna/hapus/' . $u['id']) ?>')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalForm">
    <div class="modal-dialog">
        <form action="<?= base_url('pengguna/simpan') ?>" method="post" class="modal-content">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="formId">
            <div class="modal-header"><h4 class="modal-title">Form Pengguna</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Username *</label>
                    <input type="text" name="username" id="formUsername" class="form-control" required></div>
                <div class="form-group"><label>Nama Lengkap *</label>
                    <input type="text" name="nama" id="formNama" class="form-control" required></div>
                <div class="form-group"><label>Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" id="formPassword" class="form-control" minlength="6"></div>
                <div class="form-group"><label>Role *</label>
                    <select name="role" id="formRole" class="form-control">
                        <option value="kasir">Kasir</option>
                        <option value="admin">Admin</option>
                    </select></div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="aktif" class="custom-control-input" id="formAktif" value="1" checked>
                    <label class="custom-control-label" for="formAktif">Akun Aktif</label>
                </div>
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
function resetForm() { $('#formId,#formUsername,#formNama,#formPassword').val(''); $('#formRole').val('kasir'); $('#formAktif').prop('checked', true); }
function editForm(d) {
    $('#formId').val(d.id); $('#formUsername').val(d.username); $('#formNama').val(d.nama);
    $('#formPassword').val(''); $('#formRole').val(d.role); $('#formAktif').prop('checked', d.aktif == 1);
}
</script>
<?= $this->endSection() ?>
