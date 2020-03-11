<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\registeruser;
use Illuminate\Support\Facades\DB;

class LiveSearch extends Controller {

    public function index() {
        return view('vendor.multiauth.admin.live_search');
    }

    public function action(Request $request) {

        if ($request->ajax()) {

            $output = '';
            $query = $request->get('query');

            if ($query != '') {

                $data = DB::table('registerusers')
                        ->where('id', 'LIKE', '%' . $query . '%')
                        ->orWhere('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('collegeEnrollmentNo', 'LIKE', '%' . $query . '%')
                        ->orderBy('id', 'desc')
                        ->get();
            } else {
                $data = DB::table('registerusers')
                        ->orderBy('id', 'desc')
                        ->get();
            }

            $total_row = $data->count();

            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '
            <tr>
            <td>' . $row->name . '</td>
            <td>' . $row->college . '</td>
            <td>' . $row->email . '</td>
            <td>' . $row->contact . "</td>
            <td> <a href=\"javascript:history.back()\" class=\"btn btn-primary\"> " . $row->id . " </td>
            </tr>
            ";
                }
            } else {
                $output = '
            <tr>
            <td align="center" colspan="5">No Data Found</td>
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

}
