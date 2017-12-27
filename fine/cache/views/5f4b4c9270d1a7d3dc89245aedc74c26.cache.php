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
	<div class="content-menu ib-a blue line-x">
		<a href="<?php echo url('admin/position/'); ?>"><em><?php echo lang('a-men-31'); ?></em></a><span>|</span>
		<a href="<?php echo url('admin/position/add/'); ?>" class="on"><em><?php echo lang('a-add'); ?></em></a><span>|</span>
		<a href="<?php echo url('admin/position/cache'); ?>"><em><?php echo lang('a-cache'); ?></em></a>
	</div>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<form method="post" action="" id="myform" name="myform">
		<table width="100%" class="table table-striped">
		<tbody>
		<tr>
			<th width="200"><?php echo lang('a-pos-2'); ?>：</th>
			<td>
			<select name="data[catid]">
			<option value="0" <?php if ($data['catid']==0) { ?>selected<?php } ?>> = <?php echo lang('a-pos-4'); ?> = </option>
			<option value="1" <?php if ($data['catid']==1) { ?>selected<?php } ?>> = <?php echo lang('a-con-29'); ?> = </option>
			</select></td>
		</tr>
		<tr>
			<th><?php echo lang('a-name'); ?>：</th>
			<td><input type="text" class="input-text" size="40" id="name" value="<?php echo $data['name']; ?>" name="data[name]" required /></td>
		</tr>
		<tr>
			<th><?php echo lang('a-pos-6'); ?>：</th>
			<td><input type="text" class="input-text" size="10" id="maxnum" value="<?php echo $data['maxnum']; ?>" name="data[maxnum]" />
			</td>
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
