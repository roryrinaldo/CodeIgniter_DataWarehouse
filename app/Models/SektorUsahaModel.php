<?php

namespace App\Models;
use CodeIgniter\Model;

class SektorUsahaModel extends Model
{   
    public function getYears()
    {
      // Ambil data tahun dari tabel dim_waktu
      $query = $this->db->table('dim_waktu')->get();
      return $query->getResult();
    }

    public function getSektorUsahas()
    {
        // Ambil data sektor usaha dari tabel dim_sektor_usaha
        $query = $this->db->table('dim_sektor_usaha')->get();
        return $query->getResult();
    }

    public function getData($year, $sektorUsaha)
    {
        // Implement the logic to get data based on year and sektorUsaha using Query Builder
        $query = $this->db->query("SELECT dim_staf.staf, dim_sektor_usaha.sektor_usaha, SUM(fact_nasabah.jumlah_nasabah) AS total_nasabah 
            FROM fact_nasabah 
            JOIN dim_sektor_usaha ON fact_nasabah.id_sektor_usaha = dim_sektor_usaha.id_sektor_usaha 
            JOIN dim_staf ON fact_nasabah.id_staf = dim_staf.id_staf
            WHERE fact_nasabah.id_waktu = ? AND fact_nasabah.id_sektor_usaha = ?
            GROUP BY dim_sektor_usaha.sektor_usaha,dim_staf.staf
            ORDER BY total_nasabah DESC", [$year, $sektorUsaha]);

        // Prepare the response data
        $data = [
            'sektorUsahaLabels' => [],
            'sektorUsahaData'   => []
        ];

        foreach ($query->getResult() as $sektorUsahaData) {
            $data['sektorUsahaLabels'][] = $sektorUsahaData->staf;
            $data['sektorUsahaData'][]   = $sektorUsahaData->total_nasabah;
        }

        return $data;
    }

  
}
