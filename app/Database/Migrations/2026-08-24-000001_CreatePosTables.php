<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePosTables extends Migration
{
    public function up()
    {
        // Tabel users (kasir & admin)
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'username'   => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'role'       => ['type' => 'ENUM("admin","kasir")', 'default' => 'kasir'],
            'foto'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'aktif'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);

        // Tabel kategori
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'deskripsi'  => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kategori', true);

        // Tabel satuan
        $this->forge->addField([
            'id'   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('satuan', true);

        // Tabel supplier
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'telepon'    => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'alamat'     => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('supplier', true);

        // Tabel pelanggan/member
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'       => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'telepon'    => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'alamat'     => ['type' => 'TEXT', 'null' => true],
            'poin'       => ['type' => 'INT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pelanggan', true);

        // Tabel produk
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode'        => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'barcode'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'nama'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'kategori_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'satuan_id'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'harga_beli'  => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'harga_jual'  => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'stok'        => ['type' => 'INT', 'default' => 0],
            'stok_min'    => ['type' => 'INT', 'default' => 5],
            'gambar'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'aktif'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kategori_id', 'kategori', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('satuan_id', 'satuan', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('produk', true);

        // Tabel penjualan (header transaksi)
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'no_invoice'   => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'tanggal'      => ['type' => 'DATETIME'],
            'pelanggan_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'user_id'      => ['type' => 'INT', 'unsigned' => true],
            'subtotal'     => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'diskon'       => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'pajak'        => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'total'        => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'bayar'        => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'kembali'      => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'metode_bayar' => ['type' => 'ENUM("tunai","debit","kredit","qris","transfer")', 'default' => 'tunai'],
            'status'       => ['type' => 'ENUM("selesai","batal")', 'default' => 'selesai'],
            'catatan'      => ['type' => 'TEXT', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pelanggan_id', 'pelanggan', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('penjualan', true);

        // Tabel detail penjualan
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'penjualan_id' => ['type' => 'INT', 'unsigned' => true],
            'produk_id'    => ['type' => 'INT', 'unsigned' => true],
            'kode_produk'  => ['type' => 'VARCHAR', 'constraint' => 30],
            'nama_produk'  => ['type' => 'VARCHAR', 'constraint' => 150],
            'harga'        => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'qty'          => ['type' => 'INT', 'default' => 1],
            'diskon'       => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'subtotal'     => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('penjualan_id', 'penjualan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produk_id', 'produk', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('penjualan_detail', true);

        // Tabel pembelian (restock dari supplier)
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'no_faktur'   => ['type' => 'VARCHAR', 'constraint' => 30, 'unique' => true],
            'tanggal'     => ['type' => 'DATE'],
            'supplier_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'user_id'     => ['type' => 'INT', 'unsigned' => true],
            'total'       => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'status'      => ['type' => 'ENUM("diterima","pending")', 'default' => 'diterima'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('supplier_id', 'supplier', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('pembelian', true);

        // Tabel detail pembelian
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'pembelian_id' => ['type' => 'INT', 'unsigned' => true],
            'produk_id'    => ['type' => 'INT', 'unsigned' => true],
            'harga_beli'   => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'qty'          => ['type' => 'INT', 'default' => 1],
            'subtotal'     => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pembelian_id', 'pembelian', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('produk_id', 'produk', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('pembelian_detail', true);

        // Tabel pengeluaran
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'     => ['type' => 'DATE'],
            'keterangan'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'jumlah'      => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'user_id'     => ['type' => 'INT', 'unsigned' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('pengeluaran', true);

        // Tabel pengaturan toko
        $this->forge->addField([
            'id'    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'key'   => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'value' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengaturan', true);
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan', true);
        $this->forge->dropTable('pengeluaran', true);
        $this->forge->dropTable('pembelian_detail', true);
        $this->forge->dropTable('pembelian', true);
        $this->forge->dropTable('penjualan_detail', true);
        $this->forge->dropTable('penjualan', true);
        $this->forge->dropTable('produk', true);
        $this->forge->dropTable('pelanggan', true);
        $this->forge->dropTable('supplier', true);
        $this->forge->dropTable('satuan', true);
        $this->forge->dropTable('kategori', true);
        $this->forge->dropTable('users', true);
    }
}
