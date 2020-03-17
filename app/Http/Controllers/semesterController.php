<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\semesterMarks;
use App\ssc_hsc_diploma;
use Illuminate\Support\Facades\DB;

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

    public function show(semesterMarks $semesterMarks) {
        //
    }

    public function edit(semesterMarks $semesterMarks) {

        $studentID = Auth::user()->id;

        $Premarks = DB::table('ssc_hsc_diploma')->where('id', $studentID)->first();
        $UGmarks = DB::table('semester_marks')->where('id', $studentID)->first();
        $data = [
            'ssc_hsc' => $Premarks,
            'ug_marks' => $UGmarks
        ];

        //dd($data);
        $collegeName = DB::table('registerusers')
                ->where('id', $studentID)
                ->select('college')
                ->first();
        //dd($collegeName->college);

        if ($collegeName->college == 'coep' ||
                $collegeName->college == 'gcoer' ||
                $collegeName->college == 'gcoek') {
            return view('marks.be_marks')->with('marks', $data);
        } else {
            return view('marks.diploma_marks')->with('marks', $data);
        }
        //return View::make('marks')->with($data);
        //return view('marks.be_marks')->with('marks', $marks);
    }

    public function update(Request $request, semesterMarks $semesterMarks) {

        $studentID = Auth::user()->id;
        $task = semesterMarks::findOrFail($studentID);
        $task2 = ssc_hsc_diploma::findOrFail($studentID);

        /*
          $collegeName = DB::table('registerusers')
          ->where('id', $studentID)
          ->select('college')
          ->first();

          if ($collegeName->college == 'coep' ||
          $collegeName->college == 'gcoer' ||
          $collegeName->college == 'gcoek') {
          }
         */

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
        
        $semester1 = $request->input('semester1');
        $semester2 = $request->input('semester2');
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

        $CGPA = $sum / $count;
        $task->CGPA = $CGPA;

        if ($count == $forSem) {
            $task->semester_marks_updated = 'yes';
            $task->fill($input)->save();
            $task2->fill($input)->save();
            return redirect(route('home'))->with('message', 'Marks updated successfully');
        } else {
            return redirect(route('home'))->with('message', 'You might have enter invalid marks. Check whether semester for you appeared is correct');
        }
    }

    public function checkSemester($studentID) {

        $data = DB::table('registerusers')
                ->where('id', '=', $studentID)
                ->select('id', 'yearOfAdmission')
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

        return $forSemester;
    }

    public function destroy(semesterMarks $semesterMarks) {
        //
    }

}
