<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title><?php echo $sites[$siteid]['SITE_NAME']; ?>-<?php echo lang('admin'); ?></title>
    <link href="<?php echo ADMIN_THEME; ?>luos/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="<?php echo ADMIN_THEME; ?>luos/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="<?php echo ADMIN_THEME; ?>luos/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo ADMIN_THEME; ?>luos/css/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="<?php echo ADMIN_THEME; ?>images/dialog.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        var mypath='<?php echo ADMIN_THEME; ?>';
        var sitepath = '<?php echo SITE_PATH;  echo ENTRY_SCRIPT_NAME; ?>';
        var finecms_admin_document = "<?php isset($data['catid']) && isset($cats[$data['catid']]['setting']['document'])?$cats[$data['catid']]['setting']['document']:'';?>";
    </script>
    <script src="<?php echo ADMIN_THEME; ?>luos/js/jquery.min.js?v=2.1.4"></script>
    <script src="<?php echo ADMIN_THEME; ?>luos/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="<?php echo ADMIN_THEME; ?>luos/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo ADMIN_THEME; ?>luos/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo ADMIN_THEME; ?>luos/js/plugins/layer/layer.min.js"></script>
    <script src="<?php echo ADMIN_THEME; ?>luos/js/hplus.min.js?v=4.1.0"></script>
    <script src="<?php echo ADMIN_THEME; ?>luos/js/contabs.min.js"></script>
    <script src="<?php echo ADMIN_THEME; ?>luos/js/plugins/pace/pace.min.js"></script>
    <script src="<?php echo ADMIN_THEME; ?>js/dtree.js"></script>
    <script type="text/javascript" src="<?php echo LANG_PATH; ?>lang.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_THEME; ?>js/core.js"></script>
    <script type="text/javascript" src="<?php echo ADMIN_THEME; ?>js/dialog.js"></script>
    <script>
        function logout(){
            if (confirm("<?php echo lang('a-com-19'); ?>"))
                top.location = '<?php echo url("admin/login/logout/"); ?>';
            return false;
        }
    </script>
    <style>
        .dTreeNode #id0 { display: none }
        .dtree { margin-bottom: 10px;}
    </style>
</head>

