<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/main.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css"/>
    @include('admin.top')
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript" src="/views/admin/js/dialog.js"></script>
    <script type="text/javascript" src="{{ LANG_PATH }}lang.js"></script>
    <script type="text/javascript">
        function get_avatar(filepath) {
            if (filepath) {
                var content = '<img src="' + filepath + '" />';
            } else {
                var content = fc_lang[0];
            }
            window.top.art.dialog({title: fc_lang[1], fixed: true, content: content});
        }
        function setC() {
            if ($("#deletec").attr('checked')) {
                $(".deletec").attr("checked", true);
            } else {
                $(".deletec").attr("checked", false);
            }
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
        @if(admin_auth($userinfo['roleid'], 'member-reg'))
            <a href="{{ url('admin/member/reg') }}"><em>{{ lang('a-mem-27')}}</em></a> @endif

    </div>
    <div class="bk10"></div>
    <div class="explain-col">
        <form action="" method="post">
            <input name="form" type="hidden" value="search"/>
            {{ lang('a-mem-28') }}：<input type="text" class="input-text" size="20" name="kw"/>
            <input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-search') }}" name="submit"/>
        </form>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post">
            <input name="form" id="list_form" type="hidden" value=""/>
            <table class="table table-striped" width="100%">
                <thead>
                <tr>
                    <th width="15" align="right"><input name="deletec" id="deletec" type="checkbox" onClick="setC()"/>
                    </th>
                    <th width="30" align="left">ID</th>
                    <th width="130" align="left">{{ lang('a-user') }}</th>
                    <th width="70" align="left">{{ lang('a-mem-29') }}</th>
                    <th width="70" align="left">{{ lang('a-mem-30') }}</th>
                    <th width="55" align="left">{{ lang('a-mem-31') }}</th>
                    <th width="120" align="left">{{ lang('a-mem-32') }}</th>
                    <th width="120" align="left">{{ lang('a-mem-33') }}</th>
                    <th align="left">{{ lang('a-option') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $t)
                    <?php $avatar = ''; if ($t['avatar']) {
                        $avatar = image($t['avatar']);
                    } ?>
                    <tr height="25">
                        <td align="right"><input name="del_{{ $t['id'] }}_{{ $t['modelid'] }}" type="checkbox"
                                                 class="deletec"/></td>
                        <td align="left">{{ $t['id'] }}</td>
                        <td align="left">@if(!$t['status'])
                                <font color="#FF0000">[{{ lang('a-con-32') }}]</font> @endif

                            <a href="javascript:;" onClick="get_avatar('{{ $avatar }}')">{{ $t['username'] }}</a></td>
                        <td align="left"><a
                                    href="{{ url('admin/member/index', array('modelid'=>$t['modelid'])) }}">{{ $membermodel[$t['modelid']]['modelname'] }}</a>
                        </td>
                        <td align="left"><a
                                    href="{{ url('admin/member/index',array('groupid'=>$t['groupid'])) }}">{{ $membergroup[$t['groupid']]['name'] }}</a>
                        </td>
                        <td align="left">{{ $t['credits'] }}</td>
                        <td align="left">{{ date(TIME_FORMAT, $t['regdate']) }}</td>
                        <td align="left"><a href="http://www.baidu.com/baidu?wd={{ $t['regip'] }}"
                                            target=_blank>{{ $t['regip'] }}</a></td>
                        <td align="left">
                            @if(admin_auth($userinfo['roleid'], 'member-edit'))
                                <a href="{{ url('admin/member/edit',array('id'=>$t['id'])) }}">{{ lang('a-mem-34')}}</a>
                                |  @endif

                            @if(admin_auth($userinfo['roleid'], 'member-del'))
                                <a href="javascript:;"
                                   onClick="if(confirm('{{ lang('a-mem-35') }}')){ window.location.href='<?php echo url('admin/member/del', array('id' => $t['id']));?>'; }">{{ lang('a-del')}}</a>  @endif

                        </td>
                    </tr>
                @endforeach
                <tr height="25">
                    <td colspan="9" align="left">
                        <input @if(!admin_auth($userinfo['roleid'], 'member-edit'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-36') }}"
                               name="submit_status_1" onClick="$('#list_form').val('status_1')"/>&nbsp;
                        <input @if(!admin_auth($userinfo['roleid'], 'member-edit'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-37') }}"
                               name="submit_status_0" onClick="$('#list_form').val('status_0')"/>&nbsp;
                </tr>
                </tbody>
            </table>
            {{ $pagelist }}
        </form>
    </div>

</div>
</body>
</html>