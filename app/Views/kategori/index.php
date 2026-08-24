<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalForm" onclick="resetForm()"><i class="fas fa-plus"></i> Tambah Kategori</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered datatable">
            <thead><tr><th width="50">No</th><th>Nama Kategori</th><th>Deskripsi</th><th width="120">Aksi</th></tr></thead>
            <tbody>
                <?php $no = 1; foreach ($kategori as $k): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($k['nama']) ?></td>
                    <td><?= esc($k['deskripsi'] ?? '-') ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalForm"
                            onclick="editForm($(this).data('row'))" data-row='<?= esc(json_encode($k), 'attr') ?>'><i class="fas fa-edit"></i></button>
                        <button onclick="confirmHapus('<?= base_url('kategori/hapus/' . $k['id']) ?>')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalForm">
    <div class="modal-dialog">
        <form action="<?= base_url('kategori/simpan') ?>" method="post" class="modal-content">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="formId">
            <div class="modal-header"><h4 class="modal-title">Form Kategori</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Kategori *</label>
                    <input type="text" name="nama" id="formNama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="formDeskripsi" class="form-control" rows="2"></textarea>
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
function resetForm() { $('#formId').val(''); $('#formNama').val(''); $('#formDeskripsi').val(''); }
function editForm(d) { $('#formId').val(d.id); $('#formNama').val(d.nama); $('#formDeskripsi').val(d.deskripsi); }
</script>
<?= $this->endSection() ?>
