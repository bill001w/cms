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
<script type="text/javascript">
function ajaxletter() {
	var letter = $('#letter').val();
	if (letter == '') {
	    $.post(sitepath+'?c=api&a=pinyin&id='+Math.random(), { name:$('#name').val() }, function(data){ $('#letter').val(data); });
	}
}
</script>	<?php include $this->_include('admin/top.html'); ?>
<title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
		<a href="<?php echo url('admin/tag'); ?>"><em><?php echo lang('a-men-32'); ?></em></a><span>|</span>
		<a href="<?php echo url('admin/tag/add'); ?>" class="on"><em><?php echo lang('a-add'); ?></em></a><span>|</span>
		<?php if (admin_auth($userinfo['roleid'], 'tag-cache')) { ?><a href="<?php echo url('admin/tag/cache'); ?>"><em><?php echo lang('a-cache'); ?></em></a><span>|</span><?php }  if (admin_auth($userinfo['roleid'], 'tag-import')) { ?><a href="<?php echo url('admin/tag/import'); ?>"><em><?php echo lang('a-import'); ?></em></a><?php } ?>
	</div>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<form action="" method="post">
		<input name="id" type="hidden" value="<?php echo $data['id']; ?>">
			<table class="table table-striped" width="100%">
		<tr>
			<th width="200"><?php echo lang('a-name'); ?>： </th>
			<td><input class="input-text" type="text" name="data[name]" value="<?php echo $data['name']; ?>" size="30" id="name" onBlur="ajaxletter()" required /></td>
		</tr>
            <tr>
			<th width="200"><?php echo lang('a-tag-ex-1'); ?>： </th>
			<td><select name="data[catid]" id="">
                <?php if (is_array($category)) { $count=count($category);foreach ($category as $cat) { ?>
                <option value="<?php echo $cat['catid']; ?>" <?php if ($cat['catid'] == $data['catid']) { ?>
                    selected
                <?php } ?>><?php echo $cat['catname']; ?></option>
                <?php } } ?>
            </select></td>
		</tr>
		<tr>
			<th><?php echo lang('a-tag-8'); ?>： </th>
			<td><input class="input-text" type="text" name="data[letter]" value="<?php echo $data['letter']; ?>" id="letter" size="30"/></td>
		</tr>
		<tr>
			<th><?php echo lang('a-tag-9'); ?>： </th>
			<td><input class="input-text" type="text" name="data[listorder]" value="<?php echo $data['listorder']; ?>" size="10"/>
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