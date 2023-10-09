<?php

namespace App\Models;
use CodeIgniter\Model;

class StafModel extends Model
{   
     public function getStafs()
    {
        // Ambil data bank dari tabel dim_bank
        $query = $this->db->table('dim_staf')->get();
        return $query->getResult();
    }

    public function getData($staf)
    {
        // Panggil method getTopStafsByYearAndStaf dengan tahun dan staf tertentu
        $topStafs = $this->getTopStafsByYearAndStaf($staf);

        // Buat variabel array untuk menyimpan data yang akan dikirim sebagai response AJAX
        $data = [
            'stafLabels' => [],
            'stafData'   => []
        ];

        foreach ($topStafs as $staf) {
            $data['stafLabels'][] = $staf->waktu; // Ganti 'staf' dengan nama kolom yang menyimpan nama staf di tabel dim_staf
            $data['stafData'][]   = $staf->total_nasabah; // Ganti 'total_nasabah' dengan nama kolom yang menyimpan jumlah nasabah di tabel fact_nasabah
        }

        // Mengirimkan data sebagai response JSON
        return $data;
    }

    public function getTopStafsByYearAndStaf($staf)
    {
        // ... implementasi logika untuk mengambil data dari database berdasarkan tahun dan staf ...
        // Misalnya dengan menggunakan Query Builder untuk mengambil data dari tabel fact_nasabah dan dim_staf
        // Contoh:
        $query = $this->db->query("
                SELECT dim_staf.staf, dim_waktu.waktu, SUM(fact_nasabah.jumlah_nasabah) AS total_nasabah 
                FROM fact_nasabah 
                JOIN dim_staf ON fact_nasabah.id_staf = dim_staf.id_staf 
                JOIN dim_waktu ON fact_nasabah.id_waktu = dim_waktu.id_waktu
                WHERE fact_nasabah.id_staf = ?
                GROUP BY dim_staf.staf, dim_waktu.waktu
                ORDER BY total_nasabah DESC;",
                [$staf]);

        return $query->getResult();
    }
}