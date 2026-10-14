<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        $data = [
            'title' => 'login'
        ];

        return view('auth/login', $data);
    }

    public function attemptLogin()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $this->userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] !== 'approved') {
                session()->setFlashdata('error', 'Akun Anda belum disetujui admin.');
                return redirect()->back()->withInput();
            }

            session()->set([
                'username'   => $user['username'],
                'role'       => $user['role'],
                'isLoggedIn' => true
            ]);

            return redirect()->to('/home');
        }

        session()->setFlashdata('error', 'Username atau password salah.');
        return redirect()->back()->withInput();
    }


    public function register()
    {
        $data = [
            'title' => 'Regis'
        ];
        return view('auth/register', $data);
    }

    public function processRegister()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $this->userModel->save([
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'     => 'user',
            'status'   => 'pending'
        ]);

        session()->setFlashdata('success', 'Pendaftaran berhasil, menunggu persetujuan admin.');
        return redirect()->to('/');
    }

    public function registerAdmin()
    {
        $data = [
            'title' => 'Registrasi Admin'
        ];
        return view('auth/registadmin', $data);
    }

    public function processRegisterAdmin()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'username' => 'required|is_unique[users.username]|min_length[3]|max_length[20]',
            'password' => 'required|min_length[6]|max_length[50]',
            'password_conf' => 'required|matches[password]'
        ];

        $messages = [
            'username' => [
                'required' => 'Username wajib diisi',
                'is_unique' => 'Username sudah digunakan',
                'min_length' => 'Username minimal 3 karakter',
                'max_length' => 'Username maksimal 20 karakter'
            ],
            'password' => [
                'required' => 'Password wajib diisi',
                'min_length' => 'Password minimal 6 karakter',
                'max_length' => 'Password maksimal 50 karakter'
            ],
            'password_conf' => [
                'required' => 'Konfirmasi password wajib diisi',
                'matches' => 'Konfirmasi password tidak cocok'
            ]
        ];

        $validation->setRules($rules, $messages);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $this->userModel->save([
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'     => 'admin',
            'status'   => 'approved'
        ]);

        session()->setFlashdata('success', 'Registrasi admin berhasil!');
        return redirect()->to('/akun');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