<body class="fixed-sidebar full-height-layout gray-bg " style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse" style="margin-bottom: 20px">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                               <span class="block m-t-xs"><strong class="font-bold"><?php echo $userinfo['username']; ?></strong></span>
                                <span class="text-muted text-xs block"><?php echo $userinfo['rolename']; ?><b class="caret"></b></span>
                                </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="J_menuItem" href="<?php echo url('admin/user/ajaxedit'); ?>"><?php echo lang('个人资料'); ?></a>
                            </li>
                            <li><a href="javascript:logout();"><?php echo lang('安全退出'); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">FC</div>
                </li>
                <?php if (is_array($menu)) { $count=count($menu);foreach ($menu as $i=>$m) { ?>
                <li>
                    <?php if ($m['menu']) { ?>
                    <a href="<?php if ($m['uri']) {  echo url($m['uri']);  } else { ?>#<?php } ?>">
                        <i class="fa fa-<?php echo $m['icon']; ?>"></i>
                        <span class="nav-label"><?php echo lang($m['name']); ?></span>
                        <span class="fa arrow"></span>
                    </a>
                    <?php if ($i =='content') { ?>
                    <ul style="padding-left:40px;" class="nav nav-second-level">
                        <script type="text/javascript">
                            d = new dTree('d');
                            d.add(0,-1,'');
                            <?php if (is_array($cat)) { $count=count($cat);foreach ($cat as $t) {  if ($t[typeid]!=3) { ?>
                            d.add(<?php echo intval($t[catid]); ?>, <?php echo intval($t[parentid]); ?>, '<?php echo str_replace(array("'", '"'), "", $t[catname]); ?>', '<?php if ($t[child]) {  if ($t[typeid]==2) {  echo url('admin/content/index', array('catid'=>$t[catid],'modelid'=>$t[modelid]));  }  } else {  echo url('admin/content/index', array('catid'=>$t[catid],'modelid'=>$t[modelid]));  } ?>', '', 'right');
                            <?php }  } } ?>
                            document.write(d);
                        </script>
                    </ul>
                    <?php } else { ?>
                    <ul class="nav nav-second-level">
                        <?php if (is_array($m['menu'])) { $count=count($m['menu']);foreach ($m['menu'] as $t) { ?>
                        <li>
                            <a class="J_menuItem" href="<?php echo $t['url'] ? $t['url'] : url($t['uri']); ?>"><i class="fa fa-<?php echo fn_icon($t['icon']); ?>"></i> <?php echo lang($t['name']); ?></a>
                        </li>
                        <?php } } ?>
                    </ul>
                    <?php }  } else { ?>
                    <a class="J_menuItem" href="<?php echo $m['url'] ? $m['url'] : url($m['uri']); ?>"><i class="fa fa-<?php echo $m['icon']; ?>"></i> <span class="nav-label"><?php echo lang($m['name']); ?></span></a>
                    <?php } ?>
                </li>
                <?php } } ?>


            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" target="_blank" method="post" action="http://www.dayrui.net/app-index-run?app=search">
                        <div class="form-group">
                            <input type="text" placeholder="<?php echo lang('快速查询使用帮助信息...'); ?>" class="form-control" name="keywords" id="top-search">
                            <input type="hidden" name="csrf_token" value="098098080980">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">

                    <?php if (count($sites)>1 && $userinfo['site']==0) { ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-cubes"></i> <span class="label label-primary"><?php echo count($sites); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <?php if (is_array($sites)) { $count=count($sites);foreach ($sites as $sid=>$t) { ?>
                            <li>
                                <a href="<?php echo url('admin', array('siteid'=>$sid)); ?>">
                                    <div>
                                        <i class="fa fa-cubes"></i> <?php echo $t['SITE_NAME']; ?>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <?php } } ?>
                            <li>
                                <div class="text-center link-block">
                                    <a class="J_menuItem" href="<?php echo url('admin/site/index'); ?>" data-index="89">
                                        <strong><?php echo lang('查看所有'); ?> </strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                        </li>
                        </ul>
                    </li>
                    <?php } ?>
                    <li class="hidden-xs">
                        <a href="<?php echo SITE_URL; ?>" target="_blank" data-index="0"><i class="fa fa-home"></i> <?php echo lang('网站首页'); ?></a>
                    </li>
                    <li class="dropdown">
                        <a class="J_menuItem" href="<?php echo url('admin/index/cache'); ?>"><i class="fa fa-refresh"> </i> <?php echo lang('a-men-19'); ?></a>
                    </li>
                    <li class="dropdown hidden-xs">
                        <a class="right-sidebar-toggle" aria-expanded="false">
                            <i class="fa fa-tasks"></i> <?php echo lang('后台主题'); ?>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="<?php echo url('admin/index/main'); ?>"><?php echo lang('首页'); ?></a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                    </li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                    </li>
                </ul>
            </div>
            <a href="javascript:logout();" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> <?php echo lang('退出'); ?></a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" id="right" name="iframe0" width="100%" height="100%" src="<?php echo url('admin/index/main'); ?>" frameborder="0" data-id="<?php echo url('admin/index/main'); ?>" seamless></iframe>
        </div>
        <div class="footer">
            <div class="pull-right">&copy; <a href="http://www.dayrui.com/free/" target="_blank">成都天睿信息技术有限公司</a>
            </div>
        </div>
    </div>
    <!--右侧部分结束-->
    <!--右侧边栏开始-->
    <div id="right-sidebar">
        <div class="sidebar-container">

            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="skin-setttings">
                        <div class="title">主题设置</div>
                        <div class="setings-item">
                            <span>收起左侧菜单</span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu">
                                    <label class="onoffswitch-label" for="collapsemenu">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>固定顶部</span>

                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="fixednavbar" class="onoffswitch-checkbox" id="fixednavbar">
                                    <label class="onoffswitch-label" for="fixednavbar">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                                <span>
                        固定宽度
                    </span>

                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout">
                                    <label class="onoffswitch-label" for="boxedlayout">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="title">皮肤选择</div>
                        <div class="setings-item default-skin nb">
                                <span class="skin-name ">
                         <a href="#" class="s-skin-0">
                             默认皮肤
                         </a>
                    </span>
                        </div>
                        <div class="setings-item blue-skin nb">
                                <span class="skin-name ">
                        <a href="#" class="s-skin-1">
                            蓝色主题
                        </a>
                    </span>
                        </div>
                        <div class="setings-item yellow-skin nb">
                                <span class="skin-name ">
                        <a href="#" class="s-skin-3">
                            黄色/紫色主题
                        </a>
                    </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--右侧边栏结束-->
</div>
</body>

</html>
