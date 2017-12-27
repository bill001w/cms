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
                <li @if($n==='verify')
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
                <table class="datatable" border="0" cellpadding="0" cellspacing="0" width="100%">
				<thead>
					<tr>
						<td>标题</td>
						<td width="80">栏目</td>
						<td width="130">发布时间</td>
						<td width="80">操作</td>
					</tr>
				</thead>
				<tbody>
				@foreach($list as $t)
					<tr>
						<td><a href="{{ url('member/content/editverify/', array('id'=>$t['id'])) }}">{{ get_content_status($t['status'])}}{{ $t['title'] }}</a></td>
						<td><a href="{{ $cats[$t['catid']]['url'] }}" target="_blank">{{ $cats[$t['catid']]['catname'] }}</a></td>
						<td>@if(date('Y-m-d')==date('Y-m-d',$t['updatetime']))

						<span style="color:#F00">{{ date("Y-m-d H:i:s", $t['updatetime']) }}</span>
						@else

						{{ date("Y-m-d H:i:s", $t['updatetime']) }}
						@endif
</td>
						<td>
						<a href="{{ url('member/content/editverify/', array('id'=>$t['id'])) }}">修改</a>&nbsp;
						<a href="javascript:;" onClick="if(confirm('确定删除吗？')){ window.location.href='{{ url('member/content/delverify/', array('id'=>$t['id'])) }}'; }">删除</a>
						</td>
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