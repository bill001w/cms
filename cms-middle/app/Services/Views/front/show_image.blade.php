@include('header')
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> {{ catpos($catid, ' &gt;&gt;&nbsp;&nbsp;') }}
    </div>
    <div class="blank10 clear"></div>
    <!--图片主体begin-->
    <div class="picnr">
        <div class="title">{{ $title }}<span>点击数：<script type="text/javascript" src="{{ url('api/hits',array('id'=>$id,'hits'=>$hits)) }}"></script>次 更新：{{ date("Y-m-d H:i:s", $updatetime)}} </span></div>
        <div class="clear"></div>
        <hr size="1" color="#505050" width="940" />
        <div class="picnrbox">
            <div class="showpic">
               <script type="text/javascript">
                   var imgArr='@foreach($images["file"] as $t){{ image($t) }}|@endforeach'.split('|');
                   var introArr='@foreach($images["alt"] as $t){{ $t }}|@endforeach'.split('|');
                   var siteurl='/views/admin/';
                   var totalput={{ count($images["file"]) }};
                   var currPage=1; 
                   var iss=1;//当前张数
               </script>
               <script type="text/javascript" src="/views/admin/js/photo.js"></script>
               <div class="imagelist">
                   <div class="imagetop">
                       共 <span style="color:red">{{ count($images["file"]) }}</span> 张,当前第 <span style="color:#ff6600" id="currpa">1</span> 张 <a href="javascript:prev()">上一张</a> | <a href="javascript:next()">下一张</a><span id="displayNum"></span>
                   </div>
                   <div class="defaultimagesrc"><Img style="position:relative;" alt="{{ $images['alt'][0] }}" onload="javascript:resizepic(this)" id="ShowLargeImg" onmouseover="upNext1(this)" src="{{ image($images['file'][0]) }}" border="0"></div>
                   <div class="imageintro">{{ $images['alt'][0] }}</div>
                   <div class="thumb">
                        <div class="thumb_1"><span class="font-28" id="currp">1</span> / <span id="zys">{{ count($images["file"]) }}</span></div>
                        <div class="thumb_2">
                            <div class="thumb_2_1" id="right"></div>
                            <div class="thumb_2_2" id="left"></div>
                            <!--缩略图开始-->
                            <div id="scrool_div">
                            <ul id="scrool_wrap">
                            @foreach($images['file'] as $k => $t)
                            <li><a id="t{{ $k+1 }}" class="currthumb" href="javascript:void(0)" onclick="showImg({{ $k+1 }});"><img src="{{ thumb($t) }}" border="0"/></a></li>
                            @endforeach
                            </ul>
                            </div>
                            <!--缩略图结束-->
                        </div>
                   </div>
               </div>
            </div>
            <div class="clear blank10"></div>
            <div class="nph_intro">{{ $content }}</div>
            <div class="clear blank10"></div>
            <div class="nph_tj">
             <ul>
                 @if($prev_page)
<li>上一图集：<a href="{{ $prev_page['url'] }}">{{ $prev_page['title'] }}</a></li>@endif

                 @if($next_page)
<li>下一图集：<a href="{{ $next_page['url'] }}">{{ $next_page['title'] }}</a></li>@endif

             </ul>
            </div>
        </div>
    </div>
    <div class="clear blank10"></div>
    <!--相关图片-->
    <div class="xgphoto">
      <div class="title">相关图集</div>
      <div class="xgphotobox">
          <ul>
            {list catid=$catid action=relation tag=$keywords id=$id num=5 cache=36000}
            <li><a href="{{ $t['url'] }}"><img src="{{ thumb($t['thumb']) }}" /></a></li>
            {/list}
          </ul>
      </div>
    </div>
    <!--相关图片-->
    <!--图片主体end-->
    <div class="clear blank10"></div>
@include('footer')