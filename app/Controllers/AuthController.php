<?php

namespace App\Controllers;
use App\Models\UserModel;

class AuthController extends BaseController
{

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {

        // Cek apakah pengguna sudah memiliki sesi
        if (session()->has('user')) {
            // Jika sudah memiliki sesi, redirect ke halaman dashboard atau halaman lainnya
            return redirect()->to('/');
         }   

        // Jika belum memiliki sesi, tampilkan halaman login
        return view('auth/login');
            
    }

    public function proses_login()
    {
        // Mengambil data dari formulir login
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Memeriksa keberadaan pengguna berdasarkan username dan password
        $user = $this->userModel->checkLogin($username, $password);

        if ($user) {
            // Login berhasil

            // Simpan data login atau sesi pengguna (jika perlu)
            $userSessionData = [
                'user_id' => $user['id_user'],
                'username' => $user['username'],
                'level' => $user['level'], // Menyimpan tingkat hak akses pengguna
                // Informasi lain yang mungkin perlu disimpan
            ];

            session()->set('user', $userSessionData);

            // Redirect ke halaman dashboard atau halaman lainnya
            return redirect()->to('/');
        } else {
            // Login gagal
            // Redirect kembali ke halaman login dengan pesan error
            return redirect()->back()->with('error', 'Invalid username or password');
        }
    }

    public function proses_logout()
    {
        // Hapus sesi pengguna
        session()->remove('user');

        // Redirect ke halaman login
        return redirect()->to('/login');
    }

    public function getLevel()
    {
        // Cek apakah pengguna sudah login dan memiliki sesi
        if (session()->has('user')) {
            // Ambil data tingkat hak akses pengguna dari sesi
            $userSessionData = session('user');
            $level = $userSessionData['level'];

            return $level;
        }

        // Jika pengguna belum login atau tidak memiliki sesi, kembalikan nilai default (misalnya: 0 untuk pengguna biasa)
        return 0;
    }
}
