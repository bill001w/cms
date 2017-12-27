<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/main.css" rel="stylesheet" type="text/css"/>
    @include('admin.top')
    <link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript">
        function del(id) {
            if (confirm('{{ lang('a-confirm') }}')) {
                var url = "{{ url('admin/auth/del') }}" + "/" + id;
                window.location.href = url;
            }
        }
    </script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/auth/') }}" class="on"><em>{{ lang('a-aut-7')}}</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'auth-add'))
            <a href="{{ url('admin/auth/add') }}"><em>{{ lang('a-aut-8')}}</em></a><span>|</span> @endif

        @if(admin_auth($userinfo['roleid'], 'auth-cache'))
            <a href="{{ url('admin/auth/cache') }}"><em>{{ lang('a-cache')}}</em></a> @endif

    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <table class="table table-striped" width="100%">
            <thead>
            <tr>
                <th width="30">ID</th>
                <th width="150" align="left">{{ lang('a-name') }}</th>
                <th width="250" align="left">{{ lang('a-desc') }}</th>
                <th align="left">{{ lang('a-option') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $t)
                <tr>
                    <td align="center">{{ $t['roleid'] }}</td>
                    <td align="left">{{ $t['rolename'] }}</td>
                    <td align="left">{{ $t['description'] }}</td>
                    <td align="left">
                        @if(admin_auth($userinfo['roleid'], 'auth-list'))
                            <a href="{{ url('admin/auth/list',array('roleid'=>$t['roleid'])) }}">{{ lang('a-aut-9')}}</a>
                            |  @endif

                        @if(admin_auth($userinfo['roleid'], 'user-index'))
                            <a href="{{ url('admin/user/index',array('roleid'=>$t['roleid'])) }}">{{ lang('a-aut-10')}}</a>
                            |  @endif

                        @if(admin_auth($userinfo['roleid'], 'auth-edit'))
                            <a href="{{ url('admin/auth/edit',array('roleid'=>$t['roleid'])) }}">{{ lang('a-edit')}}</a>
                            |  @endif

                        @if(admin_auth($userinfo['roleid'], 'auth-del'))
                            <a href="javascript:del({{ $t['roleid'] }});">{{ lang('a-del') }}</a>   @endif

                    </td>
                </tr>
            @endforeach
            <tbody>
        </table>
    </div>
</div>
</body>
</html>