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
    @include('admin.top')
    <script type="text/javascript">
        function del(id) {
            if (confirm('{{ lang('a-mod-16') }}')) {
                var url = "{{ url('admin/model/del') }}" + "/" + id;
                window.location.href = url;
            }
        }
    </script>
    <title>admin</title>
</head>
<body>
<form action="" method="post">
    <div class="subnav">
        <div class="content-menu ib-a blue line-x">
            <a href="{{ url('admin/model/index',  array('typeid'=>$typeid)) }}"
               class="on"><em>{{ lang('a-aut-14')}}</em></a><span>|</span>
            @if(admin_auth($userinfo['roleid'], 'model-add'))
                <a href="{{ url('admin/model/add', array('typeid'=>$typeid)) }}"><em>{{ lang('a-add')}}</em></a>
                <span>|</span> @endif

            @if(admin_auth($userinfo['roleid'], 'model-cache'))
                <a href="{{ url('admin/model/cache', array('typeid'=>$typeid)) }}"><em>{{ lang('a-cache')}}</em></a> @endif

        </div>
        <div class="bk10"></div>
        <div class="table-responsive mytable">
            <table width="100%" class="table table-striped">
                <thead>
                <tr>
                    <th width="50" align="center">ID</th>
                    <th width="200" align="left">{{ lang('a-mod-19') }}</th>
                    <th align="left">{{ lang('a-option') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $t)
                    <?php $setting = string2array($t['setting']);$disable = isset($setting['disable']) && $setting['disable'] == 1 ? 1 : 0; ?>
                    <tr>
                        <td align="left">{{ $t['modelid'] }}</td>
                        <td align="left">{{ $t['tablename'] }}</td>
                        <td align="left">
                            @if(admin_auth($userinfo['roleid'], 'model-edit'))
                                <a href="{{ url('admin/model/edit',array('modelid'=>$t['modelid'])) }}">{{ lang('a-edit')}}</a>
                                |  @endif

                            @if(admin_auth($userinfo['roleid'], 'model-del'))
                                <a href="javascript:del({{ $t['modelid'] }});">{{ lang('a-del') }}</a>  @endif

                        </td>
                    </tr>
                @endforeach
                <tbody>
            </table>
        </div>
    </div>
</form>
</body>
</html>