<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link href="<?php echo ADMIN_THEME; ?>images/reset.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ADMIN_THEME; ?>images/system.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ADMIN_THEME; ?>images/dialog.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ADMIN_THEME; ?>images/switchbox.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo ADMIN_THEME; ?>luos/css/style.min.css?v=4.1.0" rel="stylesheet"><link href="<?php echo ADMIN_THEME; ?>images/table_form.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo ADMIN_THEME; ?>luos/css/style.min.css?v=4.1.0" rel="stylesheet">
	<script type="text/javascript" src="<?php echo ADMIN_THEME; ?>js/jquery.min.js"></script>
	<script type="text/javascript">
		var sitepath = "<?php echo SITE_PATH;  echo ENTRY_SCRIPT_NAME; ?>";
		var finecms_admin_document = "<?php echo $setting['document']; ?>";
	</script>
	<script type="text/javascript" src="<?php echo LANG_PATH; ?>lang.js"></script>
	<script type="text/javascript" src="<?php echo ADMIN_THEME; ?>js/core.js"></script>
	<script type="text/javascript">
		function ajaxdir() {
			var dir = $('#dir_text').val();
			if (dir == '') {
				$.post(sitepath+'?c=api&a=pinyin&id='+Math.random(), { name:$('#dir').val() }, function(data){ $('#dir_text').val(data); });
			}
		}
	</script>
	<title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
		<a href="<?php echo url('admin/category/'); ?>"><em><?php echo lang('a-cat-12'); ?></em></a><span>|</span>
		<a href="<?php echo url('admin/category/add'); ?>" class="on"><em><?php echo lang('a-cat-13'); ?></em></a><span>|</span>
		<?php if (admin_auth($userinfo['roleid'], 'category-url')) { ?><a href="<?php echo url('admin/category/url'); ?>"><em><?php echo lang('a-cat-14'); ?></em></a><span>|</span><?php }  if (admin_auth($userinfo['roleid'], 'category-cache')) { ?><a href="<?php echo url('admin/category/cache'); ?>"><em><?php echo lang('a-cache'); ?></em></a><?php } ?>
	</div>
	<div class="table-list">
		<form method="post" action="" id="myform" name="myform">
			<input type="hidden" value="<?php echo $catid; ?>" name="catid" />
			<input type="hidden" value="<?php echo $data['typeid']; ?>" name="typeid" />
			<div class="pad-10">
				<div class="col-tab">
					<ul class="tabBut cu-li">
						<li onClick="SwapTab('setting','on','',5,1);" class="on" id="tab_setting_1"><?php echo lang('a-cat-25'); ?></li>
						<li onClick="SwapTab('setting','on','',5,2);" id="tab_setting_2" class=""><?php echo lang('a-cat-26'); ?></li>
						<li onClick="SwapTab('setting','on','',5,3);" id="tab_setting_3" class=""><?php echo lang('a-cat-27'); ?></li>
						<li onClick="SwapTab('setting','on','',5,4);" id="tab_setting_4" class=""><?php echo lang('a-cat-28'); ?></li>
					</ul>
					<div class="contentList pad-10" id="div_setting_1" style="display: block;">
						<table width="100%" class="table_form">
							<tbody>
							<tr>
								<th><font color="red">*</font> <?php echo lang('a-cat-32'); ?>：</th>
								<td>
									<select id="parentid" name="data[parentid]">
										<option value="0"><?php echo lang('a-cat-33'); ?></option>
										<?php echo $category_select; ?>
									</select>
								</td>
							</tr>
							<?php if ($add) { ?>
							<tr>
								<th><?php echo lang('a-cat-34'); ?>：</th>
								<td>
									<input type="radio" value="0" name="addall" onclick='$("#addall").hide();$("#_addall").show();' checked /> <?php echo lang('a-no'); ?>&nbsp;&nbsp;
									<input type="radio" value="1" name="addall" onclick='$("#addall").show();$("#_addall").hide();' /> <?php echo lang('a-yes'); ?>
								</td>
							</tr>
							<tbody id='addall' style="display:none">
							<tr>
								<th><font color="red">*</font> <?php echo lang('a-cat-15'); ?>：</th>
								<td><textarea style="width:200px;height:110px" name="names" /></textarea>
									<div class="onShow"><?php echo lang('a-cat-35'); ?></div>
								</td>
							</tr>
							</tbody>
							<?php } ?>
							<tbody id='_addall'>
							<tr>
								<th><font color="red">*</font> <?php echo lang('a-cat-15'); ?>：</th>
								<td><input type="text" class="input-text" size="25" value="<?php echo $data['catname']; ?>" name="data[catname]" id="dir" onBlur="ajaxdir()" /></td>
							</tr>
							<tr>
								<th><font color="red">*</font> <?php echo lang('a-cat-36'); ?>：</th>
								<td><input type="text" class="input-text" size="25" value="<?php echo $data['catdir']; ?>" name="data[catdir]" id="dir_text" /></td>
							</tr>
							<tr>
								<th><?php echo lang('a-mod-201'); ?>：</th>
								<td><input type="text" class="input-text" size="25" value="<?php echo $setting['document']; ?>" name="setting[document]" onBlur="set_document(this.value)" />
									<div id="result_document" class="onShow"><?php echo lang('a-mod-202'); ?></div></td>
							</tr>
							<tr>
								<th><?php echo lang('a-cat-37'); ?>：</th>
								<td><input type="text" class="input-text" size="50" value="<?php echo $data['image']; ?>" name="data[image]" id="image" />
									<input type="button" style="width:66px;cursor:pointer;" class="btn btn-success btn-sm" onClick="preview('image')" value="<?php echo lang('a-image'); ?>" />
									<input type="button" style="width:66px;cursor:pointer;" class="btn btn-success btn-sm" onClick="uploadImage('image')" value="<?php echo lang('a-upload'); ?>" />
									<div class="onShow"><?php echo lang('a-pic'); ?></div>
								</td>
							</tr>
							</tbody>
							<tr>
								<th><?php echo lang('a-cat-38'); ?>：</th>
								<td>
									<input type="radio" <?php if (!isset($data['ismenu']) || $data['ismenu']==1) { ?>checked<?php } ?> value="1" name="data[ismenu]" /> <?php echo lang('a-yes'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" <?php if (isset($data['ismenu']) && $data['ismenu']==0) { ?>checked<?php } ?> value="0" name="data[ismenu]" /> <?php echo lang('a-no'); ?>
									<div class="onShow"><?php echo lang('a-cat-39'); ?></div>
								</td>
							</tr>
							<tr>
								<th><?php echo lang('a-cat-58'); ?>： </th>
								<td><input name="setting[url][tohtml]" type="radio" value="1" <?php if ($setting['url']['tohtml']) { ?>checked<?php } ?> onClick="$('#html').show()"> <?php echo lang('a-yes'); ?>
									&nbsp;&nbsp;&nbsp;
									<input name="setting[url][tohtml]" type="radio" value="0" <?php if (!$setting['url']['tohtml']) { ?>checked<?php } ?> onClick="$('#html').hide()"> <?php echo lang('a-no'); ?> </td>
							</tr>
							<tr id="html" style="display:<?php if ($setting['url']['tohtml']) { ?>table-row<?php } else { ?>none<?php } ?>">
								<th><?php echo lang('a-cat-59'); ?>： </th>
								<td><input class="input-text" type="text" name="setting[url][htmldir]" value="<?php if (isset($setting['url']['htmldir'])) {  echo $setting['url']['htmldir'];  } else { ?>html<?php } ?>" size="15"/>
									<div class="onShow"><?php echo lang('a-cat-60'); ?></div>
								</td>
							</tr>
							<?php include $this->_include('admin/category_filed'); ?>
							</tbody>
						</table>
					</div>
					<div class="contentList pad-10 hidden" id="div_setting_2" style="display: none;">
						<table width="100%" class="table_form ">
							<tbody>
							<tr>
								<th width="200"><?php echo lang('a-cat-42'); ?>：</th>
								<td>
									<input type="text" class="input-text" size="30" value="<?php echo $data['pagesize']; ?>" name="data[pagesize]">
									<div class="onShow"><?php echo lang('a-cat-43'); ?></div>
								</td>
							</tr>
							<tr>
								<th><?php echo lang('a-cat-44'); ?>：</th>
								<td id="category_template">
									<input type="text" class="input-text" size="30" value="<?php echo $data['categorytpl']; ?>" name="data[categorytpl]" id="categorytpl">
								</td>
							</tr>
							<tr>
								<th><?php echo lang('a-cat-45'); ?>：</th>
								<td id="list_template">
									<input type="text" class="input-text" size="30" value="<?php echo $data['listtpl']; ?>" name="data[listtpl]" id="listtpl">
								</td>
							</tr>
							<tr>
								<th><?php echo lang('a-cat-46'); ?>：</th>
								<td id="show_template">
									<input type="text" class="input-text" size="30" value="<?php echo $data['showtpl']; ?>" name="data[showtpl]" id="showtpl">
								</td>
							</tr>
							</tbody>
						</table>
					</div>
					<div class="contentList pad-10 hidden" id="div_setting_3" style="display: none;">
						<table width="100%" class="table_form ">
							<tbody>
							<tr>
								<th width="200"><?php echo lang('a-cat-47'); ?>：</th>
								<td><input type="text" maxlength="60" size="60" value="<?php echo $data['meta_title']; ?>" id="meta_title" name="data[meta_title]" class="input-text"></td>
							</tr>
							<tr>
								<th><?php echo lang('a-cat-48'); ?>：</th>
								<td><textarea style="width:90%;height:40px" id="meta_keywords" name="data[meta_keywords]"><?php echo $data['meta_keywords']; ?></textarea></td>
							</tr>
							<tr>
								<th><?php echo lang('a-cat-49'); ?>：</th>
								<td><textarea style="width:90%;height:50px" id="meta_description" name="data[meta_description]"><?php echo $data['meta_description']; ?></textarea></td>
							</tr>
							</tbody>
						</table>
					</div>
					<div class="contentList pad-10 hidden" id="div_setting_4" style="display: none;">
						<table width="100%" class="table_form">
							<?php if ($data['child']) { ?>
							<tr>
								<th width="200"><?php echo lang('a-cat-91'); ?>：</th>
								<td>
									<input name="data[synpost]" type="checkbox" value="1" checked="" />&nbsp;&nbsp;<?php echo lang('a-yes'); ?>
								</td>
							</tr>
							<?php } ?>
							<tr>
								<th width="200"><?php echo lang('a-mod-215'); ?>：</th>
								<td>
									<input name="setting[verifypost]" type="radio" value="0"<?php if ($setting['verifypost']==0) { ?> checked<?php } ?> onClick="$('#verifypost').hide()">&nbsp;<?php echo lang('a-mod-216'); ?>
									&nbsp;&nbsp;&nbsp;
									<input name="setting[verifypost]" type="radio" value="1"<?php if ($setting['verifypost']==1) { ?> checked<?php } ?> onClick="$('#verifypost').show()">&nbsp;<?php echo lang('a-mod-217'); ?>
								</td>
							</tr>
							<tr id="verifypost" <?php if (!$setting['verifypost']) { ?>style="display:none"<?php } ?>>
							<th><?php echo lang('a-cat-99'); ?>：</th>
							<td>
								<?php if (is_array($rolemodel)) { $count=count($rolemodel);foreach ($rolemodel as $t) { ?>
								<input name="setting[verifyrole][]" type="checkbox" value="<?php echo $t['roleid']; ?>" <?php if ($t['roleid']==1) { ?>disabled<?php }  if (@in_array($t['roleid'], $setting['verifyrole'])) { ?>checked<?php } ?> />
								<?php echo $t['rolename']; ?>&nbsp;
								<?php } } ?>
								<div class="onShow"><?php echo lang('a-mod-218'); ?></div>
							</td>
							</tr>
							<tr>
								<th><?php echo lang('a-cat-97'); ?>：</th>
								<td>
									<input name="setting[adminpost]" type="radio" value="0"<?php if ($setting['adminpost']==0) { ?> checked<?php } ?> onClick="$('#adminpost').hide()">&nbsp;<?php echo lang('a-cat-51'); ?>
									&nbsp;&nbsp;&nbsp;
									<input name="setting[adminpost]" type="radio" value="1"<?php if ($setting['adminpost']==1) { ?> checked<?php } ?> onClick="$('#adminpost').show()">&nbsp;<?php echo lang('a-cat-52'); ?>
								</td>
							</tr>
							<tr id="adminpost" <?php if (!$setting['adminpost']) { ?>style="display:none"<?php } ?>>
							<th><?php echo lang('a-cat-99'); ?>：</th>
							<td>
								<?php if (is_array($rolemodel)) { $count=count($rolemodel);foreach ($rolemodel as $t) { ?>
								<input name="setting[rolepost][]" type="checkbox" value="<?php echo $t['roleid']; ?>" <?php if ($t['roleid']==1) { ?>disabled<?php }  if (@in_array($t['roleid'], $setting['rolepost'])) { ?>checked<?php } ?> />
								<?php echo $t['rolename']; ?>&nbsp;
								<?php } } ?>
								<div class="onShow"><?php echo lang('a-cat-98'); ?></div>
							</td>
							</tr>
							<tr>
								<th><?php echo lang('a-cat-50'); ?>：</th>
								<td>
									<input name="setting[memberpost]" type="radio" value="0"<?php if ($setting['memberpost']==0) { ?> checked<?php } ?> onClick="$('#memberpost').hide()">&nbsp;<?php echo lang('a-cat-51'); ?>
									&nbsp;&nbsp;&nbsp;
									<input name="setting[memberpost]" type="radio" value="1"<?php if ($setting['memberpost']==1) { ?> checked<?php } ?> onClick="$('#memberpost').show()">&nbsp;<?php echo lang('a-cat-52'); ?>
								</td>
							</tr>
							<tbody id="memberpost" <?php if (!$setting['memberpost']) { ?>style="display:none"<?php } ?>>
							<tr>
								<th><?php echo lang('a-cat-53'); ?>：</th>
								<td>
									<?php if (is_array($membermodel)) { $count=count($membermodel);foreach ($membermodel as $t) { ?>
									<input name="setting[modelpost][]" type="checkbox" value="<?php echo $t['modelid']; ?>" <?php if (@in_array($t['modelid'], $setting['modelpost'])) { ?>checked<?php } ?> />
									<?php echo $t['modelname']; ?>&nbsp;
									<?php } } ?>
									<div class="onShow"><?php echo lang('a-cat-54'); ?></div>
								</td>
							</tr>
							<tr>
								<th><?php echo lang('a-cat-55'); ?>：</th>
								<td>
									<?php if (is_array($membergroup)) { $count=count($membergroup);foreach ($membergroup as $t) { ?>
									<input name="setting[grouppost][]" type="checkbox" value="<?php echo $t['id']; ?>" <?php if (@in_array($t['id'], $setting['grouppost'])) { ?>checked<?php } ?> />
									<?php echo $t['name']; ?>&nbsp;
									<?php } } ?><div class="onShow"><?php echo lang('a-cat-56'); ?></div>
								</td>
							</tr>
							</tbody>
							<tr>
								<th><?php echo lang('a-cat-92'); ?>：</th>
								<td>
									<input name="setting[guestpost]" type="radio" value="1"<?php if ($setting['guestpost']) { ?> checked<?php } ?> onClick="$('#guestpost').show();$('#_guestpost').val(1);">&nbsp;<?php echo lang('a-cat-51'); ?>
									&nbsp;&nbsp;&nbsp;
									<input name="setting[guestpost]" type="radio" value="0"<?php if (!isset($setting['guestpost']) || $setting['guestpost']==0) { ?> checked<?php } ?> onClick="$('#guestpost').hide();$('#_guestpost').val(0);">&nbsp;<?php echo lang('a-cat-52'); ?>
								</td>
							</tr>
							<tr id="guestpost"  style="<?php if (empty($setting['guestpost'])) { ?>display:none;<?php } ?>">
								<th><?php echo lang('a-cat-93'); ?>：</th>
								<td>
									<input class="input-text" id="_guestpost" type="text" name="setting[guestpost]" value="<?php echo $setting['guestpost']; ?>" size="10"/>
								</td>
							</tr>
						</table>
					</div>
					<div class="bk15"></div>
					<input type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-submit'); ?>" name="submit" />
				</div>
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

	var data = '';//<?php echo $json_model; ?>;

	function settype(id) {
		$(".type_1").hide();
		$(".type_2").hide();
		$(".type_3").hide();
		$(".type_4").hide();
		$(".type_"+id).show();
		if (id ==2) {
			var page = $("#showtpl").val();
			if (page) {}
			else {
				$("#showtpl").val("page.html")
			}
		}
	}

	function change_tpl(mid) {
		$("#categorytpl").val(data[mid]['categorytpl']);
		$("#listtpl").val(data[mid]['listtpl']);
		$("#showtpl").val(data[mid]['showtpl']);
	}
	settype(<?php echo $data[typeid]; ?>);

	function setURL(id) {
		if (id) {
			$("#url").show();
		} else {
			$("#url").hide();
		}
	}
	setURL(<?php echo $setting['url']['use']; ?>);

	function win_category() {
		var body = '<style>.table-list td,.table-list th{ padding-left:12px; font-weight:normal;}.table-list thead th{ height:30px; background:#eef3f7; border-bottom:1px solid #d5dfe8; font-weight:normal}.table-list tbody td,.table-list .btn{ border-bottom: #eee 1px solid; padding-top:5px; padding-bottom:5px}</style><table width="350" border="0" cellpadding="1" cellspacing="0" class="table-list"><tr><td width="15%"><?php echo lang('a-cat-70'); ?></td><td width="85%">&nbsp;</td></tr><tr><td>{dir}</td><td><?php echo lang('a-cat-71'); ?></td></tr><tr><td>{pdir}</td><td><?php echo lang('a-cat-72'); ?></td></tr><tr><td>{page}</td> <td><?php echo lang('a-cat-73'); ?></td></tr><tr><td>{id}</td><td><?php echo lang('a-cat-74'); ?></td></tr><tr><td><?php echo lang('a-mod-154'); ?></td><td>&nbsp;</td></tr><tr><td colspan="2">1、<?php echo lang('a-mod-155'); ?><br>2、<?php echo lang('a-mod-156'); ?><br>3、<?php echo lang('a-mod-157'); ?><br></td></tr><tr><td><?php echo lang('a-cat-75'); ?></td><td>&nbsp;</td></tr><td colspan="2">1、<?php echo lang('a-cat-77'); ?><br>2、<?php echo lang('a-cat-78'); ?><br>3、<?php echo lang('a-cat-79'); ?><br></td></tr><tr><td><?php echo lang('a-cat-81'); ?></td><td>&nbsp;</td></tr><td colspan="2"><?php echo lang('a-cat-82'); ?>：{pdir}/ <?php echo lang('a-cat-83'); ?>：news/china/。<br><?php echo lang('a-cat-82'); ?>：list-{dir}.html <?php echo lang('a-cat-83'); ?>：list-china.html。<br><?php echo lang('a-cat-82'); ?>：list-{id}-{page}.html <?php echo lang('a-cat-83'); ?>：list-1-1.html。<br></td></tr></table>';
		window.top.art.dialog({title:'<?php echo lang('a-cat-82'); ?>',fixed:true, content: body});
	}
	function win_show() {
		var body = '<style>.table-list td,.table-list th{ padding-left:12px; font-weight:normal;}.table-list thead th{ height:30px; background:#eef3f7; border-bottom:1px solid #d5dfe8; font-weight:normal}.table-list tbody td,.table-list .btn{ border-bottom: #eee 1px solid; padding-top:5px; padding-bottom:5px}</style><table width="350" border="0" cellpadding="1" cellspacing="0" class="table-list"><tr><td width="15%"><?php echo lang('a-cat-70'); ?></td><td width="85%">&nbsp;</td></tr><tr><td>{dir}</td><td><?php echo lang('a-cat-71'); ?></td></tr><tr><td>{pdir}</td><td><?php echo lang('a-cat-72'); ?></td></tr><tr><td>{page}</td> <td><?php echo lang('a-cat-73'); ?></td></tr><tr><td>{id}</td><td><?php echo lang('a-cat-76'); ?></td></tr><tr><tr><td>{y}</td><td><?php echo lang('a-cat-84'); ?></td></tr><tr><tr><td>{m}</td><td><?php echo lang('a-cat-85'); ?></td></tr><tr><tr><td>{d}</td><td><?php echo lang('a-cat-86'); ?></td></tr><tr><td><?php echo lang('a-mod-154'); ?></td><td>&nbsp;</td></tr><tr><td colspan="2">1、<?php echo lang('a-mod-155'); ?><br>2、<?php echo lang('a-mod-156'); ?><br>3、<?php echo lang('a-mod-157'); ?><br></td></tr><tr><td><?php echo lang('a-cat-75'); ?></td><td>&nbsp;</td></tr><td colspan="2">1、<?php echo lang('a-cat-77'); ?><br>2、<?php echo lang('a-cat-78'); ?><br>3、<?php echo lang('a-cat-80'); ?><br></td></tr><tr><td><?php echo lang('a-cat-81'); ?></td><td>&nbsp;</td></tr><td colspan="2"><?php echo lang('a-cat-82'); ?>：{pdir}/{id}.html <?php echo lang('a-cat-83'); ?>：news/china/10.html。<br><?php echo lang('a-cat-82'); ?>：show-{dir}.html <?php echo lang('a-cat-83'); ?>：show-10.html。<br><?php echo lang('a-cat-82'); ?>：show-{id}-{page}.html <?php echo lang('a-cat-83'); ?>：show-10-1.html。<br></td></tr></table>';
		window.top.art.dialog({title:'<?php echo lang('a-cat-82'); ?>',fixed:true, content: body});
	}
	function import_url() {
		$.getJSON('<?php echo url('admin/category/ajaximport', array('catid'=>$data['parentid'])); ?>&'+Math.random(), function(data){
			if (data.status==1) {
				$('#url_list').val(data.list);
				$('#url_list_page').val(data.list_page);
				$('#url_show').val(data.show);
				$('#url_show_page').val(data.show_page);
				$('#url_catjoin').val(data.catjoin);
			} else {
				alert('<?php echo lang('a-cat-87'); ?>');
			}
		});
	}
	function set_document(dir) {
		var reg = /^[a-zA-Z_0-9]+$/;
		var r = dir.match(reg);
		if (dir!='' && r==null) {
			$("#result_document").addClass("onError");
			$("#result_document").html("<?php echo lang('a-mod-203'); ?>");
		} else {
			$("#result_document").addClass("onCorrect");
			$("#result_document").removeClass("onError");
			$("#result_document").html("&nbsp;");
			finecms_admin_document=dir;
		}
	}
</script>