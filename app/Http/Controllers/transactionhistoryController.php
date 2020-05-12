<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class transactionhistoryController extends Controller {

    public function index() {
        return view('charts-and-details.transactionhistory');
    }

    public function showHistory(Request $request) {
        if ($request->ajax()) {
            $output = '';

            $from = $request->get('from');
            $to = $request->get('to');

            $export_data = DB::table('transaction_history')
                    ->join('registerusers', 'transaction_history.id', '=', 'registerusers.id')
                    ->Where('dateOfTransaction', '>=', date('' . $from . ''))
                    ->Where('dateOfTransaction', '<=', date('' . $to . ''))
                    ->select('registerusers.id', 'name', 'middleName', 'surName', 'category', 'gender', 'yearOfAdmission', 'contact', 'college', 'collegeEnrollmentNo', 'directSY',
                            'transaction_history.transactionId', 'dateOfTransaction', 'amount', 'amountReceivedForYear', 'transaction_history.created_at')
                    ->orderBy('transaction_history.transactionId', 'DESC')
                    ->get();

            $total_row = $export_data->count();

            if ($total_row > 0) {
                foreach ($export_data as $row) {
                    $fullName = $row->name . " " . $row->middleName . " " . $row->surName;
                    $output .= '
                    <tr id=\"' . $row->transactionId . '\">
                    <td align=\'center\'>' . $row->transactionId . '</td>
                    <td>' . $fullName . '</td>
                    <td>' . $row->college . '</td>
                    <td>' . $row->contact . '</td>
                    <td>' . $row->amountReceivedForYear . '</td>
                    <td>' . $row->dateOfTransaction . '</td>
                    <td>' . $row->amount . "</td>
                    </tr>";
                }
            } else {
                $output = '
            <tr>
            <td align="center" colspan="7">No Data Found</td>
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

}
