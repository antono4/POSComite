<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianModel extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['no_faktur', 'tanggal', 'supplier_id', 'user_id', 'total', 'status'];
    protected $useTimestamps = false;
}
