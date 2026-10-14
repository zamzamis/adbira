<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $path = strtolower(trim($request->getUri()->getPath(), '/'));

        // Rute yang tidak butuh login
        $publicPaths = [
            'login',
            'auth/attemptlogin',
            'logout',
            'register',
            'register/process'
        ];

        if (in_array($path, $publicPaths)) {
            return;
        }

        // Jika belum login
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek role jika ada pembatasan
        if ($arguments) {
            $userRole = $session->get('role');
            if (!in_array($userRole, $arguments)) {
                return redirect()->to('/home')->with('error', 'Anda tidak punya akses ke halaman ini.');
            }
        }
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu kode khusus setelah permintaan
    }
}
