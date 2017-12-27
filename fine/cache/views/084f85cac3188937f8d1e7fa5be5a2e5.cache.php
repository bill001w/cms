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
<script type="text/javascript">var sitepath = "<?php echo SITE_PATH;  echo ENTRY_SCRIPT_NAME; ?>";</script>
<script type="text/javascript" src="<?php echo LANG_PATH; ?>lang.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_THEME; ?>js/core.js"></script><?php include $this->_include('admin/top.html'); ?>
<script type="text/javascript">
function ajaxemail() {
	$('#email_text').html('');
	$.post('<?php echo url('admin/member/ajaxemail'); ?>&rid='+Math.random(), { email:$('#email').val() }, function(data){ 
        $('#email_text').html(data); 
	});
}
function ajaxusername() {
	$('#username_text').html('');
	$.post('<?php echo url('admin/member/ajaxusername'); ?>&rid='+Math.random(), { username:$('#username').val() }, function(data){ 
        $('#username_text').html(data); 
	});
}
</script>
<title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
		<a href="<?php echo url('admin/member/index'); ?>" <?php if ($status==0) { ?>class="on"<?php } ?>><em><?php echo lang('a-mem-26'); ?>(<?php echo $count[0]; ?>)</em></a><span>|</span>
		<a href="<?php echo url('admin/member/index', array('status'=>1)); ?>" <?php if ($status==1) { ?>class="on"<?php } ?>><em><?php echo lang('a-con-20'); ?>(<?php echo $count[1]; ?>)</em></a><span>|</span>
		<a href="<?php echo url('admin/member/index', array('status'=>2)); ?>" <?php if ($status==2) { ?>class="on"<?php } ?>><em><?php echo lang('a-con-21'); ?>(<?php echo $count[2]; ?>)</em></a><span>|</span>
		<a href="<?php echo url('admin/member/reg'); ?>" class="on"><em><?php echo lang('a-mem-27'); ?></em></a>
    </div>
    <div class="bk10"></div>
	<div class="table-responsive mytable">
		<form method="post" action="" id="myform" name="myform">
		<?php if ($uc) { ?>
		<table width="100%" class="table table-striped">
		<tr>
			<th width="200"><?php echo lang('a-mem-49'); ?>：</th>
			<td><?php echo lang('a-mem-50'); ?></td>
		</tr>
		<tr>
			<th><?php echo lang('a-mem-51'); ?>：</th>
			<td><a href="<?php echo UC_API; ?>" target="_blank"><?php echo UC_API; ?></a></td>
		</tr>
		</table>
		<?php } else { ?>
		<table width="100%" class="table_form">
		<tr>
			<th width="200"><?php echo lang('a-mem-29'); ?>：</th>
			<td>
			<select name="modelid">
			<?php if (is_array($model)) { $count=count($model);foreach ($model as $t) { ?>
			<option value="<?php echo $t['modelid']; ?>"><?php echo $t['modelname']; ?></option>
			<?php } } ?>
			</select>
			</td>
		</tr>
		<tr>
			<th><?php echo lang('a-mem-52'); ?>：</th>
			<td>
			   <input type="radio" value="0" name="addall" onclick='$("#more").hide();$("#one").show();' checked> <?php echo lang('a-no'); ?>&nbsp;&nbsp;
			   <input type="radio" value="1" name="addall" onclick='$("#more").show();$("#one").hide();'> <?php echo lang('a-yes'); ?>
			</td>
		</tr>
		<tbody id="more" style="display:none">
		<tr>
			<th><?php echo lang('a-mem-53'); ?>：</th>
			<td><textarea style="width:300px;height:210px" name="members"></textarea><br>
			<div class="onShow" style="clear:both;margin-top:5px;"><?php echo lang('a-mem-54'); ?></div>
			</td>
		</tr>
		</tbody>
		<tbody id="one">
		<tr>
			<th><?php echo lang('a-mem-55'); ?>：</th>
			<td><input type="text" class="input-text" size="30" id="username" value="" name="data[username]" onBlur="ajaxusername()">
			<div class="onShow" id="username_text"></div>
			</td>
		</tr>
		<tr>
			<th><?php echo lang('a-mem-56'); ?>：</th>
			<td><input type="text" class="input-text" size="30" value="" name="data[password]"></td>
		</tr>
		<tr>
			<th><?php echo lang('a-mem-39'); ?>：</th>
			<td><input type="text" class="input-text" size="30" id="email" value="" name="data[email]" onBlur="ajaxemail()">
			<div class="onShow" id="email_text"></div>
			</td>
		</tr>
		</tbody>
		<tr>
			<th><?php echo lang('a-mem-44'); ?>：</th>
			<td>
			<input type="radio" value="1" name="data[status]" checked> <?php echo lang('a-con-20'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" value="0" name="data[status]"> <?php echo lang('a-con-21'); ?>
			</td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td><input type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-submit'); ?>" name="submit"></td>
		</tr>
		</table>
		<?php } ?>
		</form>
	</div>
</div>
</body>
</html>
