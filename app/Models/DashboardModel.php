<?php

namespace App\Models;
use CodeIgniter\Model;

class DashboardModel extends Model
{   


    public function getNumCustomers()
    {
        $query = $this->db->table('data')->countAll();
        return $query;
    }

    public function getNumYears()
    {
        $query = $this->db->table('dim_waktu')->countAll();
        return $query;
    }

    public function getNumStafs()
    {
        $query = $this->db->table('dim_staf')->countAll();
        return $query;
    }

    public function getNumBanks()
    {
        $query = $this->db->table('dim_bank')->countAll();
        return $query;
    }

    public function getTopStafs()
    {
        // Implement the logic to get data for the top 10 stafs with the highest total jumlah_nasabah
        $query = $this->db->query("SELECT dim_staf.staf, SUM(fact_nasabah.jumlah_nasabah) AS total_nasabah 
            FROM fact_nasabah 
            JOIN dim_staf ON fact_nasabah.id_staf = dim_staf.id_staf 
            GROUP BY dim_staf.staf
            ORDER BY total_nasabah DESC
            LIMIT 10");

        return $query->getResult();
    }

    public function getStatusData()
    {
        $query = $this->db->query("SELECT dim_status.status, SUM(fact_nasabah.persentase_nasabah) as count
                FROM fact_nasabah
                JOIN dim_status ON fact_nasabah.id_status=dim_status.id_status
                GROUP BY dim_status.status
                ");
        

        return $query->getResult();
    }

    public function getTopBanks()
    {
        // Implement the logic to get data for the top 10 stafs with the highest total jumlah_nasabah
        $query = $this->db->query("SELECT dim_bank.bank, SUM(fact_nasabah.jumlah_nasabah) AS total_nasabah 
            FROM fact_nasabah 
            JOIN dim_bank ON fact_nasabah.id_bank= dim_bank.id_bank
            GROUP BY dim_bank.bank
            ORDER BY total_nasabah DESC
            LIMIT 10");

        return $query->getResult();
    }
}