<?php

namespace App\Controllers;
use App\Models\SektorUsahaModel;

class SektorUsahaController extends BaseController
{
    protected $sektorUsahaModel;

    public function __construct()
    {
        $this->sektorUsahaModel = new SektorUsahaModel();
    }

    public function sektorUsaha()
    {   
        // Ambil data tahun dan sektorUsaha dari model
        $years = $this->sektorUsahaModel->getYears();
        $sektorUsahas = $this->sektorUsahaModel->getSektorUsahas();

        // Kirim data ke view
        return view('grafik/sektorUsaha', [
            'years' => $years,
            'sektorUsahas' => $sektorUsahas
        ]);
    }

    public function getData($year, $sektorUsaha)
    {
        // Panggil method getData dengan tahun dan sektorUsaha tertentu
        $data = $this->sektorUsahaModel->getData($year, $sektorUsaha);

        // Mengirimkan data sebagai response JSON
        return $this->response->setJSON($data);
    }
}