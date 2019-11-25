@if(count($links))
    <ul class="links">
        <div class="title">
            <h3>邻居</h3>
            {{--<a href="">更多>></a>--}}
        </div>
        <li class="content">
            @foreach($links as $link)
                <a href="{{$link->uri}}" target="_blank">{{$link->name}}</a>
            @endforeach
        </li>
    </ul>
@endif