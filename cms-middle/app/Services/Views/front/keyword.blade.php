@include('header')
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> 关键词
    </div>
    <div class="blank10 clear"></div>
    <div class="mapmain">
        <div class="tit"><h2>关键词</h2></div>
	    <div class="mapbox">
	        <div class='maplist'>
			@foreach($keyword as $t)
			<span><a href="{{ tag_url($t['name']) }}">{{ $t['name'] }}</a></span>
			@end
		    </div>
		</div>
	</div>
    <div class="clear blank10"></div>
@include('footer')