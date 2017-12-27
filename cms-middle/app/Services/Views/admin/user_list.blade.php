<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/main.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css"/>
    @include('admin.top')
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript">
        function del(id) {
            if (confirm('{{ lang('a-confirm') }}')) {
                var url = "{{ url('admin/user/del') }}" + '/' + id;
                window.location.href = url;
            }
        }
    </script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/user/') }}" class="on"><em>{{ lang('a-use-5')}}</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'user-add'))
            <a href="{{ url('admin/user/add') }}"><em>{{ lang('a-use-6')}}</em></a> @endif
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <table width="100%" class="table table-striped">
            <thead>
            <tr>
                <th width="20" align="left">ID</th>
                <th width="130" align="left">{{ lang('a-user') }}</th>
                <th width="100" align="left">{{ lang('a-use-7') }}</th>
                <th width="120" align="left">{{ lang('a-sit-21') }}</th>
                <th width="120" align="left">{{ lang('a-use-8') }}</th>
                <th width="120" align="left">{{ lang('a-use-9') }}</th>
                <th align="left">{{ lang('a-option') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $t)
                <tr>
                    <td align="left">{{ $t['uid'] }}</td>
                    <td align="left">{{ $t['username'] }} ({{ $t['realname'] }})</td>
                    <td align="left">{{ $t['rolename'] }}</td>
                    <td align="left">@if($t['site'])
                            {{ $sites[$t['site']]['SITE_NAME'] }}@else
                            {{ lang('a-sit-22') }} @endif
                    </td>
                    <td align="left"><a href="http://www.baidu.com/baidu?wd={{ $t['lastloginip'] }}"
                                        target=_blank>{{ $t['lastloginip'] }}</a></td>
                    <td align="left">{{ date(TIME_FORMAT,$t['lastlogintime']) }}</td>
                    <td align="left">
                        @if(admin_auth($userinfo['roleid'], 'user-edit'))
                            <a href="{{ url('admin/user/edit',array('uid'=>$t['uid'])) }}">{{ lang('a-edit')}}</a>
                            |  @endif
                        @if(admin_auth($userinfo['roleid'], 'user-del'))
                            <a href="javascript:del({{ $t['uid'] }});">{{ lang('a-del') }}</a>  @endif
                    </td>
                </tr>
            @endforeach
            <tbody>
        </table>
    </div>
</div>
</body>
</html>