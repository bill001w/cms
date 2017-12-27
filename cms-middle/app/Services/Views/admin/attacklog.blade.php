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
    <div class="content-menu ib-a blue line-x" style="padding:10px 0">
        <a href="{{ url('admin/index/attack/') }}" class="on"><em>{{ lang('a-men-66')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="explain-col">
        <form action="" method="post">
            IP：<input type="text" class="input-text" size="20" name="kw">
            &nbsp;&nbsp;
            <input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-search') }}" name="submit">
        </form>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post">
            <table class="table table-striped" width="100%">
                <thead>
                <tr>
                    <th width="130" align="left">{{ lang('a-time') }}</th>
                    <th width="50" align="left">{{ lang('a-aip-15') }}</th>
                    <th width="50" align="left">{{ lang('a-aip-16') }}</th>
                    <th width="100" align="left">{{ lang('a-aip-14') }}</th>
                    <th align="left"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $k => $t)
                    @if ($t['ip'] && $ip && is_array($ip))
                        @if (isset($ip[$t['ip']]) && (empty($ip[$t['ip']]['endtime']) || ($ip[$t['ip']]['endtime'] - $ip[$t['ip']]['addtime']) >= 0))
                            $t['attack'] = true;
                        @else
                            @foreach ($ip as $cip => $test)
                                @if (empty($cip) || strpos($cip, '*') === false) continue;  @endif
                                $preg = '/^' . str_replace(array('*', '.'), array('[0-9]+', '\.'), $cip) . '$/';
                                @if (preg_match($preg, $t['ip'])) $t['attack'] = true;  @endif
                            @endforeach
                         @endif
                     @endif
                <script type="text/javascript">
                    function view_ {{ $k }}() {
                        var content = "<style>.table-list td,.table-list th{ padding-left:12px; font-weight:normal;}.table-list thead th{ height:30px; background:#eef3f7; border-bottom:1px solid #d5dfe8; font-weight:normal}.table-list tbody td,.table-list .btn{ border-bottom: #eee 1px solid; padding-top:5px; padding-bottom:5px}</style><table width='630' border='0' cellpadding='1' cellspacing='0' class='table-list'><tr><td width='10%' align=right>{{ lang('a-aip-13') }}</td><td width='90%'>&nbsp;{{ date(TIME_FORMAT, $t['time']) }}</td></tr><tr><td align=right>{lang('a-aip-14')}}</td><td>&nbsp;<a href='http://www.baidu.com/baidu?wd={{ $t['ip'] }}' target=_blank>{{ $t['ip'] }}</a></td></tr>@if($t['attack'])
                                <tr><td align=right>{{ lang('a-aip-5') }}</td><td>&nbsp;<font color=red>{{ lang('a-aip-20')}}</font></td></tr> @endif
                                <tr><td align=right>{{ lang('a-aip-15') }}</td><td>&nbsp;{{ $t['uid'] }}</td></tr><tr><td align=right>{{ lang('a-aip-16') }}</td><td>&nbsp;{{ $t['type'] }}</td></tr><tr><td align=right>{lang('a-aip-17')}</td><td>&nbsp;{htmlspecialchars($t['val'])}</td></tr><tr><td align=right>{lang('a-aip-19')}</td><td>&nbsp;{htmlspecialchars($t['url'])}</td></tr><tr><td align=right>{lang('a-aip-18')}}</td><td>&nbsp;{{ $t['user'] }}</td></tr></table>";
                        window.top.art.dialog({
                            title: '{{ lang('a-men-66') }}',
                            fixed: true,
                            content: content,
                            width: 700
                        });
                    }
                </script>
                <tr height="25">
                    <td align="left">{{ date(TIME_FORMAT, $t['time']) }}</td>
                    <td align="left">{{ $t['uid'] }}</td>
                    <td align="left">{{ $t['type'] }}</td>
                    <td align="left"><a
                                href="{{ url('admin/index/attack', array('ip'=>$t['ip'])) }}">{{ $t['ip'] }}</a>
                    </td>
                    <td align="left"><a
                                href="javascript:view_{{ $k }}();">{{ strcut(htmlspecialchars($t['url']), 50) }}</a>
                    </td>
                </tr>
                @endforeach
                <tr height="25">
                    <td colspan="8" align="left"><input type="button" class="btn btn-success btn-sm"
                                                        value="{{ lang('a-ind-44') }}" name="submit_order"
                                                        onClick="window.location.href='{{ url('admin/index/clearattack/')}}'">
                        <div class="onShow">{{ lang('a-ind-45') }}</div>
                    </td>
                </tr>
            </table>
            {{ $pagelist }}
        </form>
    </div>
</div>
</body>
</html>