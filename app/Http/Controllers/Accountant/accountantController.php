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
//                        ->select('registerusers.name', 'registerusers.middleName', 'registerusers.surName', 'registerusers.contact', 'registerusers.college',
//                                'bank_details.bank_Name', 'bank_details.IFSC_Code', 'bank_details.account_No', 'bank_details.branch',
//                                'amount_sanctioned_by_issuer.amount', 'amount_sanctioned_by_issuer.now_receiving_amount_for_semester')
                        ->orderBy('registerusers.college', 'ASC')
                        ->get();
            } else {
                $data = DB::table('registerusers')
                        ->join('amount_sanctioned_by_issuer', 'registerusers.id', '=', 'amount_sanctioned_by_issuer.id')
                        ->join('bank_details', 'registerusers.id', '=', 'bank_details.id')
//                        ->select('registerusers.name', 'registerusers.middleName', 'registerusers.surName', 'registerusers.contact', 'registerusers.college',
//                                'bank_details.bank_Name', 'bank_details.IFSC_Code', 'bank_details.account_No', 'bank_details.branch',
//                                'amount_sanctioned_by_issuer.amount', 'amount_sanctioned_by_issuer.receiving_amount_for_semester')
                        ->orderBy('registerusers.college', 'ASC')
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
                    <td>' . $row->contact . '</td>
                    <td>' . $row->receiving_amount_for_semester . '</td>
                    <td>' . $row->amount . "</td>
                    <td> <a onclick=\"$(this).assign('$row->id')\" class=\"btn btn-primary align-content-md-center\">Sanction Amount</a> </td>
                    </tr>
                    ";
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
                'total_data' => $total_row
            );

            echo json_encode($data);
        }
    }

    // Sanction remaining all application 
    public function sanction() {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScholarshipStatus  $ScholarshipStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(ScholarshipStatus $ScholarshipStatus) {
        //
    }

    public function send(Request $request) {

        if ($request->ajax()) {
            $studentID = $request->get('query');
            try {
                DB::beginTransaction();

                $temp = DB::table('amount_sanctioned_by_issuer')
                        ->where('id', '=', $studentID)
                        ->first();

                DB::table('scholarship_status')
                        ->where('id', $studentID)
                        ->update(['in_process_with' => 'issuer', 
                            'prev_amount_received_in_semester'=> $temp->receiving_amount_for_semester]);

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

            echo json_encode(true);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScholarshipStatus  $ScholarshipStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScholarshipStatus $ScholarshipStatus) {
        //
    }

}
