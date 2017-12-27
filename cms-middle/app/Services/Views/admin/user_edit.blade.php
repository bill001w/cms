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
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="javascript:;" class="on"><em>{{ lang('a-men-63') }}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post">
            <table width="100%" class="table table-striped">
                <tr>
                    <th width="200">{{ lang('a-user') }}：</th>
                    <td><input type="hidden" value="{{ $data['username'] }}">{{ $data['username'] }}</td>
                </tr>
                <tr>
                    <th>{{ lang('a-pass') }}：</th>
                    <td><input class="input-text" type="password" name="password" value="" size="30"/>
                        <div class="onShow">{{ lang('a-use-10') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-use-11') }}：</th>
                    <td><input class="input-text" type="text" name="realname" value="{{ $data['realname'] }}"
                               size="30"/></td>
                </tr>
                <tr>
                    <th>Email：</th>
                    <td><input class="input-text" type="text" name="email" value="{{ $data['email'] }}" size="30"/></td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td><input class="btn btn-success btn-sm" type="submit" name="submit"
                               value="{{ lang('a-submit') }}"/></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">
    function add_menu() {
        var data = '<tr><td width="140">{{ lang('a-name') }}：<input class="input-text" type="text" name="menu[name][]" value="" size="10"/></td><td>{{ lang('a-address')}}：<input class="input-text" type="text" name="menu[url][]" size="50"/></td><td>&nbsp;</td></tr>';
        $('#menu_body').append(data);
    }
</script>
</body>
</html>