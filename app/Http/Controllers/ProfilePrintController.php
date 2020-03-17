<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\registeruser;
use App\semesterMarks;
use Illuminate\Support\Facades\DB;

class ProfilePrintController extends Controller {

    public function redirectTo() {
        return $this->redirectTo = route('home');
    }

    public function __construct() {
        $this->middleware(['auth', 'verified']);
    }

    public function index() {
        return view('home');
    }

    public function show(semesterMarks $semesterMarks) {

        $studentID = Auth::user()->id;

        // BE/Diploma Marks Validator
        if ($this->checkSemester($studentID) == false) {
            return redirect(route('home'))->with('message', 'Please all details and your marks first');
        }

        $banks = DB::table('bank_details')->where('id', Auth::user()->id)->first();
        if ($banks->bank_details_updated == 'no') {
            return redirect(route('home'))->with('message', 'Please update your Bank details');
        }

        $info = DB::table('registerusers')->where('id', Auth::user()->id)->first();
        
        
        $ssc_marks = DB::table('ssc_hsc_diploma')->where('id', $studentID)->first();
        $marks = DB::table('semester_marks')->where('id', $studentID)->first();
        
        switch ($info->college) {
            case 'coep':
                $info->college = 'College of Engineering Pune';
                return view('print.BE_profile', compact('info', 'ssc_marks', 'marks', 'banks'));
            case 'gcoer':
                $info->college = 'GCOER, Avasari';
                return view('print.BE_profile', compact('info', 'ssc_marks', 'marks', 'banks'));
            case 'gcoek':
                $info->college = 'GCE, Karad';
                return view('print.BE_profile', compact('info', 'ssc_marks', 'marks', 'banks'));
            case 'gpp':
                $info->college = 'Government Polytechnic Pune';
                return view('print.Diploma_profile', compact('info', 'ssc_marks', 'marks', 'banks'));
            case 'gpa':
                $info->college = 'Government Polytechnic Awasari';
                return view('print.Diploma_profile', compact('info', 'ssc_marks', 'marks', 'banks'));
        }
        return view('print.BE_profile', compact('info', 'ssc_marks', 'marks', 'banks'));
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
        

        $semester_marks = DB::table('semester_marks')
                ->where('id', $studentID)
                ->select('semester1', 'semester2', 'semester3', 'semester4', 'semester5', 'semester6', 'semester1', 'semester7')
                ->first();

        $flg = false;

        switch ($forSemester) {
            case 1:
                if (($semester_marks->semester1) != null) {
                    $flg = true;
                }
                break;
            case 2:
                if (($semester_marks->semester2) != null) {
                    $flg = true;
                }
                break;
            case 3:
                if (($semester_marks->semester3) != null) {
                    $flg = true;
                }
                break;
            case 4:
                if (($semester_marks->semester4) != null) {
                    $flg = true;
                }
                break;
            case 5:
                if (($semester_marks->semester5) != null) {
                    $flg = true;
                }
                break;
            case 6:
                if (($semester_marks->semester6) != null) {
                    $flg = true;
                }
                break;

            default:
                break;
        }

        if ($flg) {
            return true;
        } else {
            return false;
        }
    }

}
