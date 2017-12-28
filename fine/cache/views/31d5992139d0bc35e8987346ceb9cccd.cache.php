<?php include $this->_include('header');  
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
    您当前位置：<a  href="<?php echo SITE_PATH; ?>">首页</a> >> <?php echo catpos($catid, ' &gt;&gt;&nbsp;&nbsp;'); ?><!--栏目面包屑导航，参考函数教程-->
    </div>
    <div class="blank10 clear"></div>
    <!--主体begin-->
    <div class="downlist">
       <div class="left">
            <div class="left01">
                <div class="title"><?php echo $catname; ?></div>
                <div class="leftbox">
                    <div class="select-list">
                        <ul>
                        <li><a href="<?php echo list_url($param, 'area', 0); ?>" <?php if (empty($param['area'])) { ?>class="b"<?php } ?>>地区</a></li>
                        <?php $list = linkagelist(1, $param['area']); ?><!--调用联动菜单id为1（地区）的列表数据-->
                        <?php if (is_array($list)) { $count=count($list);foreach ($list as $t) { ?>
                        <li><a href="<?php echo list_url($param, 'area', $t['id']); ?>" <?php if ($param['area']==$t['id']) { ?>class="b"<?php } ?>><?php echo $t['name']; ?></a></li>
                        <?php } } ?>
                        </ul>
                        <ul>
                        <li><a href="<?php echo list_url($param, 'room', ''); ?>" <?php if (empty($param['room'])) { ?>class="b"<?php } ?>>厅室</a></li>
                        <?php $bedroom_rang = array('一室'=>'1','两室'=>'2','三室'=>'3','四室以上'=>'4_100'); ?><!--手动控制厅室循环-->	
                        <?php if (is_array($bedroom_rang)) { $count=count($bedroom_rang);foreach ($bedroom_rang as $k=>$t) { ?>
                        <li><a href="<?php echo list_url($param, 'room', $t); ?>" <?php if ($param['room']==$t) { ?>class="b"<?php } ?>><?php echo $k; ?></a></li>
                        <?php } } ?>
                        </ul>
                        <ul>
                        <li><a href="<?php echo list_url($param, 'price', ''); ?>" <?php if (empty($param['price'])) { ?>class="b"<?php } ?>>租金</a></li>
                        <?php $price_rang = array('500元以下'=>'0_500','500-1000元'=>'500_1000','1000-1500元'=>'1000_1500','1500-2000元'=>'1500_2000','2000-4500元'=>'2000_4500','4500元以上'=>'4500_99999'); ?><!--手动控制价格循环-->
                        <?php if (is_array($price_rang)) { $count=count($price_rang);foreach ($price_rang as $k=>$t) { ?>
                        <li><a href="<?php echo list_url($param, 'price', $t); ?>" <?php if ($param['price']==$t) { ?>class="b"<?php } ?>><?php echo $k; ?></a></li>
                        <?php } } ?>
                        </ul>
                    </div>
                    <div class="blank10 clear select-bottom"></div>
                    <!--根据url参数的地区id来判断sql查询区域id-->
                    <?php $data = linkagedata(1, $param['area']);$quyu=$data['arrchilds'] ? @implode(',',$data['arrchilds']) : $data['id']; ?>
                    <!--url分页规则-->
                    <?php $rule = list_url($param, 'page', '[page]');  $return = $this->_listdata("catid=$catid INquyu=$quyu BWzujin=$param[price] shi=$param[room] page=$page pagesize=$pagesize urlrule=$rule order=updatetime more=1"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
					<!--urlrule表示按照本页的分页规则，more=1表示显示自定义字段内容，参考list教程-->
                    <div class="software">
                        <span class="image"><a href="<?php echo $t['url']; ?>"><img src="<?php echo thumb($t['thumb']); ?>" /></a></span>
                        <h4 class="name"><a href="<?php echo $t['url']; ?>" class="url"><?php echo $t['title']; ?></a> 
                        <span class="date">日期：<?php echo date("Y-m-d", $t['updatetime']); ?></span></h4>
                        <p class="info"><em>租金￥<?php echo $t['zujin']; ?>元（<?php echo $t['zujinleixing']; ?>）</em> 人气：<?php echo $t['hits']; ?></p>
                        <p class="dec">小区：<?php echo $t['xiaoqu']; ?>，<?php echo $t['shi']; ?>室，<?php echo $t['ting']; ?>厅，<?php echo $t['wei']; ?>卫，楼层<?php echo $t['louceng']; ?>/<?php echo $t['zongceng']; ?>。</p>
                    </div>
                    <?php } } ?>
                    <div class="listpage"><?php echo $pagelist; ?></div>
                </div>
            </div>
       </div>
       <div class="right">
            <!--right02 begin-->
            <div class="right01">
                <div class="title"><span>最新TOP10</span></div>
                <div class="right01box">
                <ul>
                <?php $return = $this->_listdata("catid=$catid num=10 order=updatetime cache=36000"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                <li><span class="N<?php echo $key+1; ?>"></span><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></li>
                <?php } } ?>
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
                <?php $return = $this->_listdata("catid=$catid num=10 order=hits cache=36000"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                <li><span class="N<?php echo $key+1; ?>"></span><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></li>
                <?php } } ?>
                </ul>
               </div>
            </div> 
            <!--right02 end-->
       </div>
    </div>
    <!--主体end-->
    <div class="clear blank10"></div>
<?php include $this->_include('footer'); ?>