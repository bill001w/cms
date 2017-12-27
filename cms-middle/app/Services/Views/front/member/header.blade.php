<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>{{ $meta_title }}</title>
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
<link href="/views/admin/member/images/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
</head>
<body>
<!--Header-->
<div id="headerAll">
	<div id="header">
    	<div id="top">
		    <a class="logo" href="{{ SITE_PATH }}" ><cite>会员中心</cite></a>
        	<div class="right_info">
            <ul>
            @if($memberinfo)

            <li>欢迎您，<a href="{{ url('member/space/', array('userid'=>$memberinfo['id'])) }}">@if($memberinfo['nickname'])
{{ $memberinfo['nickname'] }}@else
{{ $memberinfo['username'] }}@endif
</a></li>
            <li><a href="{{ url('member/content/') }}">管理</a></li>
			<li><a href="{{ url('member/pms/inbox') }}">消息</a></li>
			<li><a href="{{ url('member/login/out') }}">退出</a></li>
            @else

            <li><a href="{{ url('member/register') }}">注册</a></li>
            <li><a href="{{ url('member/login') }}">登录</a></li>
            @endif

            </ul>
            </div>
        </div>
    	<div id="menu">
        	<ul>
            @if($memberinfo)

            <li><a href="{{ url('member') }}"><span>会员首页</span></a></li>
			<li><a href="{{ url('member/info/edit/') }}"><span>资料信息</span></a></li>
			<li><a href="{{ url('member/content/') }}"><span>内容管理</span></a></li>
			<li><a href="{{ url('member/pms/inbox') }}"><span>短消息</span></a></li>
            @if(plugin('pay'))
<li><a href="{{ url('pay/member') }}"><span>资金管理</span></a></li>@endif

		    @if(plugin('shop'))
<li><a href="{{ url('shop/member') }}"><span>购物管理</span></a></li>@endif

			<li><a href="{{ url('member/login/out') }}"><span>安全退出</span></a></li>
			@else

			<li><a href="{{ SITE_PATH }}"><span>首页</span></a></li>
			@foreach($cats as $t)
			@if($t['parentid']==0 && $t['ismenu'])

			<li><a href="{{ $t['url'] }}"><span>{{ $t['catname'] }}</span></a></li>
			@endif

			@endforeach
            @endif

            </ul>
        </div>
    </div>
</div>
<!--Header End-->