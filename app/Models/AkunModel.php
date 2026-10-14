<?php

namespace App\Models;

use CodeIgniter\Model;

class AkunModel extends Model
{
    protected $table = 'users'; // sesuaikan dengan nama tabel akun kamu
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role'];
}
