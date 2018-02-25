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
        return static::selectRaw('YEAR(published_at) AS year,MONTH(published_at) AS month,COUNT(*) published')
            ->where('publish_status', '2')
            ->groupBy('year', 'month')
            ->orderByRaw('MIN(created_at) desc')
            ->take(10)
            ->get()
            ->toArray();
    }

    /**
     * 推荐
     * @return mixed
     */
    public static function recommends()
    {
        return static::where(['recommend' => 2, 'publish_status' => 2])
            ->select(['id','category_id', 'title',  'content_length', 'page_views', 'published_at'])
            ->take(5)
            ->orderByRaw('published_at')
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
            $query->whereYear('published_at', $year);
        }
        if ($month = !empty($filters['month']) ? $filters['month'] : false) {
            $query->whereMonth('published_at', $month);
        }
    }
}
