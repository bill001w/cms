@include('header')

    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> {{ catpos($catid, ' &gt;&gt;&nbsp;&nbsp;') }}
    </div>
    <div class="blank10 clear"></div>
    <div class="mainpdbox">
        <div class="left">
            <!--articlecontent begin-->
			<div class="articlecontent">
			    <h3>{{ $title }}</h3>
				<div class="info" style=" color: #999">
                    时间：{{ date("Y-m-d H:i:s", $updatetime) }}
                    <span>点击：<script type="text/javascript" src="{{ url('api/hits',array('id'=>$id, 'hits'=>$hits)) }}"></script>次</span>
                    <span><script type="text/javascript" language="javascript">function ContentSize(size){ document.getElementById('MyContent').style.fontSize=size+'px';}</script>【字体：<a href="javascript:ContentSize(16)">大</a> <a href="javascript:ContentSize(14)">中</a> <a href="javascript:ContentSize(12)">小</a>】</span>
					<span id="scj"><a href="javascript:addfavorite('{{ $id }}', 'scj');">收藏</a></span>
				</div>
				<hr size=1 color="#e8e8e8" width="620" style="padding-bottom:5px;" />
				<div class="newscontent">
				    <div id="MyContent"><div id='news1' style='display:;'>{{ $content }}</div></div>
					<div class="clear blank10"></div>
					<!--文章内容分页 begin-->
                    @if($contentpage)

                    <div class="cpage">
                    @foreach($contentpage as $i => $u)
                    <a@if($page!=$i)
 href="{{ $u }}"@endif
>{{ $i }}</a>
                    @endforeach
                    </div>
                    <div class="clear blank10"></div>
                    @endif

					<!--文章内容分页 end-->
					<!--标签关键字 begin-->
                    @if($kws=get_tag_data($keywords))

						<div class="articlekey"><strong>TAG：</strong>
						@foreach($kws as $t)
						<a href="{{ tag_url($t) }}">{{ $t }}</a>
						@endforeach
						</div>
                    @endif

					<!--标签关键字 end-->
                    <div class="clear"></div>
					<div class="articlebook">
                    @if($prev_page)
<h2><strong>上一篇：</strong><a href="{{ $prev_page['url'] }}">{{ $prev_page['title'] }}</a> </h2>@endif

                    @if($next_page)
<h2><strong>下一篇：</strong><a href="{{ $next_page['url'] }}">{{ $next_page['title'] }}</a> </h2>@endif

					</div>
                    @if(plugin('digg'))
<div class="clear blank10"></div><script type="text/javascript" src="{{ url('digg/index/show', array('id'=>$id)) }}"></script>@endif

	                @if(plugin('mood'))
<div class="clear blank10"></div><script type="text/javascript" src="{{ url('mood/index/show', array('id'=>$id)) }}"></script>@endif

	                @if(plugin('comment'))
<div class="clear blank10"></div><div style="clear:both;width:600px;padding-left:20px;"><a name="comment"></a><script type="text/javascript" src="{{ url('comment/index/list', array('id'=>$id)) }}"></script></div>@endif

					<div class="clear blank10"></div>
					<div class="xgxw">
						<div class="title">相关文章</div>
                        <div class="xgnewsbox">
                            <ul>
                            {list modelid=$modelid action=relation tag=$keywords id=$id num=5 cache=36000}
                            <li><a href="{{ $t['url'] }}">{{ $t['title'] }}</a><span>{{ date("Y-m-d", $t['updatetime']) }}</span></li>
                            {/list}
                            </ul>
                        </div>
                    </div>
                    <div class="clear blank10"></div>
                    @if($commentCfg)

                    <!-- 多说评论框 start -->
                    <div class="ds-thread" data-thread-key="{{ $id }}" data-title="{{ $title }}" data-url="{{ $pageurl }}"></div>
                    <!-- 多说评论框 end -->
                    <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
                    <script type="text/javascript">
                        var duoshuoQuery = {short_name:"dayruicms"};
                        (function() {
                            var ds = document.createElement('script');
                            ds.type = 'text/javascript';ds.async = true;
                            ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
                            ds.charset = 'UTF-8';
                            (document.getElementsByTagName('head')[0]
                            || document.getElementsByTagName('body')[0]).appendChild(ds);
                        })();
                    </script>
                    <!-- 多说公共JS代码 end -->
                    @endif

                    <div class="clear blank10"></div>
					<div class="sharebox">
                        <!-- Baidu Button BEGIN -->
                        <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
                            <a class="bds_qzone">QQ空间</a>
                            <a class="bds_tqq">腾讯微博</a>
                            <a class="bds_tqf">腾讯朋友</a>
                            <a class="bds_tsina">新浪微博</a>
                            <a class="bds_tsohu">搜狐微博</a>
                            <a class="bds_baidu">百度搜藏</a>
                            <a class="bds_hi">百度空间</a>
                            <a class="bds_kaixin001">开心网</a>
                            <span class="bds_more">更多</span>
                            <a class="shareCount"></a>
                        </div>
                        <script type="text/javascript" id="bdshare_js" data="type=tools" ></script>
                        <script type="text/javascript" id="bdshell_js"></script>
                        <script type="text/javascript">
                            document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
                        </script>
                        <!-- Baidu Button END -->
                    </div>
					<div class="clear blank10"></div>
                 </div>
			</div>
			<!--articlecontent end-->
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
            <div class="blank10 clear"></div>
            <!--right02 begin-->
            <div class="right02">
                <div class="title"><span>热评TOP10</span></div>

                <!-- 多说热评文章 start -->
                <div class="ds-top-threads text_box"  style="" data-range="daily" data-num-items="10"></div>
                <!-- 多说热评文章 end -->
                <!-- 多说公共JS代码 start (一个网页只需插入一次) -->
                <script type="text/javascript">
                    var duoshuoQuery = {short_name:"dayruicms"};
                    (function() {
                        var ds = document.createElement('script');
                        ds.type = 'text/javascript';ds.async = true;
                        ds.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') + '//static.duoshuo.com/embed.js';
                        ds.charset = 'UTF-8';
                        (document.getElementsByTagName('head')[0]
                        || document.getElementsByTagName('body')[0]).appendChild(ds);
                    })();
                </script>
                <!-- 多说公共JS代码 end -->

            </div>
            <!--right02 end-->
       </div>
    </div>
    <div class="clear blank10"></div>
@include('footer')