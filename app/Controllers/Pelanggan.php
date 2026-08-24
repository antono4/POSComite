<?php

namespace App\Controllers;

use App\Models\PelangganModel;

class Pelanggan extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PelangganModel();
    }

    public function index()
    {
        return view('pelanggan/index', [
            'title'     => 'Data Pelanggan',
            'pelanggan' => $this->model->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function simpan()
    {
        $id = $this->request->getPost('id');
        if (!$this->validate(['nama' => 'required|max_length[100]'])) {
            return redirect()->back()->withInput()->with('error', 'Nama pelanggan wajib diisi');
        }
        $data = [
            'nama'    => $this->request->getPost('nama'),
            'telepon' => $this->request->getPost('telepon'),
            'alamat'  => $this->request->getPost('alamat'),
        ];
        if ($id) {
            $this->model->update($id, $data);
            $pesan = 'Pelanggan berhasil diperbarui';
        } else {
            $data['kode'] = $this->generateKode();
            $this->model->insert($data);
            $pesan = 'Pelanggan berhasil ditambahkan';
        }
        return redirect()->to('/pelanggan')->with('success', $pesan);
    }

    public function hapus($id)
    {
        $this->model->delete($id);
        return redirect()->to('/pelanggan')->with('success', 'Pelanggan berhasil dihapus');
    }

    private function generateKode(): string
    {
        $last = $this->model->orderBy('id', 'DESC')->first();
        $next = $last ? ((int) substr($last['kode'], 3)) + 1 : 1;
        return 'PLG' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
