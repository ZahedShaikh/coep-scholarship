<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\semesterMarks;
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

        $marks = DB::table('semester_Marks')->where('id', Auth::user()->id)->first();
        //dd($marks);
        return view('marks.marks')->with('marks', $marks);
    }

    public function update(Request $request, semesterMarks $semesterMarks) {

        $StudentId = Auth::user()->id;
        $task = semesterMarks::findOrFail($StudentId);

        $this->validate($request, [
            'semester1' => 'nullable|numeric|digits_between:0,2',
            'semester2' => 'nullable|numeric|digits_between:0,2',
            'semester3' => 'nullable|numeric|digits_between:0,2',
            'semester4' => 'nullable|numeric|digits_between:0,2',
            'semester5' => 'nullable|numeric|digits_between:0,2',
            'semester6' => 'nullable|numeric|digits_between:0,2',
            'semester7' => 'nullable|numeric|digits_between:0,2',
            'semester8' => 'nullable|numeric|digits_between:0,2'
        ]);


        $input = $request->all();

        //CGPA

        $semester1 = $request->input('semester1');
        $semester2 = $request->input('semester2');
        $semester3 = $request->input('semester3');
        $semester4 = $request->input('semester4');
        $semester5 = $request->input('semester5');
        $semester6 = $request->input('semester6');
        $semester7 = $request->input('semester7');
        $semester8 = $request->input('semester8');

        $sum = 0;
        $count = 0;

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

        // Calculating Semeseter

        $data = DB::table('registerusers')
                ->where('id', '=', $StudentId)
                ->select('id', 'yearOfAdmission')
                ->first();

        $currentYear = date("Y");
        $forSemester = 0;

        if ($data != null) {

            $months = date('m');
            $addMonths = 0;
            switch ($months) {
                case ($months >= 7 and $months <= 11):
                    // This case for Semeseter 1
                    $addMonths = 2;
                    break;
                case ($months >= 1 and $months <= 5):
                    // This case for Semeseter 2
                    $addMonths = 1;
                    break;
                default:
                    // This case holidays
                    $addMonths = 0;
            }

            // Substracting 1 since I don't wanna count current year
            // Instead I will count $addMonths
            $years = $currentYear - date('Y', strtotime($data->yearOfAdmission)) - 1;

            $forSemester = 1 + $addMonths + $years * 2;
        }

        if ($count <= $forSemester and $count >= $forSemester - 1) {
            $task->semester_marks_updated = 'yes';
            $task->fill($input)->save();
            return redirect(route('home'))->with('message', 'Marks updated successfully');
        } else {
            return redirect(route('home'))->withErrors('Error While Updating your marks');
        }
    }

    public function destroy(semesterMarks $semesterMarks) {
        //
    }

}
