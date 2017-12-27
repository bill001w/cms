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
        <a href="{{ url('admin/member/group') }}"><em>{{ lang('a-mem-30')}}</em></a><span>|</span>
        <a href="{{ url('admin/member/group/add') }}" class="on"><em>{{ lang('a-add')}}</em></a><span>|</span>
        <a href="{{ url('admin/member/group/cache') }}"><em>{{ lang('a-cache')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post">
            <input name="id" type="hidden" value="{{ $data['id'] }}">
            <table width="100%" class="table table-striped">
                <tr>
                    <th width="200"><font color="red">*</font> {{ lang('a-name') }}：</th>
                    <td><input class="input-text" type="text" name="data[name]" value="{{ $data['name'] }}" size="20"
                               required/>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-76') }}：</th>
                    <td><input class="input-text" type="text" name="data[credits]" value="{{ $data['credits'] }}"
                               size="20"/>
                        <div class="onShow">{{ lang('a-mod-209') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-77') }}：</th>
                    <td><input class="input-text" type="text" name="data[allowpost]" value="{{ $data['allowpost'] }}"
                               size="20"/>
                        <div class="onShow">{{ lang('a-mem-85') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-78') }}：</th>
                    <td><input class="input-text" type="text" name="data[allowpms]" value="{{ $data['allowpms'] }}"
                               size="20"/>
                        <div class="onShow">{{ lang('a-mem-86') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-79') }}：</th>
                    <td><input class="input-text" type="text" name="data[filesize]" value="{{ $data['filesize'] }}"
                               size="20"/>
                        <div class="onShow">{{ lang('a-mem-87') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-80') }}：</th>
                    <td>
                        <input name="data[allowattachment]" type="radio" value="1" @if($data['allowattachment']==1)
                        checked @endif
                        /> {{ lang('a-mem-83') }}
                        &nbsp;&nbsp;&nbsp;
                        <input name="data[allowattachment]" type="radio" value="0" @if($data['allowattachment']==0)
                        checked @endif
                        /> {{ lang('a-mem-84') }}
                        <div class="onShow">{{ lang('a-mod-210') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-81') }}：</th>
                    <td>
                        <input name="data[auto]" type="radio" value="0" @if(empty($data['auto']))
                        checked @endif
                        /> {{ lang('a-mem-83') }}
                        &nbsp;&nbsp;&nbsp;
                        <input name="data[auto]" type="radio" value="1" @if($data['auto']==1)
                        checked @endif
                        /> {{ lang('a-mem-84') }}
                        <div class="onShow">{{ lang('a-mod-211') }}</div>
                    </td>
                </tr>
                <tr>
                    <th>{{ lang('a-mem-125') }}：</th>
                    <td>
                        <input name="data[postverify]" type="radio" value="1" @if($data['postverify']==1)
                        checked @endif
                        /> {{ lang('a-open') }}
                        &nbsp;&nbsp;&nbsp;
                        <input name="data[postverify]" type="radio" value="0" @if(empty($data['postverify']))
                        checked @endif
                        /> {{ lang('a-close') }}
                        <div class="onShow">{{ lang('a-mod-212') }}</div>
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