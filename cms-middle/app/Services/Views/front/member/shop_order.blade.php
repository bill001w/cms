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
			    <div style="background-color:#FFFCED;border:1px solid #FFBE7A;line-height:20px;padding:8px 10px;margin-bottom:10px;">
                    <a href="{{ purl('member/', array('time'=>1)) }}" @if($time==1)
style="color:red;font-weight:bold"@endif
>最近一周</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{ purl('member/', array('time'=>2)) }}" @if($time==2)
style="color:red;font-weight:bold"@endif
>最近一月</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{ purl('member/', array('time'=>3)) }}" @if($time==3)
style="color:red;font-weight:bold"@endif
>最近半年</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{ purl('member/', array('time'=>4)) }}" @if($time==4)
style="color:red;font-weight:bold"@endif
>最近一年</a>
				</div>
                <table class="datatable" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td width="150">订单编号</td>
                            <td width="150">下单时间</td>
                            <td width="100">总金额</td>
                            <td>订单状态</td>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach($list as $t)
                      <tr>
                        <td><a href="{{ purl('member/order', array('id'=>$t['id'])) }}">{{ $t['order_sn'] }}</a></td>
                        <td>{{ date("Y-m-d H:i:s", $t['addtime']) }}</td>
                        <td><span style="color:#47A022;font-weight:bold;">￥{{ $t['price'] }}元</span></td>
                        <td>
                        @if($t['status']==0)

                        @if($pay)

                            @if($t['paytime'])

                            <span style="color:#090">已付款</span>
                            @else

                            <a href="{{ purl('member/pay', array('id'=>$t['id'])) }}" style="color:#F00">付款</a>
                            @endif

                        @else

                        <span style="color:#C60">等待联系</span>
                        @endif

                        @elseif($t['status']==1)

                        <span style="color:#C60">等待配货</span>
                        @elseif($t['status']==2)

                        <span style="color:#090">正在配货</span>
                        @elseif($t['status']==3)

                        <span style="color:#090">已发货(物流：{{ $t['shipping_name'] }}，运单编号：{{ $t['shipping_id'] }})</span>
                        <a href="{{ purl('member/confirm', array('id'=>$t['id'])) }}" style="color:#00F">确认收货</a>
                        @elseif($t['status']==4)

                        <span style="color:#F00">交易关闭({{ $t['note'] }})</span>
                        @elseif($t['status']==9)

                        <span style="color:#00F">交易成功</span>
                        @endif

                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                </table>
                <div class="datatablepage">
                <table width="100%" border="0">
                  <tr>
                    <td align="right">{{ $pagelist }}</td>
                  </tr>
                </table>
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