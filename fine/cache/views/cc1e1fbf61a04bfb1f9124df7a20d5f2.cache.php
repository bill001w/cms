<?php include $this->_include('header'); ?>
    <div class="mainbox">
        <div class="left">
            <!--left01 begin-->
            <div class="left01">
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
                    <div id="KinSlideshow" style="visibility:hidden;overflow:hidden;width:290px;height:270px;">
                        <?php $return = $this->_listdata("action=position id=3"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                        <a href="<?php echo $t['url']; ?>" title="<?php echo $t['title']; ?>"><img src="<?php echo thumb($t['thumb']); ?>" alt="<?php echo $t['title']; ?>" width="290" height="270" /></a>
                        <?php } } ?>
                    </div>
                </div>
                <div class="floatr">
                    <div class="news">
                    <!--首页头条-->
                    <?php $return = $this->_listdata("action=position id=1"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                        <h1><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></h1>
                        <div class="newsintro"><?php echo $t['description']; ?><span><a href="<?php echo $t['url']; ?>">[查看详细]</a></span></div>
                    <?php } } ?>
                    </div>
                    <div class="clear"></div>
                    <div class="newstop7">
                    <ul>
                    <!--最新文章-->
                    <?php $return = $this->_listdata("order=updatetime num=7 cache=36000"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                        <li><span><font <?php if (date('Y-m-d', $t['updatetime']) == date('Y-m-d')) { ?>style="color:red"<?php } ?>><?php echo date('m-d', $t['updatetime']); ?></font></span><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></li>
                    <?php } } ?>
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
                    <?php $return = $this->_listdata("modelid=2 thumb=1 order=updatetime num=8 cache=36000"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                    <li>
                        <div class="pe_u_thumb">
                           <a href="<?php echo $t['url']; ?>"><img src="<?php echo thumb($t['thumb']); ?>"></a>
                           <div class="pe_u_thumb_title"><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></div>
                        </div>
                    </li>
                    <?php } } ?>
                    </ul>
                    </div>
                    <span id="btn_focus_next" class="btn"></span>
                    <span id="btn_focus_prev" class="btn"></span>
                </div>
                <script type='text/javascript' src='<?php echo SITE_THEME; ?>js/pic_roll.js'></script>
                <script type="text/javascript">
                $(function(){
                    var clearTimer = null;
                    var SleepTime = 2000;   //停留时长，单位毫秒
                    $("#focus_img").jCarouselLite({
                        btnNext: "#btn_focus_next",
                        btnPrev: "#btn_focus_prev",
                        visible: 4,
                        scroll:4,
                        speed: 1000,//滚动速度，单位毫秒
                        auto:5000,
                        mouseOver:true
                    });
                });
                </script>
                <!--图片风采结束-->
            </div>
            <!--left02 end-->
            <div class="clear blank10"></div>
            <!--栏目循环 begin-->
			<!--栏目循环默认循环所有顶级内部栏目，你也可以通过loop来指定栏目循环-->
            <?php $i=0; ?><!--循环控制变量，可以对栏目循环的个数控制-->
            <?php if (is_array($cats)) { $count=count($cats);foreach ($cats as $c) { ?><!--循环顶级栏目且为内部栏目-->
            <?php if ($c['parentid']==0 && $c['typeid']==1) {  if ($i%2==0) { ?><!--分两栏显示-->
            <div class="left03">
            <?php } ?>
                <div <?php if ($i%2==0) { ?>class="floatl"<?php } else { ?>class="floatr"<?php } ?>>
                    <div class="title"><span><a href="<?php echo $c['url']; ?>">更多>></a></span><strong><?php echo $c['catname']; ?></strong></div>
                    <div class="floatlbox">
                        <div class="c_pt_1">
                        <!-- 栏目头条 -->
                        <?php $return = $this->_listdata("action=position id=4 catid=$c[catid]"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                            <div class="Pic"><a href="<?php echo $t['url']; ?>"><img src="<?php echo thumb($t['thumb']); ?>"></a></div>
                            <div class="Txt">
                                <h3><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></h3>
                                <p><?php echo strcut($t['description'],100); ?></p>
                            </div>
                        <?php } } ?>
                        </div>
                        <div class="dotline clear"></div>
                        <div class="synews9">
                        <ul>
                            <?php $return = $this->_listdata("catid=$c[catid] order=updatetime num=5 cache=36000"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                            <li><span id="date">(<?php echo date("m-d", $t['updatetime']); ?>)</span><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></li>
                            <?php } } ?>
                        </ul>
                        </div>
                    </div>
                </div>
            <?php if ($i%2==1) { ?><!--最后一栏换行，结束div-->
            </div>
            <div class="clear blank10"></div>
            <?php }  $i++; ?><!--循环控制变量自增-->
            <?php }  } }  if ($i%2==1) { ?><!--如果栏目数不是偶数，就结束div盒-->
            </div>
            <div class="clear blank10"></div>
            <?php } ?>
            <!--栏目循环 end-->
        </div>
        <div class="right">
            <!--首页推荐 begin-->
            <div class="right02">
                <div class="scrollFrame">
                    <div class="scrollUl"><div class="textdiv"><strong>推荐</strong></div></div>
                    <div class="bor01 cont">
                        <div class="display">
                        <ul class="syfresh">
                        <?php $return = $this->_listdata("action=position id=2"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                        <li><span class="N<?php echo $key+1; ?>"><!--这里的$key是list循环控制变量，list教程有详细介绍--></span><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></li>
                        <?php } } ?>
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
               <?php $return = $this->_listdata("order=updatetime num=15 cache=36000"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                   <li><span id="date">(<?php echo date("m-d", $t['updatetime']); ?>)</span><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></li>
               <?php } } ?>
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
                <?php $return = $this->_listdata("order=hits num=15 cache=36000"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
                   <li><span id="date">(<?php echo date("m-d", $t['updatetime']); ?>)</span><a href="<?php echo $t['url']; ?>"><?php echo $t['title']; ?></a></li>
                <?php } } ?>
                </ul>
                </div>
            </div>
            <!--阅读排行 end-->
            <div class="clear blank10"></div>
       </div>
    </div>
    <?php if (plugin('link')) { ?> <!--判断友情链接插件是否存在，若存在就执行下面的-->
    <div class="clear blank10"></div>
    <!--友情链接-->
    <div class="friendlink">
        <div class="title"><span id="tit">友情链接</span></div>
        <div class="linkbox">
        <?php $return = $this->_listdata("table=link.link order=listorder_asc cache=36000"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?><!--循环输出友情链接数据，list教程有详细介绍-->
        <a href="<?php echo $t['url']; ?>" target="_blank" title="<?php echo $t['introduce']; ?>"><?php echo $t['name']; ?></a>&nbsp;&nbsp;&nbsp;
        <?php } } ?>
        </div>
    </div>
    <!--友情链接end-->
    <?php } ?>
    <div class="clear blank10"></div>
<?php include $this->_include('footer'); ?>