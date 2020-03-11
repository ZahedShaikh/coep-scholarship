<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class scholarship_applicants extends Model
{
    use Notifiable;
    
    public $table = "scholarship_applicants";
    
    protected $fillable = [
        'id',
    ];
}
