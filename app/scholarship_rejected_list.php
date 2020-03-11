<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class scholarship_rejected_list extends Model
{
    use Notifiable;
    
    public $table = "scholarship_rejected_list";
    
    protected $fillable = [
        'id',
    ];
}
