@include('header')
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> TAG：{{ $kw }}
    </div>
    <div class="blank10 clear"></div>
    <div class="mainpdbox">
        <div class="left">
            <!--list begin-->
		    <div class="newslist">
                <h3>{{ $kw }}</h3>
			    <ul class="noborder">
                @foreach($taglist as $key => $t)
                <li><span class="date">{{ date("Y-m-d", $t['updatetime']) }}</span> <a href="{{ $t['url'] }}">{{ $t['title'] }}</a></li>
                @if(($key+1)%5==0)
<li class="page-list" style="background:none"></li>@endif
<!--每5行加一段分行代码-->
                @endforeach
                </ul>
                <div class="listpage" style="padding-left:10px;">{{ $tagpage }}</div>
		   </div>
	       <!--list end-->
        </div>
        <div class="right">
            <!--right02 begin-->
	        <div class="right02">
		        <div class="title"><span>最新TOP10</span></div>
		        <div class="right02box">
		        <ul>
                {list num=10 order=updatetime cache=36000}
			    <li><span class="N{{ $key+1 }}"></span><a href="{{ $t['url'] }}">{{ $t['title'] }}</a></li>
                {/list}
			    </ul>
		        </div>
		    </div> 
	        <!--right02 end-->
		    <div class="blank10 clear"></div>
	        <!--right02 begin-->
	        <div class="right02">
		       <div class="title"><span>热点TOP10</span></div>
		       <div class="right02box">
		        <ul>
                {list num=10 order=hits cache=36000}
			    <li><span class="N{{ $key+1 }}"></span><a href="{{ $t['url'] }}">{{ $t['title'] }}</a></li>
                {/list}
			    </ul>
		       </div>
		    </div> 
	        <!--right02 end-->
       </div>
    </div>
    <div class="clear blank10"></div>
@include('footer')