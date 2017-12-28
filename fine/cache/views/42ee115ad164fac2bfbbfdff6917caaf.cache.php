<?php include $this->_include('header'); ?>
    <div class="navigation">
    您当前位置：<a  href="<?php echo SITE_PATH; ?>">首页</a> >> <?php echo catpos($catid, ' &gt;&gt;&nbsp;&nbsp;'); ?><!--栏目面包屑导航，参考函数教程-->
    </div>
    <div class="blank10 clear"></div>
    <div class="mainpdbox mainbox">
        <div class="left">
            <!--栏目循环 begin-->
            <?php $i=0; ?><!--循环控制变量-->
            <?php if (is_array($cats)) { $count=count($cats);foreach ($cats as $c) { ?><!--循环子栏目且为内部栏目-->

            <?php if ($c['parentid']==$catid && $c['typeid']==1) { ?><!--判断当前栏目的子栏目并且循环该栏目的子栏目-->
                <?php if ($i%2==0) { ?><!--分两栏显示-->
                <div class="left03">
                <?php } ?>

                    <div <?php if ($i%2==0) { ?>class="floatl"<?php } else { ?>class="floatr"<?php } ?>>
                        <div class="title"><span><a href="<?php echo $c['url']; ?>">更多>></a></span><strong><?php echo $c['catname']; ?></strong></div>
                        <div class="floatlbox">
                            <div class="synews9">
                            <ul>
                                <?php $return = $this->_listdata("catid=$c[catid] page=$page num=9 cache=36000"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                                <li><span id="date">(<?php echo date("m-d", $t['updatetime']); ?>)</span><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></li>
                                <?php } } ?>
                            </ul>
                            </div>
                        </div>
                    </div>

                <?php if ($i%2==1) { ?><!--最后一栏换行-->
                </div>
                <div class="clear blank10"></div>
                <?php }  $i++;  }  } }  if ($i%2==1) { ?><!--如果栏目数不是偶数，就结束div盒-->
            </div>
            <div class="clear blank10"></div>
            <?php } ?>
            <!--栏目循环 end-->
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