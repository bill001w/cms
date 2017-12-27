<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/system.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/main.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css" />
	<?php include $this->_include('admin/top.html'); ?>
<link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet"><link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="/views/admin/js/dialog.js"></script>
<title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
		<a href="<?php echo url('admin/tag'); ?>" class="on"><em><?php echo lang('a-men-32'); ?></em></a><span>|</span>
		<?php if (admin_auth($userinfo['roleid'], 'tag-add')) { ?><a href="<?php echo url('admin/tag/add'); ?>"><em><?php echo lang('a-add'); ?></em></a><span>|</span><?php }  if (admin_auth($userinfo['roleid'], 'tag-cache')) { ?><a href="<?php echo url('admin/tag/cache'); ?>"><em><?php echo lang('a-cache'); ?></em></a><span>|</span><?php }  if (admin_auth($userinfo['roleid'], 'tag-import')) { ?><a href="<?php echo url('admin/tag/import'); ?>"><em><?php echo lang('a-import'); ?></em></a><?php } ?>
	</div>
	<div class="bk10"></div>
	<div class="explain-col">
		<form action="" method="post">
		<?php echo lang('a-name'); ?>：<input type="text" class="input-text" size="20" name="kw" />
		&nbsp;&nbsp;
		<input type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-search'); ?>" name="submit" />&nbsp;&nbsp;
		</form>
	</div>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<form action="" method="post" name="myform">
		<input name="form" id="list_form" type="hidden" value="del" />
			<table class="table table-striped" width="100%">
		<thead>
		<tr>
			<th width="20" align="right"><input name="deletec" id="deletec" type="checkbox" onClick="setC()" />&nbsp;</th>
			<th width="150" align="left"><?php echo lang('a-name'); ?></th>
			<th width="150" align="left"><?php echo lang('a-tag-8'); ?></th>
			<th width="150" align="left"><?php echo lang('a-tag-ex-1'); ?></th>
			<th width="80" align="left"><?php echo lang('a-order'); ?></th>
			<th align="left"><?php echo lang('a-option'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php if (is_array($list)) { $count=count($list);foreach ($list as $t) { ?>
		<tr >
			<td align="right"><input name="del_<?php echo $t['id']; ?>" type="checkbox" class="deletec" />&nbsp;</td>
			<td align="left"><input class="input-text" type="text" name="data[<?php echo $t['id']; ?>][name]" value="<?php echo $t['name']; ?>" size="20"/></td>
			<td align="left"><input class="input-text" type="text" name="data[<?php echo $t['id']; ?>][letter]" value="<?php echo $t['letter']; ?>" size="20"/></td>
			<td align="left">
                <select class="input-text"  name="data[<?php echo $t['id']; ?>][catid]">
                    <option value="0" <?php if (!$data['catid']) { ?>
                        selected
                    <?php } ?>>--</option>
                    <?php if (is_array($category)) { $count=count($category);foreach ($category as $cat) { ?>
                    <option value="<?php echo $cat['catid']; ?>"<?php if ($t['catid'] == $cat['catid']) { ?>
                        selected
                    <?php } ?> ><?php echo $cat['catname']; ?></option>
                    <?php } } ?>
                </select>
            </td>
			<td align="left"><input class="input-text" type="text" name="data[<?php echo $t['id']; ?>][listorder]" value="<?php echo $t['listorder']; ?>" size="5"/></td>
			<td align="left">
			<?php $del = url('admin/tag/del',array('id'=>$t['id']));?>
			<a href="<?php echo $site_url;  echo tag_url($t['name']); ?>" target="_blank"><?php echo lang('a-cat-23'); ?></a> | 
			<?php if (admin_auth($userinfo['roleid'], 'tag-edit')) { ?><a href="<?php echo url('admin/tag/edit',array('id'=>$t['id'])); ?>"><?php echo lang('a-edit'); ?></a> | <?php }  if (admin_auth($userinfo['roleid'], 'tag-del')) { ?><a href="javascript:;" onClick="if(confirm('<?php echo lang('a-confirm'); ?>')){ window.location.href='<?php echo $del; ?>'; }"><?php echo lang('a-del'); ?></a><?php } ?>
			</td>
		</tr>
		<?php } } ?>
		<tr >
			<td colspan="6" align="left">
			<input <?php if (!admin_auth($userinfo['roleid'], 'tag-del')) { ?>disabled<?php } ?> type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-del'); ?>" name="submit_del" onClick="$('#list_form').val('del');return confirm_del()" />&nbsp;
			<input <?php if (!admin_auth($userinfo['roleid'], 'tag-edit')) { ?>disabled<?php } ?> type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-gx'); ?>" name="submit_update" onClick="$('#list_form').val('update')" />&nbsp;
			<div class="onShow"><?php echo lang('a-tag-7'); ?></div>
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