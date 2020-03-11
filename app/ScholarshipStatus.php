<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ScholarshipStatus extends Model
{
    use Notifiable;
    
    public $table = "scholarship_status";
    
    protected $fillable = [
        'id',
    ];
}
