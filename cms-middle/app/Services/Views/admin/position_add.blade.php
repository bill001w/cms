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
        <a href="{{ url('admin/position/') }}"><em>{{ lang('a-men-31')}}</em></a><span>|</span>
        <a href="{{ url('admin/position/add/') }}" class="on"><em>{{ lang('a-add')}}</em></a><span>|</span>
        <a href="{{ url('admin/position/cache') }}"><em>{{ lang('a-cache')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form method="post" action="" id="myform" name="myform">
            <table width="100%" class="table table-striped">
                <tbody>
                <tr>
                    <th width="200">{{ lang('a-pos-2') }}：</th>
                    <td>
                        <select name="data[catid]">
                            <option value="0" @if($data['catid']==0)
                            selected @endif
                            > = {{ lang('a-pos-4') }} =
                            </option>
                            <option value="1" @if($data['catid']==1)
                            selected @endif
                            > = {{ lang('a-con-29') }} =
                            </option>
                        </select></td>
                </tr>
                <tr>
                    <th>{{ lang('a-name') }}：</th>
                    <td><input type="text" class="input-text" size="40" id="name" value="{{ $data['name'] }}"
                               name="data[name]" required/></td>
                </tr>
                <tr>
                    <th>{{ lang('a-pos-6') }}：</th>
                    <td><input type="text" class="input-text" size="10" id="maxnum" value="{{ $data['maxnum'] }}"
                               name="data[maxnum]"/>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td><input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-submit') }}"
                               name="submit"></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
</body>
</html>
