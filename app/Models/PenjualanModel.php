<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['no_invoice', 'tanggal', 'pelanggan_id', 'user_id', 'subtotal', 'diskon', 'pajak', 'total', 'bayar', 'kembali', 'metode_bayar', 'status', 'catatan'];
    protected $useTimestamps = false;
}
