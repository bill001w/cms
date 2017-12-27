<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=7"/>
    <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/main.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript" src="/views/admin/js/dialog.js"></script>
</head>
<body>
<style type="text/css">
    html {
        _overflow-y: scroll
    }

    tr {
        height: 25px;
    }
</style>
<div id="main_frameid" class="pad-10" style="_margin-right:-12px;_width:98.9%;">
    <script type="text/javascript">
        $(function () {
            $.getScript("{{ url('admin/index/ajaxcount', array('type'=>'member')) }}");
            $.getScript("{{ url('admin/index/ajaxcount', array('type'=>'size')) }}");
            $.getScript("{{ url('admin/index/ajaxcount', array('type'=>'install')) }}");
        });
    </script>
    <div class="explain-col mb10" style="display:none" id="browserVersionAlert">{{ lang('a-ie') }}</div>
    <div class="col-2 lf mr10" style="width:48%">
        <h6>{{ lang('a-ind-6') }}</h6>
        <div class="content" style="height:170px;">
            {{ lang('a-com-15') }}，{{ $userinfo['username'] }}&nbsp;@if($userinfo['realname'])
                ({{ $userinfo['realname'] }}) @endif
            ，{{ lang('a-ind-1') }}：{{ $userinfo['rolename'] }} <br/>
            {{ lang('a-ind-2') }}：{{ date(TIME_FORMAT, $userinfo['lastlogintime']) }} ，{lang('a-ind-3')}}：<a
                    href="http://www.baidu.com/baidu?wd={{ $userinfo['lastloginip'] }}"
                    target=_blank>{{ $userinfo['lastloginip'] }}</a><br/>
            {{ lang('a-ind-4') }}：{{ date(TIME_FORMAT, $userinfo['logintime']) }} ，{lang('a-ind-5')}}：<a
                    href="http://www.baidu.com/baidu?wd={{ $userinfo['loginip'] }}"
                    target=_blank>{{ $userinfo['loginip'] }}</a>
            <p>{{ lang('a-ind-10') }}：&nbsp;{{ CMS_NAME }}&nbsp;{{ CMS_VERSION }}</p>
            <p>{{ lang('a-ind-11') }}：&nbsp;{{ PHP_OS }} 、 PHP{{ PHP_VERSION }}
                、{{ strcut($_SERVER['SERVER_SOFTWARE'], 20)}}</p>
        </div>
    </div>
    <div class="col-2 col-auto">
        <h6>{{ lang('a-ind-19') }}</h6>
        <div class="content" id="finecms_news">
            <img src="/views/admin/images/loading.gif">
        </div>
    </div>
    <div class="col-2 lf" style="margin-top:20px;width:100%">
        <h6>{{ lang('a-ind-16') }}</h6>
        <div class="content">
            <table width="540" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="261">{{ lang('a-ind-17') }}：&nbsp;<a href="{{ url('admin/member/')}}"><span id="member_1"
                                                                                                           class="label label-success"><img
                                        src="/views/admin/images/onLoad.gif"></span></a></td>
                    <td width="279">{{ lang('a-ind-18') }}：&nbsp;<a
                                href="{{ url('admin/member/', array('status'=>2))}}"><span id="member_2"
                                                                                           class="label label-important"><img
                                        src="/views/admin/images/onLoad.gif"></span></a></td>
                </tr>
            </table>
            <div class="bk20 hr">
                <hr>
            </div>
            <table width="540" border="0" cellpadding="0" cellspacing="0">
                @foreach($model as $t)
                    <tr>
                        <td width="261">{{ $t['modelname'] }}：&nbsp;<a
                                    href="{{ url('admin/content/', array('modelid'=>$t['modelid'])) }}"><span
                                        id="m_{{ $t['modelid'] }}_1" class="label label-success"><img
                                            src="/views/admin/images/onLoad.gif"></span></a></td>
                        <td width="279">{{ lang('a-ind-18') }}：&nbsp;<a
                                    href="{{ url('admin/content/verify', array('modelid'=>$t['modelid'], 'status'=>3))}}"><span
                                        id="m_{{ $t['modelid'] }}_2" class="label label-important"><img
                                            src="/views/admin/images/onLoad.gif"></span></a></td>
                    </tr>
                    <script type="text/javascript">
                        $(function () {
                            $.getScript("{{ url('admin/index/ajaxcount', array('modelid'=>$t['modelid'])) }}");
                        });
                    </script>
                @endforeach
            </table>
        </div>
    </div>
</div>
</body>
</html>