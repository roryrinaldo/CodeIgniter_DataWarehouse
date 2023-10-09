<?php

namespace App\Controllers;
use App\Models\ProdukModel;

class ProdukController extends BaseController
{

    protected $produkModel; // Update the property name

    public function __construct()
    {
        $this->produkModel = new ProdukModel(); // Update the property name
    }

    public function produk() // Update the method name
    {   
        // Ambil data tahun dan produk dari model
        $years = $this->produkModel->getYears(); // Update the method call
        $produks = $this->produkModel->getProduks(); // Update the method call

        // Kirim data ke view
        return view('grafik/produk', [ // Update the view name
            'years' => $years,
            'produks' => $produks // Update the variable name
        ]);
    }

    public function getData($year, $produk)
    {
        // Panggil method getData dengan tahun dan produk tertentu
        $data = $this->produkModel->getData($year, $produk); // Update the method call

        // Mengirimkan data sebagai response JSON
        return $this->response->setJSON($data);
    }
}