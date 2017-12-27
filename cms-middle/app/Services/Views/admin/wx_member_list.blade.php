<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/images/main.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet"><link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(
            function(){
                $("#dr_select").click(
                   function()
                   {
                       if($("#dr_select").attr('checked')) {
                           $(".dr_select").attr("checked",true);
                       } else {
                           $(".dr_select").attr("checked",false);
                       }
                   }
                )
            }
        );
    </script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/wx/user') }}" class="on"><em>用户管理</em></a><span>|</span>
        <a href="{{ url('admin/wx/syncUsers') }}"><em>同步用户</em></a><span>|</span>
    </div>
    <div class="bk10"></div>
    <div class="table-list">
        <form action="{{ url('admin/wx/userSend') }}" method="post" name="myform">
            <input name="action" id="action" type="hidden" />
            <table width="100%">
                <thead>
                <tr>
                    <th width="20" align="right"><input name="dr_select" id="dr_select" type="checkbox" onClick="" />&nbsp;</th>
                    <th width="50"align="center">头像</th>
                    <th width="120" align="left">昵称</th>
                    <th width="50" align="center">性别</th>
                    <th width="90" align="left">地区</th>
                    <th width="130" align="left">关注时间</th>
                    <th align="left" class="dr_option">地理位置</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $t)
                <tr>
                    <td align="right"><input name="ids[]" type="checkbox" class="dr_select" value="{{ $t['id'] }}" />&nbsp;</td>
                    <td align="center"><img src="{{ $t['headimgurl'] }}46" width="30" height="30"></td>
                    <td align="left">{{ $t['nickname'] }}</td>
                    <td align="center">@if($t['sex']==1)
男@elseif($t['sex']==2)
女@else
未知 @endif
</td>
                    <td align="left">{{ $t['province'] }} - {{ $t['city'] }}</td>
                    <td align="left">{{ date('Y-m-d',$t['subscribe_time']) }}</td>
                    <td align="left" class="dr_option">
                        @if($t['location_x'] && $t['location_y'])
{{ $t['location_x'] }},{{ $t['location_y'] }}@if($t['location_info'])
 （{{ $t['location_info'] }}） @endif
 @endif

                    </td>
                </tr>
                @end

                <tr>
                    <td colspan="99" align="left">
                        <input type="submit" class="btn btn-success btn-sm" name="option" value="推送消息给选中用户" onclick="$('#action').val('sel')">
                        <input type="submit" class="btn btn-success btn-sm" name="option" value="推送消息给所有用户" onclick="$('#action').val('all')">
                    </td>
                </tr>
            </table>
            {{ str_replace('<a>共' . $total . '条</a>', '<a>耗时' . runtime() . '秒</a><a>共' . $total . '条</a>', $pages) }}
        </form>
    </div>
</div>

</body>
</html>