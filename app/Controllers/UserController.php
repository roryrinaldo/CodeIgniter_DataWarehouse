<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('user/user', $data);
    }

    public function create()
    {
        return view('user/create_user');
    }

    public function store()
    {
        $data = [
            'nama_user' => $this->request->getPost('nama_user'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'level' => $this->request->getPost('level')
        ];

        $this->userModel->insertUser($data);

        return redirect()->to(base_url('user'));
    }

    public function edit($id)
    {
        $data['user'] = $this->userModel->getUserById($id);
        return view('user/edit_user', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id_user');
        
        $data = [
            'nama_user' => $this->request->getPost('nama_user'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'level' => $this->request->getPost('level')
        ];

        if ($this->userModel->updateUser($id, $data)) {
            return redirect()->to(base_url('user'))->with('success', 'Data pengguna berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('user'))->with('error', 'Gagal memperbarui data pengguna.');
        }
    }

    public function delete($id)
    {
        $this->userModel->deleteUser($id);

        return redirect()->to(base_url('user'));
    }
}
