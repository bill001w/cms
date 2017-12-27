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
    <script src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript">
        function setC(c) {
            if ($("#c_" + c).attr('checked')) {
                $(".c_" + c).attr("checked", true);
            } else {
                $(".c_" + c).attr("checked", false);
            }
        }
    </script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<form action="" method="post">
    <div class="subnav">
        <div class="content-menu ib-a blue line-x">
            <a href="javascript:;" class="on"><em>{{ lang('a-aut-9') }}</em></a><span>|</span>
            <a href="{{ url('admin/auth/') }}"><em>{{ lang('a-aut-7')}}</em></a><span>|</span>
            <a href="{{ url('admin/auth/add') }}"><em>{{ lang('a-aut-8')}}</em></a>
        </div>
        <div class="table-responsive mytable">
            <table class="table table-striped" width="100%">
                <thead>
                <tr>
                    <th align="left" width="200"></th>
                    <th align="left">{{ lang('a-aut-9') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $k => $t)
                    <?php $listchecked = in_array($k . '-index', $role) ? true : false;?>
                    <tr height="25">
                        <td align="left">
                            <input name="auth_{{ $k }}-index" value="1" id="c_{{ $k }}" type="checkbox"
                                   onClick="setC('{{ $k }}')"
                                   @if(!empty($listchecked)) checked  @endif
                                   @if($roleid==1) checked disabled  @endif
                            >&nbsp;&nbsp;{{ lang($t['name']) }} (#{{ $k }})
                        </td>
                        <td align="left">
                            @foreach($t['option'] as $j => $v)
                                <?php
                                if ($j == 'index') {
                                    continue;
                                };
                                $checked = in_array($k . '-' . $j, $role) ? true : false;
                                ?>
                                <input class="c_{{ $k }}" name="auth_{{ $k }}-{{ $j }}" type="checkbox" value="1"
                                       @if(!empty($checked)) checked  @endif
                                       @if($roleid==1) checked disabled  @endif
                                >&nbsp;{{ lang($v) }}&nbsp;&nbsp;
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                <tr height="44">
                    <td align="left">&nbsp;</td>
                    <td align="left">
                        <input class="btn btn-success btn-sm" type="submit" name="submit"
                               value="{{ lang('a-submit') }}"/>
                    </td>
                </tr>
                <tbody>
            </table>
        </div>
    </div>
</form>
</body>
</html>