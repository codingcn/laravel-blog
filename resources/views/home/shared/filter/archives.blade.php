<div class="filter-archives">
    @if(request('year')&&request('month'))
        <div class="title">
            <h5>{{request('year') . '-' . request('month')}}</h5>
        </div>
        <ul>
            @foreach($articles as $article)
                <li class="content">
                    <span class="date">{{  $article->created_at->toDateString() }}</span>
                    —
                    <a href="{{ url('articles/'.$article->id) }}">{{$article->title}}</a>
                </li>
            @endforeach
        </ul>
    @else

        @foreach($articles as $date=>$article)
            <div class="title">
                <h5>{{$date}}</h5>
            </div>
            <ul>
                @foreach($article as $item)
                    <li class="content">
                        <span class="date">{{  $article->created_at->toDateString() }}</span>
                        —
                        <a href="{{ url('articles/'.$item->id) }}">{{$item->title}}</a>
                    </li>
                @endforeach
            </ul>
        @endforeach
    @endif
</div>
{{ $articles->links() }}