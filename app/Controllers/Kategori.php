<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KategoriModel();
    }

    public function index()
    {
        return view('kategori/index', [
            'title'    => 'Kategori Produk',
            'kategori' => $this->model->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function simpan()
    {
        $id = $this->request->getPost('id');
        if (!$this->validate(['nama' => 'required|max_length[100]'])) {
            return redirect()->back()->withInput()->with('error', 'Nama kategori wajib diisi');
        }
        $data = ['nama' => $this->request->getPost('nama'), 'deskripsi' => $this->request->getPost('deskripsi')];
        if ($id) {
            $this->model->update($id, $data);
            $pesan = 'Kategori berhasil diperbarui';
        } else {
            $this->model->insert($data);
            $pesan = 'Kategori berhasil ditambahkan';
        }
        return redirect()->to('/kategori')->with('success', $pesan);
    }

    public function hapus($id)
    {
        $this->model->delete($id);
        return redirect()->to('/kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
