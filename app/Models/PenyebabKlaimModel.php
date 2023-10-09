<?php

namespace App\Models;
use CodeIgniter\Model;

class PenyebabKlaimModel extends Model
{   

    public function getYears()
    {
      // Ambil data tahun dari tabel dim_waktu
      $query = $this->db->table('dim_waktu')->get();
      return $query->getResult();
    }

    public function getPenyebabKlaims()
    {
        // Ambil data penyebab klaim dari tabel dim_penyebab_klaim
        $query = $this->db->table('dim_penyebab_klaim')->get();
        return $query->getResult();
    }

    public function getData($year, $penyebabKlaim)
    {
        // Implement the logic to get data based on year and penyebabKlaim using Query Builder
        $query = $this->db->query("SELECT dim_staf.staf, dim_penyebab_klaim.penyebab_klaim, SUM(fact_nasabah.jumlah_nasabah) AS total_nasabah 
            FROM fact_nasabah 
            JOIN dim_penyebab_klaim ON fact_nasabah.id_penyebab_klaim = dim_penyebab_klaim.id_penyebab_klaim 
            JOIN dim_staf ON fact_nasabah.id_staf = dim_staf.id_staf 
            WHERE fact_nasabah.id_waktu = ? AND fact_nasabah.id_penyebab_klaim = ?
            GROUP BY dim_penyebab_klaim.penyebab_klaim,dim_staf.staf
            ORDER BY total_nasabah DESC", [$year, $penyebabKlaim]);

        // Prepare the response data
        $data = [
            'penyebabKlaimLabels' => [],
            'penyebabKlaimData'   => []
        ];

        foreach ($query->getResult() as $penyebabKlaimData) {
            $data['penyebabKlaimLabels'][] = $penyebabKlaimData->staf;
            $data['penyebabKlaimData'][]   = $penyebabKlaimData->total_nasabah;
        }

        return $data;
    }

}
