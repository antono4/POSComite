<?php

namespace App\Controllers;

use App\Models\SatuanModel;

class Satuan extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SatuanModel();
    }

    public function index()
    {
        return view('satuan/index', [
            'title'  => 'Satuan Produk',
            'satuan' => $this->model->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function simpan()
    {
        $id = $this->request->getPost('id');
        if (!$this->validate(['nama' => 'required|max_length[50]'])) {
            return redirect()->back()->withInput()->with('error', 'Nama satuan wajib diisi');
        }
        $data = ['nama' => $this->request->getPost('nama')];
        if ($id) {
            $this->model->update($id, $data);
            $pesan = 'Satuan berhasil diperbarui';
        } else {
            $this->model->insert($data);
            $pesan = 'Satuan berhasil ditambahkan';
        }
        return redirect()->to('/satuan')->with('success', $pesan);
    }

    public function hapus($id)
    {
        $this->model->delete($id);
        return redirect()->to('/satuan')->with('success', 'Satuan berhasil dihapus');
    }
}
