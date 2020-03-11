<?php

namespace App\Http\Controllers;

use App\transaction_history;
use Illuminate\Http\Request;

use App\registeruser;
use Illuminate\Support\Facades\DB;

class transactionhistoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\transaction_history  $transaction_history
     * @return \Illuminate\Http\Response
     */
    public function show(transaction_history $transaction_history) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\transaction_history  $transaction_history
     * @return \Illuminate\Http\Response
     */
    public function edit(transaction_history $transaction_history) {
        return view('vendor.multiauth.admin.amountDistribution');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\transaction_history  $transaction_history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transaction_history $transaction_history) {

        #$transaction_history = new transaction_history();
        // Cleaning up data to be human error free!
        $student_list1 = $request->input('student_list1');
        $amount1 = $request->input('amount1');
        $student_list1 = str_replace(' ', '', $student_list1);
        $amount1 = str_replace(' ', '', $amount1);

        if ((int) $amount1 == 0) {
            return redirect(route('getamountDistro'))->with('message', 'Please enter Amount');
        }
        
        
        $users = DB::table('registerusers')->where('id', $student_list1)->first();
        if($users == null){
            return redirect(route('getamountDistro'))->with('message', 'ID not found! Please check');
        }
        
        
        $transaction_history->id = $student_list1;
        $transaction_history->amount = (double) $amount1;

        try {
            $transaction_history->save();
        } catch (\Illuminate\Database\QueryException $exc) {
            print($exc);
            dd($exc);
            return redirect(route('getamountDistro'))->with('message', 'Something went wrong');
        }

        return redirect(route('getamountDistro'))->with('message', 'Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\transaction_history  $transaction_history
     * @return \Illuminate\Http\Response
     */
    public function destroy(transaction_history $transaction_history) {
        //
    }

}
