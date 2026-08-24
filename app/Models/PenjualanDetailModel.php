<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanDetailModel extends Model
{
    protected $table = 'penjualan_detail';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['penjualan_id', 'produk_id', 'kode_produk', 'nama_produk', 'harga', 'qty', 'diskon', 'subtotal'];
    protected $useTimestamps = false;
}
