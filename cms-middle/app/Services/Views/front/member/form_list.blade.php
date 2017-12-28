{template member/header}
<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/views/admin/js/dialog.js"></script>
<!--Wrapper-->
<div id="wrapper">
	<div class="top"></div>
	<div class="center">
	    <div class="center_left">
	        <h3>内容管理</h3>
			<div class="menu_left">
			<ul>
            @foreach($navigation as $n => $t)
                <li @if($n && $form['tablename']==$n)
 class="on"@endif
><a href="{{ $t['url'] }}">{{ $t['name'] }}</a></li>
            @endforeach
			</ul>
			</div>
        </div>
		<div class="center_right">
			@if(empty($showme))

            <div class="title_right1"></div>
			<div class="content_info">
			@else

			<div class="content_info" style="padding-top:7px;">
                <div class="p_mobile" style="padding:0">
					<ul>
						<li><a @if(empty($type))
class="select"@endif
 href="{{ url('member/content/form/',array('type'=>0,'modelid'=>$modelid)) }}">我提交的</a></li>
						<li><a @if($type)
class="select"@endif
  href="{{ url('member/content/form/',array('type'=>1,'modelid'=>$modelid)) }}">与我相关</a></li>
					</ul>
				</div>
			@endif

                <form action="" method="post">
                <table class="datatable" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <td width="22">@if(empty($type))
<input name="selectc" id="selectc" type="checkbox" onClick="setC()">@endif
</td>
                            @if($join)

							<td width="60">{{ $join }}Id</td>
							@endif

                            <td>&nbsp;</td>
                            <td width="130">提交时间</td>
                            <td width="80">操作</td>
                        </tr>
                    </thead>
                    <tbody>
					@foreach($listdata as $t)
						<tr>
							<td>@if(empty($type))
<input name="ids[]" type="checkbox" class="selectc" value="{{ $t['id'] }}">@endif
</td>
							@if($join)

							<td><a href="{{ url('member/content/form/',array('type'=>$type,'cid'=>$t['cid'],'modelid'=>$modelid)) }}">{{ $t['cid'] }}</a></td>
							@endif

							<td>根据实际情况把一些字段展示出来</td>
							<td>@if(date('Y-m-d')==date('Y-m-d',$t['inputtime']))

							 <span style="color:#F00">{{ date("Y-m-d H:i:s", $t['inputtime']) }}</span>
							 @else

							 {{ date("Y-m-d H:i:s", $t['inputtime']) }}
							 @endif
</td>
							<td>
								@if($form['setting']['form']['edit'])
<a href="{{ url('member/content/formedit/', array('id'=>$t['id'], 'modelid'=>$modelid)) }}">修改</a>@endif

								<a href="{{ form_show_url($modelid, $t) }}" target="_blank">访问</a>@if($t['status']!=1)
({{ get_form_status($t['status']) }})@endif

							</td>
						</tr>
					@endforeach
                    </tbody>
                </table>
                <div class="datatablepage">
                <table width="100%" border="0">
                  <tr>
                    <td width="100">@if(empty($type))
<input type="submit" class="button" value="删除" name="submit">@endif
</td>
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
	if($("#selectc").attr('checked')) {
		$(".selectc").attr("checked",true);
	} else {
		$(".selectc").attr("checked",false);
	}
}
</script>
{template member/footer}