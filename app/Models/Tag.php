<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $hidden = ['pivot'];
    protected $fillable = [
        'name'
    ];
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    /**
     * 标签块
     * @return mixed
     */
    public static function asideTags()
    {
        return self::take(50)
            ->get(['id','name'])
            ->toArray();
    }
    public function getRouteKeyName()
    {
        return 'name';
    }
}
