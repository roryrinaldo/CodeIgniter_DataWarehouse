<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['nama_user', 'username', 'password', 'level'];

    public function checkLogin($username, $password)
    {
        return $this->where('username', $username)
            ->where('password', $password)
            ->first();
    }

    public function getAllUsers()
    {
        return $this->findAll();
    }

    public function insertUser($data)
    {
        $this->insert($data);
    }

    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteUser($id)
    {
        $this->where('id_user', $id)->delete();
    }

    public function getUserById($id)
    {
        return $this->find($id);
    }

}

