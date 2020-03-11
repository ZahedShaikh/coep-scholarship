<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class Charts extends Controller {

    public function index() {
        $chart = (new LarapexChart)->setTitle('Net Profit')
                ->setSubtitle('From January To March')
                ->setType('bar')
                ->setXAxis(['Jan', 'Feb', 'Mar'])
                ->setGrid(true)
                ->setDataset([
                    [
                        'name' => 'Company A',
                        'data' => [500, 1000, 1900]
                    ],
                    [
                        'name' => 'Company B',
                        'data' => [300, 900, 1400]
                    ],
                    [
                        'name' => 'Company C',
                        'data' => [430, 245, 500]
                    ]
                ])
                ->setStroke(1);

        return view('vendor.multiauth.charts-and-details.collageVsYear', compact('chart'));
    }

}
