{template member/header}
<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/views/admin/js/dialog.js"></script>
<script type="text/javascript" src="{{ LANG_PATH }}lang.js"></script>
<script type="text/javascript" src="/views/admin/js/core.js"></script>
<!--Wrapper-->
<div id="wrapper">
	<div class="top"></div>
	<div class="center">
	    <div class="center_left">
	        <h3>内容管理</h3>
			<div class="menu_left">
			<ul>
            @foreach($navigation as $n => $t)
                <li @if($modelid==$n)
 class="on"@endif
><a href="{{ $t['url'] }}">{{ $t['name'] }}</a></li>
            @end
			</ul>
			</div>
        </div>
		<div class="center_right">
            <div class="title_right1"></div>
			<div class="content_info">
				<form action="" method="post">
                <table width="100%" class="table_form" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <th width="100">&nbsp;状态：</th>
                    <td>{{ $data['username'] }} 向 {{ $tomember['username'] }} 提交 @if($data['status']!=1)
{{ get_form_status($data['status']) }}@endif
</td>
                </tr>
				<tr>
                    <th>&nbsp;提交时间：</th>
                    <td><span style="@if(date('Y-m-d', $data['updatetime']) == date('Y-m-d'))
color:#F00@endif
">{{ date('Y-m-d H:i', $data['updatetime']) }}</span></td>
                </tr>
				<tr>
                    <th>&nbsp;IP地址：</th>
                    <td>{{ $data['ip'] }}</td>
                </tr>
				<tr>
                    <th>&nbsp;</th>
                    <td>模板设计人员要根据实际情况把一些字段展示出来</td>
                </tr>
				<tr>
                    <th>&nbsp;操作：</th>
                    <td>
						<input @if($data['status']==1)
checked@endif
 value="1" name="status" onclick="$('#verify').hide()" type="radio"> 通过&nbsp;
						<input @if($data['status']==0)
checked@endif
 value="0" name="status" onclick="$('#verify').hide()" type="radio"> 未审&nbsp;
						<input @if($data['status']==2)
checked@endif
 value="2" name="status" onclick="$('#verify').show()" type="radio"> 拒绝&nbsp;<span id="verify" style="display:@if($data['status']==2)
block@else
none@endif
">&nbsp;&nbsp;理由：<input class="input-text" size="50" value="{{ $data['verify'] }}" name="verify" type="text"></span>
					</td>
                </tr>
                <tr>
                    <th style="border:none">&nbsp;</th>
                    <td style="border:none"><input type="submit" class="button" value="修 改" name="submit" /></td>
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