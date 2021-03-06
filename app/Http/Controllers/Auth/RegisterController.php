<?php

namespace App\Http\Controllers\Auth;

use App\registeruser;
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
                    'contact' => ['required', 'digits:10', 'min:10'],
                    'college' => ['required'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:registerusers'],
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    public function create(array $data) {

        try {
            DB::beginTransaction();

            $user = registeruser::create([
                        'name' => ucfirst(strtolower($data['name'])),
                        'middleName' => ucfirst(strtolower($data['middleName'])),
                        'surName' => ucfirst(strtolower($data['surName'])),
                        'category' => $data['category'],
                        'gender' => $data['gender'],
                        'college' => $data['college'],
                        'directSY' => $data['directSY'],
                        'collegeEnrollmentNo' => $data['collegeEnrollmentNo'],
                        'yearOfAdmission' => $data['yearOfAdmission'],
                        'contact' => $data['contact'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
            ]);

            $id = $user->id; // Get current user id

            if ($user->college == 'coep' || $user->college == 'gcoer' || $user->college == 'gcoek') {
                DB::insert('insert into be_semester_marks (id) values (?)', [$id]);
            } else {
                DB::insert('insert into diploma_semester_marks (id) values (?)', [$id]);
            }

            DB::insert('insert into ssc_hsc_diploma (id) values (?)', [$id]);
            DB::insert('insert into bank_details (id) values (?)', [$id]);
            DB::insert('insert into scholarship_applicants (id) values (?)', [$id]);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return view('auth.login');
        }
    }

}
