<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    @include('admin.top')
    <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/main.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript" src="/views/admin/js/dialog.js"></script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/content/index', array('catid'=>$catid)) }}" @if($a=='index' && $recycle==0)
        class="on" @endif
        ><em>{{ lang('a-con-19') }}({{ $total }})</em></a><span>|</span>
        <a href="{{ url('admin/content/verify', array('catid'=>$catid,'status'=>3)) }}" @if($status==3)
        class="on" @endif
        ><em>{{ lang('a-con-21') }}({{ $count[1] }})</em></a><span>|</span>
        <a href="{{ url('admin/content/verify', array('catid'=>$catid,'status'=>2)) }}" @if($status==2)
        class="on" @endif
        ><em>{{ lang('a-con-22') }}({{ $count[2] }})</em></a><span>|</span>
        <a href="{{ url('admin/content/index', array('catid'=>$catid,'recycle'=>1)) }}" @if($recycle==1)
        class="on" @endif
        ><em>{{ lang('a-con-23') }}({{ $count[0] }})</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'content-add'))
            <a href="{{ url('admin/content/add', array('catid'=>$catid)) }}"><em>{{ lang('a-con-24')}}</em></a> @endif
        <span>|</span>
        @if(admin_auth($userinfo['roleid'], 'content-cache'))
            <a href="{{ url('admin/content/cache') }}"><em>{{ lang('a-cache')}}</em></a> @endif
    </div>
    <div class="bk10"></div>
    <div class="explain-col">
        <form action="" method="post">
            <input name="form" type="hidden" value="search"/>
            <label>
                {{ lang('a-con-25') }}： </label>
            <label>
                <select class="form-control" id="catid" name="catid">
                    <option value="0"> ----</option>
                    {{ $category }}
                </select></label>
            &nbsp;&nbsp;
            <label><select class="form-control" name="stype">
                    <option selected="" value="0">{{ lang('a-con-26') }}</option>
                    <option value="1">{{ lang('a-con-27') }}</option>
                    <option value="2">{{ lang('a-con-28') }}</option>
                </select></label>
            <label>
                <input type="text" class="form-control" size="25" name="kw"/></label>
            <label><input type="submit" class="btn btn-success" value="{{ lang('a-search') }}" name="submit"/></label>
        </form>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post" name="myform">
            <input name="form" id="list_form" type="hidden" value="order"/>
            <table class="table table-striped" width="100%">
                @include("$tpl")
                <tr>
                    <td colspan="99" align="left">
                        <input @if(!admin_auth($userinfo['roleid'], 'content-edit'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-order') }}"
                               name="submit_order" onClick="$('#list_form').val('order')" @if($a=='verify')
                               disabled @endif
                        />&nbsp;
                        <input @if(($a=='index' && !admin_auth($userinfo['roleid'], 'content-del')) || ($a=='verify' && !admin_auth($userinfo['roleid'], 'content-delverify')))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-del') }}"
                               name="submit_del" onClick="$('#list_form').val('del');return confirm_del();"/>&nbsp;
                        @if($a=='verify')

                            <input @if(!admin_auth($userinfo['roleid'], 'content-verify'))
                                   disabled @endif
                                   type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-36') }}"
                                   name="submit_status_1" onClick="$('#list_form').val('status_1')"/>&nbsp;
                            <input @if(!admin_auth($userinfo['roleid'], 'content-verify'))
                                   disabled @endif
                                   type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-37') }}"
                                   name="submit_status_0" onClick="$('#list_form').val('status_0')"/>&nbsp;
                            <input @if(!admin_auth($userinfo['roleid'], 'content-verify'))
                                   disabled @endif
                                   type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-38') }}"
                                   name="submit_status_2" onClick="$('#list_form').val('status_2')"/>&nbsp;
                        @else
                            @if(!empty($recycle))
                                <input @if(!admin_auth($userinfo['roleid'], 'content-edit'))
                                       disabled @endif
                                       type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-36') }}"
                                       name="submit_status_1" onClick="$('#list_form').val('status_1')"/>&nbsp;
                            @else
                                <input @if(!admin_auth($userinfo['roleid'], 'content-edit'))
                                       disabled @endif
                                       type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-39') }}"
                                       name="submit_status_3" onClick="$('#list_form').val('status_3')"/>&nbsp;
                             @endif
                            <input @if(!admin_auth($userinfo['roleid'], 'content-weixin'))
                                   disabled @endif
                                   type="submit" class="btn btn-success btn-sm" value="{{ lang('dr008') }}"
                                   name="submit_status_5" onClick="$('#list_form').val('status_5')"/>&nbsp;
                            {{ lang('a-con-40') }}
                            <select name="movecatid">
                                <option value="0"> ----</option>
                                {{ $category }}
                            </select>
                            <input @if(!admin_auth($userinfo['roleid'], 'content-edit'))
                                   disabled @endif
                                   type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-41') }}"
                                   name="submit_move" onClick="$('#list_form').val('move')"/>&nbsp;
                         @endif
                    </td>
                </tr>
                </tbody>
            </table>
            {{ str_replace('<a>共' . $total . '条</a>', '<a>耗时' . runtime() . '秒</a><a>共' . $total . '条</a>', $pagelist) }}
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        window.top.art.dialog({id: 'clz'}).close();
        $('a').click(
                function () {
                    var clz = $(this).attr('clz');
                    if (clz != '1') window.top.art.dialog({
                        id: 'clz',
                        title: 'loading',
                        fixed: true,
                        lock: false,
                        content: '<img src="/views/admin/images/onLoad.gif">'
                    });
                }
        );
        $('input[type="submit"]').click(
                function () {
                    var type = $(this).attr('name');
                    if (type != 'submit_status_5')
                        window.top.art.dialog({
                            id: 'clz',
                            title: 'loading',
                            fixed: true,
                            lock: false,
                            content: '<img src="/views/admin/images/onLoad.gif">'
                        });
                }
        );
        if ($(document).width() <= 900) {
            $('#s_title').css('width', '150px');
            $('#t_title').attr('width', '150');
        }
    });
    function confirm_del() {
        if (confirm('{{ lang('a-confirm') }}')) {
            return true;
        } else {
            return false;
        }
    }
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