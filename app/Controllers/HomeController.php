<?php

namespace App\Controllers;
use App\Models\DashboardModel;


class HomeController extends BaseController
{
    public function index()
    {
        $dashboardModel = new DashboardModel();
       
        $numCustomers   = $dashboardModel->getNumCustomers();
        $numYears       = $dashboardModel->getNumYears();
        $numStafs       = $dashboardModel->getNumStafs();
        $numBanks       = $dashboardModel->getNumBanks();

        // Get data for the top 10 stafs with the highest total jumlah_nasabah
        $topStafs = $dashboardModel->getTopStafs();
        $topBanks = $dashboardModel->getTopBanks();

        $statusData = $dashboardModel->getStatusData();

        return view('dashboard', [
            'numCustomers'  => $numCustomers,
            'numYears'      => $numYears,
            'numStafs'      => $numStafs,
            'numBanks'      => $numBanks,
            'topStafs'      => $topStafs,
            'topBanks'      => $topBanks,
            'statusData' => $statusData,
        ]);
    }
    
}
