<?php

namespace App\Controllers;

use App\Models\SupplierModel;

class Supplier extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SupplierModel();
    }

    public function index()
    {
        return view('supplier/index', [
            'title'    => 'Data Supplier',
            'supplier' => $this->model->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function simpan()
    {
        $id = $this->request->getPost('id');
        if (!$this->validate(['nama' => 'required|max_length[100]'])) {
            return redirect()->back()->withInput()->with('error', 'Nama supplier wajib diisi');
        }
        $data = [
            'nama'    => $this->request->getPost('nama'),
            'telepon' => $this->request->getPost('telepon'),
            'email'   => $this->request->getPost('email'),
            'alamat'  => $this->request->getPost('alamat'),
        ];
        if ($id) {
            $this->model->update($id, $data);
            $pesan = 'Supplier berhasil diperbarui';
        } else {
            $data['kode'] = $this->generateKode();
            $this->model->insert($data);
            $pesan = 'Supplier berhasil ditambahkan';
        }
        return redirect()->to('/supplier')->with('success', $pesan);
    }

    public function hapus($id)
    {
        $this->model->delete($id);
        return redirect()->to('/supplier')->with('success', 'Supplier berhasil dihapus');
    }

    private function generateKode(): string
    {
        $last = $this->model->orderBy('id', 'DESC')->first();
        $next = $last ? ((int) substr($last['kode'], 3)) + 1 : 1;
        return 'SUP' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
