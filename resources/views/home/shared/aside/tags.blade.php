@if(count($tags))
    <ul class="tags">
        <div class="title">
            <h3>标签云</h3>
        </div>
        <li>

            @foreach($tags as $tag)
                @if($tag['articles_count']>0)
                    <a href="{{url('/tag/'.$tag['name'])}}" target="_blank">{{ $tag['name'] }}</a>
                @endif
            @endforeach
        </li>
    </ul>
@endif