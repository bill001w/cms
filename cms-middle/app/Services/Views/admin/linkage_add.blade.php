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
    @include('admin.top')
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/linkage/') }}"><em>{{ lang('a-men-34')}}</em></a><span>|</span>
        <a href="{{ url('admin/linkage/add') }}" class="on"><em>{{ lang('a-add')}}</em></a><span>|</span>
        <a href="{{ url('admin/linkage/cache') }}"><em>{{ lang('a-cache')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post">
            <input name="id" type="hidden" value="{{ $data['id'] }}">
            <input name="keyid" type="hidden" value="{{ $keyid }}">
            <table width="100%" class="table table-striped">
                <tr>
                    <th width="200">{{ lang('a-lin-13') }}：</th>
                    <td><input class="input-text" type="text" name="name" value="{{ $data['name'] }}" size="20"/></td>
                </tr>
                <tr>
                    <th>{{ lang('a-sit-24') }}：</th>
                    <td><input type="radio" value="0" name="site" @if(empty($data['site']))
                        checked @endif
                        /> {{ lang('a-sit-25') }}&nbsp;&nbsp;
                        <input type="radio" value="1" name="site" @if($data['site']==1)
                        checked @endif
                        /> {{ lang('a-sit-26') }}
                        <div class="onShow">{{ lang('a-sit-27') }}</div>
                    </td>
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