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
	$.post('<?php echo url('admin/member/ajaxemail'); ?>&rid='+Math.random(), { email:$('#email').val(), id:<?php echo $id; ?> }, function(data){ 
        $('#email_text').html(data); 
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
		<a href="<?php echo url('admin/member/reg'); ?>"><em><?php echo lang('a-mem-27'); ?></em></a><span>|</span>
        <a href="<?php echo url('admin/member/edit', array('id'=>$id)); ?>" class="on"><em><?php echo lang('a-mem-34'); ?></em></a>
    </div>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<form method="post" action="" id="myform" name="myform">
		<table width="100%" class="table table-striped">
		<tbody>
		<tr>
			<th width="200"><?php echo lang('a-user'); ?>：</th>
			<td><?php echo $data['username']; ?>&nbsp;&nbsp;<?php if ($model) { ?>(<?php echo $model['modelname']; ?>)<?php } ?></td>
		</tr>
		<tr>
			<th><?php echo lang('a-mem-30'); ?>：</th>
			<td><select name="data[groupid]">
			<?php if (is_array($group)) { $count=count($group);foreach ($group as $t) { ?>
			<option value="<?php echo $t['id']; ?>" <?php if ($data['groupid']==$t['id']) { ?>selected<?php } ?>><?php echo $t['name']; ?></option>
			<?php } } ?>
			</select><div class="onShow"><?php echo lang('a-mem-36'); ?></div></td>
		</tr>
		<tr>
			<th><?php echo lang('a-mem-37'); ?>：</th>
			<td><input type="text" class="input-text" size="30" value="" name="password">
			<div class="onShow"><?php echo lang('a-mem-38'); ?></div></td>
		</tr>
		<tr>
			<th><?php echo lang('a-mem-39'); ?>：</th>
			<td><input type="text" class="input-text" size="30" id="email" value="<?php echo $data['email']; ?>" name="data[email]"onBlur="ajaxemail()">
			<div class="onShow" id="email_text"></div>
			</td>
		</tr>
		<tr>
			<th><?php echo lang('a-mem-40'); ?>：</th>
			<td><input type="text" class="input-text" size="30" value="<?php echo $data['nickname']; ?>" name="data[nickname]"></td>
		  </tr>
		<tr>
			<th><?php echo lang('a-mem-41'); ?>：</th>
			<td><input type="text" class="input-text" size="30" value="<?php echo $data['credits']; ?>" name="data[credits]">
			<div class="onShow"><?php echo lang('a-mem-42'); ?></div></td>
		  </tr>
		<tr>
			<th><?php echo lang('a-mem-43'); ?>：</th>
			<td><?php echo formatFileSize(count_member_size($data['id'])); ?></td>
		</tr>
		<tr>
			<th><?php echo lang('a-mem-32'); ?>：</th>
			<td><?php echo date(TIME_FORMAT, $data['regdate']); ?></td>
		  </tr>
		<tr>
			<th><?php echo lang('a-mem-33'); ?>：</th>
			<td><a href="http://www.baidu.com/baidu?wd=<?php echo $data['regip']; ?>" target=_blank><?php echo $data['regip']; ?></a></td>
		</tr>
		<tr>
			<th><?php echo lang('a-mod-162'); ?>：</th>
			<td><?php echo date(TIME_FORMAT, $data['logintime']); ?></td>
		  </tr>
		<tr>
			<th><?php echo lang('a-mod-163'); ?>：</th>
			<td><a href="http://www.baidu.com/baidu?wd=<?php echo $data['loginip']; ?>" target=_blank><?php echo $data['loginip']; ?></a></td>
		</tr>
		<?php if ($oauth) { ?>
		<tr>
			<th><?php echo lang('a-men-44'); ?>：</th>
			<td>
				<table>
				<thead>
					<tr>
						<td width="150"><?php echo lang('a-mem-45'); ?></td>
						<td width="140"><?php echo lang('a-mem-46'); ?></td>
						<td width="140"><?php echo lang('a-mem-47'); ?></td>
						<td width="60"><?php echo lang('a-mem-48'); ?></td>
					</tr>
				</thead>
				<tbody>
				 <?php if (is_array($oauth)) { $count=count($oauth);foreach ($oauth as $t) { ?>
				  <tr>
					<td><?php echo $t['nickname']; ?></td>
					<td><?php echo date(TIME_FORMAT, $t['addtime']); ?></td>
					<td><?php if ($t['logintimes']) {  echo date(TIME_FORMAT, $t['logintimes']);  } ?></td>
					<td><?php echo $t['oauth_name']; ?></td>
				  </tr>
				  <?php } } ?>
				</tbody>
				</table>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<th><?php echo lang('a-mem-44'); ?>：</th>
			<td>
			<input type="radio" <?php if (!isset($data['status']) || $data['status']==1) { ?>checked<?php } ?> value="1" name="data[status]"> <?php echo lang('a-con-20'); ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" <?php if (isset($data['status']) && $data['status']==0) { ?>checked<?php } ?> value="0" name="data[status]"> <?php echo lang('a-con-21'); ?>
			</td>
		</tr>
		<?php if ($model) {  echo $data_fields;  } ?>
		<tr>
			<th>&nbsp;</th>
			<td><input type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-submit'); ?>" name="submit"></td>
		</tr>
		</tbody>
		</table>
		</form>
	</div>
</div>
</body>
</html>
