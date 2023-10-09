<?php

namespace App\Models;

use CodeIgniter\Model;

class DataModel extends Model
{
    protected $table = 'data';
    protected $allowedFields = [
        'no',
        'waktu',
        'staf',
        'produk',
        'sektor_usaha',
        'bank',
        'cabang',
        'unit',
        'nama_nasabah',
        'penyebab_klaim',
        'status'
    ];

    public function getAllData()
    {
        return $this->findAll();
    }   
    
    public function truncateTable($table)
    {
        $this->db->table($table)->truncate();
    }

    public function insertData($data)
    {
              
        // Mengubah kolom tertentu menjadi huruf kapital
        $data['staf'] = strtoupper($data['staf']);
        $data['produk'] = strtoupper($data['produk']);
        $data['sektor_usaha'] = strtoupper($data['sektor_usaha']);
        $data['bank'] = strtoupper($data['bank']);
        $data['cabang'] = strtoupper($data['cabang']);
        $data['unit'] = strtoupper($data['unit']);
        $data['nama_nasabah'] = strtoupper($data['nama_nasabah']);
        $data['penyebab_klaim'] = strtoupper($data['penyebab_klaim']);
        $data['status'] = strtoupper($data['status']);

        $this->insert($data);

        // ETL Extraction - Dimensi Bank
        $this->extractData('dim_bank', 'bank', $data['bank']);

        // ETL Extraction - Dimensi Cabang
        $this->extractData('dim_cabang', 'cabang', $data['cabang']);

        // ETL Extraction - Dimensi Penyebab Klaim
        $this->extractData('dim_penyebab_klaim', 'penyebab_klaim', $data['penyebab_klaim']);

        // ETL Extraction - Dimensi Produk
        $this->extractData('dim_produk', 'produk', $data['produk']);

        // ETL Extraction - Dimensi Sektor Usaha
        $this->extractData('dim_sektor_usaha', 'sektor_usaha', $data['sektor_usaha']);

        // ETL Extraction - Dimensi Staf
        $this->extractData('dim_staf', 'staf', $data['staf']);

        // ETL Extraction - Dimensi Status
        $this->extractData('dim_status', 'status', $data['status']);


        // ETL Extraction - Dimensi Waktu
        $this->extractData('dim_waktu', 'waktu', $data['waktu']);
         
    }

    

    public function getMaxValues($table, $column)
    {
        return $this->db->table($table)
            ->select("{$column}, COUNT(*) as count")
            ->groupBy($column)
            ->orderBy('count', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();
    }

    public function extractData($table, $column, $data)
    {
        $existingData = $this->db->table($table)
            ->select('*')
            ->where($column, $data)
            ->get()
            ->getRowArray();

        if (empty($existingData)) {
            // Insert data ke dalam tabel dimensi
            $this->db->table($table)->insert([$column => $data]);
        }
    }


   // Membuat proses ETL untuk tabel fact
    public function etlProcess()
    {
        // Menghapus data yang ada di tabel faktanya
        $this->truncateTable('fact_nasabah');

        // Mengambil semua data dari tabel "data"
        $data = $this->getAllData();

        // Array untuk menyimpan data unik
        $uniqueData = [];

        // Memproses setiap data dan menyimpan data unik berdasarkan kombinasi foreign key
        foreach ($data as $row) {
            $factData = [
                'id_waktu' => $this->getDimensiId('dim_waktu', 'waktu', $row['waktu']),
                'id_staf' => $this->getDimensiId('dim_staf', 'staf', $row['staf']),
                'id_produk' => $this->getDimensiId('dim_produk', 'produk', $row['produk']),
                'id_sektor_usaha' => $this->getDimensiId('dim_sektor_usaha', 'sektor_usaha', $row['sektor_usaha']),
                'id_bank' => $this->getDimensiId('dim_bank', 'bank', $row['bank']),
                'id_cabang' => $this->getDimensiId('dim_cabang', 'cabang', $row['cabang']),
                'id_penyebab_klaim' => $this->getDimensiId('dim_penyebab_klaim', 'penyebab_klaim', $row['penyebab_klaim']),
                'id_status' => $this->getDimensiId('dim_status', 'status', $row['status']),
                'jumlah_nasabah' => 0, // Nilai awal jumlah nasabah
                'persentase_nasabah' => 0, // Nilai awal persentase nasabah
            ];

            // Menggunakan kombinasi foreign key sebagai kunci array untuk memastikan data unik
            $key = implode('-', $factData);
            if (!isset($uniqueData[$key])) {
                $uniqueData[$key] = $factData;
            }

            // Menghitung jumlah nasabah untuk data saat ini
            $uniqueData[$key]['jumlah_nasabah'] += 1;
        }

        // Menghitung total nasabah untuk perhitungan persentase nasabah
        $totalNasabah = count($data);

        // Memasukkan data unik ke dalam tabel faktanya
        foreach ($uniqueData as $factData) {
            $factData['persentase_nasabah'] = ($factData['jumlah_nasabah'] / $totalNasabah) * 100;

            // Periksa apakah data unik tersebut sudah ada di tabel fact_nasabah, jika ada, lakukan proses pembaruan data, jika belum ada, lakukan proses penyimpanan sebagai data baru
            $isExistingData = $this->db->table('fact_nasabah')
                ->where($factData)
                ->countAllResults();

            if ($isExistingData) {
                $this->db->table('fact_nasabah')
                    ->where($factData)
                    ->update($factData);
            } else {
                $this->db->table('fact_nasabah')
                    ->insert($factData);
            }
        }


    }



    // Mendapatkan ID dari tabel dimensi berdasarkan nilai kolom
    public function getDimensiId($table, $column, $value)
    {
        $row = $this->db->table($table)
            ->select('id_' . $column)
            ->where($column, $value)
            ->get()
            ->getRow();

        if ($row) {
            return $row->{'id_' . $column};
        }

        return null;
    }

   
}

