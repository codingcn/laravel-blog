<div class="filter-archives">
    <div class="title">
        <h5>{{$date_title}}</h5>
    </div>
    <ul>
        @foreach($articles as $article)
            <li class="content">
                <span class="date">{{  $article->created_at->toDateString() }}</span>
                —
                <a href="{{ url('article/'.$article->id) }}">{{$article->title}}</a>
            </li>
        @endforeach
    </ul>

</div>
{{ $articles->links() }}