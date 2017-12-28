@if($memberinfo)

您好，{{ $memberinfo['username'] }}@if($memberinfo['nickname'])
({{ $memberinfo['nickname'] }})@endif
&nbsp;&nbsp;&nbsp;
<a href="{{ url('member') }}">个人中心</a>&nbsp;&nbsp;&nbsp;
<a href="{{ url('member/content/') }}">内容管理</a>&nbsp;&nbsp;&nbsp;
<a href="{{ url('member/login/out') }}">安全退出</a>
@else

<a href="{{ url('member/register') }}">免费注册</a>&nbsp;&nbsp;&nbsp;
<a href="{{ url('member/login') }}">会员登录</a>&nbsp;&nbsp;&nbsp;
@if($memberconfig['isoauth'])

@foreach($memberconfig['oauth'] as $name => $t)
@if($t['appid'] && $t['appkey'])

<a href="{{ url("member/login/oauth", array("name"=>$name)) }}"><img src="/views/admin/images/{{ strtolower($name)}}_login.gif" align="absmiddle" border="0"></a>&nbsp;&nbsp;
@endif

@endforeach
@endif

@endif
