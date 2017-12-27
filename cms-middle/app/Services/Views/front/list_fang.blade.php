@include('header')
	<?php
	//自定义URL函数,网站上线后请将函数放在自定义函数库文件中,就可以随便更改url规则
	function list_url($param, $name=NULL, $value=NULL) {
		unset($param['page']);
		if (!is_null($name) && !is_null($value)) {
			$param[$name] = $value;
		} elseif (!is_null($name) && is_null($value)) {
			unset($param[$name]);
		}
		/*这是伪静态url地址
		$url  = SITE_PATH;
		$url .= 'area-' . $param['area'];
		$url .= '-room-' . $param['room'];
		$url .= '-price-' . $param['price'];
		if ($name=='page')$url .= '-page-' . $value;
		*/
		$url  = url('content/list', $param);//动态地址
		return $url;
	}
	?>
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> {{ catpos($catid, ' &gt;&gt;&nbsp;&nbsp;') }}<!--栏目面包屑导航，参考函数教程-->
    </div>
    <div class="blank10 clear"></div>
    <!--主体begin-->
    <div class="downlist">
       <div class="left">
            <div class="left01">
                <div class="title">{{ $catname }}</div>
                <div class="leftbox">
                    <div class="select-list">
                        <ul>
                        <li><a href="{{ list_url($param, 'area', 0) }}" @if(empty($param['area']))
class="b"@endif
>地区</a></li>
                        <?php $list = linkagelist(1, $param['area']); ?><!--调用联动菜单id为1（地区）的列表数据-->
                        @foreach($list as $t)
                        <li><a href="{{ list_url($param, 'area', $t['id']) }}" @if($param['area']==$t['id'])
class="b"@endif
>{{ $t['name'] }}</a></li>
                        @end
                        </ul>
                        <ul>
                        <li><a href="{{ list_url($param, 'room', '') }}" @if(empty($param['room']))
class="b"@endif
>厅室</a></li>
                        <?php $bedroom_rang = array('一室'=>'1','两室'=>'2','三室'=>'3','四室以上'=>'4_100'); ?><!--手动控制厅室循环-->
                        @foreach($bedroom_rang as $k => $t)
                        <li><a href="{{ list_url($param, 'room', $t) }}" @if($param['room']==$t)
class="b"@endif
>{{ $k }}</a></li>
                        @end
                        </ul>
                        <ul>
                        <li><a href="{{ list_url($param, 'price', '') }}" @if(empty($param['price']))
class="b"@endif
>租金</a></li>
                        <?php $price_rang = array('500元以下'=>'0_500','500-1000元'=>'500_1000','1000-1500元'=>'1000_1500','1500-2000元'=>'1500_2000','2000-4500元'=>'2000_4500','4500元以上'=>'4500_99999'); ?><!--手动控制价格循环-->
                        @foreach($price_rang as $k => $t)
                        <li><a href="{{ list_url($param, 'price', $t) }}" @if($param['price']==$t)
class="b"@endif
>{{ $k }}</a></li>
                        @end
                        </ul>
                    </div>
                    <div class="blank10 clear select-bottom"></div>
                    <!--根据url参数的地区id来判断sql查询区域id-->
                    <?php $data = linkagedata(1, $param['area']);$quyu=$data['arrchilds'] ? @implode(',',$data['arrchilds']) : $data['id']; ?>
                    <!--url分页规则-->
                    <?php $rule = list_url($param, 'page', '[page]'); ?>
                    {list catid=$catid INquyu=$quyu BWzujin=$param[price] shi=$param[room] page=$page pagesize=$pagesize urlrule=$rule order=updatetime more=1}
					<!--urlrule表示按照本页的分页规则，more=1表示显示自定义字段内容，参考list教程-->
                    <div class="software">
                        <span class="image"><a href="{{ $t['url'] }}"><img src="{{ thumb($t['thumb']) }}" /></a></span>
                        <h4 class="name"><a href="{{ $t['url'] }}" class="url">{{ $t['title'] }}</a>
                        <span class="date">日期：{{ date("Y-m-d", $t['updatetime']) }}</span></h4>
                        <p class="info"><em>租金￥{{ $t['zujin'] }}元（{{ $t['zujinleixing'] }}）</em> 人气：{{ $t['hits'] }}</p>
                        <p class="dec">小区：{{ $t['xiaoqu'] }}，{{ $t['shi'] }}室，{{ $t['ting'] }}厅，{{ $t['wei'] }}卫，楼层{{ $t['louceng'] }}/{{ $t['zongceng'] }}。</p>
                    </div>
                    {/list}
                    <div class="listpage">{{ $pagelist }}</div>
                </div>
            </div>
       </div>
       <div class="right">
            <!--right02 begin-->
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
            <!--right02 end-->
            <div class="blank10 clear"></div>
            <!--right02 begin-->
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
            <!--right02 end-->
       </div>
    </div>
    <!--主体end-->
    <div class="clear blank10"></div>
@include('footer')