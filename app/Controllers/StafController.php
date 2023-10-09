<?php

namespace App\Controllers;
use App\Models\StafModel;

class StafController extends BaseController
{
    protected $StafModel;

    public function __construct()
    {
        $this->StafModel = new StafModel();
    }

    public function staf()
    {   
        // Panggil method getTopBanksByYear dengan tahun tertentu
        // Ambil data tahun dan bank dari model
    
        $stafs = $this->StafModel->getStafs();

        // Kirim data ke view
        return view('grafik/staf', [
            'stafs' => $stafs
        ]);
    }

    public function getData( $staf)
    {
        // Panggil method getData dengan tahun dan staf tertentu
        $data = $this->StafModel->getData( $staf);

        // Mengirimkan data sebagai response JSON
        return $this->response->setJSON($data);
    }
}