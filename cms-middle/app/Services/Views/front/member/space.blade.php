@include('header')
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> 会员资料
    </div>
    <div class="blank10 clear"></div>
    <div class="mainpdbox">
        <div class="left">
            <!-- begin-->
			<div class="articlecontent">
			    <h3>{{ $nickname }}的个人资料</h3>
				<hr size=1 color="#e8e8e8" width="620" style="padding-bottom:5px;" />
				<div class="newscontent">
				    <div id="MyContent">
					<img src="{{ $avatar }}" width="80" height="80" />
					<li>会员名称：{{ $username }}</li>
					<li>会员模型：{{ $modelname }}</li>
					<li>会员组：{{ $groupname }}</li>
					<li>联系邮箱：{{ $email }}</li>
					<li>支持更多自定义字段内容</li>
					</div>
					<div class="clear blank10"></div>
                 </div>
			</div>
			<!-- end-->
        </div>
        <div class="right">
            <!--right02 begin-->
	        <div class="right02">
		        <div class="title"><span>我的文章</span></div>
		        <div class="right02box">
		        <ul>
                {list order=updatetime_desc userid=$userid username=$username sysadd=0 num=10 cache=36000}<!--排序方式可以更改，参数order=字段-->
			    <li><span class="N{{ $key+1 }}"></span><a href="{{ $t['url'] }}" title="{{ $t['title'] }}">{{ $t['title'] }}</a></li>
				{/list}
			    </ul>
		        </div>
		    </div> 
	        <!--right02 end-->
       </div>
    </div>
    <div class="clear blank10"></div>
@include('footer')