<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PosSeeder extends Seeder
{
    public function run()
    {
        // Users
        $this->db->table('users')->insertBatch([
            [
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'nama'       => 'Administrator',
                'role'       => 'admin',
                'aktif'      => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'kasir',
                'password'   => password_hash('kasir123', PASSWORD_DEFAULT),
                'nama'       => 'Kasir Toko',
                'role'       => 'kasir',
                'aktif'      => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        // Kategori
        $kategori = [
            ['nama' => 'Makanan', 'deskripsi' => 'Produk makanan'],
            ['nama' => 'Minuman', 'deskripsi' => 'Produk minuman'],
            ['nama' => 'Snack', 'deskripsi' => 'Makanan ringan'],
            ['nama' => 'Kebutuhan Rumah Tangga', 'deskripsi' => 'Produk rumah tangga'],
            ['nama' => 'Perawatan Diri', 'deskripsi' => 'Produk perawatan tubuh'],
        ];
        foreach ($kategori as &$k) {
            $k['created_at'] = date('Y-m-d H:i:s');
        }
        $this->db->table('kategori')->insertBatch($kategori);

        // Satuan
        $this->db->table('satuan')->insertBatch([
            ['nama' => 'Pcs'],
            ['nama' => 'Box'],
            ['nama' => 'Pack'],
            ['nama' => 'Kg'],
            ['nama' => 'Liter'],
            ['nama' => 'Botol'],
        ]);

        // Supplier
        $this->db->table('supplier')->insertBatch([
            ['kode' => 'SUP001', 'nama' => 'CV Sumber Jaya', 'telepon' => '081234567890', 'email' => 'sumberjaya@email.com', 'alamat' => 'Jl. Merdeka No. 10, Jakarta', 'created_at' => date('Y-m-d H:i:s')],
            ['kode' => 'SUP002', 'nama' => 'PT Distribusi Nusantara', 'telepon' => '081298765432', 'email' => 'nusantara@email.com', 'alamat' => 'Jl. Sudirman No. 25, Bandung', 'created_at' => date('Y-m-d H:i:s')],
        ]);

        // Pelanggan
        $this->db->table('pelanggan')->insertBatch([
            ['kode' => 'PLG000', 'nama' => 'Umum', 'telepon' => null, 'alamat' => null, 'poin' => 0, 'created_at' => date('Y-m-d H:i:s')],
            ['kode' => 'PLG001', 'nama' => 'Budi Santoso', 'telepon' => '081311122233', 'alamat' => 'Jl. Kenanga No. 5', 'poin' => 0, 'created_at' => date('Y-m-d H:i:s')],
        ]);

        // Produk contoh
        $produk = [
            ['kode' => 'PRD001', 'barcode' => '8991002000011', 'nama' => 'Indomie Goreng', 'kategori_id' => 1, 'satuan_id' => 1, 'harga_beli' => 2500, 'harga_jual' => 3500, 'stok' => 100],
            ['kode' => 'PRD002', 'barcode' => '8991002000028', 'nama' => 'Aqua 600ml', 'kategori_id' => 2, 'satuan_id' => 6, 'harga_beli' => 2500, 'harga_jual' => 4000, 'stok' => 150],
            ['kode' => 'PRD003', 'barcode' => '8991002000035', 'nama' => 'Teh Pucuk 350ml', 'kategori_id' => 2, 'satuan_id' => 6, 'harga_beli' => 2800, 'harga_jual' => 4000, 'stok' => 80],
            ['kode' => 'PRD004', 'barcode' => '8991002000042', 'nama' => 'Chitato Sapi Panggang', 'kategori_id' => 3, 'satuan_id' => 1, 'harga_beli' => 8000, 'harga_jual' => 11000, 'stok' => 50],
            ['kode' => 'PRD005', 'barcode' => '8991002000059', 'nama' => 'Beras Pandan Wangi 5kg', 'kategori_id' => 1, 'satuan_id' => 4, 'harga_beli' => 60000, 'harga_jual' => 70000, 'stok' => 20],
            ['kode' => 'PRD006', 'barcode' => '8991002000066', 'nama' => 'Minyak Goreng 2L', 'kategori_id' => 4, 'satuan_id' => 6, 'harga_beli' => 38000, 'harga_jual' => 44000, 'stok' => 30],
            ['kode' => 'PRD007', 'barcode' => '8991002000073', 'nama' => 'Sabun Lifebuoy', 'kategori_id' => 5, 'satuan_id' => 1, 'harga_beli' => 3500, 'harga_jual' => 5000, 'stok' => 60],
            ['kode' => 'PRD008', 'barcode' => '8991002000080', 'nama' => 'Shampo Clear 170ml', 'kategori_id' => 5, 'satuan_id' => 6, 'harga_beli' => 18000, 'harga_jual' => 24000, 'stok' => 25],
            ['kode' => 'PRD009', 'barcode' => '8991002000097', 'nama' => 'Kopi Kapal Api Sachet', 'kategori_id' => 2, 'satuan_id' => 3, 'harga_beli' => 11000, 'harga_jual' => 15000, 'stok' => 40],
            ['kode' => 'PRD010', 'barcode' => '8991002000103', 'nama' => 'Susu Ultra Milk 1L', 'kategori_id' => 2, 'satuan_id' => 5, 'harga_beli' => 17000, 'harga_jual' => 21000, 'stok' => 35],
        ];
        foreach ($produk as &$p) {
            $p['created_at'] = date('Y-m-d H:i:s');
        }
        $this->db->table('produk')->insertBatch($produk);

        // Pengaturan toko
        $this->db->table('pengaturan')->insertBatch([
            ['key' => 'nama_toko', 'value' => 'POS Comite Store'],
            ['key' => 'alamat', 'value' => 'Jl. Contoh No. 123, Jakarta'],
            ['key' => 'telepon', 'value' => '(021) 1234567'],
            ['key' => 'footer_struk', 'value' => 'Terima kasih telah berbelanja!'],
            ['key' => 'pajak_persen', 'value' => '0'],
        ]);
    }
}
