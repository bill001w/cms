{template member/header}
<script language="javascript">
function checkuser() {
	$('#err_username').html("");
	$.getJSON('{{ SITE_PATH }}index.php?s=member&c=register&a=checkuser&id='+Math.random(), { username:$('#username').val()}, function(data){
	if (data.result==1) {
		$('#err_username').html(data.msg);
	} else {
		$('#err_username').html(data.msg);
		$('#username').focus();
	} 
	});
}
function checkemail() {
	$('#err_email').html("");
	$.getJSON('{{ SITE_PATH }}index.php?s=member&c=register&a=checkemail&id='+Math.random(), { email:$('#email').val()}, function(data){
   if (data.result==1) {
		$('#err_email').html(data.msg);
	} else {
		$('#err_email').html(data.msg);
		$('#email').focus();
	}
	});
}
function checkpass() {
	var pass1 = $('#password').val();
	var pass2 = $('#password2').val();
	if (pass1 != pass2) {
		$('#checkpassword2').html('<span class="form-tip tip-error">两次密码不一致</span>');
		$('#password').focus();
	}
}
function ctab(id) {
	if (id==1) {
		$('#c1').show();
		$('#c2').hide();
		$('#active1').addClass('select');
		$('#active2').removeClass('select');
	} else {
		$('#c1').hide();
		$('#c2').show();
		$('#active2').addClass('select');
		$('#active1').removeClass('select');
	}
}
</script>
<div id="wrapper">
	<div class="top"></div>
	<div class="center1 password_management">
        <div class="title_r">登录绑定</div>
        <div class="token_process">
            <div class="p_mobile">
                <ul>
                    <li><a class="select" id="active1" onclick="ctab(1)" href="###">完善账号信息</a></li>
                    <li><a id="active2" onclick="ctab(2)" href="###" class="">绑定我的帐号</a></li>
                </ul>
            </div>
                <div id="c1" style="display: block;">
                    <form action="{{ url("member/register/bang") }}" method="post">
                    <input name="type" type="hidden" value="reg">
                    <ul>
                    @if(count($membermodel)>1)

                    <li>会员模型：<select name="data[modelid]" style="height:29px;"> @foreach($membermodel as $t)<option value="{{ $t['modelid'] }}" @if($memberconfig['modelid']==$t['modelid'])
selected@endif
>{{ $t['modelname'] }}</option>@end </select>
                    </li>
                    @endif

                    <li>会员账号：<input type="text" class="input_text" name="data[username]" id="username" onblur="checkuser()" />
                    <span id="err_username" class="tips_info"></span>
                    </li>
                    <li>会员密码：<input type="password" class="input_text" name="data[password]" id="password"/>
                    </li>
                    <li>确认密码：<input type="password" class="input_text" name="data[password2]" id="password2" onblur="checkpass()" />
                    <span id="checkpassword2" class="tips_info"></span>
                    </li>
                    <li>安全邮箱：<input type="text" class="input_text" onblur="checkemail()" name="data[email]" id="email" />
                    <span id="err_email" class="tips_info"></span>
                    </li>
                    <li>会员昵称：<input type="text" class="input_text" name="data[nickname]" value="{{ $data['name'] }}" /></li>
                    <li>会员头像：<img src="{{ $data[avatar] }}"><input name="data[avatar]" type="hidden" value="{{ $data[avatar] }}"></li>
                    <li><input type="submit" value="绑 定" class="btn" name="submit"/></li>
                    </ul>
                    </form>
                </div>
                
                <div style="display: none;" id="c2">
                    <form action="{{ url("member/register/bang") }}" method="post">
                    <input name="type" type="hidden" value="bang">
                    <ul>
                    <li>会员账号：<input type="text" class="input_text" name="data[username]" /></li>
                    <li>会员密码：<input type="password" class="input_text" name="data[password]" />
                    </li>
                    <li><input type="submit" value="绑 定" class="btn" name="submit"/></li>
                    </ul>
                    </form>
                </div>
        </div>
    </div>
    <div id="index_bottom"></div>
</div>
{template member/footer}