<?php

namespace App\Http\Controllers;

use App\registeruser;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class userupdateController extends Controller {

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

    public function show(registeruser $registeruser) {
        //
    }

    public function edit(registeruser $registeruser) {

        $info = DB::table('registerusers')->where('id', Auth::user()->id)->first();
        //dd($info);
        return view('myuser.updateuser')->with('info', $info);
    }

    public function update(Request $request, registeruser $registeruser) {

        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
                    'surName' => ['required', 'string', 'max:255'],
                    'gender' => ['required'],
                    'contact' => ['required', 'digits:10', 'min:10'],
                    'college' => ['required'],
        ])->validate();

        $task = registeruser::findOrFail(Auth::user()->id);

        $input = $request->all();
        $task->fill($input)->save();
        return redirect(route('home'))->with('message', 'Your information is updated successfully');
    }

    public function destroy(registeruser $registeruser) {
        //
    }

}
