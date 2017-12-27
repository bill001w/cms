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
            $.post('{{ url('admin/member/ajaxemail') }}&rid=' + Math.random(), {
                email: $('#email').val(),
                id:{{ $id }} }, function (data) {
                $('#email_text').html(data);
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
        <a href="{{ url('admin/member/reg') }}"><em>{{ lang('a-mem-27')}}</em></a><span>|</span>
        <a href="{{ url('admin/member/edit', array('id'=>$id)) }}" class="on"><em>{{ lang('a-mem-34')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form method="post" action="" id="myform" name="myform">
            <table width="100%" class="table table-striped">
                <tbody>
                <tr>
                    <th width="200">{{ lang('a-user') }}：</th>
                    <td>{{ $data['username'] }}&nbsp;&nbsp;@if(!empty($model))
                            ({{ $model['modelname'] }}) @endif
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-30') }}：</th>
                    <td><select name="data[groupid]">
                            @foreach($group as $t)
                                <option value="{{ $t['id'] }}" @if($data['groupid']==$t['id'])
                                selected @endif
                                >{{ $t['name'] }}</option>
                            @endforeach
                        </select>
                        <div class="onShow">{{ lang('a-mem-36') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-37') }}：</th>
                    <td><input type="text" class="input-text" size="30" value="" name="password">
                        <div class="onShow">{{ lang('a-mem-38') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-39') }}：</th>
                    <td><input type="text" class="input-text" size="30" id="email" value="{{ $data['email'] }}"
                               name="data[email]" onBlur="ajaxemail()">
                        <div class="onShow" id="email_text"></div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-40') }}：</th>
                    <td><input type="text" class="input-text" size="30" value="{{ $data['nickname'] }}"
                               name="data[nickname]"></td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-41') }}：</th>
                    <td><input type="text" class="input-text" size="30" value="{{ $data['credits'] }}"
                               name="data[credits]">
                        <div class="onShow">{{ lang('a-mem-42') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-43') }}：</th>
                    <td>{formatFileSize(count_member_size($data['id']))}</td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-32') }}：</th>
                    <td>{{ date(TIME_FORMAT, $data['regdate']) }}</td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-33') }}：</th>
                    <td><a href="http://www.baidu.com/baidu?wd={{ $data['regip'] }}"
                           target=_blank>{{ $data['regip'] }}</a></td>
                </tr>
                <tr>
                    <th>{{ lang('a-mod-162') }}：</th>
                    <td>{{ date(TIME_FORMAT, $data['logintime']) }}</td>
                </tr>
                <tr>
                    <th>{{ lang('a-mod-163') }}：</th>
                    <td><a href="http://www.baidu.com/baidu?wd={{ $data['loginip'] }}"
                           target=_blank>{{ $data['loginip'] }}</a></td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-44') }}：</th>
                    <td>
                        <input type="radio" @if(!isset($data['status']) || $data['status']==1)
                        checked @endif
                        value="1" name="data[status]"> {{ lang('a-con-20') }}
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" @if(isset($data['status']) && $data['status']==0)
                        checked @endif
                        value="0" name="data[status]"> {{ lang('a-con-21') }}
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
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
