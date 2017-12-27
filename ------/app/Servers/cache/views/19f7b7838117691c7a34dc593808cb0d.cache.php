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
<title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
		<a href="<?php echo url('admin/model/index',  array('typeid'=>$typeid)); ?>"><em><?php echo lang('a-aut-14'); ?></em></a><span>|</span>
		<a href="<?php echo url('admin/model/add', array('typeid'=>$typeid)); ?>" class="on"><em><?php echo lang('a-add'); ?></em></a><span>|</span>
		<?php if (admin_auth($userinfo['roleid'], 'model-import')) { ?><a href="<?php echo url('admin/model/import', array('typeid'=>$typeid)); ?>"><em><?php echo lang('a-import'); ?></em></a><span>|</span><?php }  if (admin_auth($userinfo['roleid'], 'model-cache')) { ?><a href="<?php echo url('admin/model/cache', array('typeid'=>$typeid)); ?>"><em><?php echo lang('a-cache'); ?></em></a><?php } ?>
	</div>
	<div class="table-list">
		<form action="" method="post">
		<input name="modelid" type="hidden" value="<?php echo $data['modelid']; ?>" />
		<div class="pad-10">
			<div class="col-tab">
				<ul class="tabBut cu-li">
					<li onClick="SwapTab('setting','on','',2,1);" class="on" id="tab_setting_1"><?php echo lang('a-cat-25'); ?></li>
					<?php if ($typeid != 2 && $typeid != 4) { ?><li onClick="SwapTab('setting','on','',2,2);" id="tab_setting_2" class=""><?php echo lang('a-mod-134'); ?></li><?php } ?>
				</ul>
				<div class="contentList pad-10" id="div_setting_1" style="display: block;">
				<table width="100%" class="table_form">
				<tr>
					<th><font color="red">*</font> <?php echo lang('a-mod-19'); ?>： </th>
					<td><input class="input-text" type="text" name="tablename" value="<?php echo $data['tablename']; ?>" size="30" <?php if ($data['modelid']) { ?>disabled<?php } ?> required /><div class="onShow"><?php echo lang('a-mod-20'); ?></div></td>
				</tr>
				<tr>
					<th><font color="red">*</font> <?php echo lang('a-mod-23'); ?>： </th>
					<td><input class="input-text" type="text" name="categorytpl" value="<?php echo $data['categorytpl']; ?>" size="30" /><div class="onShow"><?php echo lang('a-mod-28'); ?>：category.html</div></td>
				</tr>
				<tr>
					<th><font color="red">*</font> <?php echo lang('a-mod-25'); ?>： </th>
					<td><input class="input-text" type="text" name="listtpl" value="<?php echo $data['listtpl']; ?>" size="30" /><div class="onShow"><?php echo lang('a-mod-28'); ?>：list.html</div></td>
				</tr>
				<tr>
					<th><font color="red">*</font> <?php echo lang('a-mod-26'); ?>： </th>
					<td><input class="input-text" type="text" name="showtpl" value="<?php echo $data['showtpl']; ?>" size="30" /><div class="onShow"><?php echo lang('a-mod-28'); ?>：show.html</div>
					</td>
				</tr>
				</table>
				</div>
				<div class="contentList pad-10 hidden" id="div_setting_2" style="display: none;">
				<table width="100%" class="table_form">
				<tr>
					<th width="200"><?php echo lang('a-cat-97'); ?>：</th>
					<td>
					<input name="setting[auth][adminpost]" type="radio" value="0"<?php if ($setting['auth']['adminpost']==0) { ?> checked<?php } ?> onClick="$('#adminpost').hide()" />&nbsp;<?php echo lang('a-cat-51'); ?>
					&nbsp;&nbsp;&nbsp;
					<input name="setting[auth][adminpost]" type="radio" value="1"<?php if ($setting['auth']['adminpost']==1) { ?> checked<?php } ?> onClick="$('#adminpost').show()" />&nbsp;<?php echo lang('a-cat-52'); ?>
					</td>
				</tr>
				<tr id="adminpost" <?php if (!$setting['auth']['adminpost']) { ?>style="display:none"<?php } ?>>
					<th><?php echo lang('a-cat-99'); ?>：</th>
					<td>
						<?php if (is_array($rolemodel)) { $count=count($rolemodel);foreach ($rolemodel as $t) { ?>
						<input name="setting[auth][rolepost][]" type="checkbox" value="<?php echo $t['roleid']; ?>" <?php if ($t['roleid']==1) { ?>disabled<?php }  if (@in_array($t['roleid'], $setting['auth']['rolepost'])) { ?>checked<?php } ?> />
						<?php echo $t['rolename']; ?>&nbsp;
						<?php } } ?>
						<div class="onShow"><?php echo lang('a-mod-135'); ?></div>
					</td>
				</tr>
				<tr>
					<th width="200"><?php echo lang('a-cat-50'); ?>：</th>
					<td>
					<input name="setting[auth][memberpost]" type="radio" value="0"<?php if ($setting['auth']['memberpost']==0) { ?> checked<?php } ?> onClick="$('#memberpost').hide()" />&nbsp;<?php echo lang('a-cat-51'); ?>
					&nbsp;&nbsp;&nbsp;
					<input name="setting[auth][memberpost]" type="radio" value="1"<?php if ($setting['auth']['memberpost']==1) { ?> checked<?php } ?> onClick="$('#memberpost').show()" />&nbsp;<?php echo lang('a-cat-52'); ?>
					</td>
				</tr>
				<tbody id="memberpost" <?php if (!$setting['auth']['memberpost']) { ?>style="display:none"<?php } ?>>
				<tr>
					<th><?php echo lang('a-cat-53'); ?>：</th>
					<td>
						<?php if (is_array($membermodel)) { $count=count($membermodel);foreach ($membermodel as $t) { ?>
						<input name="setting[auth][modelpost][]" type="checkbox" value="<?php echo $t['modelid']; ?>" <?php if (@in_array($t['modelid'], $setting['auth']['modelpost'])) { ?>checked<?php } ?> />
						<?php echo $t['modelname']; ?>&nbsp;
						<?php } } ?>
						<div class="onShow"><?php echo lang('a-mod-135'); ?></div>
					</td>
				</tr>
				<tr>
					<th><?php echo lang('a-cat-55'); ?>：</th>
					<td>
						<?php if (is_array($membergroup)) { $count=count($membergroup);foreach ($membergroup as $t) { ?>
						<input name="setting[auth][grouppost][]" type="checkbox" value="<?php echo $t['id']; ?>" <?php if (@in_array($t['id'], $setting['auth']['grouppost'])) { ?>checked<?php } ?> />
						<?php echo $t['name']; ?>&nbsp;
						<?php } } ?>
						<div class="onShow"><?php echo lang('a-mod-135'); ?></div>
					</td>
				</tr>
				</tbody>
				</table>
				</div>
				<div class="bk15"></div>
				<input type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-submit'); ?>" name="submit" />
			</div>
		</form>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
function SwapTab(name,cls_show,cls_hide,cnt,cur){
	for(i=1;i<=cnt;i++){
		if(i==cur){
			$('#div_'+name+'_'+i).show();
			$('#tab_'+name+'_'+i).attr('class',cls_show);
		}else{
			$('#div_'+name+'_'+i).hide();
			$('#tab_'+name+'_'+i).attr('class',cls_hide);
		}
	}
}
</script>