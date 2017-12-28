{template member/header}
<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/views/admin/js/dialog.js"></script>
<script type="text/javascript" src="{{ LANG_PATH }}lang.js"></script>
<script type="text/javascript">var sitepath = "{{ SITE_PATH }}{{ ENTRY_SCRIPT_NAME }}";</script>
<script type="text/javascript" src="/views/admin/js/core.js"></script>
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
                <table width="100%" class="table_form ">
                <tbody>
                <tr>
                    <th width="100">会员名称：</th>
                    <td>{{ $memberinfo['username'] }}</td>
                </tr>
                <tr>
                    <th>安全邮箱：</th>
                    <td>{{ $memberinfo['email'] }}</td>
                </tr>
                <tr>
                    <th>会员昵称：</th>
                    <td><input name="data[nickname]" type="text" class="input-text" value="{{ $memberinfo['nickname'] }}" /></td>
                </tr>
                <tr>
                {{ $data_fields }}
                <tr>
                    <th style="border:none">&nbsp;</th>
                    <td style="border:none"><input type="submit" class="button" value="保 存" name="submit"></td>
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
{template member/footer}