<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Struk <?= esc($penjualan['no_invoice']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; font-size: 12px; width: 80mm; margin: 0 auto; padding: 10px; }
        .center { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 6px 0; }
        table { width: 100%; border-collapse: collapse; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .item-name { padding-top: 4px; }
        @media print {
            .no-print { display: none; }
            body { width: auto; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom:10px;text-align:center">
        <button onclick="window.print()">🖨️ Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    <div class="center">
        <div class="bold" style="font-size:16px"><?= esc(pengaturan('nama_toko', 'POS Comite')) ?></div>
        <div><?= esc(pengaturan('alamat')) ?></div>
        <div>Telp: <?= esc(pengaturan('telepon')) ?></div>
    </div>
    <div class="line"></div>
    <table>
        <tr><td>No</td><td class="right"><?= esc($penjualan['no_invoice']) ?></td></tr>
        <tr><td>Tanggal</td><td class="right"><?= date('d/m/Y H:i', strtotime($penjualan['tanggal'])) ?></td></tr>
        <tr><td>Kasir</td><td class="right"><?= esc($kasir['nama'] ?? '-') ?></td></tr>
        <tr><td>Pelanggan</td><td class="right"><?= esc($pelanggan['nama'] ?? 'Umum') ?></td></tr>
    </table>
    <div class="line"></div>
    <?php foreach ($detail as $d): ?>
    <div class="item-name"><?= esc($d['nama_produk']) ?></div>
    <table>
        <tr>
            <td>&nbsp;&nbsp;<?= $d['qty'] ?> x <?= number_format($d['harga'], 0, ',', '.') ?></td>
            <td class="right"><?= number_format($d['subtotal'], 0, ',', '.') ?></td>
        </tr>
    </table>
    <?php endforeach; ?>
    <div class="line"></div>
    <table>
        <tr><td>Subtotal</td><td class="right"><?= number_format($penjualan['subtotal'], 0, ',', '.') ?></td></tr>
        <?php if ($penjualan['diskon'] > 0): ?>
        <tr><td>Diskon</td><td class="right">-<?= number_format($penjualan['diskon'], 0, ',', '.') ?></td></tr>
        <?php endif; ?>
        <?php if ($penjualan['pajak'] > 0): ?>
        <tr><td>Pajak</td><td class="right">+<?= number_format($penjualan['pajak'], 0, ',', '.') ?></td></tr>
        <?php endif; ?>
        <tr class="bold"><td>TOTAL</td><td class="right"><?= number_format($penjualan['total'], 0, ',', '.') ?></td></tr>
        <tr><td>Bayar (<?= strtoupper($penjualan['metode_bayar']) ?>)</td><td class="right"><?= number_format($penjualan['bayar'], 0, ',', '.') ?></td></tr>
        <tr><td>Kembali</td><td class="right"><?= number_format($penjualan['kembali'], 0, ',', '.') ?></td></tr>
    </table>
    <div class="line"></div>
    <div class="center">
        <div><?= esc(pengaturan('footer_struk', 'Terima kasih!')) ?></div>
        <div style="margin-top:4px">Dicetak: <?= date('d/m/Y H:i') ?></div>
    </div>
</body>
</html>
