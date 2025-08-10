<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCheck extends Model
{
    //
    protected $fillable = [
        'email',
        'is_valid',
        'reason',
        'meta',
    ];

    protected $table = 'email_checks';
}
