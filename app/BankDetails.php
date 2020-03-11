<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model {

    use Notifiable;

    protected $fillable = [
        'bank_Name', 'account_No', 'IFSC_Code', 'branch',
    ];
}
