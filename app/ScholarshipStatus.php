<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ScholarshipStatus extends Model {

    use Notifiable;

    public $table = "scholarship_status";
    protected $fillable = [
        'id', 'lastest_approved_date', 'prev_amount_received_in_semester', 'now_receiving_amount_for_semester',
    ];

}
