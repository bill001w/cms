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
<script type="text/javascript" src="<?php echo ADMIN_THEME; ?>js/jquery.min.js"></script> <?php include $this->_include('admin/top.html'); ?>
<title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
		<a href="<?php echo url('admin/linkage/'); ?>" class="on"><em><?php echo lang('a-men-34'); ?></em></a><span>|</span>
		<?php if (admin_auth($userinfo['roleid'], 'linkage-add')) { ?><a href="<?php echo url('admin/linkage/add'); ?>"><em><?php echo lang('a-add'); ?></em></a><span>|</span><?php }  if (admin_auth($userinfo['roleid'], 'linkage-cache')) { ?><a href="<?php echo url('admin/linkage/cache'); ?>"><em><?php echo lang('a-cache'); ?></em></a><?php } ?>
	</div>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<form action="" method="post" name="myform">
		<table width="100%" class="table table-striped">
		<thead>
		<tr>
			<th width="20" align="right"><input name="deletec" id="deletec" type="checkbox" onClick="setC()"></th>
			<th width="30" align="left">ID </th>
			<th width="80" align="left"><?php echo lang('a-lin-10'); ?></th>
			<th width="130" align="left"><?php echo lang('a-lin-11'); ?></th>
			<th width="280" align="left"><?php echo lang('a-lin-12'); ?></th>
			<th align="left"><?php echo lang('a-option'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php if (is_array($data)) { $count=count($data);foreach ($data as $t) { ?>
		<tr height="25">
			<td align="right"><input name="ids[]" type="checkbox" value="<?php echo $t['id']; ?>" class="deletec"></td>
			<td align="left"><?php echo $t['id']; ?></td>
			<td align="left"><?php echo $t['name']; ?></td>
			<td align="left"><input type="text" style="width:90%;" value="{<?php echo 'linkagelist(' . $t['id'] . ')'; ?>}" class="input-text"></td>
			<td align="left"><input type="text" style="width:90%;" value="{<?php echo 'linkageform(' . $t['id'] . ', ' . lang('a-mod-95') . ', ' . lang('a-lin-13') . ', ' . lang('a-lin-14') . ')'; ?>}" class="input-text"></td>
			<td align="left">
			<?php if (admin_auth($userinfo['roleid'], 'linkage-list')) { ?><a href="<?php echo url('admin/linkage/list',array('keyid'=>$t['id'], 'id'=>$t['id'])); ?>"><?php echo lang('a-lin-0'); ?></a> | <?php }  if (admin_auth($userinfo['roleid'], 'linkage-edit')) { ?><a href="<?php echo url('admin/linkage/edit',array('id'=>$t['id'])); ?>"><?php echo lang('a-edit'); ?></a> <?php } ?>
			</td>
		</tr>
		<?php } } ?>
		<tr height="25">
			<td colspan="10" align="left">
			<input <?php if (!admin_auth($userinfo['roleid'], 'linkage-del')) { ?>disabled<?php } ?> type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-del'); ?>" name="submit" onclick="return confirm_del()">&nbsp;</td>
		</tr>
		</tbody>
		</table>
		</form>
	</div>
</div>
<script type="text/javascript">
function setC() {
	if($("#deletec").attr('checked')) {
		$(".deletec").attr("checked",true);
	} else {
		$(".deletec").attr("checked",false);
	}
}

function confirm_del() {
    if (confirm('<?php echo lang('a-confirm'); ?>')) { 
	    document.myform.submit();
		return true; 
	} else {
	    return false;
	}
}
</script>
</body>
</html>