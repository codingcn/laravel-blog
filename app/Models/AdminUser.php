<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use HasApiTokens, Notifiable;


    public function findForPassport($username) {
        return $this->orWhere('username', $username)->orWhere('email', $username)->orWhere('phone', $username)->first();
    }
}
