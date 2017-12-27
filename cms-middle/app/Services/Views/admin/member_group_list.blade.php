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
        <a href="{{ url('admin/member/group') }}" class="on"><em>{{ lang('a-mem-30')}}</em></a><span>|</span>
        <a href="{{ url('admin/member/group/add') }}"><em>{{ lang('a-add')}}</em></a><span>|</span>
        <a href="{{ url('admin/member/group/cache') }}"><em>{{ lang('a-cache')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post" name="myform">
            <input name="form" id="list_form" type="hidden" value="order">
            <table width="100%" class="table table-striped">
                <thead>
                <tr>
                    <th width="20" align="right"><input name="deletec" id="deletec" type="checkbox" onClick="setC()"/>
                    </th>
                    <th width="33" align="left">{{ lang('a-order') }}</th>
                    <th width="90" align="left">{{ lang('a-name') }}</th>
                    <th width="55" align="center">{{ lang('a-mem-76') }}</th>
                    <th width="55" align="center">{{ lang('a-mem-77') }}</th>
                    <th width="55" align="center">{{ lang('a-mem-78') }}</th>
                    <th width="55" align="center">{{ lang('a-mem-79') }}</th>
                    <th width="80" align="center">{{ lang('a-mem-80') }}</th>
                    <th width="80" align="center">{{ lang('a-mem-81') }}</th>
                    <th width="80" align="center">{{ lang('a-mem-125') }}</th>
                    <th align="left">{{ lang('a-option') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $t)
                    <tr height="25">
                        <td align="right"><input name="del_{{ $t['id'] }}" type="checkbox" class="deletec"></td>
                        <td align="left"><input type="text" name="order_{{ $t['id'] }}" class="input-text"
                                                style="width:25px;margin:none;" value="{{ $t['listorder'] }}"/></td>
                        <td align="left">{{ $t['name'] }}</td>
                        <td align="center">{{ $t['credits'] }}</td>
                        <td align="center">{{ $t['allowpost'] }}</td>
                        <td align="center">{{ $t['allowpms'] }}</td>
                        <td align="center">@if(empty($t['filesize']))
                                {{ lang('a-mem-82') }}@else
                                {{ $t['filesize'] }}MB @endif
                        </td>
                        <td align="center"><?php echo $t['allowattachment'] ? "<font color=green>√</font>" : "<font color=red>×</font>" ?></td>
                        <td align="center"><?php echo $t['auto'] ? "<font color=red>×</font>" : "<font color=green>√</font>" ?></td>
                        <td align="center"><?php echo !$t['postverify'] ? "<font color=red>×</font>" : "<font color=green>√</font>" ?></td>
                        <td align="left">
                            <?php $del = url('admin/member/group/delete') . '?id=' . $t['id'];?>
                            <a href="<?php echo url('admin/member/group/edit') . '?id=' . $t['id']; ?>">{{ lang('a-edit') }}</a>
                            |
                            <a href="javascript:;"
                               onClick="if(confirm('{{ lang('a-confirm') }}')){ window.location.href='{{ $del }}'; }">{{ lang('a-del')}}</a>
                        </td>
                    </tr>
                @endforeach
                <tr height="25">
                    <td colspan="9" align="left">
                        <input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-del') }}"
                               name="submit_del" onClick="$('#list_form').val('del');return confirm_del()"/>&nbsp;
                        <input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-order') }}"
                               name="submit_order" onClick="$('#list_form').val('order')"/>&nbsp;
                    </td>
                </tr>
            </table>
            {{ $pagelist }}
        </form>
    </div>
</div>
<script type="text/javascript">
    function setC() {
        if ($("#deletec").attr('checked')) {
            $(".deletec").attr("checked", true);
        } else {
            $(".deletec").attr("checked", false);
        }
    }
    function confirm_del() {
        if (confirm('{{ lang('a-confirm') }}')) {
            document.myform.submit();
            return true;
        } else {
            return false;
        }
    }
</script>
</body>
</html>