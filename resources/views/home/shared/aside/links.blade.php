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
            <a href="http://sec2hack.com/" target="_blank">wfox</a>
            <a href="https://xianzhi.aliyun.com/forum" target="_blank">先知社区</a>
            <a href="https://paper.seebug.org/" target="_blank">paper</a>
            <a href="http://www.freebuf.com/" target="_blank">freebuf</a>
            <a href="https://www.leavesongs.com/" target="_blank">离别歌</a>
        </li>
    </ul>
@endif