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
               <table width="100%" class="table_form">
               <tbody>
                <tr>
                  <th style="text-align:left; font-weight:bold; color: #C03; font-size:14px;">您的订单已提交成功，请记住您的订单号：{{ $order_sn }}。</th>
                </tr>
                @if($pay)

                <tr>
                  <th style="text-align:left; border-bottom:none">请您在<a href="{{ purl('member/pay', array('id'=>$order_id)) }}">这里付款</a>，付款之后我们会第一时间为您配货。</th>
                </tr>
                @else

                <tr>
                  <th style="text-align:left; border-bottom:none">客服将会第一时间和您取得联系。</th>
                </tr>
                @endif

                </tbody>
               </table>
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