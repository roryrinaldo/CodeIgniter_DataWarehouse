<?php

namespace App\Controllers;
use App\Models\PenyebabKlaimModel;

class PenyebabKlaimController extends BaseController
{
    protected $penyebabKlaimModel; // Update the property name

    public function __construct()
    {
        $this->penyebabKlaimModel = new PenyebabKlaimModel(); // Update the property name
    }

    public function penyebabKlaim() // Update the method name
    {   
        // Ambil data tahun dan penyebab klaim dari model
        $years = $this->penyebabKlaimModel->getYears(); // Update the method call
        $penyebabKlaims = $this->penyebabKlaimModel->getPenyebabKlaims(); // Update the method call

        // Kirim data ke view
        return view('grafik/penyebabKlaim', [ // Update the view name
            'years' => $years,
            'penyebabKlaims' => $penyebabKlaims // Update the variable name
        ]);
    }

    public function getData($year, $penyebabKlaim)
    {
        // Panggil method getData dengan tahun dan penyebab klaim tertentu
        $data = $this->penyebabKlaimModel->getData($year, $penyebabKlaim); // Update the method call

        // Mengirimkan data sebagai response JSON
        return $this->response->setJSON($data);
    }
}