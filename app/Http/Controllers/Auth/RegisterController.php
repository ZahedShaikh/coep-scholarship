<?php

namespace App\Http\Controllers\Auth;

use App\registeruser;
use App\semesterMarks;
use App\BankDetails;
use App\scholarship_applicants;
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

    protected function create(array $data) {

        try {
            DB::beginTransaction();

            $user = registeruser::create([
                        'name' => $data['name'],
                        'middleName' => $data['middleName'],
                        'surName' => $data['surName'],
                        'category' => $data['category'],
                        'gender' => $data['gender'],
                        'college' => $data['college'],
                        'collegeEnrollmentNo' => $data['collegeEnrollmentNo'],
                        'yearOfAdmission' => $data['yearOfAdmission'],
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


            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
            //return view('auth.login');
        }
    }

}
