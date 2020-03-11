<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class displayAllStudentsDetails extends Controller {

    public function index() {
        return view('vendor.multiauth.charts-and-details.displayAllStudentsDetails');
    }

    public function show(Request $request) {

        if ($request->ajax()) {

            $output = '';
            $query = $request->get('query');

            if ($query != '') {


                $data = DB::table('registerusers')
                        ->where('registerusers.id', 'LIKE', '%' . $query . '%')
                        ->orWhere('registerusers.name', 'LIKE', '%' . $query . '%')
                        ->join('scholarship_status AS s1', 'registerusers.id', '=', 'S1.id')
                        ->join('scholarship_status AS S2', 'registerusers.id', '=', 'S2.id')
                        ->join('semester_marks', 'semester_marks.id', '=', 'registerusers.id')
                        ->where('semester_marks.semester_marks_updated', '=', 'yes')
                        ->where('S1.in_process_with', '=', 'issuer')
                        ->where('S1.prev_amount_received_in_semester', '!=', 'S2.now_receiving_amount_for_semester')
                        ->orderBy('registerusers.id', 'desc')
                        ->get();
            } else {

                $data = DB::table('registerusers')
                        ->join('scholarship_accepted_list', 'registerusers.id', '=', 'scholarship_accepted_list.id')
                        ->orderBy('registerusers.id', 'desc')
                        ->get();
            }

            $total_row = $data->count();

            if ($total_row > 0) {
                foreach ($data as $row) {

                    $fullName = $row->name . " " . $row->middleName . " " . $row->surName;

                    $output .= '
                    <tr id=\"' . $row->id . '\">
                    <td align=\'center\'>' . $row->id . '</td>
                    <td>' . $fullName . '</td>
                    <td>' . $row->college . '</td>
                    <td>' . $row->contact . "</td>
                    <td> <a onclick=\"$(this).assign('$row->id')\" class=\"btn btn-primary align-content-md-center\">View More details</a> </td>
                    </tr>
                    ";
                }
            } else {
                $output = '
            <tr>
            <td align="center" colspan="6">No Data Found</td>
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
