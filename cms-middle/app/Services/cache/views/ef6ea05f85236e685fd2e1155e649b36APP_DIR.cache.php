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
<script type="text/javascript" src="/views/admin/js/jquery.min.js"></script><?php include $this->_include('admin/top.html'); ?>
<script type="text/javascript">
function del(id) {
	if(confirm('<?php echo lang('a-mod-16'); ?>')){
		var url = "<?php echo url('admin/model/del'); ?>"+ "/" + id;
		window.location.href=url;
	}
}
</script>
<title>admin</title>
</head>
<body>
<form action="" method="post">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
		<a href="<?php echo url('admin/model/index',  array('typeid'=>$typeid)); ?>" class="on"><em><?php echo lang('a-aut-14'); ?></em></a><span>|</span>
		<?php if (admin_auth($userinfo['roleid'], 'model-add')) { ?><a href="<?php echo url('admin/model/add', array('typeid'=>$typeid)); ?>"><em><?php echo lang('a-add'); ?></em></a><span>|</span><?php }  if (admin_auth($userinfo['roleid'], 'model-cache')) { ?><a href="<?php echo url('admin/model/cache', array('typeid'=>$typeid)); ?>"><em><?php echo lang('a-cache'); ?></em></a><?php } ?>
	</div>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<table width="100%" class="table table-striped">
			<thead>
			<tr>
				<th width="50" align="center">ID</th>
				<th width="200" align="left"><?php echo lang('a-mod-19'); ?></th>
				<th align="left"><?php echo lang('a-option'); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if (is_array($list)) { $count=count($list);foreach ($list as $t) {  $setting=string2array($t['setting']);$disable = isset($setting['disable']) && $setting['disable'] == 1 ? 1 : 0; ?>
			<tr>
				<td align="left"><?php echo $t['modelid']; ?></td>
				<td align="left"><?php echo $t['tablename']; ?></td>
				<td align="left">
				<?php if (admin_auth($userinfo['roleid'], 'model-edit')) { ?><a href="<?php echo url('admin/model/edit',array('modelid'=>$t['modelid'])); ?>"><?php echo lang('a-edit'); ?></a> | <?php }  if (admin_auth($userinfo['roleid'], 'model-del')) { ?><a href="javascript:del(<?php echo $t['modelid']; ?>);"><?php echo lang('a-del'); ?></a> <?php } ?>
				</td>
			</tr>
			<?php } } ?>
			<tbody>
		</table>
	</div>
</div>
</body>
</html>