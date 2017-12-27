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
    <script type="text/javascript">var sitepath = "{{ SITE_PATH }}{{ ENTRY_SCRIPT_NAME }}";</script>
    <script type="text/javascript" src="{{ LANG_PATH }}lang.js"></script>
    <script type="text/javascript" src="/views/admin/js/core.js"></script>
    @include('admin.top')
    <script type="text/javascript">
        function ajaxemail() {
            $('#email_text').html('');
            $.post('{{ url('admin/member/ajaxemail') }}?rid=' + Math.random(), {email: $('#email').val()}, function (data) {
                $('#email_text').html(data);
            });
        }
        function ajaxusername() {
            $('#username_text').html('');
            $.post('{{ url('admin/member/ajaxusername') }}?rid=' + Math.random(), {username: $('#username').val()}, function (data) {
                $('#username_text').html(data);
            });
        }
    </script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/member/index') }}" @if($status==0)
        class="on" @endif
        ><em>{{ lang('a-mem-26') }}({{ $count[0] }})</em></a><span>|</span>
        <a href="{{ url('admin/member/index', array('status'=>1)) }}" @if($status==1)
        class="on" @endif
        ><em>{{ lang('a-con-20') }}({{ $count[1] }})</em></a><span>|</span>
        <a href="{{ url('admin/member/index', array('status'=>2)) }}" @if($status==2)
        class="on" @endif
        ><em>{{ lang('a-con-21') }}({{ $count[2] }})</em></a><span>|</span>
        <a href="{{ url('admin/member/reg') }}" class="on"><em>{{ lang('a-mem-27')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form method="post" action="" id="myform" name="myform">
            <table width="100%" class="table_form">
                <tr>
                    <th width="200">{{ lang('a-mem-52') }}：</th>
                    <td>
                        <input type="radio" value="0" name="addall" onclick='$("#more").hide();$("#one").show();'
                               checked> {{ lang('a-no') }}&nbsp;&nbsp;
                        <input type="radio" value="1" name="addall"
                               onclick='$("#more").show();$("#one").hide();'> {{ lang('a-yes') }}
                    </td>
                </tr>
                <tbody id="more" style="display:none">
                <tr>
                    <th>{{ lang('a-mem-53') }}：</th>
                    <td><textarea style="width:300px;height:210px" name="members"></textarea><br>
                        <div class="onShow" style="clear:both;margin-top:5px;">{{ lang('a-mem-54') }}</div>
                    </td>
                </tr>
                </tbody>
                <tbody id="one">
                <tr>
                    <th>{{ lang('a-mem-55') }}：</th>
                    <td><input type="text" class="input-text" size="30" id="username" value="" name="data[username]"
                               onBlur="ajaxusername()">
                        <div class="onShow" id="username_text"></div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-56') }}：</th>
                    <td><input type="text" class="input-text" size="30" value="" name="data[password]"></td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-39') }}：</th>
                    <td><input type="text" class="input-text" size="30" id="email" value="" name="data[email]"
                               onBlur="ajaxemail()">
                        <div class="onShow" id="email_text"></div>
                    </td>
                </tr>
                </tbody>
                <tr>
                    <th>{{ lang('a-mem-44') }}：</th>
                    <td>
                        <input type="radio" value="1" name="data[status]" checked> {{ lang('a-con-20') }}&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" value="0" name="data[status]"> {{ lang('a-con-21') }}
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td><input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-submit') }}"
                               name="submit"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>
