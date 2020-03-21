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

        $freeze = '';
        if ($info->freeze == 'yes') {
            $freeze = 'disabled';
        }

        $s = "-07-01";
        $str = $info->yearOfAdmission . " " . $s;
        $str = str_replace(' ', '', $str);
        $date = date($str);
        $info->yearOfAdmission = $date;

        return view('myuser.updateuser', compact('info', 'freeze'));
    }

    public function update(Request $request, registeruser $registeruser) {

        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'surName' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'contact' => ['required', 'digits:10', 'min:10'],
            'college' => ['required'],
            'yearOfAdmission' => ['required'],
        ])->validate();

        try {
            $studentID = Auth::user()->id;
            $task = registeruser::findOrFail($studentID);
            $input = $request->all();

            //dd($task->college);
            $preCollege = $task->college;
            $nowCollege = $input['college'];

            if ($preCollege != $nowCollege) {
                // Changed diploma to BE    
                if (($preCollege == 'gpp' and $nowCollege != 'gpa') or ($preCollege == 'gpa' and $nowCollege != 'gpp' )) {
                    DB::table('diploma_semester_marks')->where('id', '=', $studentID)->delete();
                    DB::insert('insert into be_semester_marks (id) values (?)', [$studentID]);
                }
                // Changed BE to diploma
                if (($preCollege == 'coep' or $preCollege == 'gcoer' or $preCollege == 'gcoek')
                        and ($nowCollege == 'gpp' or $nowCollege = 'gpa')) {
                    DB::table('be_semester_marks')->where('id', '=', $studentID)->delete();
                    DB::insert('insert into diploma_semester_marks (id) values (?)', [$studentID]);
                }
            }
            DB::table('scholarship_status')->where('id', '=', $studentID)->delete();

            $year = date('Y', strtotime($input['yearOfAdmission']));
            $input['yearOfAdmission'] = $year;
            //Incrementing Form Version
            $task->version = $task->version + 1;

            $task->fill($input)->save();
            return redirect(route('home'))->with('message', 'Your information is updated successfully');
        } catch (Exception $ex) {
            DB::rollback();
            dd($ex);
            return redirect(route('home'))->withErrors('Please Contact Admin');
        }
    }

    public function destroy(registeruser $registeruser) {
        //
    }

}
