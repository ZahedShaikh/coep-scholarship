<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class scholarship_tenure extends Model
{
    use Notifiable;
    
    public $table = "scholarship_tenure";
    
    protected $fillable = [
        'id',
    ];
}
