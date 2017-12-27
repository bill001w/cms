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
    <div class="content-menu ib-a blue line-x" style="padding-top:8px">
        <a class="on" href="{{ url('admin/index/bq') }}"><em>{{ lang('dr003')}}</em></a>
    </div>
    <div class="explain-col mb10">FineCMS企业版永久免费开源，推荐在此基础上进行二次开发或者发行，支持修改程序版权并发行新的程序</div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post">
            <table width="100%" class="table table-striped">
                <tr>
                    <th width="200">程序名称：</th>
                    <td><input class="input-text" type="text" name="data[cms]" value="{{ $data['cms'] }}" size="30"/>
                    </td>
                </tr>

                <tr>
                    <th width="200">版本名称：</th>
                    <td><input class="input-text" type="text" name="data[name]" value="{{ $data['name'] }}" size="30"/>
                    </td>
                </tr>
                <tr>
                    <th width="200">版权所有：</th>
                    <td><input class="input-text" type="text" name="data[company]" value="{{ $data['company'] }}"
                               size="50"/></td>
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