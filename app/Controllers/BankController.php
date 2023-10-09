<?php

namespace App\Controllers;
use App\Models\BankModel;

class BankController extends BaseController
{

    protected $BankModel;

    public function __construct()
    {
        $this->BankModel = new BankModel();
    }

    public function bank()
    {   
        // Panggil method getTopBanksByYear dengan tahun tertentu
        // Ambil data tahun dan bank dari model
        $years = $this->BankModel->getYears();
        $banks = $this->BankModel->getBanks();

        // Kirim data ke view
        return view('grafik/bank', [
            'years' => $years,
            'banks' => $banks
        ]);
    }

    public function getData($year, $bank)
    {
        // Panggil method getData dengan tahun dan staf tertentu
        $data = $this->BankModel->getData($year, $bank);

        // Mengirimkan data sebagai response JSON
        return $this->response->setJSON($data);
    }

    
}