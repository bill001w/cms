<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo ADMIN_THEME; ?>images/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_THEME; ?>images/system.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_THEME; ?>images/dialog.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_THEME; ?>images/main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_THEME; ?>images/switchbox.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_THEME; ?>luos/css/style.min.css?v=4.1.0" rel="stylesheet"><link href="<?php echo ADMIN_THEME; ?>images/table_form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo ADMIN_THEME; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_THEME; ?>js/dialog.js"></script><?php include $this->_include('admin/top.html'); ?>
<title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
	<form action="" method="post">
		<?php echo lang('a-con-26'); ?>：<input type="text" class="input-text" size="25" name="title">
		<select name='catid'>
		<option value='0'> --- </option>
		<?php echo $category; ?>
		</select>
		 <?php echo lang('a-con-45'); ?> <input name="thumb" type="checkbox" value="1">
		<input type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-search'); ?>" name="submit">
	</form>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<table width="100%" class="table table-striped">
		<thead>
		<tr>
			<th width="60" align="center"><?php echo lang('a-select'); ?></th>
			<th align="left"><?php echo lang('a-con-26'); ?></th>
			<th width="80" align="left"><?php echo lang('a-con-29'); ?></th>
			<th width="130" align="left"><?php echo lang('a-con-31'); ?></th>
		</tr>
		</thead>
		<tbody>
		<input name="select" id="select" type="hidden" value="">
		<?php if (is_array($list)) { $count=count($list);foreach ($list as $t) { ?>
		<input name="title_<?php echo $t['id']; ?>" id="title_<?php echo $t['id']; ?>" type="hidden" value="<?php echo $t['title']; ?>">
		<input name="url_<?php echo $t['id']; ?>" id="url_<?php echo $t['id']; ?>" type="hidden" value="<?php echo $t['url']; ?>">
		<input name="thumb_<?php echo $t['id']; ?>" id="thumb_<?php echo $t['id']; ?>" type="hidden" value="<?php echo $t['thumb']; ?>">
		<input name="catid_<?php echo $t['id']; ?>" id="catid_<?php echo $t['id']; ?>" type="hidden" value="<?php echo $t['catid']; ?>">
		<input name="desc_<?php echo $t['id']; ?>" id="desc_<?php echo $t['id']; ?>" type="hidden" value="<?php echo $t['description']; ?>">
		<tr height="25">
			<td align="center"><input name="select_" id="select_<?php echo $t['id']; ?>" type="radio" value="<?php echo $t['id']; ?>" onClick="setv(this)"></td>
			<td align="left"><div style="overflow:hidden; height:22px; width:290px;"><?php if ($t['thumb']) { ?><font color="#FF0000">[<?php echo lang('a-pos-7'); ?>]</font><?php }  echo $t['title']; ?></div></td>
			<td align="left"><?php echo $cats[$t['catid']]['catname']; ?></td>
			<td align="left"><?php echo date(TIME_FORMAT, $t['updatetime']); ?></td>
		</tr>
		<?php } } ?>
		</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
function setv(obj) {
	var id = $(obj).val();
	$("#select").val(id);
}
</script>
</body>
</html>