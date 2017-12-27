{template member/header}
<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function checkuser() {
	$('#err_username').html("");
	$.get('{{ SITE_PATH }}{{ ENTRY_SCRIPT_NAME }}?s=member&c=pms&a=checkuser&id='+Math.random(), { username:$('#username').val()}, function(data){
	    $('#err_username').html(data);
	});
}
</script>
<!--Wrapper-->
<div id="wrapper">
	<div class="top"></div>
	<div class="center">
	    <div class="center_left">
	        <h3>短消息</h3>
			<div class="menu_left">
			<ul>
            @foreach($navigation as $n => $t)
                <li @if($n==$a)
 class="on"@endif
><a href="{{ $t['url'] }}">{{ $t['name'] }}@if($n=='inbox' && $inbox)
({{ $inbox }})@endif
</a></li>
            @end
			</ul>
			</div>
        </div>
		<div class="center_right">
            <div class="title_right1"></div>
			<div class="content_info">
               <form action="" method="post">
               <table class="table_form" border="0" cellpadding="0" cellspacing="0" width="100%">
               <tbody>
                <tr>
                    <th width="100">会员名称：</th>
                    <td><input name="data[toname]" type="text" class="input-text" id="username" onblur="checkuser()" />
                    <div class="onShow" id="err_username"></div>
                    </td>
                </tr>
                <tr>
                    <th>短信标题：</th>
                    <td><input name="data[title]" type="text" size="50" class="input-text" /></td>
                </tr>
                <tr>
                    <th valign="top">短信内容：</th>
                    <td>
					<?php App::auto_load('fields');echo content_editor('content', array(0=>$data['content']), array('type'=>0, 'width'=>90, height=>200,'system'=>1)); ?>
					</td>
                </tr>
                <tr>
                 <tr>
                    <th style="border:none">&nbsp;</th>
                    <td style="border:none"><input type="submit" class="button" value="发 送" name="submit"></td>
                </tr>
                </tbody>
               </table>
               </form>
		    </div>
        </div>
	</div>
    <div class="bottom"></div>
</div>
<!--Wrapper End-->
<script language="javascript">
function setC() {
	if($("#selectc").attr('checked')==true) {
		$(".selectc").attr("checked",true);
	} else {
		$(".selectc").attr("checked",false);
	}
}
</script>
{template member/footer}