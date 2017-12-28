<?php include $this->_include('header'); ?>
    <div class="navigation">
    您当前位置：<a  href="<?php echo SITE_PATH; ?>">首页</a> >> <?php echo catpos($catid, ' &gt;&gt;&nbsp;&nbsp;'); ?><!--栏目面包屑导航，参考函数教程-->
    </div>
    <div class="blank10 clear"></div>
    <div class="mainpdbox">
        <div class="left">
            <!--list begin-->
		    <div class="newslist">
                <h3><?php echo $catname; ?></h3> 	
			    <ul class="noborder">
                <?php $return = $this->_listdata("catid=$catid page=$page pagesize=5 order=updatetime"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                <li><span class="date"><?php echo date("Y-m-d", $t['updatetime']); ?></span> <a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></li>
                <?php if (($key+1)%5==0) { ?><li class="page-list" style="background:none"></li><?php } ?>
				<!--这里的$key是list循环控制变量，($key+1)%5==0表示每5行加一段分行代码-->
                <?php } } ?>
                </ul>
                <div class="listpage" style="padding-left:10px;"><?php echo $pagelist; ?></div>
		   </div>
	       <!--list end-->
        </div>
        <div class="right">
            <!--right02 begin-->
	        <div class="right02">
		        <div class="title"><span>最新TOP10</span></div>
		        <div class="right02box">
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
	        <div class="right02">
		       <div class="title"><span>热点TOP10</span></div>
		       <div class="right02box">
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
    <div class="clear blank10"></div>
<?php include $this->_include('footer'); ?>