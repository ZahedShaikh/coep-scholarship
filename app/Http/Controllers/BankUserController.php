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

        $info = DB::table('registerusers')
                ->where('id', Auth::user()->id)
                ->select('freeze')
                ->first();

        $freeze = '';
        if ($info->freeze == 'yes') {
            $freeze = 'disabled';
        }

        $banks = DB::table('bank_details')->where('id', Auth::user()->id)->first();
        return view('bank.banks', compact('banks', 'freeze'));
    }

    public function update(Request $request, BankDetails $bankDetails) {
        $studentID = Auth::user()->id;
        $task = BankDetails::findOrFail($studentID);

        $this->validate($request, [
            'bank_Name' => 'required',
            'account_No' => 'required',
            'IFSC_Code' => 'required',
            'branch' => 'required'
        ]);

        $input = $request->all();
        $task->bank_details_updated = 'yes';

        try {
            DB::table('registerusers')
                    ->where('id', '=', $studentID)
                    ->increment('version');

            $task->fill($input)->save();
            
        } catch (Exception $ex) {
            DB::rollback();
            dd($ex);
            return redirect(route('home'))->withErrors('Error while saving Bank Details: Please contact Admin');
        }
        return redirect(route('home'))->with('message', 'Bank details updated successfully');
    }

    public function destroy() {
        //
    }

}
