<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('kasir/simpan') ?>" method="post" id="formKasir">
<?= csrf_field() ?>
<input type="hidden" name="keranjang" id="inputKeranjang">
<div class="row">
    <!-- Kolom kiri: pencarian & keranjang -->
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-barcode"></i> Cari Produk (nama / kode / barcode)</h3>
            </div>
            <div class="card-body">
                <div class="input-group input-group-lg">
                    <input type="text" id="cariProduk" class="form-control" placeholder="Ketik nama produk atau scan barcode..." autocomplete="off" autofocus>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                </div>
                <div id="hasilCari" class="list-group mt-2" style="max-height:250px;overflow-y:auto;"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped" id="tabelKeranjang">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-right" width="120">Harga</th>
                            <th class="text-center" width="140">Qty</th>
                            <th class="text-right" width="130">Subtotal</th>
                            <th width="50"></th>
                        </tr>
                    </thead>
                    <tbody id="isiKeranjang">
                        <tr id="barisKosong"><td colspan="5" class="text-center text-muted py-4">Keranjang kosong — cari produk di atas</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kolom kanan: pembayaran -->
    <div class="col-md-4">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-money-check-alt"></i> Pembayaran</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>No. Invoice</label>
                    <input type="text" class="form-control" value="<?= esc($no_invoice) ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Pelanggan</label>
                    <select name="pelanggan_id" class="form-control select2">
                        <option value="">-- Umum --</option>
                        <?php foreach ($pelanggan as $pl): ?>
                        <option value="<?= $pl['id'] ?>"><?= esc($pl['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <select name="metode_bayar" class="form-control">
                        <option value="tunai">Tunai</option>
                        <option value="debit">Kartu Debit</option>
                        <option value="kredit">Kartu Kredit</option>
                        <option value="qris">QRIS</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>
                <hr>
                <div class="d-flex justify-content-between"><span>Subtotal</span><strong id="tampilSubtotal">Rp 0</strong></div>
                <div class="form-group mt-2 mb-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Diskon (Rp)</span>
                        <input type="number" name="diskon" id="inputDiskon" class="form-control form-control-sm text-right" style="width:130px" value="0" min="0">
                    </div>
                </div>
                <div class="form-group mb-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Pajak (Rp)</span>
                        <input type="number" name="pajak" id="inputPajak" class="form-control form-control-sm text-right" style="width:130px" value="0" min="0">
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <h4>TOTAL</h4>
                    <h3 class="text-success mb-0" id="tampilTotal">Rp 0</h3>
                </div>
                <div class="form-group mt-3">
                    <label>Jumlah Bayar</label>
                    <input type="number" name="bayar" id="inputBayar" class="form-control form-control-lg text-right" placeholder="0" min="0" required>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Kembalian</span>
                    <h4 class="text-info" id="tampilKembali">Rp 0</h4>
                </div>
                <div class="form-group mt-2">
                    <input type="text" name="catatan" class="form-control" placeholder="Catatan (opsional)">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-lg btn-block" id="btnBayar">
                    <i class="fas fa-check-circle"></i> Simpan & Cetak Struk
                </button>
                <button type="button" class="btn btn-outline-danger btn-block mt-2" onclick="resetKeranjang()">
                    <i class="fas fa-trash"></i> Kosongkan Keranjang
                </button>
            </div>
        </div>
    </div>
</div>
</form>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
let keranjang = [];

function formatRp(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

$('#cariProduk').on('input', function () {
    const q = $(this).val();
    if (q.length < 1) { $('#hasilCari').empty(); return; }
    $.get('<?= base_url('produk/cari') ?>', {q: q}, function (data) {
        let html = '';
        data.forEach(p => {
            html += `<a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                onclick="tambahItem(${p.id}, '${p.kode}', '${p.nama.replace(/'/g, "\\'")}', ${p.harga_jual}, ${p.stok}); return false;">
                <span><strong>${p.kode}</strong> — ${p.nama}</span>
                <span>${formatRp(p.harga_jual)} <span class="badge badge-secondary ml-2">stok ${p.stok}</span></span>
            </a>`;
        });
        $('#hasilCari').html(html || '<div class="list-group-item text-muted">Produk tidak ditemukan</div>');
    });
});

// Scan barcode: tekan Enter langsung tambah produk pertama
$('#cariProduk').on('keypress', function (e) {
    if (e.which === 13) {
        e.preventDefault();
        $('#hasilCari a').first().trigger('click');
    }
});

function tambahItem(id, kode, nama, harga, stok) {
    const ada = keranjang.find(i => i.id === id);
    if (ada) {
        if (ada.qty + 1 > stok) { toastr.warning('Stok tidak cukup'); return; }
        ada.qty++;
        ada.subtotal = ada.qty * ada.harga;
    } else {
        keranjang.push({id, kode, nama, harga, qty: 1, subtotal: harga, stok});
    }
    $('#cariProduk').val('').focus();
    $('#hasilCari').empty();
    renderKeranjang();
}

function ubahQty(id, qty) {
    const item = keranjang.find(i => i.id === id);
    if (!item) return;
    qty = parseInt(qty) || 1;
    if (qty < 1) qty = 1;
    if (qty > item.stok) { toastr.warning('Stok maksimal: ' + item.stok); qty = item.stok; }
    item.qty = qty;
    item.subtotal = item.qty * item.harga;
    renderKeranjang();
}

function hapusItem(id) {
    keranjang = keranjang.filter(i => i.id !== id);
    renderKeranjang();
}

function resetKeranjang() {
    keranjang = [];
    renderKeranjang();
}

function hitungTotal() {
    const subtotal = keranjang.reduce((s, i) => s + i.subtotal, 0);
    const diskon = parseFloat($('#inputDiskon').val()) || 0;
    const pajak = parseFloat($('#inputPajak').val()) || 0;
    const total = Math.max(0, subtotal - diskon + pajak);
    const bayar = parseFloat($('#inputBayar').val()) || 0;
    $('#tampilSubtotal').text(formatRp(subtotal));
    $('#tampilTotal').text(formatRp(total));
    $('#tampilKembali').text(formatRp(Math.max(0, bayar - total)));
    return total;
}

function renderKeranjang() {
    let html = '';
    keranjang.forEach(i => {
        html += `<tr>
            <td><strong>${i.kode}</strong> — ${i.nama}</td>
            <td class="text-right">${formatRp(i.harga)}</td>
            <td class="text-center">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend"><button type="button" class="btn btn-outline-secondary" onclick="ubahQty(${i.id}, ${i.qty - 1})">-</button></div>
                    <input type="number" class="form-control text-center" value="${i.qty}" min="1" max="${i.stok}" onchange="ubahQty(${i.id}, this.value)">
                    <div class="input-group-append"><button type="button" class="btn btn-outline-secondary" onclick="ubahQty(${i.id}, ${i.qty + 1})">+</button></div>
                </div>
            </td>
            <td class="text-right"><strong>${formatRp(i.subtotal)}</strong></td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="hapusItem(${i.id})"><i class="fas fa-times"></i></button></td>
        </tr>`;
    });
    $('#isiKeranjang').html(html || '<tr id="barisKosong"><td colspan="5" class="text-center text-muted py-4">Keranjang kosong — cari produk di atas</td></tr>');
    hitungTotal();
}

$('#inputDiskon, #inputPajak, #inputBayar').on('input', hitungTotal);

$('#formKasir').on('submit', function (e) {
    if (keranjang.length === 0) {
        e.preventDefault();
        toastr.error('Keranjang belanja masih kosong');
        return;
    }
    const total = hitungTotal();
    const bayar = parseFloat($('#inputBayar').val()) || 0;
    if (bayar < total) {
        e.preventDefault();
        toastr.error('Jumlah bayar kurang dari total');
        return;
    }
    $('#inputKeranjang').val(JSON.stringify(keranjang));
});
</script>
<?= $this->endSection() ?>
