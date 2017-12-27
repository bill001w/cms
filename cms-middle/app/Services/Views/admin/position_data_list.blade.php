<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/main.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript" src="/views/admin/js/dialog.js"></script>
    @include('admin.top')
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/position') }}"><em>{{ lang('a-men-31')}}</em></a><span>|</span>
        <a href="{{ url('admin/position/list',array('posid'=>$posid)) }}"
           class="on"><em>{{ lang('a-pos-0')}}</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'position-adddata'))
            <a href="{{ url('admin/position/adddata',array('posid'=>$posid)) }}"><em>{{ lang('a-add')}}</em></a>
            <span>|</span> @endif
        @if(admin_auth($userinfo['roleid'], 'position-cache'))
            <a href="{{ url('admin/position/cache') }}"><em>{{ lang('a-cache')}}</em></a> @endif
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post" name="myform">
            <table width="100%" class="table table-striped">
                <thead>
                <tr>
                    <th width="20" align="right"><input name="deletec" id="deletec" type="checkbox" onClick="setC()"/>
                    </th>
                    <th width="45" align="left">{{ lang('a-order') }}</th>
                    <th width="50" align="left">ID</th>
                    <th width="80" align="left">{{ lang('a-con-29') }} </th>
                    <th width="400" align="left">{{ lang('a-con-26') }}</th>
                    <th align="left">{{ lang('a-option') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $t)
                    <tr>
                        <td align="right"><input name="del_{{ $t['id'] }}" type="checkbox" class="deletec"/></td>
                        <td align="left"><input type="text" name="order_{{ $t['id'] }}" class="input-text"
                                                style="width:35px;" value="{{ $t[listorder] }}"/></td>
                        <td align="left">{{ $t['id'] }}</td>
                        <td align="left">@if($t['catid'])
                                {{ $cats[$t['catid']]['catname'] }}@else
                                <font color="green">{{ lang('a-pos-4') }}</font> @endif
                        </td>
                        <td align="left">
                            <div style="overflow:hidden;height:22px;width:322px;">@if($t['thumb'])
                                    <font color="#FF0000">[{{ lang('a-pos-7') }}]</font> @endif
                                {{ $t[title] }}</div>
                        </td>
                        <td align="left">
                            <?php $del = url('admin/position/deldata', array('id' => $t['id']));?>
                            <a href="{{ $t['url'] }}" target="_blank">{{ lang('a-cat-23') }}</a> |
                            @if(admin_auth($userinfo['roleid'], 'position-editdata'))
                                <a href="{{ url('admin/position/editdata',array('posid'=>$posid,'id'=>$t['id'])) }}">{{ lang('a-edit')}}</a>  @endif

                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6" align="left">
                        <input @if(!admin_auth($userinfo['roleid'], 'position-editdata'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-order') }}"
                               name="submit_order" onClick="$('#list_form').val('order')"/>&nbsp;
                        <input @if(!admin_auth($userinfo['roleid'], 'position-deldata'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-del') }}"
                               name="submit_del" onClick="return confirm_del()"/>&nbsp;
                        <div class="onShow">{{ lang('a-pos-8')}}</div>
                    </td>
                </tr>
                </tbody>
            </table>
            {{ $pagelist }}
        </form>
    </div>
</div>
<script type="text/javascript">
    function confirm_del() {
        if (confirm('{{ lang('a-confirm') }}')) {
            $('#list_form').val('del');
            return true;
        } else {
            return false;
        }
    }
    function setC() {
        if ($("#deletec").attr('checked')) {
            $(".deletec").attr("checked", true);
        } else {
            $(".deletec").attr("checked", false);
        }
    }
</script>
</body>
</html>