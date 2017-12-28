{template member/header}
<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
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
            @endforeach
			</ul>
			</div>
        </div>
		<div class="center_right">
            <div class="title_right1"></div>
			<div class="content_info">
                <form action="" method="post">
                <table class="datatable" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td width="22"><input name="selectc" id="selectc" type="checkbox" onClick="setC()"></td>
                            <td>标题</td>
                            <td width="30">类型</td>
                            <td width="70">发件人</td>
                            <td width="130">发送时间</td>
                            <td width="80">操作</td>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach($data as $t)
                      <tr>
                        <td><input name="ids[]" type="checkbox" class="selectc" value="{{ $t['id'] }}"></td>
                        <td><a href="{{ url("member/pms/read/", array("id"=>$t['id'])) }}">@if(!$t['hasview'] && $a=='inbox')
<font color="#FF0000">(未读)</font>@endif
{{ $t['title'] }}</a></td>
                        <td>@if($t['isadmin'])
<font color="#FF0000">系统</font>@else
普通@endif
</td>
                        <td>{{ $t['sendname'] }}</td>
                        <td>{{ date("Y-m-d H:i:s", $t['sendtime']) }}</td>
                        <td><a href="{{ url("member/pms/read/", array("id"=>$t['id'])) }}" title="阅读">阅读</a></td>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
                <div class="datatablepage">
                <table width="100%" border="0">
                  <tr>
                    <td width="100"><input type="submit" class="button" value="删除" name="submit"></td>
                    <td align="right">{{ $pagelist }}</td>
                  </tr>
                </table>
                </div>
                <div class="datatablepage">
                <span class="count">今天只能发送<em>{{ $countinfo['posts'] }}</em>条短消息，已经发送了<em>{{ $countinfo['post'] }}</em>条。 </span>
                </div>
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