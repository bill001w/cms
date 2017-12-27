@include('header')
<div class="mainbox">
    <div class="left">
        <!--left01 begin-->
        <div class="left01">
            <div class="floatl">
                <script type='text/javascript' src='{{ SITE_THEME }}js/KinSlideshow.js'></script>
                <script type="text/javascript">
                    $(function () {
                        $("#KinSlideshow").KinSlideshow({
                            moveStyle: "down", //切换参数left,right,down,up
                            intervalTime: 3, //切换时间
                            mouseEvent: "mouseover",
                            titleBar: {titleBar_height: 30, titleBar_bgColor: "#656565", titleBar_alpha: 0.5}, //标题背景
                            titleFont: {TitleFont_size: 12, TitleFont_color: "#FFFFFF", TitleFont_weight: "normal"}, //标题字体
                            btn: {
                                btn_bgColor: "#FFFFFF",
                                btn_bgHoverColor: "#FF7A00",
                                btn_fontColor: "#000000",
                                btn_fontHoverColor: "#FFFFFF",
                                btn_borderColor: "#cccccc",
                                btn_borderHoverColor: "#666666",
                                btn_borderWidth: 1
                            } //按钮设置
                        });
                    })
                </script>
                <div id="KinSlideshow" style="visibility:hidden;overflow:hidden;width:290px;height:270px;">
                    {list action=position id=3}
                    <a href="{{ $t['url'] }}" title="{{ $t['title'] }}"><img src="{{ thumb($t['thumb']) }}"
                                                                             alt="{{ $t['title'] }}" width="290"
                                                                             height="270"/></a>
                    {/list}
                </div>
            </div>
            <div class="floatr">
                <div class="news">
                    <!--首页头条-->
                    {list action=position id=1}
                    <h1><a href="{{ $t['url'] }}">{{ $t['title'] }}</a></h1>
                    <div class="newsintro">{{ $t['description'] }}<span><a href="{{ $t['url'] }}">[查看详细]</a></span>
                    </div>
                    {/list}
                </div>
                <div class="clear"></div>
                <div class="newstop7">
                    <ul>
                        <!--最新文章-->
                        {list order=updatetime num=7 cache=36000}
                        <li><span><font @if(date('Y-m-d', $t['updatetime']) == date('Y-m-d'))
                                        style="color:red"@endif
                                >{{ date('m-d', $t['updatetime']) }}</font></span><a
                                    href="{{ $t['url'] }}">{{ $t['title'] }}</a></li>
                        {/list}
                    </ul>
                </div>
            </div>
        </div>
        <!--left01 end-->
        <div class="clear blank10"></div>
        <!--left02 begin-->
        <div class="left02">
            <!--图片风采开始-->
            <div id="schoolPhoto" class="mod-banner">
                <div id="focus_img">
                    <ul class="thumbListStlye4">
                        <!--循环图片模型(modelid=2)中的数据-->
                        {list modelid=2 thumb=1 order=updatetime num=8 cache=36000}
                        <li>
                            <div class="pe_u_thumb">
                                <a href="{{ $t['url'] }}"><img src="{{ thumb($t['thumb']) }}"></a>
                                <div class="pe_u_thumb_title"><a href="{{ $t['url'] }}">{{ $t['title'] }}</a></div>
                            </div>
                        </li>
                        {/list}
                    </ul>
                </div>
                <span id="btn_focus_next" class="btn"></span>
                <span id="btn_focus_prev" class="btn"></span>
            </div>
            <script type='text/javascript' src='{{ SITE_THEME }}js/pic_roll.js'></script>
            <script type="text/javascript">
                $(function () {
                    var clearTimer = null;
                    var SleepTime = 2000;   //停留时长，单位毫秒
                    $("#focus_img").jCarouselLite({
                        btnNext: "#btn_focus_next",
                        btnPrev: "#btn_focus_prev",
                        visible: 4,
                        scroll: 4,
                        speed: 1000,//滚动速度，单位毫秒
                        auto: 5000,
                        mouseOver: true
                    });
                });
            </script>
            <!--图片风采结束-->
        </div>
        <!--left02 end-->
        <div class="clear blank10"></div>
        <!--栏目循环 begin-->
        <!--栏目循环默认循环所有顶级内部栏目，你也可以通过loop来指定栏目循环-->
    <?php $i = 0; ?><!--循环控制变量，可以对栏目循环的个数控制-->
    @foreach($cats as $c)<!--循环顶级栏目且为内部栏目-->
    @if($c['parentid']==0 && $c['typeid']==1)
        @if($i%2==0)
            <!--分两栏显示-->
                <div class="left03">
                    @endif
                    <div @if($i%2==0) class="floatl" @else class="floatr" @endif>
                        <div class="title"><span><a
                                        href="{{ $c['url'] }}">更多>></a></span><strong>{{ $c['catname'] }}</strong></div>
                        <div class="floatlbox">
                            <div class="c_pt_1">
                                <!-- 栏目头条 -->
                                {list action=position id=4 catid=$c[catid]}
                                <div class="Pic"><a href="{{ $t['url'] }}"><img src="{{ thumb($t['thumb']) }}"></a>
                                </div>
                                <div class="Txt">
                                    <h3><a href="{{ $t['url'] }}">{{ $t['title'] }}</a></h3>
                                    <p>{{ strcut($t['description'],100) }}</p>
                                </div>
                                {/list}
                            </div>
                            <div class="dotline clear"></div>
                            <div class="synews9">
                                <ul>
                                    {list catid=$c[catid] order=updatetime num=5 cache=36000}
                                    <li><span id="date">({{ date("m-d", $t['updatetime']) }})</span><a
                                                href="{{ $t['url'] }}">{{ $t['title'] }}</a></li>
                                    {/list}
                                </ul>
                            </div>
                        </div>
                    </div>
                @if($i%2==1)
                    <!--最后一栏换行，结束div-->
                </div>
                <div class="clear blank10"></div>
        @endif

        <?php $i++; ?><!--循环控制变量自增-->
    @endif

    @end
    @if($i%2==1)
        <!--如果栏目数不是偶数，就结束div盒-->
    </div>
    <div class="clear blank10"></div>
