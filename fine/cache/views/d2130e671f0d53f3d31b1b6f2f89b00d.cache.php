<?php include $this->_include('header.html'); ?>
<script type="text/javascript">
$(function() {
	<?php if ($data[uid]) { ?>
	$.getScript("http://sms.dayrui.com/index.php?c=check&uid=<?php echo $data[uid]; ?>&key=<?php echo $data[key]; ?>");
	<?php } ?>
});
</script>
<form action="" method="post" name="myform" id="myform">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
        <a href="<?php echo url('admin/sms/index'); ?>" class="on"><em><?php echo lang('dr005'); ?></em></a><span>|</span>
        <a href="<?php echo url('admin/sms/send'); ?>"><em><?php echo lang('dr006'); ?></em></a><span>|</span>
        <a href="http://wpa.qq.com/msgrd?v=3&uin=83961832&site=%CC%EC%EE%A3&Menu=yes" target="_blank"><em>定制第三方接口集成服务</em></a>
	</div>
	<div class="bk10"></div>
	<div class="table-list col-tab">
		<div class="contentList pad-10">
            <table width="100%" class="table_form">
            <tr class="dr_0">
                <th width="200"><font color="red">*</font>&nbsp;SMS Uid： </th>
                <td>
                <input class="input-text" type="text" name="data[uid]" value="<?php echo $data[uid]; ?>" size="10" />
                    <div class="onShow">
                    <a href="http://i.dayrui.com/index.php?s=sms&c=home&m=index" target="_blank">申请短信接口</a>
					&nbsp;&nbsp;
                    <a href="http://news.dayrui.com/2015/07/239.html" style="color:red" target="_blank">免费领取短信</a>
                        </div>
                </td>
            </tr>
            <tr class="dr_0">
                <th><font color="red">*</font>&nbsp;SMS Key： </th>
                <td>
                <input class="input-text" type="text" name="data[key]" value="<?php echo $data[key]; ?>" size="25" />
                    <div class="onShow"><span id="dr_sms">...</span></div>
                </td>
            </tr>
                <tr>
                    <th>签名： </th>
                    <td>
                        <input class="input-text" type="text" name="data[note]" value="<?php echo $data[note]; ?>" size="25" />
                        <div class="onShow">保持在10个字符以内</div>
                    </td>
                </tr>
            <tr>
                <th style="border:none;">&nbsp;</th>
                <td><input class="btn btn-success btn-sm" type="submit" name="submit" value="<?php echo lang('submit'); ?>" /></td>
            </tr>
            </table>
		</div>
	</div>
</div>
</form>
</body>
</html>