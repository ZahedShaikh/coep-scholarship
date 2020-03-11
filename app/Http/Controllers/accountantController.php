<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class accountantController extends Controller {

    public function index() {
        return view('vendor.multiauth.admin.Amountant');
    }

    public function show(Request $request) {

        if ($request->ajax()) {

            $output = '';
            $query = $request->get('query');

            if ($query != '') {

                $data = DB::table('registerusers')->join('scholarship_status', function ($join) {
                            $join->on('registerusers.id', '=', 'scholarship_status.id');
                        })
                        ->where('registerusers.id', 'LIKE', '%' . $query . '%')
                        ->orWhere('registerusers.name', 'LIKE', '%' . $query . '%')
                        ->where('scholarship_status.in_process_with', '=', 'accountant')
                        ->orderBy('registerusers.id', 'desc')
                        ->get();
            } else {

                $data = DB::table('registerusers')
                        ->join('scholarship_status', function ($join) {
                            $join->on('registerusers.id', '=', 'scholarship_status.id');
                        })
                        ->where('scholarship_status.in_process_with', '=', 'accountant')
                        ->orderBy('registerusers.id', 'desc')
                        ->get();
            }

            $total_row = $data->count();

            if ($total_row > 0) {
                foreach ($data as $row) {

                    $fullName = $row->name . " " . $row->middleName . " " . $row->surName;
                    $amount = ($row->now_receiving_amount_for_semester - $row->prev_amount_received_in_semester) * 4000;

                    $output .= '
                    <tr id=\"' . $row->id . '\">
                    <td align=\'center\'>' . $row->id . '</td>
                    <td>' . $fullName . '</td>
                    <td>' . $row->college . '</td>
                    <td>' . $row->contact . '</td>
                    <td>' . $amount . "</td>
                    <td> <a onclick=\"$(this).assign('$row->id, $amount')\" class=\"btn btn-primary align-content-md-center\">Sanction Amount</a> </td>
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
            $output = false;

            $str_arr = explode(",", trim($request->get('query')));
            $studentID = $str_arr[0];
            $amount = (float) $str_arr[1];

            try {
                DB::beginTransaction();

                $temp = DB::table('scholarship_status')
                        ->where('scholarship_status.id', '=', $studentID)
                        ->join('registerusers', 'scholarship_status.id', '=', 'registerusers.id')
                        ->select('scholarship_status.now_receiving_amount_for_semester', 'registerusers.yearOfAdmission')
                        ->first();

                DB::table('scholarship_status')
                        ->where('id', $studentID)
                        ->update(['prev_amount_received_in_semester' => $temp->now_receiving_amount_for_semester,
                            'in_process_with' => 'issuer']);

                $months = date('m');
                $addMonths = 0;
                switch ($months) {
                    case ($months >= 7 and $months <= 11):
                        // This case for Semeseter 1
                        $addMonths = 2;
                        break;
                    case ($months >= 1 and $months <= 5):
                        // This case for Semeseter 2
                        $addMonths = 1;
                        break;
                    default:
                        // This case holidays
                        $addMonths = 0;
                }

                // Substracting 1 since I don't wanna count current year
                // Instead I will count $addMonths
                $years = date("Y") - date('Y', strtotime($temp->yearOfAdmission)) - 1;
                $forSemester = 1 + $addMonths + $years * 2;
                $years = $years + 1;

                DB::table('transaction_history')->insert(
                        ['id' => $studentID,
                            'dateOfTransaction' => now(),
                            'amount' => intval($amount),
                            'amountReceivedForYear' => $years,
                            'amountReceivedForSemester' => $forSemester,
                            'year' => date("Y"),
                            'created_at' => Carbon::now(),
                            'updated_at' => now()]
                );

                DB::table('amount_sanctioned_by_issuer')->where('id', '=', $studentID)->delete();
                DB::commit();
                $output = true;
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('vendor.multiauth.admin.getAmountToBeCredit'))->with('message', 'Something went wrong');
            }

            echo json_encode($output);
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
