@if(count($recommends))
    <ul class="recommend">
        <div>
            <h3>推荐阅读</h3>
        </div>
        @foreach($recommends as $recommend)
            <li>
                <a class="title" href="{{url('/article/'.$recommend->id)}}" target="_blank">{{$recommend->title}}</a>

                <div class="notice-new">
                    <span class="date">{{$recommend->published_at}}</span>
                    <span class="statistics">
                        {{$recommend->content_length}}字/{{$recommend->page_views}}次阅读/{{$recommend->comments_count}}条评论
                    </span>
                </div>
            </li>
        @endforeach
    </ul>
@endif