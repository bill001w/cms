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
		<a href="<?php echo url('admin/position'); ?>"><em><?php echo lang('a-men-31'); ?></em></a><span>|</span>
		<a href="<?php echo url('admin/position/list',array('posid'=>$posid)); ?>" class="on"><em><?php echo lang('a-pos-0'); ?></em></a><span>|</span>
		<?php if (admin_auth($userinfo['roleid'], 'position-adddata')) { ?><a href="<?php echo url('admin/position/adddata',array('posid'=>$posid)); ?>"><em><?php echo lang('a-add'); ?></em></a><span>|</span><?php }  if (admin_auth($userinfo['roleid'], 'position-cache')) { ?><a href="<?php echo url('admin/position/cache'); ?>"><em><?php echo lang('a-cache'); ?></em></a><?php } ?>
	</div>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<form action="" method="post" name="myform">
		<input name="form" id="list_form" type="hidden" value="order" />
		<table width="100%" class="table table-striped">
		<thead>
		<tr>
			<th width="20" align="right"><input name="deletec" id="deletec" type="checkbox" onClick="setC()" /></th>
			<th width="45" align="left"><?php echo lang('a-order'); ?></th>
			<th width="50" align="left">ID </th>
			<th width="80" align="left"><?php echo lang('a-con-29'); ?> </th>
			<th width="400" align="left"><?php echo lang('a-con-26'); ?></th>
			<th align="left"><?php echo lang('a-option'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php if (is_array($list)) { $count=count($list);foreach ($list as $t) { ?>
		<tr>
			<td align="right"><input name="del_<?php echo $t['id']; ?>" type="checkbox" class="deletec" /></td>
			<td align="left"><input type="text" name="order_<?php echo $t['id']; ?>" class="input-text" style="width:35px;" value="<?php echo $t[listorder]; ?>" /></td>
			<td align="left"><?php echo $t['id']; ?></td>
			<td align="left"><?php if ($t['catid']) {  echo $cats[$t['catid']]['catname'];  } else { ?><font color="green"><?php echo lang('a-pos-4'); ?></font><?php } ?></td>
			<td align="left"><div style="overflow:hidden;height:22px;width:322px;"><?php if ($t['thumb']) { ?><font color="#FF0000">[<?php echo lang('a-pos-7'); ?>]</font><?php }  echo $t[title]; ?></div></td>
			<td align="left">
			<?php $del = url('admin/position/deldata',array('id'=>$t['id']));?>
			<a href="<?php echo $t['url']; ?>" target="_blank"><?php echo lang('a-cat-23'); ?></a> | 
			<?php if (admin_auth($userinfo['roleid'], 'position-editdata')) { ?><a href="<?php echo url('admin/position/editdata',array('posid'=>$posid,'id'=>$t['id'])); ?>"><?php echo lang('a-edit'); ?></a> <?php } ?>
			</td>
		</tr>
		<?php } } ?>
		<tr>
			<td colspan="6" align="left">
			<input <?php if (!admin_auth($userinfo['roleid'], 'position-editdata')) { ?>disabled<?php } ?> type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-order'); ?>" name="submit_order" onClick="$('#list_form').val('order')" />&nbsp;
			<input <?php if (!admin_auth($userinfo['roleid'], 'position-deldata')) { ?>disabled<?php } ?> type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-del'); ?>" name="submit_del" onClick="return confirm_del()" />&nbsp;<div class="onShow"><?php echo lang('a-pos-8'); ?></div>
			</td>
		</tr>     
		</tbody>
		</table>
		<?php echo $pagelist; ?>
		</form>
	</div>
</div>
<script type="text/javascript">
function confirm_del() {
    if (confirm('<?php echo lang('a-confirm'); ?>')) {
		$('#list_form').val('del');
		return true; 
	} else {
	    return false;
	}
}
function setC() {
	if($("#deletec").attr('checked')) {
		$(".deletec").attr("checked",true);
	} else {
		$(".deletec").attr("checked",false);
	}
}
</script>
</body>
</html>