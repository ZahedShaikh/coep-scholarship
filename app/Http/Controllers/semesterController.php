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


        $Premarks = DB::table('ssc_hsc_diploma')->where('id', $studentID)->first();
        $UGmarks = DB::table('semester_marks')->where('id', $studentID)->first();

        //dd($data);
        $collegeName = DB::table('registerusers')
                ->where('id', $studentID)
                ->select('college')
                ->first();
        //dd($collegeName->college);

        if ($collegeName->college == 'coep' ||
                $collegeName->college == 'gcoer' ||
                $collegeName->college == 'gcoek') {

            $this->validate($request, [
                'ssc' => 'required|numeric|between:35.00,99.99',
                'hcs' => 'nullable|numeric|between:35.00,99.99',
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

            $ssc = $request->input('ssc');
            $hcs = $request->input('hcs');
            $diploma = $request->input('diploma');
            
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

            if ($count == 0) {
                return redirect(route('home'))->withErrors('No changes made');
            }

            $CGPA = $sum / $count;
            $task->CGPA = $CGPA;

            
            //dd($input);
            // Calculating Semeseter

            $data = DB::table('registerusers')
                    ->where('id', '=', $studentID)
                    ->select('id', 'yearOfAdmission')
                    ->first();

            $currentYear = date("Y");
            $forSemester = 0;
            
            if ($data != null) {

                $months = date('m');
                $addMonths = 0;
                switch ($months) {
                    case ($months >= 6 and $months <= 11):
                        // This case for Semeseter 1
                        $addMonths = 2;
                        break;
                    case ($months == 12 or ($months >= 1 and $months <= 5)):
                        // This case for Semeseter 2
                        $addMonths = 1;
                        break;
                    default:
                        // This case holidays
                        $addMonths = 0;
                }

                // Substracting 1 since I don't wanna count current year
                // Instead I will count $addMonths
                $years = $currentYear - date('Y', strtotime($data->yearOfAdmission));
                
                $forSemester = $addMonths + $years * 2;
            }

            if ($count <= $forSemester and $count >= $forSemester - 1) {
                $task->semester_marks_updated = 'yes';
                $task->fill($input)->save();
                $task2->fill($input)->save();
                return redirect(route('home'))->with('message', 'Marks updated successfully');
            } else {
                return redirect(route('home'))->withErrors('Error: Marks not saved. Plese fill complete details');
            }
        } else {
            
             $this->validate($request, [
                'ssc' => 'required|numeric|between:35.00,99.99',
                'hcs' => 'nullable|numeric|between:35.00,99.99',
                
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

            $ssc = $request->input('ssc');
            $hcs = $request->input('hcs');
            $diploma = $request->input('diploma');
            
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

            if ($count == 0) {
                return redirect(route('home'))->withErrors('No changes made');
            }

            $CGPA = $sum / $count;
            $task->CGPA = $CGPA;

            
            //dd($input);
            // Calculating Semeseter

            $data = DB::table('registerusers')
                    ->where('id', '=', $studentID)
                    ->select('id', 'yearOfAdmission')
                    ->first();

            $currentYear = date("Y");
            $forSemester = 0;
            
            if ($data != null) {

                $months = date('m');
                $addMonths = 0;
                switch ($months) {
                    case ($months >= 6 and $months <= 11):
                        // This case for Semeseter 1
                        $addMonths = 2;
                        break;
                    case ($months == 12 or ($months >= 1 and $months <= 5)):
                        // This case for Semeseter 2
                        $addMonths = 1;
                        break;
                    default:
                        // This case holidays
                        $addMonths = 0;
                }

                // Substracting 1 since I don't wanna count current year
                // Instead I will count $addMonths
                $years = $currentYear - date('Y', strtotime($data->yearOfAdmission));
                
                $forSemester = $addMonths + $years * 2;
            }

            if ($count <= $forSemester and $count >= $forSemester - 1) {
                $task->semester_marks_updated = 'yes';
                $task->fill($input)->save();
                $task2->fill($input)->save();
                return redirect(route('home'))->with('message', 'Marks updated successfully');
            } else {
                return redirect(route('home'))->withErrors('Error: Marks not saved. Plese fill complete details');
            }
        }
    }

    public function destroy(semesterMarks $semesterMarks) {
        //
    }

}
