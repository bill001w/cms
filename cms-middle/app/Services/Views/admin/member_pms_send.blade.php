<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css"/>
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
        <a href="{{ url('admin/member/pms/') }}"><em>{{ lang('a-mem-57')}}</em></a><span>|</span>
        <a href="{{ url('admin/member/pms/', array('type'=>'send')) }}" class="on"><em>{{ lang('a-mem-58')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post">
            <table width="100%" class="table table-striped">
                <tr>
                    <th width="200">{{ lang('a-mem-66') }}：</th>
                    <td>
                        <input name="type" type="radio" value="1"
                               onClick="$('#qun').show();$('#geren').hide()"> {{ lang('a-mem-67') }}&nbsp;&nbsp;&nbsp;&nbsp;
                        <input name="type" type="radio" value="2"
                               onClick="$('#geren').show();$('#qun').hide()"> {{ lang('a-mem-68') }}&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                <tr id="qun" style='display:none'>
                    <th>{{ lang('a-mem-69') }}：</th>
                    <td>
                        <select name="data[modelid]">
                            @foreach($model as $t)
                                <option value="{{ $t['modelid'] }}">{{ $t['modelname'] }}</option>
                            @endforeach
                        </select>
                        &nbsp;&nbsp;
                        <select name="data[groupid]">
                            <option value="0">{{ lang('a-mem-70') }}</option>
                            @foreach($group as $t)
                                <option value="{{ $t['id'] }}">{{ $t['name'] }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr id="geren" style='display:none'>
                    <th>{{ lang('a-mem-55') }}：</th>
                    <td><input class="input-text" type="text" name="data[tonames]" value="" size="40"/>
                        <div class="onShow">{{ lang('a-mem-71') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-59') }}：</th>
                    <td><input class="input-text" type="text" name="data[title]" value="" size="40"/></td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-72') }}：</th>
                    <td>
                        <?php App::auto_load('fields');echo content_editor('content', array(0 => $data['content']), array('type' => 0, 'width' => 90, height => 200, 'system' => 1)); ?>
                    </td>
                </tr>
                <tr>
                    <th width="200">&nbsp;</th>
                    <td><input class="btn btn-success btn-sm" type="submit" name="submit" value="{{ lang('a-mem-73') }}"
                               onClick="$('#load').show()"/>
                        <span id="load" style="display:none"><img
                                    src="/views/admin/images/loading.gif"> {{ lang('a-mem-74') }}</span>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>