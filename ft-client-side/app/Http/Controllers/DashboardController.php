<?php

namespace App\Http\Controllers;

use App\Helper\TotalHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        if (Cache::get('user')['role'] == 'admin') {
            return redirect()->route('transactions');
        } else {
            $totalHelper = new TotalHelper();
            $month = $totalHelper->getMonth();
            $all = $totalHelper->getAll();

            $chart = $totalHelper->getDataChart();

            $chartData = array();
            foreach ($chart as $data) {
                $amount = $data['data'];
                $chartData[] = $amount;
            }

            $chartCategories = array();
            foreach ($chart as $dataChart) {
                $name = $dataChart['name_month'];
                $chartCategories[] = $name;
            }

            return view('welcome', compact(['month', 'all', 'chartData', 'chartCategories']));
        }
    }
}
