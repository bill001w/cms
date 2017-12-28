@include('header')
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> {{ catpos($catid, ' &gt;&gt;&nbsp;&nbsp;') }}
    </div>
    <div class="blank10 clear"></div>
    <!--图片主体begin-->
    <div class="piclist">
        <div class="title"><span>{{ $catname }}</span></div>
        <div class="piclistbox">
            <ul>
            {list catid=$catid page=$page order=updatetime}
            <li>
            <div><a href="{{ $t['url'] }}"><img src="{{ thumb($t['thumb']) }}" /></a></div>
            <div class="picname"><a href="{{ $t['url'] }}">{{ $t['title'] }}</a></div>
            </li>
            {/list}
            </ul>
            <div class="listpage">{{ $pagelist }}</div>
       </div>
    </div>
    <!--图片主体end-->
    <div class="clear blank10"></div>
@include('footer')