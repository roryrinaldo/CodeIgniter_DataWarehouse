<?php

namespace App\Controllers;
use App\Models\CabangModel;

class CabangController extends BaseController
{

    protected $CabangModel;

    public function __construct()
    {
        $this->CabangModel = new CabangModel();
    }

    public function cabang()
    {   
        // Ambil data tahun dan cabang dari model
        $years = $this->CabangModel->getYears();
        $cabangs = $this->CabangModel->getCabangs();

        // Kirim data ke view
        return view('grafik/cabang', [
            'years' => $years,
            'cabangs' => $cabangs
        ]);
    }

    public function getData($year, $cabang)
    {
        // Panggil method getData dengan tahun dan cabang tertentu
        $data = $this->CabangModel->getData($year, $cabang);

        // Mengirimkan data sebagai response JSON
        return $this->response->setJSON($data);
    }
}