<?php $meta_title = '订单确认';$itemdata=$data; ?>
@include('header')
<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> 订单确认
    </div>
    <div class="blank10 clear"></div>
    <!--begin-->
    <div class="piclist">
        <div class="title"><span>订单确认</span></div>
        <div class="item-list">
            <form action="" method="post">
            <input name="param" type="hidden" value="{{ $param }}" />
            <div class="j-pdt" style="margin:0px 0 10px 0"><h2>商品列表</h2></div>
            <table width="100%" class="table-list" cellspacing="0" cellpadding="0" border="0">
            <thead>
            <tr>
              <th width="33%" align="left">商品名称</th>
              <th width="12%" align="left">商品价格</th>
              <th width="11%" align="left">购买数量</th>
              <th width="44%" align="left">小计</th>
            </tr>
            </thead>
            <tbody>
            <?php $total_price = 0; ?>
            @foreach($itemdata as $cartid => $t)
            <tr>
              <td align="left">&nbsp;<a href="{{ url('content/show/', array('id'=>$t['id'])) }}" target="_blank">{{ $t['title'] }}</a></td>
              <td align="left">￥{{ $t['item_price'] }}元</td>
              <td align="left">{{ $t['num'] }}</td>
              <td align="left">￥<?php echo $t['item_price']*$t['num'] ?>元</td>
            </tr>
            <?php $total_price += $t['item_price']*$t['num']; ?>
            @endforeach
            </tbody>
            </table>
            <div class="j-pdt" style="margin:10px 0 10px 0"><h2>确认收货地址</h2></div>
            <table width="100%" class="table-list" cellspacing="0" cellpadding="0" border="0">
            <thead>
            <tr>
              <th width="6%" align="left">选择</th>
              <th width="12%" align="left">收货人</th>
              <th width="12%" align="left">电话号码</th>
              <th width="8%" align="left">邮政编码</th>
              <th align="left">详细地址</th>
            </tr>
            </thead>
            <tbody>
            @if($address)

            @foreach($address as $t)
            <tr>
              <td align="left"><input type="radio" name="address" value="{{ $t['id'] }}" @if($t['default_value'])
checked=""@endif
></td>
              <td align="left">{{ $t['name'] }}</td>
              <td align="left">{{ $t['tel'] }}</td>
              <td align="left">{{ $t['zip'] }}</td>
              <td align="left">{{ $t['address'] }}</td>
            </tr>
            @endforeach
            @else

            <tr>
              <td align="left">添加</td>
              <td align="left"><input name="data[name]" class="input-text" type="text" style="width:60px;" /></td>
              <td align="left"><input name="data[tel]" class="input-text" type="text" style="width:100px;" /></td>
              <td align="left"><input name="data[zip]" class="input-text" type="text" style="width:60px;" /></td>
              <td align="left"><input name="data[address]" class="input-text" type="text" style="width:300px;" /></td>
            </tr>
            @endif

            </tbody>
            </table>
            @if($shipping)

            <div class="j-pdt" style="margin:10px 0 10px 0"><h2>选择配送方式</h2></div>
            <table width="100%" class="table-list" cellspacing="0" cellpadding="0" border="0">
            <thead>
            <tr>
              <th width="6%" align="left">选择</th>
              <th width="16%" align="left">物流名称</th>
              <th width="12%" align="left">费用</th>
              <th align="left">描述</th>
            </tr>
            </thead>
            <tbody>
            @foreach($shipping as $t)
            <input name="shipping_{{ $t['id'] }}" id="shipping_{{ $t['id'] }}" type="hidden" value="{{ $t['price'] }}" />
            <tr>
              <td align="left"><input type="radio" name="shipping" value="{{ $t['id'] }}" onclick="set_price(this.value)"></td>
              <td align="left">{{ $t['name'] }}</td>
              <td align="left">￥{{ $t['price'] }}元</td>
              <td align="left">{{ $t['description'] }}</td>
            </tr>
            @endforeach
            </tbody>
            </table>
            <script language="javascript">
            function set_price(id) {
                var price = $('#shipping_'+id).val();
                var value = Number({{ $total_price }}, 2) + Number(price, 2);
                $('#total_price').html(Number(value,2))
            }
            </script>
            @endif

            <div class="j-pdt" style="margin:10px 0 10px 0; padding-bottom:10px;">
            <h2 style="color: #CC0000;font-family: tahoma; font-weight: bold; float:right;">
            实付款： ￥<b id="total_price">{{ $total_price }}</b>元。&nbsp;&nbsp;&nbsp;&nbsp;
            验证码：
            <input name="code" type="text" class="input-text" style="width:50px; margin-right:2px;" />
            <img id="code" src="{{ url("api/captcha/", array("width"=>80, "height"=>18)) }}" align="absmiddle" title="看不清楚？换一张" onclick="this.src='{{ url("api/captcha/", array("width"=>80, "height"=>18))}}&'+Math.random();" style="cursor:pointer;">
            <input type="submit" value="提交订单" name="submit" class="button">
            </h2>
            </div>
            </form>
       </div>
    </div>
    <!--end-->
    <div class="clear blank10"></div>
@include('footer')