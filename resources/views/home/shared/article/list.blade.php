<section class="article-list">
    @if($articles->isEmpty())
        <div>无数据</div>
    @else
        @foreach($articles as $article)
            @if($article->cover )
                <li class="article-item">
                    <div class="title">
                        <strong><a href="{{url('/articles',$article->id )}}">{{ $article->title }}</a></strong>
                        <span class="date float-right">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                            {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                    </span>
                    </div>
                    <div class="row summary">
                    <span class="col-9 col-sm-9">
                        {{ str_limit($article->summary,250,'...') }}
                    </span>
                        <span class="col-3 col-sm-3 cover">
                        <a href="{{url('/articles',$article->id )}}"><img src="{{ \Storage::url($article->cover) }}"
                                                                          alt="{{ $article->title }}"></a>
                    </span>
                    </div>
                    <div class="meta">
                        <span class="category">
                            <a href="{{url('/categories',$article->articleCategory->id)}}">{{$article->articleCategory->name}}</a>
                        </span>
                        @if(count($article->tags))
                            <span class="tags">
                                <i class="fas fa-tags" aria-hidden="true"></i>
                                @foreach($article->tags as $tag)
                                    <a href="{{url('/tag/'.$tag->name)}}">{{ $tag->name }}</a>
                                @endforeach
                        </span>
                        @endif
                        <span class="float-right">
                        {{ $article->content_length }}
                            字/{{$article->page_views}}次阅读
                            @if ($article->comment_count)
                                /<b>{{ $article->comment_count }}条</b>评论
                            @endif
                    </span>
                    </div>
                </li>
            @else
                <li class="article-item">
                    <div class="title">
                        <b><a href="articles/{{ $article->id }}">{{ $article->title }}</a></b>
                        <span class="date float-right">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                            {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}
                    </span>
                    </div>
                    <div class="summary">
                        {{ $article->summary }}
                    </div>
                    <div class="meta">
                        <span class="category">
                            <a href="{{url('/categories',$article->articleCategory->id)}}">{{$article->articleCategory->name}}</a>
                        </span>
                        @if(count($article->tags))
                            <span class="tags">
                                <i class="fas fa-tags" aria-hidden="true"></i>
                                @foreach($article->tags as $tag)
                                    <a href="{{url('/tag/'.$tag->name)}}">{{ $tag->name }}</a>
                                @endforeach
                        </span>
                        @endif
                        <span class="float-right">{{ $article->content_length }}
                            字/{{$article->page_views}}次阅读
                            @if ($article->comment_count)
                                /<b>{{ $article->comment_count }}条</b>评论
                            @endif
                    </span>
                    </div>

                </li>
            @endif
        @endforeach
        {{ $articles->links() }}
    @endif

</section>