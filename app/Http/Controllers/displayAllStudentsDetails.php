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

            $data1 = DB::table('registerusers')
                    ->join('scholarship_accepted_list', 'scholarship_accepted_list.id', '=', 'registerusers.id')
                    ->Where('yearOfAdmission', '>=', date('' . $from . ''))
                    ->Where('yearOfAdmission', '<=', date('' . $to . ''))
                    ->orderBy('registerusers.id', 'ASC')
                    ->get();

            $total_row = $data1->count();

            if ($total_row > 0) {
                foreach ($data1 as $row) {
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
                    <td> <a onclick=\"$(this).assign('$row->id')\" class=\"btn btn-primary align-content-md-center\">view</a> </td>
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
                'total_data' => $total_row
            );
            echo json_encode($data);
        }
    }

    public function sanction() {
        //
    }

    public function edit() {
        //
    }

}
