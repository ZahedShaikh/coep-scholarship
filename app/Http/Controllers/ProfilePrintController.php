<?php

namespace App\Http\Controllers;

use Auth;
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

    public function show() {
        $studentID = Auth::user()->id;

        $banks = DB::table('bank_details')->where('id', $studentID)->first();
        if ($banks->bank_details_updated == 'no') {
            return redirect(route('home'))->withErrors('Please update your Bank details');
        }

        $info = DB::table('registerusers')->where('id', $studentID)->first();
        $forSemester = $this->checkSemester($info);

        $BE = true;
        if ($info->college == 'coep' ||
                $info->college == 'gcoer' ||
                $info->college == 'gcoek') {
            switch ($info->college) {
                case 'coep':
                    $info->college = 'College of Engineering Pune';
                    break;
                case 'gcoer':
                    $info->college = 'GCOER, Avasari';
                    break;
                case 'gcoek':
                    $info->college = 'GCE, Karad';
                    break;
            }
            $semester_marks = DB::table('be_semester_marks')
                    ->where('id', $info->id)
                    ->select('semester1', 'semester2', 'semester3', 'semester4', 'semester5', 'semester6', 'semester7', 'semester8', 'CGPA')
                    ->first();
        } else {
            switch ($info->college) {
                case 'gpp':
                    $info->college = 'Government Polytechnic Pune';
                    break;
                case 'gpa':
                    $info->college = 'Government Polytechnic Awasari';
                    break;
            }
            $semester_marks = DB::table('diploma_semester_marks')
                    ->where('id', $info->id)
                    ->select('semester1', 'semester2', 'semester3', 'semester4', 'semester5', 'semester6', 'CGPA')
                    ->first();
            $BE = false;
        }

        if ($info->directSY == 'yes') {
            $forSemester += 2;
        }
        
        $flg = false;
        switch ($forSemester) {
            case 8:
                if (($semester_marks->semester8) != null) {
                    $flg = true;
                }
            case 7:
                if (($semester_marks->semester7) != null) {
                    $flg = true;
                }
            case 6:
                if (($semester_marks->semester6) != null) {
                    $flg = true;
                }
            case 5:
                if (($semester_marks->semester5) != null) {
                    $flg = true;
                }
            case 4:
                if (($semester_marks->semester4) != null) {
                    $flg = true;
                }
            case 3:
                if (($semester_marks->semester3) != null) {
                    $flg = true;
                }
            case 2:
                if (($semester_marks->semester2) != null) {
                    $flg = true;
                }
            case 1:
                if (($semester_marks->semester1) != null) {
                    $flg = true;
                }
            default:
                break;
        }

        if ($flg) {
            $ssc_marks = DB::table('ssc_hsc_diploma')->where('id', $info->id)->first();
            if ($BE) {
                if ($info->directSY == 'no') {
                    return view('print.BE_profile', compact('info', 'ssc_marks', 'semester_marks', 'banks'));
                }
                return view('print.DSY_BE_profile', compact('info', 'ssc_marks', 'semester_marks', 'banks'));
            } else {
                if ($info->directSY == 'no') {
                    return view('print.Diploma_profile', compact('info', 'ssc_marks', 'semester_marks', 'banks'));
                }
                return view('print.DSY_Diploma_profile', compact('info', 'ssc_marks', 'semester_marks', 'banks'));
            }
        } else {
            return redirect(route('home'))->withErrors('Please update your marks first');
        }
    }

    public function checkSemester($info) {

        $currentYear = date("Y");
        $months = date('m');
        $addMonths = 0;
        switch ($months) {
            case ($months >= 7):
                $addMonths = 1;
                break;
        }

        $years = $currentYear - $info->yearOfAdmission;
        $forSemester = 1 + $addMonths + ($years - 1) * 2;
        return $forSemester;
    }

}
