<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/system.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet"><link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
	<?php include $this->_include('admin/top.html'); ?>
<script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="/views/admin/js/dialog.js"></script>
<script type="text/javascript">
var sitepath = '<?php echo SITE_PATH;  echo ENTRY_SCRIPT_NAME; ?>';
var finecms_admin_document = "<?php echo $cats[$data['catid']]['setting']['document']; ?>";
</script>
<script type="text/javascript" src="<?php echo LANG_PATH; ?>lang.js"></script>
<script type="text/javascript" src="/views/admin/js/core.js"></script>
<title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
		<a href="<?php if ($backurl) {  echo $backurl;  } else {  echo url('admin/content', array('catid'=>$catid));  } ?>" onclick="clz()"><em><?php echo lang('a-con-42'); ?></em></a><span>|</span>
		<a href="javascript:;" class="on"><em><?php echo lang('a-con-24'); ?></em></a>
	</div>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<form method="post" action="" id="myform" name="myform">
		<input name="backurl" type="hidden" value="<?php echo $backurl; ?>" />
		<table class="table table-striped" width="100%">
		<tbody>
		<tr>
			<th width="130"><font color="red">*</font>&nbsp;<?php echo lang('a-con-29'); ?>：</th>
			<td>
			<select name="data[catid]" id="catid">
			<?php echo $category; ?>
			</select>
			</td>
		</tr>
		<tr>
			<th><font color="red">*</font>&nbsp;<?php echo lang('a-con-26'); ?>：</th>
			<td><input type="text" class="input-text" size="80" id="title" value="<?php echo $data['title']; ?>" name="data[title]" required />
			<div class="onShow" id="title_text"></div></td>
		</tr>
		<tr>
			<th><?php echo lang('a-con-43'); ?>：</th>
			<td><input type="text" class="input-text" size="50" id="keywords" value="<?php echo $data['keywords']; ?>" name="data[keywords]" />
			<div class="onShow"><?php echo lang('a-con-44'); ?></div></td>
		</tr>
		<tr>
			<th><?php echo lang('a-con-45'); ?>：</th>
			<td><input type="text" class="input-text" size="50" value="<?php echo $data['thumb']; ?>" name="data[thumb]" id="thumb" />
			<input type="button" style="width:66px;cursor:pointer;" class="btn btn-success btn-sm" onClick="preview('thumb')" value="<?php echo lang('a-mod-118'); ?>" />
			<input type="button" style="width:66px;cursor:pointer;" class="btn btn-success btn-sm" onClick="uploadImage('thumb', '<?php echo $SITE_THUMB_WIDTH; ?>', '<?php echo $SITE_THUMB_HEIGHT; ?>')" value="<?php echo lang('a-mod-119'); ?>" />
			<div class="onShow"><?php echo lang('a-pic'); ?></div></td>
		</tr>
		<tr>
			<th><?php echo lang('a-desc'); ?>：</th>
			<td><textarea style="width:490px;height:66px;" id="description" name="data[description]" /><?php echo $data['description']; ?></textarea></td>
		</tr>
		<?php echo $data_fields; ?>
		<tr>
			<th><?php echo lang('a-con-134'); ?>：</th>
			<td><input type="text" class="input-text" size="15" value="<?php echo $data['hits']; ?>" name="data[hits]" /></td>
		</tr>
		<?php if ($a!='editverify') { ?>
		<tr>
			<th><?php echo lang('a-con-129'); ?>：</th>
			<td>
			<input type="radio" value="2" name="updatetime" checked onClick="$('#updatetime').hide()" /> <?php echo lang('a-con-132'); ?>
			&nbsp;
			<?php if (isset($data['id'])) { ?>
			<input type="radio" value="1" name="updatetime" onClick="$('#updatetime').hide()" /> <?php echo lang('a-con-130'); ?>
			&nbsp;
			<?php } ?>
			<input type="radio" value="3" name="updatetime" onClick="$('#updatetime').show()" /> <?php echo lang('a-con-133'); ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<span id="updatetime" style="display:none"><?php echo content_date('select_time'); ?></span>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<th><?php echo lang('a-con-46'); ?>：</th>
			<td>
			<?php if ($a=='editverify') { ?>
			<input type="radio" <?php if (!isset($data['status']) || $data['status']==1) { ?>checked<?php } ?> value="1" name="data[status]" onClick="$('#verify').hide()" /> <?php echo lang('a-con-20'); ?>
			&nbsp;
			<input type="radio" <?php if (isset($data['status']) && $data['status']==3) { ?>checked<?php } ?> value="3" name="data[status]" onClick="$('#verify').hide()" /> <?php echo lang('a-con-21'); ?>
			&nbsp;
			<input type="radio" <?php if (isset($data['status']) && $data['status']==2) { ?>checked<?php } ?> value="2" name="data[status]" onClick="$('#verify').show()" /> <?php echo lang('a-con-33'); ?>
			<span id="verify" <?php if ($data['status']!=2) { ?> style="display:none"<?php } ?>>&nbsp;&nbsp;<?php echo lang('a-con-47'); ?>：<input type="text" class="input-text" size="50" value="<?php echo $data['verify']; ?>" name="data[verify]"></span>
			<?php } else { ?>
			<input type="radio" <?php if (!isset($data['status']) || $data['status']==1) { ?>checked<?php } ?> value="1" name="data[status]" /> <?php echo lang('a-con-20'); ?>
			&nbsp;
			<input type="radio" <?php if (isset($data['status']) && $data['status']==0) { ?>checked<?php } ?> value="0" name="data[status]" /> <?php echo lang('a-con-34'); ?>
			&nbsp;
			<input type="radio" <?php if (isset($data['status']) && $data['status']==3) { ?>checked<?php } ?> value="3" name="data[status]" disabled="" /> <?php echo lang('a-con-21'); ?>
			&nbsp;
			<input type="radio" <?php if (isset($data['status']) && $data['status']==2) { ?>checked<?php } ?> value="2" name="data[status]" disabled="" /> <?php echo lang('a-con-33');  } ?>
			</td>
		</tr>
		<?php if ($a!='editverify') { ?>
		<tr>
			<th><?php echo lang('a-con-48'); ?>：</th>
			<td>
			<?php $pos = @explode(',', $data['position']);  if (is_array($position)) { $count=count($position);foreach ($position as $t) {  echo $t['name']; ?>&nbsp;<input type="checkbox" value="<?php echo $t['posid']; ?>" name="data[position][]" <?php if (in_array($t['posid'], $pos)) { ?>checked<?php } ?>>&nbsp;&nbsp;&nbsp;
			<?php } } ?>
			</td>
		</tr>
		<tr>
			<th><?php echo lang('a-con-49'); ?>：</th>
			<td>
			<table width="80%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
				<input type="hidden" style="50" value="<?php echo $relation_ids; ?>" id="relation" name="data[relation]">
				<ul id="relation_text" class="list-dot" style="width:90%;">
				<?php $return = $this->relation($data['id'],10); if (is_array($return)) { $count=count($return);foreach ($return as $r) { ?>
				<li id="rel_<?php echo $r['id']; ?>">·<span><?php echo $r['title']; ?></span><a onClick="remove_relation('rel_<?php echo $r['id']; ?>',<?php echo $r['id']; ?>)" class="close" href="javascript:;"></a></li>
				<?php } } ?>
				</ul></td>
				<td><input type="button" style="width:66px;cursor:pointer;" class="btn btn-success btn-sm" onClick="loadInfo(0)" value="<?php echo lang('a-add'); ?>" /></td>
			</tr>
			</table>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<th>&nbsp;</th>
			<td><input type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-submit'); ?>" name="submit" onClick="$('#load').show()" />
			<span id="load" style="display:none"><img src="/views/admin/images/loading.gif"></span>
			</td>
		</tr>
		</tbody>
		</table>
	</form>
	</div>
</div>
<script type="text/javascript">
$(function(){
    window.top.art.dialog({id:'clz'}).close();
	var catid = $("#catid").val();
	var cats = new Array();
	<?php if (is_array($cats)) { $count=count($cats);foreach ($cats as $t) {  if ($t['modelid']==$modelid) { ?>
	cats[<?php echo $t['catid']; ?>]="<?php echo $t['setting']['document']; ?>";
	<?php }  } } ?>
	finecms_admin_document = cats[catid];
	$("#catid").change(function(){
		var catid = $(this).val();
		finecms_admin_document = cats[catid];
    });
});
function clz() {
	window.top.art.dialog({ id:'clz',title:'Loading',fixed:true,lock:false,content: '<img src="/views/admin/images/onLoad.gif">' });
}

function loadInfo() {
	var url   = '<?php echo url("admin/content/ajaxloadinfo/"); ?>&kw='+$("#keywords").val();
	var winid = 'loadinfo';
	window.top.art.dialog(
	    {id:winid, okVal:fc_lang[6], cancelVal:fc_lang[7], iframe:url, title:'<?php echo lang('a-con-50'); ?>', width:'660', height:'280', lock:true}, 
		function(){
		    var d     = window.top.art.dialog({id:winid}).data.iframe;
			var ids   = d.document.getElementById('select').value;
			var arrid = ids.split(',');
			var c     = '';
			for (var i in arrid) {
				var id = arrid[i];
				if (id) {
					var title = d.document.getElementById('title_'+id).value;
					c += '<li id="rel_'+id+'">·<span>'+title+'</span><a onclick="remove_relation(\'rel_'+id+'\', \''+id+'\')" class="close" href="javascript:;"></a></li>';
				}
			}
			$("#relation_text").append(c);
			var rids = $("#relation").val();
	        $("#relation").val(rids+ids);
		},
		function(){
			window.top.art.dialog({id:winid}).close();
	    }
	);
	void(0);
}
//移除相关文章
function remove_relation(sid, id) {
	var relation_ids = $('#relation').val();
	if(relation_ids !='' ) {
		$('#'+sid).remove();
		var r_arr = relation_ids.split(',');
		var newrelation_ids = '';
		$.each(r_arr, function(i, n){
			if(n!=id) {
				if(i==0) {
					newrelation_ids = n;
				} else {
				    newrelation_ids = newrelation_ids+','+n;
				}
			}
		});
		$('#relation').val(newrelation_ids);
	}
}
</script>
</body>
</html>
