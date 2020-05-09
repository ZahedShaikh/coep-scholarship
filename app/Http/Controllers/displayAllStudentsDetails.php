<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class displayAllStudentsDetails extends Controller {

    public function index() {
        return view('charts-and-details.displayAllStudentsDetails');
    }

    public function show(Request $request) {

        if ($request->ajax()) {
            $output = '';
            $from = $request->get('from');
            $to = $request->get('to');

            $data_DE = DB::table('registerusers')
                    ->join('scholarship_accepted_list', 'scholarship_accepted_list.id', '=', 'registerusers.id')
                    ->join('bank_details', 'bank_details.id', '=', 'scholarship_accepted_list.id')
                    ->join('diploma_semester_marks', 'registerusers.id', '=', 'diploma_semester_marks.id')
                    ->Where('yearOfAdmission', '>=', date('' . $from . ''))
                    ->Where('yearOfAdmission', '<=', date('' . $to . ''))
                    ->orderBy('registerusers.id', 'ASC')
                    ->select('registerusers.id', 'name', 'middleName', 'surName', 'category', 'gender', 'yearOfAdmission', 'contact', 'college', 'collegeEnrollmentNo', 'directSY', 'registerusers.created_at', 'registerusers.updated_at',
                            'bank_Name', 'account_No', 'IFSC_Code', 'branch', 'bank_details_updated',
                            'semester1', 'semester2', 'semester3', 'semester4', 'semester5', 'semester6', 'CGPA', 'semester_marks_updated')
                    ->get();

            $data_BE = DB::table('registerusers')
                    ->join('scholarship_accepted_list', 'scholarship_accepted_list.id', '=', 'registerusers.id')
                    ->join('bank_details', 'bank_details.id', '=', 'scholarship_accepted_list.id')
                    ->join('be_semester_marks', 'be_semester_marks.id', '=', 'scholarship_accepted_list.id')
                    ->Where('yearOfAdmission', '>=', date('' . $from . ''))
                    ->Where('yearOfAdmission', '<=', date('' . $to . ''))
                    ->orderBy('registerusers.id', 'ASC')
                    ->select('registerusers.id', 'name', 'middleName', 'surName', 'category', 'gender', 'yearOfAdmission', 'contact', 'college', 'collegeEnrollmentNo', 'directSY', 'registerusers.created_at', 'registerusers.updated_at',
                            'bank_Name', 'account_No', 'IFSC_Code', 'branch', 'bank_details_updated',
                            'semester1', 'semester2', 'semester3', 'semester4', 'semester5', 'semester6', 'semester7', 'semester8', 'CGPA', 'semester_marks_updated')
                    ->get();

            $export_data = $data_BE->merge($data_DE);
            $total_row = $export_data->count();

            if ($total_row > 0) {
                foreach ($export_data as $row) {
                    $fullName = $row->name . " " . $row->middleName . " " . $row->surName;
                    $output .= '
                    <tr id=\"' . $row->id . '\">
                    <td align=\'center\'>' . $row->id . '</td>
                    <td>' . $fullName . '</td>
                    <td>' . $row->college . '</td>
                    <td>' . $row->directSY . '</td>
                    <td>' . $row->category . '</td>
                    <td>' . $row->gender . '</td>
                    <td>' . $row->yearOfAdmission . '</td>
                    <td>' . $row->contact . "</td>
                    <td> <a onclick=\"$(this).assign('$row->id')\" class=\"btn btn-primary align-content-md-center\">Show</a> </td>
                    </tr>
                    ";
                }
            } else {
                $output = '
            <tr>
            <td align="center" colspan="9">No Data Found</td>
            </tr>
            ';
            }

            $data = array(
                'table_data' => $output,
                'total_data' => $total_row,
                'export_data' => $export_data->toArray()
            );

            echo json_encode($data);
        }
    }

    public function exportExt() {
        //
    }

}
