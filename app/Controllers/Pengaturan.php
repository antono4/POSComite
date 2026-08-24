<?php

namespace App\Controllers;

use App\Models\PengaturanModel;

class Pengaturan extends BaseController
{
    public function index()
    {
        $rows = (new PengaturanModel())->findAll();
        $pengaturan = [];
        foreach ($rows as $r) {
            $pengaturan[$r['key']] = $r['value'];
        }
        return view('pengaturan/index', [
            'title'      => 'Pengaturan Toko',
            'pengaturan' => $pengaturan,
        ]);
    }

    public function simpan()
    {
        $model = new PengaturanModel();
        $keys = ['nama_toko', 'alamat', 'telepon', 'footer_struk', 'pajak_persen'];
        foreach ($keys as $key) {
            $value = $this->request->getPost($key);
            $existing = $model->where('key', $key)->first();
            if ($existing) {
                $model->update($existing['id'], ['value' => $value]);
            } else {
                $model->insert(['key' => $key, 'value' => $value]);
            }
        }
        return redirect()->to('/pengaturan')->with('success', 'Pengaturan berhasil disimpan');
    }
}
