<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class Charts extends Controller {

    public function index() {
        
        $coep = [];
        $gcoer = [];
        $gcoek = [];
        $gpp = [];
        $gpa = [];

        for ($i = 1; $i <= 4; $i++) {
            $coep[$i] = DB::table('transaction_history')
                    ->join('registerusers', 'transaction_history.id', '=', 'registerusers.id')
                    ->where('transaction_history.amountReceivedForYear', '=', $i)
                    ->where('registerusers.college', '=', 'coep')
                    ->count();
        }
        for ($i = 1; $i <= 4; $i++) {
            $gcoer[$i] = DB::table('transaction_history')
                    ->join('registerusers', 'transaction_history.id', '=', 'registerusers.id')
                    ->where('transaction_history.amountReceivedForYear', '=', $i)
                    ->where('registerusers.college', '=', 'gcoer')
                    ->count();
        }
        for ($i = 1; $i <= 4; $i++) {
            $gcoek[$i] = DB::table('transaction_history')
                    ->join('registerusers', 'transaction_history.id', '=', 'registerusers.id')
                    ->where('transaction_history.amountReceivedForYear', '=', $i)
                    ->where('registerusers.college', '=', 'gcoek')
                    ->count();
        }
        for ($i = 1; $i <= 3; $i++) {
            $gpp[$i] = DB::table('transaction_history')
                    ->join('registerusers', 'transaction_history.id', '=', 'registerusers.id')
                    ->where('transaction_history.amountReceivedForYear', '=', $i)
                    ->where('registerusers.college', '=', 'gpp')
                    ->count();
        }
        for ($i = 1; $i <= 3; $i++) {
            $gpa[$i] = DB::table('transaction_history')
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
        return view('charts-and-details.charts', ['College' => $college,
            'Data1' => $FY, 'Data2' => $SY, 'Data3' => $TY, 'Data4' => $BE]);
    }
    
}
