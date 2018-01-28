<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authentication
{
    use HasApiTokens, Notifiable;
    /**
     * 不可被批量赋值的属性。
     * @var array
     */
    protected $guarded = [];

    public function articles()
    {
        $this->hasMany(Article::class);
    }

    public function comments()
    {
        $this->hasMany(Comment::class);
    }


}
