<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianDetailModel extends Model
{
    protected $table = 'pembelian_detail';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['pembelian_id', 'produk_id', 'harga_beli', 'qty', 'subtotal'];
    protected $useTimestamps = false;
}
