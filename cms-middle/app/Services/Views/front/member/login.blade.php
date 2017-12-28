{template member/header}
<!--Wrapper-->
<div id="loginbar">
    <div id="login">
        <div id="login_alert" class="login">
            <h3>用户登录</h3>
			<div class="main" style="border:0px;">
                <div id="normal_login">
                    <div id="web_login">
                        <form  action="" method="post" >
						<input type="hidden" value="{{ $backurl }}" name="data[back]">
                        <ul id="g_list">
                        <li>
                            <span><u>&nbsp;&nbsp;会员：</u></span> <input type="text" class="inputstyle" name="data[username]" tabindex="1" /><label><a href="{{ url('member/register') }}" target="_blank">注册新会员</a></label>
                        </li> 
                        <li>
                            <span><u>&nbsp;&nbsp;密码：</u></span><input type="password" class="inputstyle" name="data[password]" tabindex="2" /><label><a href="{{ url('member/repass') }}" target="_blank">忘了密码？</a></label>
                        </li>
                        @if($memberconfig['logincode'])

                        <li>
                            <span for="code"><u>&nbsp;&nbsp;验证：</u></span><input name="code" type="text" style="width:110px;" tabindex="3" class="inputstyle" /><label style="margin-top:0px;"><img id="code" src="{{ url("api/captcha/", array("width"=>80, "height"=>28)) }}" align="absmiddle" title="看不清楚？换一张" onclick="document.getElementById('code').src='{{ url("api/captcha/", array("width"=>80, "height"=>28))}}&'+Math.random();" style="cursor:pointer; float:left"></label>
                        </li>
                        @endif

                        </ul> 
                        <div class="login_button">
                            <input type="submit" value="登 录" class="btn" tabindex="4" name="submit"/>
                            <label><input type="checkbox" id="cookie" name="data[cookie]" value="1" /> 记住登录状态</label>
                        </div>
                        @if($memberconfig['isoauth'])

                        <div style="padding-top:40px; padding-left:0px; text-align:center">
                        @foreach($memberconfig['oauth'] as $name => $t)
                        @if($t['appid'] && $t['appkey'])

                        <a href="{{ url("member/login/oauth", array("name"=>$name)) }}"><img src="/views/admin/images/{{ strtolower($name)}}_login.gif" align="absmiddle" border="0"></a>&nbsp;&nbsp;
                        @endif

                        @endforeach
                        </div>
                        @endif

                        </form>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>
<!--Wrapper End-->
{template member/footer}