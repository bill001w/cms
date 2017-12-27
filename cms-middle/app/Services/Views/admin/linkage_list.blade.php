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
    @include('admin.top')
    <script type="text/javascript">
        function del(id) {
            if (confirm('{{ lang('a-lin-9') }}')) {
                var url = "{{ url('admin/linkage/del/',array('keyid'=>$keyid)) }}&id=" + id;
                window.location.href = url;
            }
        }
    </script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/linkage/') }}"><em>{{ lang('a-men-34')}}</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'linkage-list'))
            <a href="{{ url('admin/linkage/list', array('keyid'=>$keyid)) }}"
               class="on"><em>{{ lang('a-lin-0')}}</em></a><span>|</span> @endif
        @if(admin_auth($userinfo['roleid'], 'linkage-addson'))
            <a href="{{ url('admin/linkage/addson', array('keyid'=>$keyid)) }}"><em>{{ lang('a-add')}}</em></a>
            <span>|</span> @endif
        @if(admin_auth($userinfo['roleid'], 'linkage-cache'))
            <a href="{{ url('admin/linkage/cache') }}"><em>{{ lang('a-cache')}}</em></a> @endif
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form name="myform" action="" method="post">
            <table width="100%" cellspacing="0" class="table table-striped">
                <thead>
                <tr>
                    <th width="50">{{ lang('a-order') }}</th>
                    <th width="60" align="left">ID</th>
                    <th align="left">{{ lang('a-lin-13') }}</th>
                    <th width="50%" align="left">{{ lang('a-option') }}</th>
                </tr>
                </thead>
                <tbody>
                {{ $list }}
                <tr>
                    <td colspan="4"><input @if(!admin_auth($userinfo['roleid'], 'linkage-editson'))
                                           disabled @endif
                                           type="submit" class="btn btn-success btn-sm" name="submit"
                                           value="{{ lang('a-order') }}"/>
                        <div class="onShow">{{ lang('a-lin-15')}}</div>{{ $pagelist }}</td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">
    function setC() {
        if ($("#deletec").attr('checked')) {
            $(".deletec").attr("checked", true);
        } else {
            $(".deletec").attr("checked", false);
        }
    }
</script>
</body>
</html>