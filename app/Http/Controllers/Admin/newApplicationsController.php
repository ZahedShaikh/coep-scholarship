<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ScholarshipStatus;
use App\scholarship_accepted_list;
use Illuminate\Support\Facades\DB;

class newApplicationsController extends Controller {

    public function index() {
        return view('admin.auth.newScholarshipApplications');
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        //
    }

    public function show(Request $request) {

        if ($request->ajax()) {

            $output = '';
            $query = $request->get('query');

            if ($query != '') {

                $data = DB::table('registerusers')
                        ->join('scholarship_applicants', 'registerusers.id', '=', 'scholarship_applicants.id')
                        ->join('bank_details', 'bank_details.id', '=', 'registerusers.id')
                        ->where('bank_details.bank_details_updated', '=', 'yes')
                        ->where('registerusers.id', 'LIKE', '%' . $query . '%')
                        ->orWhere('registerusers.name', 'LIKE', '%' . $query . '%')
                        ->orderBy('registerusers.id', 'ASC')
                        ->get();
            } else {
                $data = DB::table('registerusers')
                        ->join('scholarship_applicants', 'registerusers.id', '=', 'scholarship_applicants.id')
                        ->join('bank_details', 'bank_details.id', '=', 'registerusers.id')
                        ->where('bank_details.bank_details_updated', '=', 'yes')
                        ->orderBy('registerusers.id', 'ASC')
                        ->get();
            }

            $total_row = $data->count();

            if ($total_row > 0) {
                foreach ($data as $row) {

                    $fullName = $row->name . " " . $row->middleName . " " . $row->surName;

                    $output .= '
                    <tr id=\"' . $row->id . '\">
                    <td align=\'center\'>' . $row->id . '</td>
                    <td>' . $row->version . '</td>
                    <td align=\'left\'>' . $fullName . '</td>
                    <td>' . $row->college . '</td>
                    <td>' . $row->contact . "</td>
                    <td> <a onclick=\"$(this).assign('$row->id')\" class=\"btn btn-primary align-content-md-center\">Sanction</a> </td>
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

    public function update(Request $request) {
        //
    }

    public function accept(Request $request) {

        if ($request->ajax()) {
            $output = false;
            $studentID = $request->get('query');
            try {
                DB::beginTransaction();

                $data = DB::table('registerusers')
                        ->where('id', '=', $studentID)
                        ->select('directSY')
                        ->first();

                if ($data->directSY == 'yes') {
                    ScholarshipStatus::create([
                        'id' => $studentID,
                        'prev_amount_received_in_semester' => 2,
                        'now_receiving_amount_for_semester' => 2
                    ]);
                } else {
                    ScholarshipStatus::create([
                        'id' => $studentID
                    ]);
                }

                scholarship_accepted_list::create([
                    'id' => $studentID,
                ]);

                DB::table('scholarship_applicants')->where('id', '=', $studentID)->delete();

                DB::commit();
                $output = true;
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('admin.auth.newScholarshipApplications'))->with('message', 'Something went wrong');
            }

            echo json_encode($output);
        }
    }

    public function reject() {
        try {
            DB::beginTransaction();

            $remainingIDs = \App\scholarship_applicants::where('id', '>', 0)->pluck('id')->toArray();
            $registerusers = DB::table('registerusers')->whereIn('id', $remainingIDs)->get()->toArray();
            $COUNT = 0;
            foreach ($remainingIDs as $studentID) {
                DB::table('scholarship_rejected_list')->insert([
                    'id' => $studentID,
                    'name' => $registerusers[$COUNT]->name,
                    'middleName' => $registerusers[$COUNT]->middleName,
                    'surName' => $registerusers[$COUNT]->surName,
                    'category' => $registerusers[$COUNT]->category,
                    'gender' => $registerusers[$COUNT]->gender,
                    'yearOfAdmission' => $registerusers[$COUNT]->yearOfAdmission,
                    'contact' => $registerusers[$COUNT]->contact,
                    'college' => $registerusers[$COUNT]->college,
                    'email' => $registerusers[$COUNT]->email]
                );
                $COUNT++;
            }

            DB::table('registerusers')->whereIn('id', $remainingIDs)->delete();
            DB::table('scholarship_applicants')->truncate();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect(route('admin.home'))->withErrors('message', 'Something went wrong. Please contact Dev. Error code:newApplicationsController');
        }

        return redirect(route('admin.home'))->with('message', 'Successfully Rejected all application');
    }

    public function edit(ScholarshipStatus $ScholarshipStatus) {
        //
    }

    public function destroy(ScholarshipStatus $ScholarshipStatus) {
        //
    }

}
