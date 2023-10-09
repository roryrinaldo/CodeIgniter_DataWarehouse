<?php

namespace App\Models;
use CodeIgniter\Model;

class StatusModel extends Model
{   

    public function getYears()
    {
        // Ambil data tahun dari tabel dim_waktu
        $query = $this->db->table('dim_waktu')->get();
        return $query->getResult();
    }

    public function getStatuses()
    {
        // Ambil data status dari tabel dim_status
        $query = $this->db->table('dim_status')->get();
        return $query->getResult();
    }

    public function getData($year, $status)
    {
        // Implement the logic to get data based on year and statusId using Query Builder
        $query = $this->db->query("SELECT dim_staf.staf, dim_status.status, SUM(fact_nasabah.jumlah_nasabah) AS total_nasabah 
            FROM fact_nasabah 
            JOIN dim_status ON fact_nasabah.id_status = dim_status.id_status 
            JOIN dim_staf ON fact_nasabah.id_staf = dim_staf.id_staf
            WHERE fact_nasabah.id_waktu = ? AND fact_nasabah.id_status = ?
            GROUP BY dim_status.status,dim_staf.staf
            ORDER BY total_nasabah DESC", [$year, $status]);

        // Prepare the response data
        $data = [
            'statusLabels' => [],
            'statusData'   => []
        ];

        foreach ($query->getResult() as $statusData) {
            $data['statusLabels'][] = $statusData->staf;
            $data['statusData'][]   = $statusData->total_nasabah;
        }

        return $data;
    }
}