<section class="article-container">
    <h1 class="title">{{ $article['title'] }}</h1>
    <div class="meta">
        <!-- 如果文章更新时间大于发布时间，那么使用 tooltip 显示更新时间 -->
        <span class="publish-time">{{$article['created_at']}}</span>
        <span class="wordage">字数 {{ mb_strlen(strip_tags($article['content_html'])) }}</span>
        <span class="views-count">阅读 {{$article['page_views']}}</span>
        <span class="comments-count">评论 {{$article['comments_count']}}</span>
    </div>
    <div>
        <!-- 如果是当前作者，加入编辑按钮 -->
    </div>
    <div class="article-content markdown-body" id="article-content">
        {!! $article['content_html'] !!}
    </div>
    <div class="tags">
        标签：
        @foreach($article['tags'] as $tag)
            <a href="{{url('/tag/'.$tag['name'])}}">{{ $tag['name'] }}</a>
        @endforeach
    </div>
</section>

