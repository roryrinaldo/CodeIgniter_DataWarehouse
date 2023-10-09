<?php

namespace App\Models;
use CodeIgniter\Model;

class BankModel extends Model
{   

    
    public function getYears()
    {
        // Ambil data tahun dari tabel dim_waktu
        $query = $this->db->table('dim_waktu')->get();
        return $query->getResult();
    }

    public function getBanks()
    {
        // Ambil data bank dari tabel dim_bank
        $query = $this->db->table('dim_bank')->get();
        return $query->getResult();
    }


    public function getData($year, $bank)
    {
        // Panggil method getTopBanksByYearAndBank dengan tahun dan bank tertentu
        $topBanks = $this->getTopBanksByYearAndBank($year, $bank);

        // Buat variabel array untuk menyimpan data yang akan dikirim sebagai response AJAX
        $data = [
            'bankLabels' => [],
            'bankData'   => []
        ];

        foreach ($topBanks as $bank) {
            $data['bankLabels'][] = $bank->staf; // Ganti 'bank' dengan nama kolom yang menyimpan nama bank di tabel dim_bank
            $data['bankData'][]   = $bank->total_nasabah; // Ganti 'total_nasabah' dengan nama kolom yang menyimpan jumlah nasabah di tabel fact_nasabah
        }

        // Mengirimkan data sebagai response JSON
        return $data;
    }

    public function getTopBanksByYearAndBank($year, $bank)
    {
        // ... implementasi logika untuk mengambil data dari database berdasarkan tahun dan bank ...
        // Misalnya dengan menggunakan Query Builder untuk mengambil data dari tabel fact_nasabah dan dim_bank
        // Contoh:
        $query = $this->db->query("SELECT dim_bank.bank, dim_staf.staf, SUM(fact_nasabah.jumlah_nasabah) AS total_nasabah 
        FROM fact_nasabah 
        JOIN dim_bank ON fact_nasabah.id_bank = dim_bank.id_bank 
        JOIN dim_staf ON fact_nasabah.id_staf = dim_staf.id_staf
        WHERE fact_nasabah.id_waktu = ? AND fact_nasabah.id_bank = ?
        GROUP BY dim_bank.bank, dim_staf.staf
        ORDER BY total_nasabah DESC;
        ", [$year, $bank]);

        return $query->getResult();
    }
}