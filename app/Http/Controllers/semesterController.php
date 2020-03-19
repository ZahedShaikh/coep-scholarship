<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\be_semesterMarks;
use App\diploma_semesterMarks;
use App\ssc_hsc_diploma;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class semesterController extends Controller {

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

    public function edit() {

        $studentID = Auth::user()->id;
        $Premarks = DB::table('ssc_hsc_diploma')->where('id', $studentID)->first();

        //dd($data);
        $collegeName = DB::table('registerusers')
                ->where('id', $studentID)
                ->select('college', 'directSY')
                ->first();

        if ($collegeName->college == 'coep' ||
                $collegeName->college == 'gcoer' ||
                $collegeName->college == 'gcoek') {

            $UGmarks = DB::table('be_semester_marks')->where('id', $studentID)->first();
            $data = [
                'ssc_hsc' => $Premarks,
                'ug_marks' => $UGmarks
            ];

            if ($collegeName->directSY == 'yes') {
                return view('marks.be_DSY_marks')->with('marks', $data);
            }
            return view('marks.be_marks')->with('marks', $data);
        } else {

            $UGmarks = DB::table('diploma_semester_marks')->where('id', $studentID)->first();
            $data = [
                'ssc_hsc' => $Premarks,
                'ug_marks' => $UGmarks
            ];

            if ($collegeName->directSY == 'yes') {
                return view('marks.diploma_DSY_marks')->with('marks', $data);
            }

            return view('marks.diploma_marks')->with('marks', $data);
        }
    }

    public function update(Request $request) {

        $studentID = Auth::user()->id;

        try {
            $task = be_semesterMarks::findOrFail($studentID);
        } catch (ModelNotFoundException $ex) {
            $task = diploma_semesterMarks::findOrFail($studentID);
        }

        $task2 = ssc_hsc_diploma::findOrFail($studentID);

        $this->validate($request, [
            'ssc' => 'required|numeric|between:35.00,99.99',
            'hsc' => 'nullable|numeric|between:35.00,99.99',
            'diploma' => 'nullable|numeric|between:35.00,99.99',
            'semester1' => 'nullable|numeric|between:1,99.99',
            'semester2' => 'nullable|numeric|between:1,99.99',
            'semester3' => 'nullable|numeric|between:1,99.99',
            'semester4' => 'nullable|numeric|between:1,99.99',
            'semester5' => 'nullable|numeric|between:1,99.99',
            'semester6' => 'nullable|numeric|between:1,99.99',
            'semester7' => 'nullable|numeric|between:1,99.99',
            'semester8' => 'nullable|numeric|between:1,99.99'
        ]);

        $input = $request->all();
        $diploma = $request->input('diploma');
        $hsc = $request->input('hsc');
        $semester3 = $request->input('semester3');
        $semester4 = $request->input('semester4');
        $semester5 = $request->input('semester5');
        $semester6 = $request->input('semester6');
        $semester7 = $request->input('semester7');
        $semester8 = $request->input('semester8');

        //CGPA
        $sum = 0;
        $count = 0;
        $forSem = $this->checkSemester($studentID);
        $avg = $forSem['forSemester'];

        if ($forSem['directSY'] == 'yes') {
            $avg += 2;
            $semester1 = true;
            $semester2 = true;
        } else {
            $semester1 = $request->input('semester1');
            $semester2 = $request->input('semester2');
        }

        if ($semester1) {
            $sum = $sum + $semester1;
            $count++;
        }
        if ($semester2) {
            $sum = $sum + $semester2;
            $count++;
            if ($count != 2) {
                $count = -8;
            }
        }
        if ($semester3) {
            $sum = $sum + $semester3;
            $count++;
            if ($count != 3) {
                $count = -8;
            }
        }
        if ($semester4) {
            $sum = $sum + $semester4;
            $count++;
            if ($count != 4) {
                $count = -8;
            }
        }

        if ($semester5) {
            $sum = $sum + $semester5;
            $count++;
            if ($count != 5) {
                $count = -8;
            }
        }
        if ($semester6) {
            $sum = $sum + $semester6;
            $count++;
            if ($count != 6) {
                $count = -8;
            }
        }
        if ($semester7) {
            $sum = $sum + $semester7;
            $count++;
            if ($count != 7) {
                $count = -8;
            }
        }
        if ($semester8) {
            $sum = $sum + $semester8;
            $count++;
            if ($count != 8) {
                $count = -8;
            }
        }

        $CGPA = $sum / $avg - 2;
        $task->CGPA = $CGPA;

        if ($count == ($avg)) {
            $task->semester_marks_updated = 'yes';
            $task->fill($input)->save();

            // Cheack wether SSC/ Diploma marked filled or not!
            if (($diploma == null and $hsc == null)) {
                if ($forSem['college'] != 'gpp' and $forSem['college'] != 'gpa') {
                    return redirect(route('home'))->withErrors('Please fill your SSC or Diploma Marks');
                }
            }

            $task2->fill($input)->save();
            return redirect(route('home'))->with('message', 'Marks updated successfully');
        } else {
            return redirect(route('home'))->withErrors('You might have enter invalid marks. Check whether semester for you appeared is correct');
        }
    }

    public function checkSemester($studentID) {

        $data = DB::table('registerusers')
                ->where('id', '=', $studentID)
                ->select('id', 'yearOfAdmission', 'college', 'directSY')
                ->first();

        $currentYear = date("Y");
        $months = date('m');
        $addMonths = 0;
        switch ($months) {
            case ($months >= 7):
                $addMonths = 1;
                break;
        }

        $years = $currentYear - $data->yearOfAdmission;
        $forSemester = 1 + $addMonths + ($years - 1) * 2;

        $bind = [
            'forSemester' => $forSemester,
            'college' => $data->college,
            'directSY' => $data->directSY
        ];

        return $bind;
    }

}
