<?php

namespace App\Controllers;

use App\Models\PengeluaranModel;

class Pengeluaran extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PengeluaranModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $pengeluaran = $db->table('pengeluaran pg')
            ->select('pg.*, u.nama as user')
            ->join('users u', 'u.id = pg.user_id')
            ->orderBy('pg.tanggal', 'DESC')->get()->getResultArray();

        return view('pengeluaran/index', [
            'title'       => 'Pengeluaran',
            'pengeluaran' => $pengeluaran,
        ]);
    }

    public function simpan()
    {
        $id = $this->request->getPost('id');
        if (!$this->validate([
            'tanggal'    => 'required|valid_date',
            'keterangan' => 'required|max_length[255]',
            'jumlah'     => 'required|numeric',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi dengan benar');
        }

        $data = [
            'tanggal'    => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'jumlah'     => $this->request->getPost('jumlah'),
            'user_id'    => session()->get('user_id'),
        ];

        if ($id) {
            $this->model->update($id, $data);
            $pesan = 'Pengeluaran berhasil diperbarui';
        } else {
            $this->model->insert($data);
            $pesan = 'Pengeluaran berhasil ditambahkan';
        }
        return redirect()->to('/pengeluaran')->with('success', $pesan);
    }

    public function hapus($id)
    {
        $this->model->delete($id);
        return redirect()->to('/pengeluaran')->with('success', 'Pengeluaran berhasil dihapus');
    }
}
