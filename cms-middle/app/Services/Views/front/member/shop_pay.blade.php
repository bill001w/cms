{template member/header}
<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
<!--Wrapper-->
<div id="wrapper">
	<div class="top"></div>
	<div class="center">
	    <div class="center_left">
	        <h3>购物管理</h3>
			<div class="menu_left">
			<ul>
            @foreach($navigation as $n => $t)
                <li @if($n=='index')
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
                    <th width="100">&nbsp;</th>
                    <td>可用资金：<font style="color:#F00;font-size:22px;font-family:Georgia,Arial;font-weight:700">{{ $pay_data['available'] }}</font>
					元
					（冻结资金：<font style="color:#F00;font-size:22px;font-family:Georgia,Arial;font-weight:700">{{ $pay_data['freeze'] }}</font>
					元）
                    </td>
                </tr>
                <tr>
                    <th>支付金额：</th>
                    <td><font style="color:#F00;font-size:22px;font-family:Georgia,Arial;font-weight:700">{{ $data['price'] }}</font>
					元</td>
                </tr>
                @if($pay_data['available']-$data['price'] >=0)

                <tr>
                    <th style="border:none">&nbsp;</th>
                    <td style="border:none"><input type="submit" class="button" value="付 款" name="submit"></td>
                </tr>
                @else

                <tr>
                    <th style="border:none">&nbsp;</th>
                    <td style="border:none">余额不足，<a href="{{ url('pay/member/add', array('price'=>$data['price']-$pay_data['available'])) }}">请充值。</a></td>
                </tr>
                @endif

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