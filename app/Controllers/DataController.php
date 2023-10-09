<?php

namespace App\Controllers;

use App\Models\DataModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class DataController extends BaseController
{
    protected $dataModel;

    public function __construct()
    {
        $this->dataModel = new DataModel();
    }
 
    public function index()
    {   
        $data['records'] = $this->dataModel->getAllData();
        return view('data/data', $data);
    }
 
    public function clear()
    {
        $this->dataModel->truncateTable('data');
        $this->dataModel->truncateTable('dim_waktu');
        $this->dataModel->truncateTable('dim_staf');
        $this->dataModel->truncateTable('dim_bank');
        $this->dataModel->truncateTable('dim_status');
        $this->dataModel->truncateTable('dim_penyebab_klaim');
        $this->dataModel->truncateTable('dim_cabang');
        $this->dataModel->truncateTable('dim_produk');
        $this->dataModel->truncateTable('dim_sektor_usaha');
        return redirect()->to(base_url('/data'))->with('success', 'Data cleared successfully.');
    }
    
    public function import()
    {
        $file = $this->request->getFile('excel_file');

        if ($file->isValid() && $file->getExtension() === 'xlsx') {
            $importData = $this->readExcelFile($file->getPathname());

            if ($importData !== false) {
                // Proses import data ke database
                foreach ($importData as $data) {
                    // Ubah format waktu menjadi 'Y-m-d'
                    $formattedDate = Carbon::createFromFormat('d/m/Y', $data['waktu'])->format('Y-m-d');
                    $data['waktu'] = $formattedDate;

                    // Proses ETL - Mengisi data kosong dengan data yang paling banyak muncul
                    $data = $this->fillEmptyData($data);

                    ini_set('max_execution_time', 120); // Atur batas waktu eksekusi menjadi 120 detik (2 menit)
                    $this->dataModel->insertData($data);

                    $this->dataModel->etlProcess();
                     
                }
                
                return redirect()->to(base_url('data'))->with('success', 'Data imported successfully.');
            }
        }

        return redirect()->to(base_url('data'))->with('error', 'Invalid Excel file.');
    }

    private function readExcelFile($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $rowData = [];

        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData[] = [
                'no' => $worksheet->getCell('A' . $row)->getValue(),
                'waktu' => $worksheet->getCell('B' . $row)->getFormattedValue(),
                'staf' => $worksheet->getCell('C' . $row)->getValue(),
                'produk' => $worksheet->getCell('D' . $row)->getValue(),
                'sektor_usaha' => $worksheet->getCell('E' . $row)->getValue(),
                'bank' => $worksheet->getCell('F' . $row)->getValue(),
                'cabang' => $worksheet->getCell('G' . $row)->getValue(),
                'unit' => $worksheet->getCell('H' . $row)->getValue(),
                'nama_nasabah' => $worksheet->getCell('J' . $row)->getValue(),
                'penyebab_klaim' => $worksheet->getCell('L' . $row)->getValue(),
                'status' => $worksheet->getCell('M' . $row)->getValue(),
            ];
        }

        return $rowData;
    }


    private function fillEmptyData($data)
    {
        // Mendapatkan data yang paling banyak muncul untuk setiap kolom
        $maxValues = [
            'staf' => $this->dataModel->getMaxValues('data', 'staf')['staf'],
            'produk' => $this->dataModel->getMaxValues('data', 'produk')['produk'],
            'sektor_usaha' => $this->dataModel->getMaxValues('data', 'sektor_usaha')['sektor_usaha'],
            'bank' => $this->dataModel->getMaxValues('data', 'bank')['bank'],
            'cabang' => $this->dataModel->getMaxValues('data', 'cabang')['cabang'],
            'unit' => $this->dataModel->getMaxValues('data', 'unit')['unit'],
            'nama_nasabah' => $this->dataModel->getMaxValues('data', 'nama_nasabah')['nama_nasabah'],
            'penyebab_klaim' => $this->dataModel->getMaxValues('data', 'penyebab_klaim')['penyebab_klaim'],
            'status' => $this->dataModel->getMaxValues('data', 'status')['status'],
        ];

        // Mengisi data kosong dengan data yang paling banyak muncul
        if (empty($data['staf'])) {
            $data['staf'] = "N/A";
        }
        if (empty($data['produk'])) {
            $data['produk'] = "N/A";
        }
        if (empty($data['sektor_usaha'])) {
            $data['sektor_usaha'] = "N/A";
        }
        if (empty($data['bank'])) {
            $data['bank'] = "N/A";
        }
        if (empty($data['cabang'])) {
            $data['cabang'] = "N/A";
        }
        if (empty($data['unit'])) {
            $data['unit'] = "N/A";
        }
        if (empty($data['nama_nasabah'])) {
            $data['nama_nasabah'] = "N/A";
        }
        if (empty($data['penyebab_klaim'])) {
            $data['penyebab_klaim'] = "N/A";
        }
        if (empty($data['status'])) {
            $data['status'] = "N/A";
        }

        return $data;
    }
}
