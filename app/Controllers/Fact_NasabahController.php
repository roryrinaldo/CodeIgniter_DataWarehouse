<?php

namespace App\Controllers;

use App\Models\Fact_NasabahModel;

class Fact_NasabahController extends BaseController
{

    protected $factModel;

    public function __construct()
    {
        $this->factModel = new Fact_NasabahModel();
    }

    public function index()
    {
      
        // Mengambil semua data faktanya
        $data['fact_nasabah'] = $this->factModel->getAllData();

        // Menampilkan view dengan data faktanya
        return view('fact_nasabah/fact_nasabah', $data);
    }


    
}
