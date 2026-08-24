<?php

if (!function_exists('rupiah')) {
    function rupiah($angka): string
    {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }
}

if (!function_exists('tgl_indo')) {
    function tgl_indo(?string $tanggal): string
    {
        if (empty($tanggal)) {
            return '-';
        }
        $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $ts = strtotime($tanggal);
        return date('d', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y', $ts);
    }
}

if (!function_exists('pengaturan')) {
    function pengaturan(string $key, string $default = ''): string
    {
        $db = \Config\Database::connect();
        $row = $db->table('pengaturan')->where('key', $key)->get()->getRowArray();
        return $row['value'] ?? $default;
    }
}
