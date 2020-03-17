<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class registeruser extends Authenticatable {

    use Notifiable;

    protected $fillable = [
        'name', 'middleName', 'surName', 'category', 'gender', 'yearOfAdmission',
        'contact', 'college', 'directSY', 'collegeEnrollmentNo', 'email', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'yearOfAdmission' => 'date:Y',
    ];

}
