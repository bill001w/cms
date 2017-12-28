@include('header')
	<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
	<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/views/admin/js/dialog.js"></script>
	<script type="text/javascript">var sitepath = "{{ SITE_PATH }}{{ ENTRY_SCRIPT_NAME }}";</script>
    <script type="text/javascript" src="{{ LANG_PATH }}lang.js"></script>
	<script type="text/javascript" src="/views/admin/js/core.js"></script>
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> 对“{{ $tomember['username'] }}”{{ $model['modelname'] }}
    </div>
    <div class="blank10 clear"></div>
    <!--begin-->
    <div class="piclist">
        <div class="title"><span>{{ $model['modelname'] }}</span></div>
        <div class="item-list">
            <form action="" method="post">
			<table width="100%" class="table_form">
			<tr>
				<th width="100">对他提交：</th>
				<td>{{ $tomember['username'] }}</td>
			</tr>
			{{ $fields }}
			@if($model['setting']['member']['code'])

			<tr>
				<th>验证码：</th>
				<td><input name="code" type="text" class="input-text" size=10 /><img src="{{ url('api/captcha', array('width'=>80,'height'=>25)) }}" align="absmiddle" /></td>
			</tr>
			@endif

			<tr>
				<th style="border:none">&nbsp;</th>
				<td style="border:none"><input type="submit" class="button" value="提 交" name="submit"></td>
			</tr>
			</table>
			</form>
        </div>
    </div>
    <!--end-->
    <div class="clear blank10"></div>
@include('footer')