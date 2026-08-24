<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('pembelian/simpan') ?>" method="post" id="formPembelian">
<?= csrf_field() ?>
<input type="hidden" name="items" id="inputItems">
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Informasi Pembelian</h3></div>
            <div class="card-body">
                <div class="form-group">
                    <label>No. Faktur</label>
                    <input type="text" class="form-control" value="<?= esc($no_faktur) ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Tanggal *</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <select name="supplier_id" class="form-control select2">
                        <option value="">-- Pilih Supplier --</option>
                        <?php foreach ($supplier as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= esc($s['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <h4>TOTAL</h4>
                    <h4 class="text-success" id="tampilTotal">Rp 0</h4>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-save"></i> Simpan & Tambah Stok</button>
                <a href="<?= base_url('pembelian') ?>" class="btn btn-default btn-block mt-2">Batal</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Tambah Item</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <select id="pilihProduk" class="form-control select2">
                            <option value="">-- Pilih Produk --</option>
                            <?php foreach ($produk as $p): ?>
                            <option value="<?= $p['id'] ?>" data-harga="<?= $p['harga_beli'] ?>" data-nama="<?= esc($p['nama']) ?>" data-kode="<?= esc($p['kode']) ?>">
                                <?= esc($p['kode']) ?> — <?= esc($p['nama']) ?> (stok: <?= $p['stok'] ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" id="inputHarga" class="form-control" placeholder="Harga beli" min="0">
                    </div>
                    <div class="col-md-2">
                        <input type="number" id="inputQty" class="form-control" placeholder="Qty" min="1" value="1">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary btn-block" onclick="tambahItem()"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped">
                    <thead><tr><th>Produk</th><th class="text-right">Harga Beli</th><th class="text-center">Qty</th><th class="text-right">Subtotal</th><th width="50"></th></tr></thead>
                    <tbody id="isiItems">
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada item</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</form>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
let items = [];
function formatRp(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

$('#pilihProduk').on('change', function () {
    const harga = $(this).find(':selected').data('harga');
    if (harga !== undefined) $('#inputHarga').val(harga);
});

function tambahItem() {
    const opt = $('#pilihProduk').find(':selected');
    const id = parseInt(opt.val());
    if (!id) { toastr.warning('Pilih produk dulu'); return; }
    const harga = parseFloat($('#inputHarga').val()) || 0;
    const qty = parseInt($('#inputQty').val()) || 1;
    const ada = items.find(i => i.id === id);
    if (ada) {
        ada.qty += qty;
        ada.harga_beli = harga;
        ada.subtotal = ada.qty * harga;
    } else {
        items.push({id, kode: opt.data('kode'), nama: opt.data('nama'), harga_beli: harga, qty, subtotal: harga * qty});
    }
    $('#inputQty').val(1);
    renderItems();
}

function hapusItem(id) {
    items = items.filter(i => i.id !== id);
    renderItems();
}

function renderItems() {
    let html = '', total = 0;
    items.forEach(i => {
        total += i.subtotal;
        html += `<tr>
            <td><strong>${i.kode}</strong> — ${i.nama}</td>
            <td class="text-right">${formatRp(i.harga_beli)}</td>
            <td class="text-center">${i.qty}</td>
            <td class="text-right"><strong>${formatRp(i.subtotal)}</strong></td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="hapusItem(${i.id})"><i class="fas fa-times"></i></button></td>
        </tr>`;
    });
    $('#isiItems').html(html || '<tr><td colspan="5" class="text-center text-muted py-4">Belum ada item</td></tr>');
    $('#tampilTotal').text(formatRp(total));
}

$('#formPembelian').on('submit', function (e) {
    if (items.length === 0) {
        e.preventDefault();
        toastr.error('Belum ada item pembelian');
        return;
    }
    $('#inputItems').val(JSON.stringify(items));
});
</script>
<?= $this->endSection() ?>
