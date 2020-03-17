<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class diploma_semesterMarks extends Model {

    use Notifiable;

    protected $fillable = [
        'semester1', 'semester2', 'semester3', 'semester4', 'semester5', 'semester6',
    ];
}
