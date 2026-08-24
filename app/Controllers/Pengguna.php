<?php

namespace App\Controllers;

use App\Models\UserModel;

class Pengguna extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        return view('pengguna/index', [
            'title' => 'Manajemen Pengguna',
            'users' => $this->model->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function simpan()
    {
        $id = $this->request->getPost('id');
        $rules = [
            'username' => "required|max_length[50]|is_unique[users.username,id,$id]",
            'nama'     => 'required|max_length[100]',
            'role'     => 'required|in_list[admin,kasir]',
        ];
        if (!$id || $this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'nama'     => $this->request->getPost('nama'),
            'role'     => $this->request->getPost('role'),
            'aktif'    => $this->request->getPost('aktif') ? 1 : 0,
        ];
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($id) {
            $this->model->update($id, $data);
            $pesan = 'Pengguna berhasil diperbarui';
        } else {
            $this->model->insert($data);
            $pesan = 'Pengguna berhasil ditambahkan';
        }
        return redirect()->to('/pengguna')->with('success', $pesan);
    }

    public function hapus($id)
    {
        if ($id == session()->get('user_id')) {
            return redirect()->to('/pengguna')->with('error', 'Tidak dapat menghapus akun sendiri');
        }
        $this->model->delete($id);
        return redirect()->to('/pengguna')->with('success', 'Pengguna berhasil dihapus');
    }
}
