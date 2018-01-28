<div class="filter-tags">
    <div class="title">
        <h5>{{ $tag_name }}</h5>
    </div>
    @if(count($articles))
        @foreach($articles as $article)
            <li class="content">
                <span class="date">{{$article->created_at->toDateString() }}</span>
                —
                <a href="{{url('/article/'.$article->id)}}">{{$article->title}}</a>
            </li>
        @endforeach
    @else
        无数据
    @endif
</div>
{{ $articles->links() }}