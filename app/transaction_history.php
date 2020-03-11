<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class transaction_history extends Model {

    use Notifiable;
    
    public $table = "transaction_history";
    
    protected $fillable = [
        'id', 'amount', 'fundingAgancy',
    ];

}
