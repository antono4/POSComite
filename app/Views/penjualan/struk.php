<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Struk <?= esc($penjualan['no_invoice']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            
            font-family: 'Courier New', monospace;
            font-size: 12px;
            width: 80mm;
            margin: 0 auto;
            padding: 14px 10px;
            background: #fff;
        }
        .header-logo {
            width: 46px; height: 46px; border-radius: 12px;
            background: #1e1e2d; color: #fff; margin: 0 auto 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; font-weight: bold;
        }
        .center { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 7px 0; }
        table { width: 100%; border-collapse: collapse; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .item-name { padding-top: 4px; }
        .total-row td { font-size: 14px; font-weight: bold; padding-top: 4px; }
        .footer-box {
            border: 1px dashed #000; border-radius: 6px;
            margin-top: 10px; padding: 8px; text-align: center;
        }
        .no-print {
            position: fixed; top: 14px; left: 50%; transform: translateX(-50%);
            display: flex; gap: 8px; z-index: 10;
        }
        .no-print button {
            border: none; border-radius: 8px; padding: 9px 18px;
            font-size: 13px; font-weight: 600; cursor: pointer;
            box-shadow: 0 4px 14px rgba(0,0,0,0.2);
        }
        .btn-print { background: linear-gradient(135deg,#11998e,#38ef7d); color: #fff; }
        .btn-close { background: #1e1e2d; color: #fff; }
        @media print {
            .no-print { display: none; }
            body { width: auto; }
        }
        @page { margin: 0; }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Struk</button>
        <button class="btn-close" onclick="window.close()">✖ Tutup</button>
    </div>

    <div class="header-logo">P</div>
    <div class="center">
        <div class="bold" style="font-size:17px;letter-spacing:.5px"><?= esc(pengaturan('nama_toko', 'POS Comite')) ?></div>
        <div style="margin-top:3px"><?= esc(pengaturan('alamat')) ?></div>
        <div>Telp: <?= esc(pengaturan('telepon')) ?></div>
    </div>
    <div class="line"></div>
    <table>
        <tr><td>No. Invoice</td><td class="right bold"><?= esc($penjualan['no_invoice']) ?></td></tr>
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
        <tr class="total-row"><td>TOTAL</td><td class="right">Rp <?= number_format($penjualan['total'], 0, ',', '.') ?></td></tr>
        <tr><td>Bayar (<?= strtoupper($penjualan['metode_bayar']) ?>)</td><td class="right"><?= number_format($penjualan['bayar'], 0, ',', '.') ?></td></tr>
        <tr><td>Kembali</td><td class="right"><?= number_format($penjualan['kembali'], 0, ',', '.') ?></td></tr>
    </table>
    <div class="footer-box">
        <div class="bold"><?= esc(pengaturan('footer_struk', 'Terima kasih!')) ?></div>
        <div style="margin-top:3px">Dicetak: <?= date('d/m/Y H:i') ?></div>
    </div>
</body>
</html>
