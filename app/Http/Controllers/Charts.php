<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Charts extends Controller {

    public function index() {
        return view('charts-and-details.charts');

//        return view('charts-and-details.charts', ['College' => $college,
//                'Data1' => $FY, 'Data2' => $SY, 'Data3' => $TY, 'Data4' => $BE]);
    }

    public function update(Request $request) {

        if ($request->ajax()) {
            $coep = [];
            $gcoer = [];
            $gcoek = [];
            $gpp = [];
            $gpa = [];

            $from = $request->get('from');
            $to = $request->get('to');

            for ($i = 1; $i <= 4; $i++) {
                $coep[$i] = DB::table('transaction_history')
                        ->Where('transaction_history.year', '>=', $from)
                        ->Where('transaction_history.year', '<=', $to)
                        ->join('registerusers', 'transaction_history.id', '=', 'registerusers.id')
                        ->where('transaction_history.amountReceivedForYear', '=', $i)
                        ->where('registerusers.college', '=', 'coep')
                        ->count();
            }

            for ($i = 1; $i <= 4; $i++) {
                $gcoer[$i] = DB::table('transaction_history')
                        ->Where('transaction_history.year', '>=', $from)
                        ->Where('transaction_history.year', '<=', $to)
                        ->join('registerusers', 'transaction_history.id', '=', 'registerusers.id')
                        ->where('transaction_history.amountReceivedForYear', '=', $i)
                        ->where('registerusers.college', '=', 'gcoer')
                        ->count();
            }
            for ($i = 1; $i <= 4; $i++) {
                $gcoek[$i] = DB::table('transaction_history')
                        ->Where('transaction_history.year', '>=', $from)
                        ->Where('transaction_history.year', '<=', $to)
                        ->join('registerusers', 'transaction_history.id', '=', 'registerusers.id')
                        ->where('transaction_history.amountReceivedForYear', '=', $i)
                        ->where('registerusers.college', '=', 'gcoek')
                        ->count();
            }
            for ($i = 1; $i <= 3; $i++) {
                $gpp[$i] = DB::table('transaction_history')
                        ->Where('transaction_history.year', '>=', $from)
                        ->Where('transaction_history.year', '<=', $to)
                        ->join('registerusers', 'transaction_history.id', '=', 'registerusers.id')
                        ->where('transaction_history.amountReceivedForYear', '=', $i)
                        ->where('registerusers.college', '=', 'gpp')
                        ->count();
            }
            for ($i = 1; $i <= 3; $i++) {
                $gpa[$i] = DB::table('transaction_history')
                        ->Where('transaction_history.year', '>=', $from)
                        ->Where('transaction_history.year', '<=', $to)
                        ->join('registerusers', 'transaction_history.id', '=', 'registerusers.id')
                        ->where('transaction_history.amountReceivedForYear', '=', $i)
                        ->where('registerusers.college', '=', 'gpa')
                        ->count();
            }
            //dd($coep, $gcoer, $gcoek, $gpp, $gpa);

            $college = array('COEP', 'GCOER', 'GCOEK', 'GPP', 'GPA');
            $FY = array($coep[1], $gcoer[1], $gcoek[1], $gpp[1], $gpa[1]);
            $SY = array($coep[2], $gcoer[2], $gcoek[2], $gpp[2], $gpa[2]);
            $TY = array($coep[3], $gcoer[3], $gcoek[3], $gpp[3], $gpa[3]);
            $BE = array($coep[4], $gcoer[4], $gcoek[4]);
//            return view('charts-and-details.charts', ['College' => $college,
//                'Data1' => $FY, 'Data2' => $SY, 'Data3' => $TY, 'Data4' => $BE]);


            $data = array(
                'College' => $college,
                'FY' => $FY,
                'SY' => $SY,
                'TY' => $TY,
                'BE' => $BE
            );
            //error_log(print_r($data, true));

            echo json_encode($data);
        }
    }

}
