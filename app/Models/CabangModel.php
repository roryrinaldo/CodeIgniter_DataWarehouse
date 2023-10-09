<?php

namespace App\Models;
use CodeIgniter\Model;

class CabangModel extends Model
{   
    public function getYears()
    {
        // Ambil data tahun dari tabel dim_waktu
        $query = $this->db->table('dim_waktu')->get();
        return $query->getResult();
    }

    public function getCabangs()
    {
        // Ambil data bank dari tabel dim_bank
        $query = $this->db->table('dim_cabang')->get();
        return $query->getResult();
    }

    public function getData($year, $cabang)
    {
        // Panggil method getTopCabangsByYearAndCabang dengan tahun dan cabang tertentu
        $topCabangs = $this->getTopCabangsByYearAndCabang($year, $cabang);

        // Buat variabel array untuk menyimpan data yang akan dikirim sebagai response AJAX
        $data = [
            'cabangLabels' => [],
            'cabangData'   => []
        ];

        foreach ($topCabangs as $cabang) {
            $data['cabangLabels'][] = $cabang->staf; // Ganti 'cabang' dengan nama kolom yang menyimpan nama cabang di tabel dim_cabang
            $data['cabangData'][]   = $cabang->total_nasabah; // Ganti 'total_nasabah' dengan nama kolom yang menyimpan jumlah nasabah di tabel fact_nasabah
        }

        // Mengirimkan data sebagai response JSON
        return $data;
    }

    public function getTopCabangsByYearAndCabang($year, $cabang)
    {
        // ... implementasi logika untuk mengambil data dari database berdasarkan tahun dan cabang ...
        // Misalnya dengan menggunakan Query Builder untuk mengambil data dari tabel fact_nasabah dan dim_cabang
        // Contoh:
        $query = $this->db->query("SELECT dim_cabang.cabang, dim_staf.staf, SUM(fact_nasabah.jumlah_nasabah) AS total_nasabah 
                FROM fact_nasabah 
                JOIN dim_cabang ON fact_nasabah.id_cabang = dim_cabang.id_cabang 
                JOIN dim_staf ON fact_nasabah.id_staf = dim_staf.id_staf
                WHERE fact_nasabah.id_waktu = ? AND fact_nasabah.id_cabang = ?
                GROUP BY dim_cabang.cabang, dim_staf.staf
                ORDER BY total_nasabah DESC;
                ", [$year, $cabang]);

        return $query->getResult();
    }
}