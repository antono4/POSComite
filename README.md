# POS Comite — Aplikasi Point of Sale

Aplikasi kasir (Point of Sale) lengkap berbasis **PHP CodeIgniter 4**, **MySQL**, dan **AdminLTE 3**.

## Fitur

| Modul | Keterangan |
|---|---|
| Dashboard | Statistik penjualan, grafik 7 hari, produk terlaris, peringatan stok menipis |
| Kasir / POS | Pencarian produk (nama/kode/barcode), keranjang, diskon, pajak, multi metode bayar (tunai/debit/kredit/QRIS/transfer), cetak struk 80mm |
| Master Data | Produk (CRUD + upload gambar), Kategori, Satuan, Supplier, Pelanggan (dengan poin) |
| Transaksi | Riwayat penjualan, detail, cetak ulang struk, pembatalan transaksi (stok kembali otomatis) |
| Pembelian | Restock dari supplier, stok & harga beli ter-update otomatis |
| Pengeluaran | Pencatatan biaya operasional |
| Laporan | Penjualan (dengan estimasi laba), Stok (nilai persediaan), Produk Terlaris |
| Pengaturan | Manajemen pengguna (role admin/kasir), pengaturan toko |

## Akun Demo

| Username | Password | Role |
|---|---|---|
| `admin` | `admin123` | Admin (akses penuh) |
| `kasir` | `kasir123` | Kasir (tanpa menu pengaturan) |

## Instalasi

```bash
# 1. Install dependency
composer install

# 2. Salin & sesuaikan konfigurasi
cp env .env
# Edit .env: app.baseURL dan database.default.*

# 3. Buat database MySQL
mysql -u root -p -e "CREATE DATABASE pos_comite"

# 4. Migrasi & seed data awal
php spark migrate
php spark db:seed PosSeeder

# 5. Jalankan
php spark serve --port 8080
```

Buka `http://localhost:8080` lalu login dengan akun demo di atas.

## Struktur Database

- `users` — pengguna (admin/kasir)
- `kategori`, `satuan`, `supplier`, `pelanggan` — master data
- `produk` — barang dengan harga beli/jual, stok, stok minimum
- `penjualan` + `penjualan_detail` — transaksi kasir
- `pembelian` + `pembelian_detail` — restock dari supplier
- `pengeluaran` — biaya operasional
- `pengaturan` — konfigurasi toko (nama, alamat, footer struk, pajak)

## Teknologi

- CodeIgniter 4.7 · PHP 8.4 · MySQL/MariaDB
- AdminLTE 3.2 · jQuery · DataTables · Select2 · Chart.js · Toastr
