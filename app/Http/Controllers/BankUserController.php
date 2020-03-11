<?php

namespace App\Http\Controllers;

use App\BankDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class BankUserController extends Controller {

    public function redirectTo() {
        return $this->redirectTo = route('home');
    }

    public function __construct() {
        $this->middleware(['auth', 'verified']);
    }

    public function index() {
        return view('home');
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        //
    }

    public function show(BankDetails $bankDetails) {
        //
    }

    public function edit(BankDetails $bankDetails) {
        $banks = DB::table('bank_details')->where('id', Auth::user()->id)->first();
        //dd($marks);
        return view('bank.banks')->with('banks', $banks);
    }

    public function update(Request $request, BankDetails $bankDetails) {
        $task = BankDetails::findOrFail(Auth::user()->id);

        $this->validate($request, [
            'bank_Name' => 'required',
            'account_No' => 'required',
            'IFSC_Code' => 'required',
            'branch' => 'required'
        ]);

        $input = $request->all();
        $task->bank_details_updated = 'yes';
        $task->fill($input)->save();
        return redirect(route('home'))->with('message', 'Bank details updated successfully');
    }

    public function destroy(BankDetails $bankDetails) {
        //
    }

}
