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
<script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="/views/admin/js/dialog.js"></script>
<script type="text/javascript" src="<?php echo LANG_PATH; ?>lang.js"></script><?php include $this->_include('admin/top.html'); ?>
<title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
		<a href="<?php echo url('admin/position/'); ?>" class="on"><em><?php echo lang('a-men-31'); ?></em></a><span>|</span>
		<?php if (admin_auth($userinfo['roleid'], 'position-add')) { ?><a href="<?php echo url('admin/position/add/'); ?>"><em><?php echo lang('a-add'); ?></em></a><span>|</span><?php }  if (admin_auth($userinfo['roleid'], 'position-cache')) { ?><a href="<?php echo url('admin/position/cache'); ?>"><em><?php echo lang('a-cache'); ?></em></a><?php } ?>
	</div>
	<div class="bk10"></div>
	<div class="table-responsive mytable">
		<form action="" method="post" name="myform">
		<table width="100%" class="table table-striped">
		<thead>
		<tr>
			<th width="20" align="right"><input name="deletec" id="deletec" type="checkbox" onClick="setC()" /></th>
			<th width="26" align="left">ID </th>
			<th width="150" align="left"><?php echo lang('a-name'); ?></th>
			<th width="55" align="left"><?php echo lang('a-pos-2'); ?></th>
			<th width="80" align="center"><?php echo lang('a-pos-3'); ?></th> 
			<th align="left"><?php echo lang('a-option'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php if (is_array($list)) { $count=count($list);foreach ($list as $t) { ?>
		<tr>
			<td align="right"><input name="del_<?php echo $t[posid]; ?>" type="checkbox" class="deletec" /></td>
			<td align="left"><?php echo $t['posid']; ?></td>
			<td align="left"><?php echo $t['name']; ?></td>
			<td align="left"><?php if ($t['catid']) {  echo lang('a-con-29');  } else {  echo lang('a-pos-4');  } ?></td>
			<td align="center"><?php echo $t['maxnum']; ?></td>
			<td align="left">
			<?php $del = url('admin/position/del/',array('posid'=>$t['posid'])); if (admin_auth($userinfo['roleid'], 'position-list')) { ?><a href="<?php echo url('admin/position/list',array('posid'=>$t['posid'])); ?>"><?php echo lang('a-pos-0'); ?></a> | <?php }  if (admin_auth($userinfo['roleid'], 'position-edit')) { ?><a href="<?php echo url('admin/position/edit',array('posid'=>$t['posid'])); ?>"><?php echo lang('a-edit'); ?></a> | <?php }  if (admin_auth($userinfo['roleid'], 'position-del')) { ?><a href="javascript:;" onClick="if(confirm('<?php echo lang('a-confirm'); ?>')){ window.location.href='<?php echo $del; ?>'; }"><?php echo lang('a-del'); ?></a> | <?php } ?>
			<a href="javascript:;" onClick="getViewData(<?php echo $t['posid']; ?>);"><?php echo lang('a-pos-5'); ?></a>
			</td>
		</tr>
		<?php } } ?>
		<tr>
			<td colspan="7" align="left">&nbsp;
			<input <?php if (!admin_auth($userinfo['roleid'], 'position-del')) { ?>disabled<?php } ?> type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-del'); ?>" name="submit" onclick="return confirm_del()" />&nbsp;</td>
		</tr>   
		</tbody>
		</table>
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
function getViewData(posid) {
	var url = '<?php echo url("admin/position/ajaxview/",array("posid"=>"")); ?>'+posid;
	window.top.art.dialog(
	    {id:"ajaxview", okVal:fc_lang[6], cancelVal:fc_lang[7], iframe:url, title:'<?php echo lang('a-pos-5'); ?>', width:'300', height:'120', lock:true,
		button: [
            {
				name: '<?php echo lang('a-copy'); ?>',
				callback: function () {
					 var d = window.top.art.dialog({id:'ajaxview'}).data.iframe;
			         var c = d.document.getElementById('position_'+posid).value;
					 copyToClipboard(c);
					 return false;
				},
				focus: true
            }, {
                name: '<?php echo lang('a-close'); ?>'
            }
        ]
		
		}
	);
}

function copyToClipboard(meintext) {
    if (window.clipboardData){
        window.clipboardData.setData("Text", meintext);
    } else if (window.netscape){
        try {
            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
        } catch (e) {
            alert("<?php echo lang('a-att-18'); ?>"); 
		} 
        var clip = Components.classes['@mozilla.org/widget/clipboard;1'].
        createInstance(Components.interfaces.nsIClipboard);
        if (!clip) return;
        var trans = Components.classes['@mozilla.org/widget/transferable;1'].
        createInstance(Components.interfaces.nsITransferable);
        if (!trans) return;
        trans.addDataFlavor('text/unicode');
        var len = new Object();
        var str = Components.classes["@mozilla.org/supports-string;1"].
        createInstance(Components.interfaces.nsISupportsString);
        var copytext=meintext;
        str.data=copytext;
        trans.setTransferData("text/unicode",str,copytext.length*2);
        var clipid=Components.interfaces.nsIClipboard;
        if (!clip) return false;
        clip.setData(trans,null,clipid.kGlobalClipboard);
    }
    alert("<?php echo lang('a-att-19'); ?>");
    return false;
}
</script>
</body>
</html>