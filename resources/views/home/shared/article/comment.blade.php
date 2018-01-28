<section class="comment">
    <h2>评论（{{$article->comments_count}}）</h2>
    @if(\Auth::check())
        <div class="comment-form">
            <form action="{{ url('comment/store/'.$article->id) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="article_id" value="{{ $article->id }}">
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
    @if(count($article->comments))
        <div class="comment-list">
            @foreach($article->comments as $comment)
                <div class="comment-item ">
                    <div class="flex-block">
                        <div class="comment-avatar-container ">
                            <div class="comment-avatar">
                                <img src="https://avatars2.githubusercontent.com/u/16743078?v=4&s=460" alt="">
                            </div>
                        </div>
                        <div class="comment-info flex-1">
                            <!-- 空的话自然是显示赞 -->
                            <div class="comment-like">
                                <like comment_id="{{$comment->id}}" user_id="{{Auth::id()}}"
                                      like_count="{{$comment->likes_count}}"></like>
                            </div>

                            <div class="comment-title author">{{$comment->user->username}}</div>
                            <div class="comment-time">{{$comment->created_at->diffForHumans()}}</div>
                            <div class="comment-desc con">{{$comment->content}}</div>

                            <input name="cid" value="ED327E6D-98AF-0333-D283-9B3068861C9F" type="hidden">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>
{{--<script>--}}
{{--//点赞--}}
{{--$.ajax({--}}
{{--type: "POST",--}}
{{--url: "{{ url('/comment/like/') }}",--}}
{{--cache: false,--}}
{{--success: function (data) {--}}
{{--$("#like").html(data);--}}
{{--if (D === 'like') {--}}
{{--$(this).addClass("heartAnimation").attr("rel", "unlike"); //applying animation class--}}
{{--}--}}
{{--else {--}}
{{--$(this).removeClass("heartAnimation").attr("rel", "like");--}}
{{--$(this).css("background-position", "left");--}}
{{--}--}}
{{--}--}}
{{--});--}}
{{--</script>--}}