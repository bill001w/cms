@include('header.html')
<form action="" method="post" name="myform" id="myform">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/wx/index') }}" class="on"><em>微信配置</em></a><span>|</span>
        <a href="http://wpa.qq.com/msgrd?v=3&uin=83961832&site=%CC%EC%EE%A3&Menu=yes" target="_blank"><em>定制应用</em></a>
	</div>
	<div class="bk10"></div>
	<div class="table-list col-tab">
		<div class="contentList pad-10">
            <table width="100%" class="table_form">
            <tr class="dr_0">
                <th width="200"><font color="red">*</font>&nbsp;URL： </th>
                <td>
					{{ SITE_URL }}index.php?c=wx
                </td>
            </tr>
            <tr class="dr_0">
                <th><font color="red">*</font>&nbsp;Token： </th>
                <td>
                <input class="input-text" type="text" name="data[token]" value="<?php echo $data[token] ? $data[token] : md5(rand(0, 999)); ?>" size="40" />
                </td>
            </tr>
            <tr class="dr_0">
                <th><font color="red">*</font>&nbsp;AppId： </th>
                <td>
                <input class="input-text" type="text" name="data[appid]" value="{{ $data[appid] }}" size="40" />
                </td>
            </tr>
            <tr class="dr_0">
                <th><font color="red">*</font>&nbsp;AppSecret： </th>
                <td>
                <input class="input-text" type="text" name="data[appsecret]" value="{{ $data[appsecret] }}" size="40" />
                </td>
            </tr>
            <tr>
                <th style="border:none;">&nbsp;</th>
                <td><input class="button" type="submit" name="submit" value="{{ lang('submit') }}" />
				微信功能下个版本正式发行
				</td>
            </tr>
            </table>
		</div>
	</div>
</div>
</form>
</body>
</html>