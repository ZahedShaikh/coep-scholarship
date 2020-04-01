<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ScholarshipStatus;
use App\scholarship_accepted_list;
use App\scholarship_rejected_list;
use App\scholarship_applicants;
use Illuminate\Support\Facades\DB;

class newApplicationsController extends Controller {

    public function index() {
        return view('vendor.multiauth.admin.newScholarshipApplications');
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

                $data = DB::table('registerusers')->join('scholarship_applicants', function ($join) {
                            $join->on('registerusers.id', '=', 'scholarship_applicants.id');
                        })
                        ->join('bank_details', 'bank_details.id', '=', 'registerusers.id')
                        ->where('bank_details.bank_details_updated', '=', 'yes')
                        ->where('registerusers.id', 'LIKE', '%' . $query . '%')
                        ->orWhere('registerusers.name', 'LIKE', '%' . $query . '%')
                        ->orderBy('registerusers.id', 'desc')
                        ->get();
            } else {
                $data = DB::table('registerusers')
                        ->join('scholarship_applicants', function ($join) {
                            $join->on('registerusers.id', '=', 'scholarship_applicants.id');
                        })
                        ->join('bank_details', 'bank_details.id', '=', 'registerusers.id')
                        ->where('bank_details.bank_details_updated', '=', 'yes')
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
                    <td> <a onclick=\"$(this).assign('$row->id')\" class=\"btn btn-primary align-content-md-center\">Sanction</a> </td>
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

    public function update(Request $request) {
        //
    }

    public function accept(Request $request) {

        if ($request->ajax()) {
            $output = false;
            $studentID = $request->get('query');
            try {
                DB::beginTransaction();

                ScholarshipStatus::create([
                    'id' => $studentID,
                ]);

                scholarship_accepted_list::create([
                    'id' => $studentID,
                ]);

                DB::table('scholarship_applicants')->where('id', '=', $studentID)->delete();

                DB::commit();
                $output = true;
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('vendor.multiauth.admin.newScholarshipApplications'))->with('message', 'Something went wrong');
            }

            echo json_encode($output);
        }
    }

    public function reject() {
        if ($request->ajax()) {
            $output = false;

            try {
                DB::beginTransaction();

                $remainingIDs = DB::table('scholarship_applicants')->select('id');

                foreach ($remainingIDs as $answers) {
                    scholarship_rejected_list::create([
                        'id' => $answers,
                    ]);
                }

                DB::table('scholarship_applicants')->truncate();

                DB::commit();
                $output = true;
            } catch (\Exception $e) {
                DB::rollback();
                return redirect(route('vendor.multiauth.admin.newScholarshipApplications'))->with('message', 'Something went wrong');
            }

            echo json_encode($output);
        }
    }

    public function edit(ScholarshipStatus $ScholarshipStatus) {
        //
    }

    public function destroy(ScholarshipStatus $ScholarshipStatus) {
        //
    }

}
