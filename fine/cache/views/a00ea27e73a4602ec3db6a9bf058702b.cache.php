<?php include $this->_include('header.html'); ?>
<form action="" method="post" name="myform" id="myform">
<div class="subnav">
	<div class="content-menu ib-a blue line-x">
        <a href="<?php echo url('admin/sms/index'); ?>"><em><?php echo lang('dr005'); ?></em></a><span>|</span>
        <a href="<?php echo url('admin/sms/send'); ?>" class="on"><em><?php echo lang('dr006'); ?></em></a><span>|</span>
        <a href="http://wpa.qq.com/msgrd?v=3&uin=83961832&site=%CC%EC%EE%A3&Menu=yes" target="_blank"><em>定制第三方接口集成服务</em></a>
    </div>
	<div class="bk10"></div>
	<div class="table-list col-tab">
		<div class="contentList pad-10">
				<table width="100%" class="table_form">
				<tr>
                    <th width="200">类型： </th>
                    <td>
                    <input name="is_all" type="radio" value="0" onclick="$('.dr_0').show();$('.dr_1').hide();" checked="checked" />&nbsp;单发&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="is_all" type="radio" value="1" onclick="$('.dr_1').show();$('.dr_0').hide();" />&nbsp;群发
                    </td>
                </tr>
				<tr class="dr_0">
                    <th>手机号码： </th>
                    <td>
                    <input class="input-text" type="text" name="data[mobile]" style="width:150px;" />
                    </td>
                </tr>
                <tr class="dr_1" style="display:none">
                    <th>手机号码： </th>
                    <td>
                    <textarea class="input-text" name="data[mobiles]" style="height:200px; width:150px;"></textarea>
                    <br><font color="#999999">多个手机号码按“回车符号”分隔，一行一个号码</font>
                    </td>
                </tr>
               <tr>
                    <th>短信内容： </th>
                    <td>
                    <textarea class="input-text" name="data[content]" style="height:80px; width:250px;"></textarea>
                    <br><font color="#999999">字数控制在40字以内，请勿发布非法信息</font>
                    <br><font color="#999999">短信发送日志文件：cache/sms.log，记录发送的全部信息</font>
                    </td>
                </tr>
                <tr>
                    <th style="border:none;">&nbsp;</th>
                    <td>
                    <input class="btn btn-success btn-sm" type="button" name="button" value="发送" onclick="dr_send()" />
                        &nbsp;&nbsp;
                    <span id="dr_send_note"></span>
                    </td>
                </tr>
				</table>
            </div>
		</div>
	</div>
</div>
</form>
<script type="text/javascript">
function dr_send() {
	$("#dr_send_note").html('...');
	var data = $("#myform").serialize();
	$.ajax({type: "POST",dataType:"json", url: "<?php echo url('admin/sms/ajaxsend'); ?>&"+Math.random(), data: data,
		success: function(data) {
			if (data.status == 1) {
				$("#dr_send_note").html('<font color=green>'+data.code+'</font>');
			} else {
				$("#dr_send_note").html('<font color=red>'+data.code+'</font>');
			}
		},
		error: function(HttpRequest, ajaxOptions, thrownError) {
			$("#dr_send_note").html('');
			alert(thrownError + "\r\n" + HttpRequest.statusText + "\r\n" + HttpRequest.responseText);
		}
	});
	return false;
}
</script>
        </body>
        </html>