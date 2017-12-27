@include('header')
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> {{ catpos($catid, ' &gt;&gt;&nbsp;&nbsp;') }}
    </div>
    <div class="blank10 clear"></div>
    <!--主体begin-->
    <div class="downlist">
        <div class="floatl">
            <div class="left01">
                <div class="title">{{ $title }}</div>
                <div class="downbox1">
                    <div class="floatl"> <img src="{{ thumb($thumb) }}" height="130" width="160" /></div>
                    <div class="floatr">
                        <ul>
                        <li><span>软件名称：</span> {{ $title }}</li>
                        <li><span>软件大小：</span> {{ $softsize }}</li>
                        <li><span>软件作者：</span> {{ $developers }}</li>
                        <li><span>软件版本：</span> {{ $version }}</li>
                        <li><span>软件语言：</span> {{ $language }}</li>
                        <li><span>操作系统：</span> <?php echo implode(',',$os) ?></li>
                        <li><span>更新时间：</span> {{ date("Y-m-d H:i:s", $updatetime) }}</li>
                        <li><span>下载次数：</span> <script type="text/javascript" src="{{ url('api/hits',array('id'=>$id,'hits'=>$hits)) }}"></script></li>
                        </ul>
                    </div>
                </div>	
                <div class="clear blank10"></div>  
            </div>
            <div class="clear blank10"></div>
            <div class="left02">
               <div class="title">下载地址</div>
               <div class="downbox2">
                @if($memberinfo)
<!--已经登录-->
                    <!--这里还有对会员组，积分，会员模型判断是否能下载-->
                    @foreach($downdata['file'] as $k => $file)
                    {{ $title }}<img border="0" align="absmiddle" src="/views/admin/images/down.gif"><a href="{{ downfile($file) }}">{{ $downdata['alt'][$k] }}</a><br>   
                    @endforeach
                @else
<!--没有登录时，不允许下载-->
                     <a href="{{ url('member/login',array('back'=>urlencode($url))) }}">对不起，请登录以后再下载。</a>
                @endif

               </div>
            </div>
            <div class="clear blank10"></div>
            <div class="left02">
               <div class="title">介绍信息</div>
               <div class="downbox2">
                  {{ $content }}
               </div>
            </div>
        </div>
        <div class="right">
            <!--right01 begin-->
            <div class="right01">
                <div class="title"><span>最新TOP10</span></div>
                <div class="right01box">
                <ul>
                {list catid=$catid num=10 order=updatetime cache=36000}
                <li><span class="N{{ $key+1 }}"></span><a href="{{ $t['url'] }}">{{ $t['title'] }}</a></li>
                {/list}
                </ul>
                </div>
            </div> 
            <!--right01 end-->
            <div class="blank10 clear"></div>
            <!--right01 begin-->
            <div class="right01">
               <div class="title"><span>热点TOP10</span></div>
               <div class="right01box">
                <ul>
                {list catid=$catid num=10 order=hits cache=36000}
                <li><span class="N{{ $key+1 }}"></span><a href="{{ $t['url'] }}">{{ $t['title'] }}</a></li>
                {/list}
                </ul>
               </div>
            </div> 
            <!--right01 end-->
        </div>
    </div>
    <!--主体end-->
    <div class="clear blank10"></div>
@include('footer')