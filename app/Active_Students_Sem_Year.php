<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Active_Students_Sem_Year extends Model {

    use Notifiable;
    
    public $table = "Active_Students_Sem_Year";
    
    protected $fillable = [
        'id',
    ];
}
