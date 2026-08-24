<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<form action="<?= base_url('kasir/simpan') ?>" method="post" id="formKasir">
<?= csrf_field() ?>
<input type="hidden" name="keranjang" id="inputKeranjang">
<div class="row">
    <!-- Kolom kiri: pencarian & keranjang -->
    <div class="col-md-8">
        <div class="card kasir-search-card">
            <div class="card-body py-3">
                <div class="input-group input-group-lg kasir-search">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-barcode text-primary"></i></span>
                    </div>
                    <input type="text" id="cariProduk" class="form-control border-left-0" placeholder="Ketik nama produk atau scan barcode..." autocomplete="off" autofocus>
                </div>
                <div id="hasilCari" class="list-group mt-2 hasil-cari"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-shopping-cart text-primary"></i> Keranjang Belanja</h3>
                <span class="badge badge-primary badge-pill" id="jumlahItem">0 item</span>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover" id="tabelKeranjang">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-right" width="120">Harga</th>
                            <th class="text-center" width="150">Qty</th>
                            <th class="text-right" width="140">Subtotal</th>
                            <th width="50"></th>
                        </tr>
                    </thead>
                    <tbody id="isiKeranjang">
                        <tr id="barisKosong"><td colspan="5" class="text-center text-muted py-5">
                            <i class="fas fa-shopping-basket fa-3x mb-3 d-block" style="color:#dfe3f0"></i>
                            Keranjang kosong — cari produk di atas
                        </td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kolom kanan: pembayaran -->
    <div class="col-md-4">
        <div class="card payment-card">
            <div class="payment-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-money-check-alt"></i> Pembayaran</span>
                    <span class="invoice-no"><?= esc($no_invoice) ?></span>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label><i class="fas fa-user-tag text-muted mr-1"></i>Pelanggan</label>
                    <select name="pelanggan_id" class="form-control select2">
                        <option value="">-- Umum --</option>
                        <?php foreach ($pelanggan as $pl): ?>
                        <option value="<?= $pl['id'] ?>"><?= esc($pl['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-credit-card text-muted mr-1"></i>Metode Pembayaran</label>
                    <div class="payment-methods">
                        <?php
                        $metodes = ['tunai' => ['Tunai', 'fa-money-bill-wave'], 'debit' => ['Debit', 'fa-credit-card'], 'kredit' => ['Kredit', 'fa-credit-card'], 'qris' => ['QRIS', 'fa-qrcode'], 'transfer' => ['Transfer', 'fa-university']];
                        foreach ($metodes as $val => [$label, $icon]): ?>
                        <label class="pay-method <?= $val === 'tunai' ? 'active' : '' ?>" data-val="<?= $val ?>">
                            <input type="radio" name="metode_bayar" value="<?= $val ?>" <?= $val === 'tunai' ? 'checked' : '' ?> hidden>
                            <i class="fas <?= $icon ?>"></i><span><?= $label ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="summary-box">
                    <div class="d-flex justify-content-between mb-1"><span class="text-muted">Subtotal</span><strong id="tampilSubtotal">Rp 0</strong></div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-muted">Diskon (Rp)</span>
                        <input type="number" name="diskon" id="inputDiskon" class="form-control form-control-sm text-right input-mini" value="0" min="0">
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Pajak (Rp)</span>
                        <input type="number" name="pajak" id="inputPajak" class="form-control form-control-sm text-right input-mini" value="0" min="0">
                    </div>
                </div>
                <div class="total-display">
                    <span>TOTAL</span>
                    <span id="tampilTotal">Rp 0</span>
                </div>
                <div class="form-group mt-3">
                    <label><i class="fas fa-hand-holding-usd text-muted mr-1"></i>Jumlah Bayar</label>
                    <input type="number" name="bayar" id="inputBayar" class="form-control form-control-lg text-right input-bayar" placeholder="0" min="0" required>
                </div>
                <div class="quick-cash mb-2">
                    <?php foreach ([10000, 20000, 50000, 100000] as $qc): ?>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="setBayar(<?= $qc ?>)"><?= number_format($qc / 1000, 0) ?>rb</button>
                    <?php endforeach; ?>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="bayarPas()">Uang Pas</button>
                </div>
                <div class="d-flex justify-content-between align-items-center kembali-box">
                    <span>Kembalian</span>
                    <strong id="tampilKembali">Rp 0</strong>
                </div>
                <div class="form-group mt-2 mb-0">
                    <input type="text" name="catatan" class="form-control" placeholder="📝 Catatan (opsional)">
                </div>
            </div>
            <div class="card-footer bg-white pt-0">
                <button type="submit" class="btn btn-success btn-lg btn-block btn-bayar">
                    <i class="fas fa-check-circle"></i> Bayar & Cetak Struk
                </button>
                <button type="button" class="btn btn-outline-danger btn-block mt-2" onclick="resetKeranjang()">
                    <i class="fas fa-trash"></i> Kosongkan
                </button>
            </div>
        </div>
    </div>
</div>
</form>

<style>
.kasir-search-card { border: 2px solid #e8ecf8; }
.kasir-search .form-control { border: none; font-size: 17px; padding-left: 6px; }
.kasir-search .form-control:focus { box-shadow: none; }
.kasir-search .input-group-text { border: none; font-size: 18px; }
.kasir-search { border: 2px solid #e3e6f0; border-radius: 12px; overflow: hidden; transition: border-color .2s, box-shadow .2s; }
.kasir-search:focus-within { border-color: #667eea; box-shadow: 0 0 0 4px rgba(102,126,234,.12); }
.hasil-cari { max-height: 260px; overflow-y: auto; border-radius: 10px; }
.hasil-cari .list-group-item { border-radius: 10px !important; margin-bottom: 4px; border: 1.5px solid #eef0f8; transition: all .15s; }
.hasil-cari .list-group-item:hover { background: #f4f6ff; border-color: #667eea; transform: translateX(3px); }
.payment-card { overflow: hidden; }
.payment-header {
    background: linear-gradient(135deg, #11998e, #38ef7d);
    color: #fff; padding: 14px 20px; font-weight: 600; font-size: 16px;
}
.invoice-no { background: rgba(255,255,255,.2); border-radius: 8px; padding: 3px 10px; font-size: 12px; font-family: monospace; }
.payment-methods { display: flex; gap: 6px; flex-wrap: wrap; }
.pay-method {
    flex: 1; min-width: 58px; text-align: center; padding: 8px 4px;
    border: 2px solid #e8ecf4; border-radius: 10px; cursor: pointer;
    font-size: 11px; color: #8a8aa3; transition: all .15s; margin-bottom: 0;
}
.pay-method i { display: block; font-size: 16px; margin-bottom: 3px; }
.pay-method:hover { border-color: #b8c4f5; }
.pay-method.active { border-color: #667eea; background: linear-gradient(135deg, rgba(102,126,234,.08), rgba(118,75,162,.08)); color: #5a67d8; font-weight: 600; }
.summary-box { background: #f8f9fd; border-radius: 12px; padding: 12px 14px; }
.input-mini { width: 120px; border-radius: 8px; }
.total-display {
    display: flex; justify-content: space-between; align-items: center;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff; border-radius: 12px; padding: 14px 18px; margin-top: 12px;
    font-size: 15px; font-weight: 600;
}
.total-display span:last-child { font-size: 24px; font-weight: 800; }
.input-bayar { font-size: 20px; font-weight: 700; border-radius: 10px; }
.quick-cash { display: flex; gap: 5px; flex-wrap: wrap; }
.kembali-box {
    background: #e8f8f0; border-radius: 10px; padding: 10px 14px;
    color: #0e7a5f; font-size: 16px;
}
.btn-bayar { border-radius: 12px; font-size: 17px; font-weight: 700; letter-spacing: .3px; }
</style>

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
                <span><b class="text-primary">${formatRp(p.harga_jual)}</b> <span class="badge badge-secondary ml-2">stok ${p.stok}</span></span>
            </a>`;
        });
        $('#hasilCari').html(html || '<div class="list-group-item text-muted text-center"><i class="fas fa-search-minus"></i> Produk tidak ditemukan</div>');
    });
});

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
    if (keranjang.length === 0) return;
    Swal.fire({
        title: 'Kosongkan keranjang?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#eb3349'
    }).then(r => { if (r.isConfirmed) { keranjang = []; renderKeranjang(); } });
}

function hitungTotal() {
    const subtotal = keranjang.reduce((s, i) => s + i.subtotal, 0);
    const diskon = parseFloat($('#inputDiskon').val()) || 0;
    const pajak = parseFloat($('#inputPajak').val()) || 0;
    const total = Math.max(0, subtotal - diskon + pajak);
    const bayar = parseFloat($('#inputBayar').val()) || 0;
    $('#tampilSubtotal').text(formatRp(subtotal));
    $('#tampilTotal').text(formatRp(total));
    const kembali = bayar - total;
    $('#tampilKembali').text(formatRp(Math.max(0, kembali)));
    $('.kembali-box').css('background', kembali < 0 && bayar > 0 ? '#fde8ea' : '#e8f8f0');
    return total;
}

function setBayar(n) { $('#inputBayar').val(n); hitungTotal(); }
function bayarPas() { $('#inputBayar').val(hitungTotal()); hitungTotal(); }

$('.pay-method').on('click', function () {
    $('.pay-method').removeClass('active');
    $(this).addClass('active');
    $(this).find('input').prop('checked', true);
});

function renderKeranjang() {
    let html = '';
    keranjang.forEach(i => {
        html += `<tr>
            <td><strong>${i.kode}</strong> — ${i.nama}</td>
            <td class="text-right">${formatRp(i.harga)}</td>
            <td class="text-center">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend"><button type="button" class="btn btn-outline-secondary" onclick="ubahQty(${i.id}, ${i.qty - 1})">−</button></div>
                    <input type="number" class="form-control text-center" value="${i.qty}" min="1" max="${i.stok}" onchange="ubahQty(${i.id}, this.value)">
                    <div class="input-group-append"><button type="button" class="btn btn-outline-secondary" onclick="ubahQty(${i.id}, ${i.qty + 1})">+</button></div>
                </div>
            </td>
            <td class="text-right"><strong class="text-primary">${formatRp(i.subtotal)}</strong></td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="hapusItem(${i.id})"><i class="fas fa-times"></i></button></td>
        </tr>`;
    });
    $('#isiKeranjang').html(html || '<tr id="barisKosong"><td colspan="5" class="text-center text-muted py-5"><i class="fas fa-shopping-basket fa-3x mb-3 d-block" style="color:#dfe3f0"></i>Keranjang kosong — cari produk di atas</td></tr>');
    $('#jumlahItem').text(keranjang.length + ' item');
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
        Swal.fire({icon: 'error', title: 'Pembayaran kurang', text: 'Jumlah bayar kurang dari total ' + formatRp(total), confirmButtonColor: '#667eea'});
        return;
    }
    $('#inputKeranjang').val(JSON.stringify(keranjang));
});
</script>
<?= $this->endSection() ?>
