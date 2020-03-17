<?php

namespace App\Http\Controllers\Auth;

use App\registeruser;
use App\semesterMarks;
use App\BankDetails;
use App\scholarship_applicants;
use App\ssc_hsc_diploma;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller {

    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct() {
        $this->middleware('guest');
    }

    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => ['required', 'string', 'max:255'],
                    'surName' => ['required', 'string', 'max:255'],
                    'gender' => ['required'],
                    'yearOfAdmission' => ['required', 'string', 'max:255'],
                    'contact' => ['required', 'digits:10', 'min:10'],
                    'college' => ['required'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:registerusers'],
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    public function create(array $data) {

        try {
            DB::beginTransaction();

            // Since we are dealing with year only.
            $year = date('Y', strtotime($data['yearOfAdmission']));

            $user = registeruser::create([
                        'name' => ucfirst(strtolower($data['name'])),
                        'middleName' => ucfirst(strtolower($data['middleName'])),
                        'surName' => ucfirst(strtolower($data['surName'])),
                        'category' => $data['category'],
                        'gender' => $data['gender'],
                        'college' => $data['college'],
                        'collegeEnrollmentNo' => $data['collegeEnrollmentNo'],
                        'yearOfAdmission' => $year,
                        'contact' => $data['contact'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
            ]);

            $id = $user->id; // Get current user id

            semesterMarks::create([
                'id' => $id,
            ]);

            BankDetails::create([
                'id' => $id,
            ]);

            scholarship_applicants::create([
                'id' => $id,
            ]);

            ssc_hsc_diploma::create([
                'id' => $id,
            ]);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return view('auth.login');
        }
    }

}
