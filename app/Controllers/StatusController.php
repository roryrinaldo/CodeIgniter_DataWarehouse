<?php

namespace App\Controllers;
use App\Models\StatusModel;

class StatusController extends BaseController
{
    protected $statusModel; // Update the property name

    public function __construct()
    {
        $this->statusModel = new StatusModel(); // Update the model name
    }

    public function status() // Update the method name
    {   
        // Ambil data tahun dan status dari model
        $years = $this->statusModel->getYears(); // Update the method call
        $statuses = $this->statusModel->getStatuses(); // Update the method call

        // Kirim data ke view
        return view('grafik/status', [ // Update the view name
            'years' => $years,
            'statuses' => $statuses // Update the variable name
        ]);
    }

    public function getData($year, $status)
    {
        // Panggil method getData dengan tahun dan status tertentu
        $data = $this->statusModel->getData($year, $status); // Update the method call

        // Mengirimkan data sebagai response JSON
        return $this->response->setJSON($data);
    }
}