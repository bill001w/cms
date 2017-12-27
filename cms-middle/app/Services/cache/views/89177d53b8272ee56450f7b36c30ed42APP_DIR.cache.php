<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/system.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/main.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet"><link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="/views/admin/js/dialog.js"></script>
<script type="text/javascript">var sitepath = "<?php echo url(); ?>";</script>
<script type="text/javascript" src="<?php echo LANG_PATH; ?>lang.js"></script><?php include $this->_include('admin/top.html'); ?>
<script type="text/javascript" src="/views/admin/js/core.js"></script>
<title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
		<a href="<?php echo url('admin/position'); ?>"><em><?php echo lang('a-men-31'); ?></em></a><span>|</span>
		<a href="<?php echo url('admin/position/list',array('posid'=>$posid)); ?>"><em><?php echo lang('a-pos-0'); ?></em></a><span>|</span>
		<a href="<?php echo url('admin/position/adddata',array('posid'=>$posid)); ?>" class="on"><em><?php echo lang('a-add'); ?></em></a><span>|</span>
		<a href="<?php echo url('admin/position/cache'); ?>"><em><?php echo lang('a-cache'); ?></em></a>
	</div>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<form method="post" action="" id="myform" name="myform">
		<input name="data[catid]" type="hidden" id="catid" value="<?php echo $data['catid']; ?>">
		<input name="data[contentid]" type="hidden" id="contentid" value="<?php echo $data['contentid']; ?>">
		<table width="100%"class="table table-striped">
		<tbody>
		<tr>
			<th width="200"><?php echo lang('a-pos-2'); ?>：</th>
			<td><?php echo $position['name']; ?> (<?php if ($position['catid']) {  echo lang('a-con-29');  } else {  echo lang('a-pos-4');  } ?>)</td>
		</tr>
		<tr>
			<th><?php echo lang('a-con-26'); ?>：</th>
			<td><input type="text" class="input-text" size="50" id="title" value="<?php echo $data['title']; ?>" name="data[title]" required />
			<input type="button" style="cursor:pointer;" class="btn btn-success btn-sm" onClick="loadInfo()" value="<?php echo lang('a-pos-9'); ?>">
			</td>
		</tr>
		<tr>
			<th>contentid：</th>
			<td>
				<input type="text" class="input-text" size="50" id="url" value="<?php if ($data['contentid']) {  echo $data['contentid'];  } else {  } ?>" name="data[contentid]" required />
			</td>
		</tr>
		<tr>
			<th><?php echo lang('a-con-59'); ?>：</th>
			<td>
            <input <?php if ($data['contentid']) { ?>readonly<?php } ?> type="text" class="input-text" size="50" id="url" value="<?php if ($data['url']) {  echo $data['url'];  } else {  echo url();  } ?>" name="data[url]" required />
            <?php if ($data['contentid']) { ?>已从文章中获取了地址<?php } ?>
            </td>
		</tr>
		<tr>
			<th><?php echo lang('a-con-45'); ?>：</th>
			<td><input type="text" class="input-text" size="50" value="<?php echo $data['thumb']; ?>" name="data[thumb]" id="thumb">
			<input type="button" style="width:66px;cursor:pointer;" class="btn btn-success btn-sm" onClick="preview('thumb')" value="<?php echo lang('a-mod-118'); ?>">
			<input type="button" style="width:66px;cursor:pointer;" class="btn btn-success btn-sm" onClick="uploadImage('thumb')" value="<?php echo lang('a-mod-119'); ?>">
			<div id="urlTip" class="onShow"><?php echo lang('a-pic'); ?></div>
			</td>
		</tr>
		<tr>
			<th><?php echo lang('a-desc'); ?>：</th>
			<td><textarea style="width:490px;height:66px;" id="description" name="data[description]"><?php echo $data['description']; ?></textarea></td>
		</tr>
		<tr>
			<th></th>
			<td><input type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-submit'); ?>" name="submit"></td>
		</tr>
		</tbody>
		</table>
		</form>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
function loadInfo() {
	var url = '<?php echo url("admin/position/ajaxloadinfo/"); ?>';
	var winid = 'loadinfo';
	window.top.art.dialog(
	    {id:winid, okVal:fc_lang[6], cancelVal:fc_lang[7], iframe:url, title:'<?php echo lang('a-con-50'); ?>', width:'660', height:'280', lock:true}, 
		function(){
		    var d  = window.top.art.dialog({id:winid}).data.iframe;
			var id = d.document.getElementById('select').value;
			if (id) {
				var title = d.document.getElementById('title_'+id).value;
				var url   = d.document.getElementById('url_'+id).value;
				var thumb = d.document.getElementById('thumb_'+id).value;
				var catid = d.document.getElementById('catid_'+id).value;
				var desc  = d.document.getElementById('desc_'+id).value;
				$("#title").val(title);
				$("#url").val(url);
				$("#thumb").val(thumb);
				$("#catid").val(catid);
				$("#description").val(desc);
				$("#contentid").val(id);
			} else {
				return false;
			}
		},
		function(){
			window.top.art.dialog({id:winid}).close();
	    }
	);
	void(0);
}
</script>