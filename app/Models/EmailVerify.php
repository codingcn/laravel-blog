<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerify extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'email';
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;
}
