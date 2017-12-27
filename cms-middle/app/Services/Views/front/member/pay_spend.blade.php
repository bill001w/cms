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
            @end
			</ul>
			</div>
        </div>
		<div class="center_right">
            <div class="title_right1"></div>
			<div class="content_info">
                <form action="" method="post">
			    <div style="background-color:#FFFCED;border: 1px solid #FFBE7A;line-height: 20px;padding: 8px 10px;margin-bottom:10px;">
			    <a href="{{ purl('member/spend', array('time'=>1)) }}" @if($time==1)
style="color:red;font-weight:bold"@endif
>最近一周</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
				<a href="{{ purl('member/spend', array('time'=>2)) }}" @if($time==2)
style="color:red;font-weight:bold"@endif
>最近一月</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
				<a href="{{ purl('member/spend', array('time'=>3)) }}" @if($time==3)
style="color:red;font-weight:bold"@endif
>最近半年</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
				<a href="{{ purl('member/spend', array('time'=>4)) }}" @if($time==4)
style="color:red;font-weight:bold"@endif
>最近一年</a>
				</div>
                <table class="datatable" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td width="150">消费时间</td>
                            <td width="150">消费金额</td>
                            <td>备注</td>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach($list as $t)
                      <tr>
                        <td>{{ date("Y-m-d H:i:s", $t['addtime']) }}</td>
                        <td><span style="color:red;font-weight:bold;">-{{ $t['money'] }}</span></td>
                        <td>{{ $t['note'] }}</td>
                      </tr>
                      @end
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
{template member/footer}