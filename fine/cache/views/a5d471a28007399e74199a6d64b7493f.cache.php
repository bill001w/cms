<?php include $this->_include('header'); ?>
    <div class="navigation">
    您当前位置：<a  href="<?php echo SITE_PATH; ?>">首页</a> >> <?php echo catpos($catid, ' >>  '); ?>
    </div>
	<div class="blank10 clear"></div>
    <div class="picmain">
	    <div class="left">
		    <div class="floatl">
				<script type='text/javascript' src='<?php echo SITE_THEME; ?>js/KinSlideshow.js'></script>
				<script type="text/javascript">
				$(function(){
					$("#KinSlideshow").KinSlideshow({
						moveStyle:"down", //切换参数left,right,down,up
						intervalTime:3, //切换时间
						mouseEvent:"mouseover",
						titleBar:{titleBar_height:30,titleBar_bgColor:"#656565",titleBar_alpha:0.5}, //标题背景
						titleFont:{TitleFont_size:12,TitleFont_color:"#FFFFFF",TitleFont_weight:"normal"}, //标题字体
						btn:{btn_bgColor:"#FFFFFF",btn_bgHoverColor:"#FF7A00",btn_fontColor:"#000000",btn_fontHoverColor:"#FFFFFF",btn_borderColor:"#cccccc",btn_borderHoverColor:"#666666",btn_borderWidth:1} //按钮设置
					});
				})
				</script>
				<div id="KinSlideshow" style="visibility:hidden;overflow:hidden;width:358px;height:290px;">
					<?php $return = $this->_listdata("action=position id=3"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
					<a href="<?php echo $t['url']; ?>" title="<?php echo $t['title']; ?>"><img src="<?php echo thumb($t['thumb']); ?>" alt="<?php echo $t['title']; ?>" width="358" height="290" /></a>
					<?php } } ?>
				</div>
			</div>
	        <div class="floatr">
				<ul>
				<?php $return = $this->_listdata("action=position id=3"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
					<li><a href="<?php echo $t['url']; ?>"><img src="<?php echo thumb($t['thumb'], 120, 90); ?>" width="120" height="90"></a><br /><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></li>
				<?php } } ?>	
				</ul>
	        </div>
		</div>
		<div class="right">
		    <div class="title">最新TOP10</div>
			<div class="right01box">
			<ul>
			<?php $return = $this->_listdata("catid=$catid order=updatetime num=7 cache=36000"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
			<li><span class="N<?php echo $key+1; ?>"><!--这里的$key是list循环控制变量，list教程有详细介绍--></span><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></li>
			<?php } } ?>
			</ul>
		    </div>
        </div>
	</div>
    <div class="blank10 clear"></div>
    <div class="picmain2">
    <?php if (is_array($cats)) { $count=count($cats);foreach ($cats as $c) {  if ($c['parentid']==$catid && $c['typeid']==1) { ?>
        <div class="col">
            <div class="t"><span><a href="<?php echo $c['url']; ?>">更多>></a></span><?php echo $c['catname']; ?></div>
            <ul> 
            <?php $return = $this->_listdata("catid=$c[catid] order=updatetime num=6"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
            <li>
            <a href="<?php echo $t['url']; ?>"><img src="<?php echo thumb($t['thumb']); ?>"></a>
            <br />
            <a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a>
            </li>
            <?php } } ?>
            </ul>
        </div>
    <?php }  } } ?>
    </div>
    <div class="clear blank10"></div>
<?php include $this->_include('footer'); ?>