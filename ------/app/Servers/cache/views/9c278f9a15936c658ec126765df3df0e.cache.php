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
<script type="text/javascript" src="<?php echo ADMIN_THEME; ?>js/jquery.min.js"></script>	<?php include $this->_include('admin/top.html'); ?>
<title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
		<a href="<?php echo url('admin/relatedlink'); ?>"><em><?php echo lang('a-men-33'); ?></em></a><span>|</span>
		<a href="<?php echo url('admin/relatedlink/add'); ?>" class="on"><em><?php echo lang('a-add'); ?></em></a><span>|</span>
		<?php if (admin_auth($userinfo['roleid'], 'relatedlink-cache')) { ?><a href="<?php echo url('admin/relatedlink/cache'); ?>"><em><?php echo lang('a-cache'); ?></em></a><span>|</span><?php }  if (admin_auth($userinfo['roleid'], 'relatedlink-import')) { ?><a href="<?php echo url('admin/relatedlink/import'); ?>"><em><?php echo lang('a-import'); ?></em></a><?php } ?>
	</div>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<form action="" method="post">
		<input name="id" type="hidden" value="<?php echo $data['id']; ?>" />
		<table width="100%" class="table table-striped">
		<tr>
			<th width="200"><?php echo lang('a-tag-17'); ?>： </th>
			<td><input class="input-text" type="text" name="data[name]" value="<?php echo $data['name']; ?>" size="30" required /></td>
		</tr>
		<tr>
			<th><?php echo lang('a-tag-18'); ?>： </th>
			<td><input class="input-text" type="text" name="data[url]" value="<?php echo $data['url']; ?>" size="50" required /></td>
		</tr>
		<tr>
			<th><?php echo lang('a-tag-19'); ?>： </th>
			<td><input class="input-text" type="text" name="data[sort]" value="<?php echo $data['sort']; ?>" size="10"/>
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td><input class="btn btn-success btn-sm" type="submit" name="submit" value="<?php echo lang('a-submit'); ?>" /></td>
		</tr>
		</table>
		</form>
	</div>
</div>
</body>
</html>