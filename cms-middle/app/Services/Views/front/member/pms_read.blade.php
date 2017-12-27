{template member/header}
<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ EXT_PATH }}kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="{{ LANG_PATH }}kindeditor.js"></script>
<script language="javascript">
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
                <li @if($n=='send')
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
               <table width="100%" class="table_form ">
               <tbody>
                <tr>
                    <th width="100">发件人：</th>
                    <td>{{ $data['sendname'] }}</td>
                </tr>
                <tr>
                    <th>收件人：</th>
                    <td>{{ $data['toname'] }}</td>
                </tr>
                <tr>
                    <th>标题：</th>
                    <td>{{ $data['title'] }}</td>
                </tr>
                <tr>
                  <td colspan="2" align="left" style="border:none">{{ htmlspecialchars_decode($data['content']) }}</td>
                </tr>
                <tr>
                   <th style="border:none">&nbsp;</th>
                   <td style="border:none"><a href="{{ $backurl }}">返回</a></td>
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