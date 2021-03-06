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
        <a href="{{ url('admin/tag') }}"><em>{{ lang('a-men-32')}}</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'tag-add'))
            <a href="{{ url('admin/tag/add') }}"><em>{{ lang('a-add')}}</em></a><span>|</span> @endif
        @if(admin_auth($userinfo['roleid'], 'tag-cache'))
            <a href="{{ url('admin/tag/cache') }}"><em>{{ lang('a-cache')}}</em></a><span>|</span> @endif
        <a href="{{ url('admin/tag/import') }}" class="on"><em>{{ lang('a-import')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post" enctype="multipart/form-data">
            <table class="table table-striped" width="100%">
                <tr>
                    <th width="200">{{ lang('a-tag-ex-1') }}：</th>
                    <td><select name="catid" id="">
                            @foreach($category as $cat)
                                <option value="{{ $cat['catid'] }}">
                                    {{ $cat['catname'] }}
                                </option>
                            @endforeach
                        </select></td>
                </tr>
                <tr>
                    <th width="200">{{ lang('a-tag-10') }}：</th>
                    <td><input type="file" name="txt" size="50"/>&nbsp;&nbsp;
                        <div class="onShow">{{ lang('a-tag-11') }}</div>
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