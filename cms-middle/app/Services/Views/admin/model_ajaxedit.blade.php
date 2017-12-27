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
    <script type="text/javascript">
        var sitepath = "{{ SITE_PATH }}{{ ENTRY_SCRIPT_NAME }}";
        $(document).keyup(function (event) {
            if (event.keyCode == 13) {
                $("#submit").trigger("click");
            }
        });
    </script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/model/index', array('typeid'=>$typeid)) }}"><em>{{ lang('a-aut-14')}}</em></a><span>|</span>
        <a href="{{ url('admin/model/fields/', array('typeid'=>$typeid, 'modelid'=>$modelid)) }}"><em>{{ lang('a-aut-18')}}</em></a><span>|</span>
        <a href="javascript:;" class="on"><em>{{ lang('a-edit') }}</em></a><span>|</span>
        <a href="{{ url('admin/model/cache', array('typeid'=>$typeid)) }}"><em>{{ lang('a-cache')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-list">
        <form action="" method="post">
            <table width="100%" class="table_form">
                <tr>
                    <th width="200">{{ lang('a-mod-35') }}：</th>
                    <td>{{ $name }}</td>
                </tr>
                <tr>
                    <th><font color="red">*</font> {{ lang('a-mod-30') }}：</th>
                    <td><input class="input-text" type="text" name="data[name]" value="{{ $data['name'] }}" size="20"/>
                        <div class="onShow">{{ lang('a-mod-38') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mod-132') }}：</th>
                    <td>
                        <input type="radio" @if($data['show'])
                        checked @endif
                        value="1" name="data[show]"> {{ lang('a-mod-60') }}
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" @if(empty($data['show']))
                        checked @endif
                        value="0" name="data[show]"> {{ lang('a-mod-61') }}
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td><input class="btn btn-success btn-sm" type="submit" name="submit" id="submit"
                               value="{{ lang('a-submit') }}"/></td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>