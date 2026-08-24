<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalForm" onclick="resetForm()"><i class="fas fa-plus"></i> Tambah Pengeluaran</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered datatable">
            <thead><tr><th>Tanggal</th><th>Keterangan</th><th>Dicatat Oleh</th><th class="text-right">Jumlah</th><th width="120">Aksi</th></tr></thead>
            <tbody>
                <?php foreach ($pengeluaran as $p): ?>
                <tr>
                    <td><?= tgl_indo($p['tanggal']) ?></td>
                    <td><?= esc($p['keterangan']) ?></td>
                    <td><?= esc($p['user']) ?></td>
                    <td class="text-right text-danger"><strong><?= rupiah($p['jumlah']) ?></strong></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalForm"
                            onclick="editForm($(this).data('row'))" data-row='<?= esc(json_encode($p), 'attr') ?>'><i class="fas fa-edit"></i></button>
                        <button onclick="confirmHapus('<?= base_url('pengeluaran/hapus/' . $p['id']) ?>')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalForm">
    <div class="modal-dialog">
        <form action="<?= base_url('pengeluaran/simpan') ?>" method="post" class="modal-content">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="formId">
            <div class="modal-header"><h4 class="modal-title">Form Pengeluaran</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Tanggal *</label>
                    <input type="date" name="tanggal" id="formTanggal" class="form-control" value="<?= date('Y-m-d') ?>" required></div>
                <div class="form-group"><label>Keterangan *</label>
                    <input type="text" name="keterangan" id="formKeterangan" class="form-control" placeholder="Contoh: Bayar listrik" required></div>
                <div class="form-group"><label>Jumlah (Rp) *</label>
                    <input type="number" name="jumlah" id="formJumlah" class="form-control" min="0" required></div>
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
function resetForm() { $('#formId').val(''); $('#formTanggal').val('<?= date('Y-m-d') ?>'); $('#formKeterangan,#formJumlah').val(''); }
function editForm(d) { $('#formId').val(d.id); $('#formTanggal').val(d.tanggal); $('#formKeterangan').val(d.keterangan); $('#formJumlah').val(d.jumlah); }
</script>
<?= $this->endSection() ?>
