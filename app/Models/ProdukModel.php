<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['kode', 'barcode', 'nama', 'kategori_id', 'satuan_id', 'harga_beli', 'harga_jual', 'stok', 'stok_min', 'gambar', 'aktif'];
    protected $useTimestamps = false;
}
