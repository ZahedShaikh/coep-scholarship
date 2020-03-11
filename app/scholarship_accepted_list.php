<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class scholarship_accepted_list extends Model
{
    use Notifiable;
    
    public $table = "scholarship_accepted_list";
    
    protected $fillable = [
        'id',
    ];
}
