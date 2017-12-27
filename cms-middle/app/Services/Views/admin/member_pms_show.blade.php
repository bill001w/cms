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
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/member/pms/') }}"><em>{{ lang('a-mem-57')}}</em></a><span>|</span>
        <a href="javascript:;" class="on"><em>{{ lang('a-mem-75') }}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-list">
        <form action="" method="post">
            <table width="100%" class="table_form">
                <tr>
                    <th width="200">{{ lang('a-mem-60') }}：</th>
                    <td>{{ $data['sendname'] }}</td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-61') }}：</th>
                    <td>{{ $data['toname'] }}</td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-59') }}：</th>
                    <td>{{ $data['title'] }}</td>
                </tr>
                <tr>
                    <th valign="top">{{ lang('a-mem-72') }}：</th>
                    <td>{{ htmlspecialchars_decode($data['content']) }}</td>
                </tr>
                <tr>
                    <th>{{ lang('a-option') }}：</th>
                    <td><input class="btn btn-success btn-sm" type="submit" name="submit" value="{{ lang('a-del') }}"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>