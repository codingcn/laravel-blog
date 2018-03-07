<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{

    protected $hidden = ['pivot'];
    protected $guarded = [];
    protected $appends = ['format_recommend','format_publish_status'];

public function getFormatPublishStatusAttribute()
{
    if ($this->attributes['publish_status'] === 1) {
        $format_publish_status = '未发布';
    } elseif ($this->getOriginal('publish_status') === 2) {
        $format_publish_status = '已发布';
    } else {
        $format_publish_status = '未知';
    }
    return $format_publish_status;
}
    public function getFormatRecommendAttribute()
    {
        if ($this->attributes['recommend'] === 1) {
            $format_recommend = '不推荐';
        } elseif ($this->getOriginal('recommend') === 2) {
            $format_recommend = '推荐';
        } else {
            $format_recommend = '未知';
        }
        return $format_recommend;
    }



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
            ->where('publish_status', '2')
            ->groupBy('year', 'month')
            ->orderByRaw('MIN(created_at) desc')
            ->take(8)
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
            ->select(['id', 'category_id', 'title', 'content_length', 'page_views', 'created_at'])
            ->take(5)
            ->orderByRaw('created_at')
            ->withCount('comments')
            ->get(['id', 'title', 'created_at', 'page_views', 'content_length']);
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
