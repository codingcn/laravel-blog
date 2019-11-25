@if(count($archives))
    <ul class="archives">
        <div class="title">
            <h3>归档</h3>
            <a href="{{url('/article/archives')}}">更多>></a>
        </div>
        <li>
            @foreach($archives as $archive)
                <span><a href="{{ url('/article/archives') }}/?year={{ $archive['year'] }}&month={{ $archive['month'] }}"
                         target="_blank">{{ $archive['year'] }}
                        年{{$archive['month']}}月</a>（{{$archive['published']}}）
                </span>
            @endforeach
        </li>
    </ul>
@endif