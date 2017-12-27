{template member/header}
<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
<!--Wrapper-->
<div id="wrapper">
	<div class="top"></div>
	<div class="center">
	    <div class="center_left">
	        <h3>资料信息</h3>
			<div class="menu_left">
			<ul>
            @foreach($navigation as $n => $t)
                <li @if($n==$a)
 class="on"@endif
><a href="{{ $t['url'] }}">{{ $t['name'] }}</a></li>
            @endforeach
			</ul>
			</div>
        </div>
		<div class="center_right">
            <div class="title_right1"></div>
			<div class="content_info">
                <form action="" method="post">
                <table border="0" cellpadding="0" cellspacing="0" class="datatable">
                    <thead>
                        <tr>
                            <td width="90">头像</td>
                            <td width="150">昵称</td>
                            <td width="140">绑定时间</td>
                            <td width="140">上次登录</td>
                            <td width="60">平台</td>
                            <td>操作</td>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach($listdata as $t)
                      <tr>
                        <td><img src="{{ $t['avatar'] }}"></td>
                        <td>{{ $t['nickname'] }}</td>
                        <td>{{ date("Y-m-d H:i:s", $t['addtime']) }}</td>
                        <td>@if($t['logintimes'])
{{ date("Y-m-d H:i:s", $t['logintimes']) }}@else
没有登录@endif
</td>
                        <td>{{ $t['oauth_name'] }}</td>
                        <td><a href="{{ url("member/info/jie/", array("id"=>$t['id'])) }}">解除绑定</a></td>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
              </form>
		  </div>
        </div>
	</div>
    <div class="bottom"></div>
</div>
<!--Wrapper End-->
{template member/footer}