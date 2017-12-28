@include('header')
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> {{ catpos($catid, ' &gt;&gt;&nbsp;&nbsp;') }}<!--栏目面包屑导航，参考函数教程-->
    </div>
    <div class="blank10 clear"></div>
    <div class="mainpdbox mainbox">
        <div class="left">
            <!--栏目循环 begin-->
            <?php $i=0; ?><!--循环控制变量-->
            @foreach($cats as $c)<!--循环子栏目且为内部栏目-->

            @if($c['parentid']==$catid && $c['typeid']==1)
<!--判断当前栏目的子栏目并且循环该栏目的子栏目-->
                @if($i%2==0)
<!--分两栏显示-->
                <div class="left03">
                @endif


                    <div @if($i%2==0)
class="floatl"@else
class="floatr"@endif
>
                        <div class="title"><span><a href="{{ $c['url'] }}">更多>></a></span><strong>{{ $c['catname'] }}</strong></div>
                        <div class="floatlbox">
                            <div class="synews9">
                            <ul>
                                {list catid=$c[catid] page=$page num=9 cache=36000}
                                <li><span id="date">({{ date("m-d", $t['updatetime']) }})</span><a href="{{ $t['url'] }}">{{ $t['title'] }}</a></li>
                                {/list}
                            </ul>
                            </div>
                        </div>
                    </div>

                @if($i%2==1)
<!--最后一栏换行-->
                </div>
                <div class="clear blank10"></div>
                @endif

            <?php $i++; ?>
            @endif


            @endforeach
            @if($i%2==1)
<!--如果栏目数不是偶数，就结束div盒-->
            </div>
            <div class="clear blank10"></div>
            @endif

            <!--栏目循环 end-->
        </div>
        <div class="right">
            <!--right02 begin-->
	        <div class="right02">
		        <div class="title"><span>最新TOP10</span></div>
		        <div class="right02box">
		        <ul>
                {list catid=$catid num=10 order=updatetime cache=36000}
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
                {list catid=$catid num=10 order=hits cache=36000}
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