@endif

<!--栏目循环 end-->
</div>
<div class="right">
    <!--首页推荐 begin-->
    <div class="right02">
        <div class="scrollFrame">
            <div class="scrollUl">
                <div class="textdiv"><strong>推荐</strong></div>
            </div>
            <div class="bor01 cont">
                <div class="display">
                    <ul class="syfresh">
                        {list action=position id=2}
                        <li><span class="N{{ $key+1 }}"><!--这里的$key是list循环控制变量，list教程有详细介绍--></span><a
                                    href="{{ $t['url'] }}">{{ $t['title'] }}</a></li>
                        {/list}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--首页推荐 end-->
    <div class="clear blank10"></div>
    <!--最近更新 begin-->
    <div class="right03">
        <div class="title"><span>最近更新</span></div>
        <div class="right03box">
            <ul>
                {list order=updatetime num=15 cache=36000}
                <li><span id="date">({{ date("m-d", $t['updatetime']) }})</span><a
                            href="{{ $t['url'] }}">{{ $t['title'] }}</a></li>
                {/list}
            </ul>
        </div>
    </div>
    <!--最近更新 end-->
    <div class="clear blank10"></div>
    <!--阅读排行 begin-->
    <div class="right03">
        <div class="title"><span>阅读排行</span></div>
        <div class="right03box">
            <ul>
                {list order=hits num=15 cache=36000}
                <li><span id="date">({{ date("m-d", $t['updatetime']) }})</span><a
                            href="{{ $t['url'] }}">{{ $t['title'] }}</a></li>
                {/list}
            </ul>
        </div>
    </div>
    <!--阅读排行 end-->
    <div class="clear blank10"></div>
</div>
</div>
@if(plugin('link'))
    <!--判断友情链接插件是否存在，若存在就执行下面的-->
    <div class="clear blank10"></div>
    <!--友情链接-->
    <div class="friendlink">
        <div class="title"><span id="tit">友情链接</span></div>
        <div class="linkbox">
            {list table=link.link order=listorder_asc cache=36000}<!--循环输出友情链接数据，list教程有详细介绍-->
            <a href="{{ $t['url'] }}" target="_blank" title="{{ $t['introduce'] }}">{{ $t['name'] }}</a>&nbsp;&nbsp;&nbsp;
            {/list}
        </div>
    </div>
    <!--友情链接end-->
@endif

<div class="clear blank10"></div>
@include('footer')