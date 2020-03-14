<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ssc_hsc_diploma extends Model
{
    use Notifiable;
    
    public $table = "ssc_hsc_diploma";

    protected $fillable = [
        'ssc', 'hcs', 'diploma','sscYear', 'hcsYear', 'diplomaYear',
    ];
}
