<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class accountantController extends Controller {

    public function index() {
        return view('accountant.amountDistribute');
    }

    public function show(Request $request) {

        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');

            if ($query != '') {
                $data = DB::table('registerusers')
                        ->join('amount_sanctioned_by_issuer', 'registerusers.id', '=', 'amount_sanctioned_by_issuer.id')
                        ->join('bank_details', 'registerusers.id', '=', 'bank_details.id')
                        ->where('registerusers.id', 'LIKE', '%' . $query . '%')
                        ->orWhere('registerusers.name', 'LIKE', '%' . $query . '%')
                        ->select('registerusers.id', 'registerusers.name', 'registerusers.middleName', 'registerusers.surName', 'registerusers.contact', 'registerusers.college',
                                'bank_details.bank_Name', 'bank_details.IFSC_Code', 'bank_details.account_No', 'bank_details.branch',
                                'amount_sanctioned_by_issuer.amount', 'amount_sanctioned_by_issuer.now_receiving_amount_for_semester')
                        ->orderBy('registerusers.college', 'ASC')
                        ->get();
            } else {
                $data = DB::table('registerusers')
                        ->join('amount_sanctioned_by_issuer', 'registerusers.id', '=', 'amount_sanctioned_by_issuer.id')
                        ->join('bank_details', 'registerusers.id', '=', 'bank_details.id')
                        ->select('registerusers.id', 'registerusers.name', 'registerusers.middleName', 'registerusers.surName', 'registerusers.contact', 'registerusers.college',
                                'bank_details.bank_Name', 'bank_details.IFSC_Code', 'bank_details.account_No', 'bank_details.branch',
                                'amount_sanctioned_by_issuer.amount', 'amount_sanctioned_by_issuer.receiving_amount_for_semester')
                        ->orderBy('registerusers.college', 'ASC')
                        ->get();
            }

            $total_row = $data->count();

            if ($total_row > 0) {
                foreach ($data as $row) {

                    $fullName = $row->name . " " . $row->middleName . " " . $row->surName;
                    $prev_amount_received_in_semester = $row->receiving_amount_for_semester - ($row->amount / 4000);
                    $multiplier = 12.5;
                    if ($row->college == 'gpp' || $row->college == 'gpa') {
                        $multiplier = 16.6;
                    }

                    $pre = $prev_amount_received_in_semester * $multiplier;
                    $now = ($row->receiving_amount_for_semester * $multiplier) - $pre;

                    $output .= '
                    <tr id=\"' . $row->id . '\">
                    <td align=\'center\'>' . $row->id . '</td>
                    <td>' . $fullName . '</td>
                    <td>' . $row->college . '</td>
                    <td>' . $row->contact . "</td>
                    <td><div class=\"progress\" style=\"height: 30px;\">
                      <div class=\"progress-bar bg-success\" role=\"progressbar\" style=\"width:" . $pre . "%\" aria-valuenow=\"\" aria-valuemin=\"0\" aria-valuemax=\"100\">" . $prev_amount_received_in_semester . "</div>
                      <div class=\"progress-bar \" role=\"progressbar\" style=\"width:" . $now . "%\" aria-valuenow=\"\" aria-valuemin=\"0\" aria-valuemax=\"100\">" . $row->receiving_amount_for_semester . "</div>
                    </div></td>
                    <td contenteditable='true'>" . $row->amount . "</td>
                    <td> <a onclick=\"$(this).assign('$row->id')\" class=\"btn btn-primary align-content-md-center\">Sanction Amount</a> </td>
                    </tr>
                    ";

//                    
//                    $fullName = $row->name . " " . $row->middleName . " " . $row->surName;
//                    $output .= '
//                    <tr id=\"' . $row->id . '\">
//                    <td align=\'center\'>' . $row->id . '</td>
//                    <td>' . $fullName . '</td>
//                    <td>' . $row->college . '</td>
//                    <td>' . $row->contact . '</td>
//                    <td>' . $row->receiving_amount_for_semester . '</td>
//                    <td>' . $row->amount . "</td>
//                    <td> <a onclick=\"$(this).assign('$row->id')\" class=\"btn btn-primary align-content-md-center\">Sanction Amount</a> </td>
//                    </tr>
//                    ";
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
                'export_data' => $data->toArray()
            );

            echo json_encode($data);
        }
    }

    public function send(Request $request) {
        if ($request->ajax()) {
            $studentID = $request->get('query');
            $this->functionSaction($studentID);
            echo json_encode(true);
        }
    }

    // Sanction remaining all application 
    public function sanction(Request $request) {
        try {
            if ($request->ajax()) {
                $ids = $request->input('SanctionAlldataIds');
                foreach ($ids as $studentID) {
                    $this->functionSaction($studentID);
                }
            }
            echo json_encode(true);
        } catch (\Exception $e) {
            error . log('Error for sanction all', $e);
            echo json_encode(false);
        }
    }

    public function functionSaction($studentID) {
        try {
            DB::beginTransaction();

            $temp = DB::table('amount_sanctioned_by_issuer')
                    ->where('id', '=', $studentID)
                    ->first();

            DB::table('scholarship_status')
                    ->where('id', $studentID)
                    ->update(['in_process_with' => 'issuer',
                        'prev_amount_received_in_semester' => $temp->receiving_amount_for_semester]);

            DB::table('transaction_history')->insert(
                    ['id' => $studentID,
                        'dateOfTransaction' => now(),
                        'amount' => $temp->amount,
                        'amountReceivedForYear' => ceil($temp->receiving_amount_for_semester / 2),
                        'amountReceivedForSemester' => $temp->receiving_amount_for_semester,
                        'year' => date("Y"),
                        'created_at' => Carbon::now(),
                        'updated_at' => now()]
            );

            DB::table('amount_sanctioned_by_issuer')->where('id', '=', $studentID)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd('Something went wrong - admin.auth.accountcontroller@send', $e);
        }
    }

}
