<?php

namespace App\Controllers;
use App\Models\UserModel;

class AkunController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $approvedUsers = $this->userModel->where('status', 'approved')->findAll();
        $pendingUsers = $this->userModel->where('status', 'pending')->findAll();

        $data = [
            'title' => 'Daftar Akun',
            'akun'  => $approvedUsers,
            'pendingUsers' => $pendingUsers
        ];

        return view('auth/index', $data);
    }

    public function approve($id)
    {
        $this->userModel->update($id, ['status' => 'approved']);
        session()->setFlashdata('success', 'Akun berhasil disetujui.');
        return redirect()->to('/akun');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('success', 'Akun berhasil dihapus.');
        return redirect()->to('/akun');
    }
}
