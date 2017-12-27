@include('header')
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> {{ $form_name }}
    </div>
    <div class="blank10 clear"></div>
    <div class="mainpdbox">
        <div class="left">
            <!--list begin-->
		    <div class="newslist">
                <h3>{{ $form_name }}</h3>
			    <ul class="noborder">
                {list table=$table page=$page cid=$cid pagesize=$pagesize urlrule=$urlrule order=updatetime}
                <li><span class="date">{{ date("Y-m-d", $t['updatetime']) }}</span>
				<a href="{{ form_show_url($modelid, $t) }}">信息（根据自己设计的字段来决定）{{ $t['id'] }}</a></li>
				<!--这里可以在a标签中写上自定义的url，需伪静态指向-->
                @if(($key+1)%5==0)
<li class="page-list" style="background:none"></li>@endif
<!--每5行加一段分行代码-->
                {/list}
                </ul>
                <div class="listpage" style="padding-left:10px;">{{ $pagelist }}</div>
		   </div>
	       <!--list end-->
        </div>
        <div class="right">
            <!--right02 begin-->
	        <div class="right02">
		        <div class="title"><span>最新TOP10</span></div>
		        <div class="right02box">
		        <ul>
                {list table=$table cid=$cid num=10 order=updatetime cache=36000}<!--排序方式可以更改，参数order=字段-->
			    <li><span class="N{{ $key+1 }}"></span><a href="{{ url('form/show', array('modelid'=>$modelid, 'id'=>$t['id'])) }}">信息（根据自己设计的字段来决定）{{ $t['id'] }}</a></li>
                <!--这里可以在a标签中写上自定义的url，需伪静态指向-->
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
                {list table=$table cid=$cid num=10 order=listorder cache=36000}<!--排序方式可以更改，参数order=字段-->
			    <li><span class="N{{ $key+1 }}"></span><a href="{{ url('form/show', array('modelid'=>$modelid, 'id'=>$t['id'])) }}">信息（根据自己设计的字段来决定）{{ $t['id'] }}</a></li>
				<!--这里可以在a标签中写上自定义的url，需伪静态指向-->
                {/list}
			    </ul>
		       </div>
		    </div> 
	        <!--right02 end-->
       </div>
    </div>
    <div class="clear blank10"></div>
@include('footer')