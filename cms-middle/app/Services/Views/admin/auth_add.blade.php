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
    @include('admin.top')
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/auth/') }}"><em>{{ lang('a-aut-7')}}</em></a><span>|</span>
        <a href="{{ url('admin/auth/add') }}" class="on"><em>{{ lang('a-aut-8')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post">
            <input name="roleid" type="hidden" value="{{ $data['roleid'] }}">
            <table width="100%" class="table table-striped">
                <tr>
                    <th width="200">{{ lang('a-name') }}：</th>
                    <td><input class="input-text" type="text" name="rolename" value="{{ $data['rolename'] }}" size="30"
                               required/></td>
                </tr>
                <tr>
                    <th>{{ lang('a-desc') }}：</th>
                    <td class="y-bg"><textarea name="description" rows="3" cols="55"
                                               class="text">{{ $data['description'] }}</textarea></td>
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
</body>
</html>