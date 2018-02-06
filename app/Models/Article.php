<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{

    protected $hidden = ['pivot'];
    protected $guarded = [];

    public function articleCategory()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        //一篇文章有多个评论
        return $this->hasMany(Comment::class)->orderByDesc('created_at');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    /**
     * 获取归档列表
     * @return mixed
     */
    public static function archives()
    {
        return static::selectRaw('YEAR(created_at) AS year,MONTH(created_at) AS month,COUNT(*) published')
            ->groupBy('year', 'month')
            ->orderByRaw('MIN(created_at) desc')
            ->get()
            ->toArray();
    }

    public static function recommends()
    {
        return static::where(['recommend' => 2, 'status' => 2])
            ->take(5)
            // ->orderBy(\DB::raw('RAND()'))
            ->orderByRaw('RAND()')
            ->withCount('comments')
            ->get(['id', 'title', 'published_at', 'page_views', 'content_length']);
    }

    /**
     * 归档筛选
     * @param $query
     * @param $filters
     */
    public function scopeFilter($query, $filters)
    {
        if ($year = !empty($filters['year']) ? $filters['year'] : false) {
            $query->whereYear('created_at', $year);
        }
        if ($month = !empty($filters['month']) ? $filters['month'] : false) {
            $query->whereMonth('created_at', $month);
        }
    }


}
