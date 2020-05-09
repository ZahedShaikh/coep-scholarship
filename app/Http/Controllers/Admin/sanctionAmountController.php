<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ScholarshipStatus;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class sanctionAmountController extends Controller {

    public function index() {
        
        $this->updateStatus();
        return view('admin.auth.sendSanctionAmountToAccounts');
    }

    public function show(Request $request) {

        if ($request->ajax()) {
            $output = '';
            $data = [];
            $query = $request->get('query');

            if ($query != '') {
                $data1 = DB::table('registerusers')
                        ->join('scholarship_status AS s1', 'registerusers.id', '=', 'S1.id')
                        ->join('scholarship_status AS S2', 'registerusers.id', '=', 'S2.id')
                        ->join('diploma_semester_marks', 'registerusers.id', '=', 'diploma_semester_marks.id')
                        ->where('S1.in_process_with', '=', 'issuer')
                        ->where('S1.prev_amount_received_in_semester', '=', 'S2.now_receiving_amount_for_semester')
                        ->where('diploma_semester_marks.semester_marks_updated', '=', 'yes')
                        ->where('registerusers.id', 'LIKE', '%' . $query . '%')
                        ->orWhere('registerusers.name', 'LIKE', '%' . $query . '%')
                        ->orderBy('registerusers.id', 'ASC')
                        ->get();

                $data2 = DB::table('registerusers')
                        ->join('scholarship_status AS s1', 'registerusers.id', '=', 'S1.id')
                        ->join('scholarship_status AS S2', 'registerusers.id', '=', 'S2.id')
                        ->join('be_semester_marks', 'registerusers.id', '=', 'be_semester_marks.id')
                        ->where('S1.in_process_with', '=', 'issuer')
                        ->where('S1.prev_amount_received_in_semester', '=', 'S2.now_receiving_amount_for_semester')
                        ->where('be_semester_marks.semester_marks_updated', '=', 'yes')
                        ->where('registerusers.id', 'LIKE', '%' . $query . '%')
                        ->orWhere('registerusers.name', 'LIKE', '%' . $query . '%')
                        ->orderBy('registerusers.id', 'ASC')
                        ->get();

                $data = $data1->merge($data2);
            } else {
                $data1 = DB::table('registerusers')
                        ->join('scholarship_status AS s1', 'registerusers.id', '=', 'S1.id')
                        ->join('scholarship_status AS S2', 'registerusers.id', '=', 'S2.id')
                        ->join('diploma_semester_marks', 'registerusers.id', '=', 'diploma_semester_marks.id')
                        ->where('S1.in_process_with', '=', 'issuer')
                        ->where('S1.prev_amount_received_in_semester', '=', 'S2.now_receiving_amount_for_semester')
                        ->where('diploma_semester_marks.semester_marks_updated', '=', 'yes')
                        ->orderBy('registerusers.id', 'ASC')
                        ->get();

                $data2 = DB::table('registerusers')
                        ->join('scholarship_status AS s1', 'registerusers.id', '=', 'S1.id')
                        ->join('scholarship_status AS S2', 'registerusers.id', '=', 'S2.id')
                        ->join('be_semester_marks', 'registerusers.id', '=', 'be_semester_marks.id')
                        ->where('S1.in_process_with', '=', 'issuer')
                        ->where('S1.prev_amount_received_in_semester', '=', 'S2.now_receiving_amount_for_semester')
                        ->where('be_semester_marks.semester_marks_updated', '=', 'yes')
                        ->orderBy('registerusers.id', 'ASC')
                        ->get();

                $data = $data1->merge($data2);
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
                    <td>' . $row->contact . "</td>
                    <td contenteditable='true'>" . $row->now_receiving_amount_for_semester . "</td>
                    <td contenteditable='true'>" . $amount . "</td>
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

    public function edit(ScholarshipStatus $ScholarshipStatus) {
        //
    }

    public function send(Request $request) {

        if ($request->ajax()) {

            $studentID = $request->get('query_id');
            $receiving_amount_for_semester = $request->get('query_for_Sem');
            $amount = $request->get('query_amount');
            $output = false;

            try {
                DB::beginTransaction();
                DB::table('amount_sanctioned_by_issuer')->insert(
                        ['id' => $studentID, "created_at" => Carbon::now(), "updated_at" => now(),
                            'receiving_amount_for_semester' => $receiving_amount_for_semester, 'amount' => $amount]
                );

                $sem = DB::table('scholarship_status')
                        ->where('id', '=', $studentID)
                        ->select('now_receiving_amount_for_semester')
                        ->first();

                // Delete Student if its scholarship peroid is over 
                if (intval($sem->now_receiving_amount_for_semester == 8)) {
                    DB::table('scholarship_status')->where('id', '=', $studentID)->delete();
                    DB::table('scholarship_tenure')->insert(
                            ['id' => $studentID, 'created_at' => Carbon::now(), 'updated_at' => now()]
                    );
                }
                DB::table('scholarship_status')
                        ->where('id', $studentID)
                        ->update(['in_process_with' => 'accountant']);

                DB::commit();
                $output = true;
            } catch (\Exception $e) {
                DB::rollback();
                dd('Some problem in Sanction amount controller\n', $e);
                //return redirect(route('admin.auth.getSanctionAmount'))->with('message', 'Something went wrong');
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
    public function status() {

        $this->updateStatus();
        $output = '';

        $data_DE = DB::table('registerusers')
                ->join('diploma_semester_marks', 'registerusers.id', '=', 'diploma_semester_marks.id')
                ->where('diploma_semester_marks.semester_marks_updated', '=', 'no')
                ->orderBy('registerusers.college', 'ASC')
                ->select('registerusers.id', 'name', 'middleName', 'surName', 'category', 'gender', 'yearOfAdmission', 'contact', 'college', 'collegeEnrollmentNo', 'directSY', 'registerusers.created_at', 'registerusers.updated_at',
                        'semester1', 'semester2', 'semester3', 'semester4', 'semester5', 'semester6', 'CGPA', 'semester_marks_updated')
                ->get();

        $data_BE = DB::table('registerusers')
                ->join('be_semester_marks', 'registerusers.id', '=', 'be_semester_marks.id')
                ->where('be_semester_marks.semester_marks_updated', '=', 'no')
                ->orderBy('registerusers.college', 'ASC')
                ->select('registerusers.id', 'name', 'middleName', 'surName', 'category', 'gender', 'yearOfAdmission', 'contact', 'college', 'collegeEnrollmentNo', 'directSY', 'registerusers.created_at', 'registerusers.updated_at',
                        'semester1', 'semester2', 'semester3', 'semester4', 'semester5', 'semester6', 'CGPA', 'semester_marks_updated')
                ->get();

        $export_data = $data_BE->merge($data_DE);
        $total_row = $export_data->count();

        $data = array(
            'total_data' => $total_row,
            'export_data' => $export_data->toArray()
        );

        return view('admin.auth.studentsStatus', compact('data'));
    }

    public function updateStatus() {
        // Somehow dont know, In this query '=' means '!=' 
        // and '!=' means '='

        $data = DB::table('registerusers')
                ->join('scholarship_status', 'registerusers.id', '=', 'scholarship_status.id')
                ->where('scholarship_status.in_process_with', '=', 'issuer')
                ->where('scholarship_status.prev_amount_received_in_semester', '=', 'scholarship_status.now_receiving_amount_for_semester')
                ->orderBy('registerusers.id', 'desc')
                ->select('registerusers.id', 'registerusers.yearOfAdmission', 'college', 'directSY')
                ->get();

        $total_row = $data->count();
        if ($total_row > 0) {
            foreach ($data as $info) {
                $forSemester = $this->checkSemester($info);
                $BE = true;
                if ($info->college == 'coep' ||
                        $info->college == 'gcoer' ||
                        $info->college == 'gcoek') {
                    switch ($info->college) {
                        case 'coep':
                            $info->college = 'College of Engineering Pune';
                            break;
                        case 'gcoer':
                            $info->college = 'GCOER, Avasari';
                            break;
                        case 'gcoek':
                            $info->college = 'GCE, Karad';
                            break;
                    }
                    $semester_marks = DB::table('be_semester_marks')
                            ->where('id', $info->id)
                            ->select('semester1', 'semester2', 'semester3', 'semester4', 'semester5', 'semester6', 'semester7', 'semester8', 'CGPA')
                            ->first();
                } else {
                    switch ($info->college) {
                        case 'gpp':
                            $info->college = 'Government Polytechnic Pune';
                            break;
                        case 'gpa':
                            $info->college = 'Government Polytechnic Awasari';
                            break;
                    }
                    $semester_marks = DB::table('diploma_semester_marks')
                            ->where('id', $info->id)
                            ->select('semester1', 'semester2', 'semester3', 'semester4', 'semester5', 'semester6', 'CGPA')
                            ->first();
                    $BE = false;
                }

                if ($info->directSY == 'yes') {
                    $forSemester += 2;
                }

                $flg = false;

                switch ($forSemester) {
                    case 8:
                        if (($semester_marks->semester8) != null) {
                            $flg = true;
                        }
                        break;
                    case 7:
                        if (($semester_marks->semester7) != null) {
                            $flg = true;
                        }
                        break;
                    case 6:
                        if (($semester_marks->semester6) != null) {
                            $flg = true;
                        }
                        break;
                    case 5:
                        if (($semester_marks->semester5) != null) {
                            $flg = true;
                        }
                        break;
                    case 4:
                        if (($semester_marks->semester4) != null) {
                            $flg = true;
                        }
                        break;
                    case 3:
                        if (($semester_marks->semester3) != null) {
                            $flg = true;
                        }
                        break;
                    case 2:
                        if (($semester_marks->semester2) != null) {
                            $flg = true;
                        }
                        break;
                    case 1:
                        if (($semester_marks->semester1) != null) {
                            $flg = true;
                        }
                        break;
                    default:
                        break;
                }

                if ($flg) {
                    DB::table('scholarship_status')
                            ->where('id', $info->id)
                            ->update(['now_receiving_amount_for_semester' => $forSemester]);
                } else {
                    if ($BE) {
                        DB::table('be_semester_marks')
                                ->where('id', $info->id)
                                ->update(['semester_marks_updated' => 'no']);
                    } else {
                        DB::table('diploma_semester_marks')
                                ->where('id', $info->id)
                                ->update(['semester_marks_updated' => 'no']);
                    }
                }
            }
        }
    }

    public function checkSemester($info) {

        $currentYear = date("Y");
        $months = date('m');
        $addMonths = 0;
        switch ($months) {
            case ($months >= 7):
                $addMonths = 1;
                break;
        }

        $years = $currentYear - $info->yearOfAdmission;
        $forSemester = 1 + $addMonths + ($years - 1) * 2;
        return $forSemester;
    }

}
