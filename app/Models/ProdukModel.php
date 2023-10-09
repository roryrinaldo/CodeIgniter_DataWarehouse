<?php

namespace App\Models;
use CodeIgniter\Model;

class ProdukModel extends Model
{   

   
    public function getYears()
    {
        // Ambil data tahun dari tabel dim_waktu
        $query = $this->db->table('dim_waktu')->get();
        return $query->getResult();
    }

    public function getProduks()
    {
        // Ambil data produk dari tabel dim_produk
        $query = $this->db->table('dim_produk')->get();
        return $query->getResult();
    }

    public function getData($year, $produk)
    {
        // Implement the logic to get data based on year and produkId using Query Builder
        $query = $this->db->query("SELECT dim_staf.staf, dim_produk.produk, SUM(fact_nasabah.jumlah_nasabah) AS total_nasabah 
            FROM fact_nasabah 
            JOIN dim_produk ON fact_nasabah.id_produk = dim_produk.id_produk 
            JOIN dim_staf ON fact_nasabah.id_staf = dim_staf.id_staf
            WHERE fact_nasabah.id_waktu = ? AND fact_nasabah.id_produk = ?
            GROUP BY dim_produk.produk,dim_staf.staf
            ORDER BY total_nasabah DESC", [$year, $produk]);

        // Prepare the response data
        $data = [
            'produkLabels' => [],
            'produkData'   => []
        ];

        foreach ($query->getResult() as $produkData) {
            $data['produkLabels'][] = $produkData->staf;
            $data['produkData'][]   = $produkData->total_nasabah;
        }

        return $data;
    }
}
