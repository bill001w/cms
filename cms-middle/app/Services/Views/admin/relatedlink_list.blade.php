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
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/relatedlink') }}" class="on"><em>{{ lang('a-men-33')}}</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'relatedlink-add'))
            <a href="{{ url('admin/relatedlink/add') }}"><em>{{ lang('a-add')}}</em></a><span>|</span> @endif
        @if(admin_auth($userinfo['roleid'], 'relatedlink-cache'))
            <a href="{{ url('admin/relatedlink/cache') }}"><em>{{ lang('a-cache')}}</em></a><span>|</span> @endif
        @if(admin_auth($userinfo['roleid'], 'relatedlink-import'))
            <a href="{{ url('admin/relatedlink/import') }}"><em>{{ lang('a-import')}}</em></a> @endif
    </div>
    <div class="bk10"></div>
    <div class="explain-col">
        <form action="" method="post">
            {{ lang('a-name') }}：<input type="text" class="input-text" size="20" name="kw"/>
            &nbsp;&nbsp;
            <input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-search') }}" name="submit"/>&nbsp;&nbsp;
            <font color="gray">{{ lang('a-tag-15') }}</font>
        </form>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post" name="myform">
            <input name="form" id="list_form" type="hidden" value="del">
            <table width="100%" class="table table-striped">
                <thead>
                <tr>
                    <th width="30" align="right"><input name="deletec" id="deletec" type="checkbox" onClick="setC()"/>&nbsp;
                    </th>
                    <th width="150" align="left">{{ lang('a-tag-17') }}</th>
                    <th width="250" align="left">{{ lang('a-tag-18') }}</th>
                    <th width="80" align="left">{{ lang('a-tag-19') }}</th>
                    <th align="left">{{ lang('a-option') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $t)
                    <tr>
                        <td align="right"><input name="del_{{ $t['id'] }}" type="checkbox" class="deletec"/>&nbsp;</td>
                        <td align="left"><input class="input-text" type="text" name="data[{{ $t['id'] }}][name]"
                                                value="{{ $t['name'] }}" size="20"/></td>
                        <td align="left"><input class="input-text" type="text" name="data[{{ $t['id'] }}][url]"
                                                value="{{ $t['url'] }}" size="40"/></td>
                        <td align="left"><input class="input-text" type="text" name="data[{{ $t['id'] }}][sort]"
                                                value="{{ $t['sort'] }}" size="5"/></td>
                        <td align="left">
                            <?php $del = url('admin/relatedlink/del', array('id' => $t['id']));?>
                            @if(admin_auth($userinfo['roleid'], 'relatedlink-edit'))
                                <a href="{{ url('admin/relatedlink/edit',array('id'=>$t['id'])) }}">{{ lang('a-edit')}}</a>
                                |  @endif
                            @if(admin_auth($userinfo['roleid'], 'relatedlink-del'))
                                <a href="javascript:;"
                                   onClick="if(confirm('{{ lang('a-confirm') }}')){ window.location.href='{{ $del }}'; }">{{ lang('a-del')}}</a> @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" align="left">
                        <input @if(!admin_auth($userinfo['roleid'], 'relatedlink-del'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-del') }}"
                               name="submit_del" onClick="$('#list_form').val('del');return confirm_del()"/>&nbsp;
                        <input @if(!admin_auth($userinfo['roleid'], 'relatedlink-edit'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-gx') }}"
                               name="submit_update" onClick="$('#list_form').val('update')"/>&nbsp;
                        <div class="onShow">{{ lang('a-tag-16') }}</div>
                    </td>
                </tr>
                </tbody>
            </table>
            {{ $pagelist }}
        </form>
    </div>
</div>
<script type="text/javascript">
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