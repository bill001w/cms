{template member/header}
<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
<!--Wrapper-->
<div id="wrapper">
	<div class="top"></div>
	<div class="center">
	    <div class="center_left">
	        <h3>资金管理</h3>
			<div class="menu_left">
			<ul>
            @foreach($navigation as $n => $t)
                <li @if($n=='add')
 class="on"@endif
><a href="{{ $t['url'] }}">{{ $t['name'] }}</a></li>
            @end
			</ul>
			</div>
        </div>
		<div class="center_right">
            <div class="title_right1"></div>
			<div class="content_info">
              <form action="" method="post" target="_blank">
               <table width="100%" class="table_form ">
               <tbody>
                <tr>
                    <th width="100">充值金额：</th>
                    <td><font style="color:#F00;font-size:22px;font-family:Georgia,Arial;font-weight:700">{{ $data['money'] }}</font>
					元</td>
                </tr>
                <tr>
                    <th>订单编号：</th>
                    <td>
					{{ $data['order_sn'] }}
					</td>
                </tr>
                <tr>
                    <th>支付方式：</th>
                    <td>
					{{ $pay_config[$data['paytype']]['name'] }}
					</td>
                </tr>
                <tr>
                 <tr>
                    <th style="border:none">&nbsp;</th>
                    <td style="border:none"><input type="submit" class="button" value="确 定" name="submit" onclick="on_submit()"></td>
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
<script language="javascript" src="/views/admin/js/dialog.js"></script>
<script language="javascript">
function on_submit() {
    window.top.art.dialog({title:'充值提示',fixed:true, content: '<a href="{{ url('pay/member/order', array('id'=>$data['id'])) }}">如果您已经完成了付款，请单击查看充值信息。</a>'});
}
</script>
{template member/footer}