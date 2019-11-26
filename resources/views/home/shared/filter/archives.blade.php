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
        <div class="title">
            <h5>All</h5>
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
    @endif
</div>
{{ $articles->links() }}
