<section class="comment">
    <h2>评论（{{$article['comments_count']}}）</h2>
    @if(\Auth::guard('home_session')->check())
        <div class="comment-form">
            <form action="{{ url('comment/store/'.$article['id']) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="article_id" value="{{ $article['id'] }}">
                <div class="form-group row">
                    <div class="col-sm-12">
                        <textarea name="content" class="form-control" placeholder="说点什么"></textarea>
                    </div>
                </div>
                <button class="btn btn-info float-right">发表</button>
            </form>
        </div>
        @if(0<count($errors))
            <div class="alert alert-danger" role="alert">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>
        @endif
    @else
        请先<a href="{{url('/sign-in')}}">登陆</a>，参与评论。
    @endif
    @if(count($article['comments']))
        <div class="comment-list">
            @foreach($article['comments'] as $comment)
                <div class="comment-item ">
                    <div class="flex-block">
                        <div class="comment-avatar-container ">
                            <div class="comment-avatar">
                                <?php
                                if (!empty($comment['user']['avatar'])) {
                                    $avatar = $comment['user']['avatar'];
                                } else {
                                    $avatar = url('/static/home/img/avatar/' . substr($comment['user']['id'], -1) . '.jpg');
                                }
                                ?>
                                <img src="{{$avatar}}" alt="{{$comment['user']['username']}}">
                            </div>
                        </div>
                        <div class="comment-info flex-1">
                            <!-- 空的话自然是显示赞 -->
                            <div class="comment-like">
                                <like comment_id="{{$comment['id']}}"
                                      like_count="{{$comment['likes_count']}}"
                                      is_liked="{{$comment['is_liked']}}"
                                >
                                </like>
                            </div>

                            <div class="comment-title author">{{$comment['user']['username']}}</div>
                            <div class="comment-time">{{Carbon\Carbon::parse($comment['created_at'])->diffForHumans()}}</div>
                            <div class="comment-desc con">{{$comment['content']}}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>