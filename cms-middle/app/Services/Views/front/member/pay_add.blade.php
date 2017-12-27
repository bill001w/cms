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
                    <th width="100">&nbsp;</th>
                    <td>可用资金：<font style="color:#F00;font-size:22px;font-family:Georgia,Arial;font-weight:700">{{ $pay_data['available'] }}</font>
					元
					（冻结资金：<font style="color:#F00;font-size:22px;font-family:Georgia,Arial;font-weight:700">{{ $pay_data['freeze'] }}</font>
					元）
                    </td>
                </tr>
                <tr>
                    <th>充值金额：</th>
                    <td><input name="data[money]" type="text" size="8" value="{{ $price }}" class="input-text" />
					元</td>
                </tr>
                <tr>
                    <th>支付方式：</th>
                    <td>
					@foreach($pay_config as $name => $t)
					@if($t['use'])
<input type="radio" value="{{ $name }}" name="data[paytype]">{{ $t['name'] }}&nbsp;&nbsp;&nbsp;&nbsp;@endif

					@endforeach
					</td>
                </tr>
                <tr>
                    <th>验证码：</th>
                    <td>
					<input name="code" type="text" class="input-text" size="8" />
					<img src="{{ url('api/captcha', array('width'=>80,'height'=>25)) }}&'+Math.random();" onclick="this.src='{{ url('api/captcha', array('width'=>80,'height'=>25))}}&'+Math.random();" align="absmiddle" title="看不清楚？换一张" style="cursor:pointer;">
					</td>
                </tr>
                <tr>
                 <tr>
                    <th style="border:none">&nbsp;</th>
                    <td style="border:none"><input type="submit" class="button" value="确 定" name="submit"></td>
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