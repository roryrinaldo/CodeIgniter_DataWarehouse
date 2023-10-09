<?php

namespace App\Models;
use CodeIgniter\Model;

class Fact_NasabahModel extends Model
{
    protected $table = 'fact_nasabah';
    protected $primaryKey = 'id_fact';
    protected $allowedFields = [
        'id_waktu',
        'id_staf',
        'id_produk',
        'id_sektor_usaha',
        'id_bank',
        'id_cabang',
        'id_penyebab_klaim',
        'id_status',
        'jumlah_nasabah',
        'persentase_nasabah'
    ];

    public function getAllData()
    {
        return $this->findAll();
    }

}
