{template member/header}
<div id="wrapper">
	<div class="top"></div>
	<form method="post" action="" name="myform" id="myform">
	<div class="center1 password_management">
        <div class="title_r">激活会员</div>
        <div class="token_process">
            <ul>
            @if(count($membermodel)>1)

            <li>会员模型：<select name="modelid" style="height:29px;"> @foreach($membermodel as $t)<option value="{{ $t['modelid'] }}" @if($memberconfig['modelid']==$t['modelid'])
selected@endif
>{{ $t['modelname'] }}</option>@end </select>
            </li>
            @endif

            <li>会员账号：{{ $username }}</li>
            <li><input type="submit" value="激活会员" class="btn" name="submit"/></li>
            </ul>
        </div>
    </div>
	</form>
    <div id="index_bottom"></div>
</div>
{template member/footer}