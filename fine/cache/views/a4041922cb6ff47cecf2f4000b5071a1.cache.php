<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $meta_title; ?> [v<?php echo CMS_VERSION; ?>]</title>
<meta name="keywords" content="<?php echo $meta_keywords; ?>" />
<meta name="description" content="<?php echo $meta_description; ?>" />
<meta name="author" content="dayrui@gmail.com" >
<meta name="Copyright" content="FineCMS v<?php echo CMS_VERSION; ?>" >
<link rel="stylesheet" type="text/css" href="<?php echo SITE_THEME; ?>images/style.css" />
<link rel="stylesheet" href="/dayrui/statics/style.css">
<script type="text/javascript">var sitepath = '<?php echo SITE_PATH;  echo ENTRY_SCRIPT_NAME; ?>';</script>
<script type="text/javascript" src="<?php echo ADMIN_THEME; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_THEME; ?>js/header.js"></script>
<script type="text/javascript" src="<?php echo SITE_THEME; ?>js/jquery.autocomplete.js"></script>
<!--[if IE 6]>
<script src="<?php echo SITE_THEME; ?>js/iepng.js" type="text/javascript"></script>
<script type="text/javascript">
   EvPNG.fix('div, ul, img, li, input'); 
</script>
<![endif]-->
</head>
<body>
<!--header begin-->
<div class="header">
    <div class="head">
        <div class="left"><script type="text/javascript" src="<?php echo url('api/user'); ?>"></script></div>
        <div class="right"><a href="<?php echo url('tag'); ?>">关键词</a> | <a href="<?php echo url('content/post'); ?>">我要投稿</a></div>
    </div>
</div>
<!--header end-->
<!--wrap begin-->
<div id="wrap">
    <div class="blank10 clear"></div>
	<!--top_a begin-->
	<div class="top_a">
		<div class="logo"><a href="<?php echo SITE_PATH; ?>"><img src="<?php echo SITE_THEME; ?>images/finecms.png" width="258" height="78" border="0" /></a></div>
		<div class="search">
            <form id="SearchForm" name="SearchForm" method="Get" action="" onSubmit="return search_post()">
            <div class="searchsd">
            <input name="searchkw" id="SearchKey" type="text" class="textbox" value=""/><span>
            <input type="image" class="inputButton" name="Submit1" src="<?php echo SITE_THEME; ?>images/btn.gif" align="absmiddle"  onClick="return search_post()" />
            </span>
            </div>
            </form>
            <div class="clear blank10"></div>
            <div class="searchkw">
			<?php $return = $this->_listdata("action=keywords order=addtime num=10 cache=3600"); extract($return); $count=count($result); if (is_array($result)) { foreach ($result as $key=>$t) { ?>
			<a href="<?php echo url('content/search', array('kw'=>urlencode($t['title']))); ?>"><?php echo $t['title']; ?></a>
			<?php } } ?>
			</div>
		</div>
		<div class="banner"><a href="http://down.finecms.net" target="_blank"><img src="<?php echo SITE_THEME; ?>images/down.png" width="280" height="78" border="0" /></a></div>
	</div>
	<!--top_a end-->
	<div class="blank10 clear"></div>
	<!--menu begin-->
	<div id="menu_out">
        <div id="menul"></div>
		<div id="menum">
			<ul>
				<li <?php if ($indexc==1) { ?>class="currclass"<?php } ?>><a href="<?php echo SITE_PATH; ?>">首页</a></li>
                <?php if (is_array($cats)) { $count=count($cats);foreach ($cats as $t) {  if ($t['parentid']==0 && $t['ismenu']) {  $arrchilds = @explode(',', $t['arrchilds']); ?>
                <li <?php if (isset($catid) && in_array($catid, $arrchilds)) { ?>class="currclass"<?php } ?>><a href="<?php echo $t['url']; ?>"><?php echo $t['catname']; ?></a></li>
                <?php }  } } ?>
                <li><a href="http://www.finecms.net" target="_blank">FineCMS</a></li>
			</ul>
		</div>
		<div id="menur"></div>
	</div>
	<!--EndMenu-->
    <div class="blank10 clear"></div>
	<!--这里可以放置广告
	<div class="banner965">广告内容</div>
	<div class="blank10 clear"></div>
	-->