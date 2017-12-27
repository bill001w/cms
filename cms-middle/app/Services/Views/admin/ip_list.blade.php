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
    <script type="text/javascript" src="{{ LANG_PATH }}lang.js"></script>
    @include('admin.top')
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/ip') }}" class="on"><em>{{ lang('a-men-67')}}</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'ip-add'))
            <a href="{{ url('admin/ip/add') }}"><em>{{ lang('a-add')}}</em></a><span>|</span> @endif

        <a href="{{ url('admin/ip/cache') }}"><em>{{ lang('a-cache')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="explain-col">
        <form action="" method="post">
            Ip：<input type="text" class="input-text" size="20" name="kw"/>
            &nbsp;&nbsp;
            <input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-search') }}" name="submit"/>&nbsp;&nbsp;
        </form>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post" name="myform">
            <table width="100%" class="table table-striped">
                <thead>
                <tr>
                    <th width="20" align="right"><input name="deletec" id="deletec" type="checkbox" onClick="setC()"/>
                    </th>
                    <th width="120" align="left">Ip</th>
                    <th width="130" align="left">{{ lang('a-aip-3') }}</th>
                    <th width="130" align="left">{{ lang('a-aip-4') }}</th>
                    <th align="left">{{ lang('a-aip-5') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $t)
                    <tr>
                        <td align="right"><input name="del_{{ $t['id'] }}" type="checkbox" class="deletec"/></td>
                        <td align="left"><a href="{{ url('admin/ip/edit', array('id'=>$t['id'])) }}">{{ $t['ip'] }}</a>
                        </td>
                        <td align="left">{{ date(TIME_FORMAT, $t['addtime']) }}</td>
                        <td align="left">@if($t['endtime'])
                                {{ date(TIME_FORMAT, $t['endtime']) }} @endif
                        </td>
                        <td align="left">@if($t['endtime'])
                                <?php $time = round(($t['endtime'] - $t['addtime']) / (3600)); echo $time > 0 ? $time['lang']('a-aip-12') : lang('a-aip-7'); ?>@else
                                {{ lang('a-aip-9') }} @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="9" align="left"><input @if(!admin_auth($userinfo['roleid'], 'ip-del'))
                                                        disabled @endif
                                                        type="submit" class="btn btn-success btn-sm"
                                                        value="{{ lang('a-del') }}" name="submit_del"/>&nbsp;</td>
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
</script>
</body>
</html>