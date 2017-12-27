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
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript" src="/views/admin/js/dialog.js"></script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        {{ $join_info }}<span>|</span>
        <a href="{{ url('admin/form/list',array('status'=>1,'modelid'=>$modelid,'cid'=>$cid)) }}" @if($status==1)
        class="on" @endif
        ><em>{{ lang('a-con-20') }}({{ $count[1] }})</em></a><span>|</span>
        <a href="{{ url('admin/form/list',array('status'=>0,'modelid'=>$modelid,'cid'=>$cid)) }}" @if($status==0)
        class="on" @endif
        ><em>{{ lang('a-con-21') }}({{ $count[0] }})</em></a><span>|</span>
        <a href="{{ url('admin/form/list',array('status'=>3,'modelid'=>$modelid,'cid'=>$cid)) }}" @if($status==3)
        class="on" @endif
        ><em>{{ lang('a-con-23') }}({{ $count[3] }})</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'form-add'))
            <a href="{{ url('admin/form/add',array('modelid'=>$modelid, 'cid'=>$cid)) }}"><em>{{ lang('a-con-24')}}</em></a>
            <span>|</span> @endif
        @if(admin_auth($userinfo['roleid'], 'form-config'))
            <a href="{{ url('admin/form/config',array('modelid'=>$modelid, 'cid'=>$cid)) }}"><em>{{ lang('a-con-60')}}</em></a>
            <span>|</span> @endif
        <a href="{{ $site_url }}{{ url('form/post',array('modelid'=>$modelid, 'cid'=>$cid))}" target="_blank"><em>{{ lang('a-con-61')}}</em></a><span>|</span>
		<a href="{{ $site_url }}{{ url('form/list',array('modelid'=>$modelid, 'cid'=>$cid))}" target="_blank"><em>{{ lang('a-con-62')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="explain-col">
        <form action="" method="post">
            <input name="form" type="hidden" value="search"/>
            userid：
            <input type="text" class="input-text" size="5" name="userid"/>
            {{ lang('a-con-63') }}：
            <select id="stype" name="stype">
                <option value="0"> ----</option>
                @foreach($model['fields']['data'] as $t)
                    <option value="{{ $t['field'] }}">{{ $t['name'] }}</option>
                @endforeach
            </select>
            &nbsp;&nbsp;
            <input type="text" class="input-text" size="25" name="kw"/>
            <input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-search') }}" name="submit"/>
        </form>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form action="" method="post" name="myform">
            <input name="form" id="list_form" type="hidden" value="order"/>
            <table width="100%" class="table table-striped">
                @include("$tpl")
                <tr>
                    <td colspan="99" align="left">
                        <input @if(!admin_auth($userinfo['roleid'], 'form-edit'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-order') }}"
                               name="submit_order" onClick="$('#list_form').val('order')"/>&nbsp;
                        <input @if(!admin_auth($userinfo['roleid'], 'form-del'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-del') }}"
                               name="submit_del" onClick="$('#list_form').val('del');return confirm_del()"/>&nbsp;
                        <input @if(!admin_auth($userinfo['roleid'], 'form-edit'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-36') }}"
                               name="submit_status_1" onClick="$('#list_form').val('status_1')"/>&nbsp;
                        <input @if(!admin_auth($userinfo['roleid'], 'form-edit'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-37') }}"
                               name="submit_status_0" onClick="$('#list_form').val('status_0')"/>&nbsp;
                        <input @if(!admin_auth($userinfo['roleid'], 'form-edit'))
                               disabled @endif
                               type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-39') }}"
                               name="submit_status_3" onClick="$('#list_form').val('status_3')"/>&nbsp;
                        @if(!empty($join))

                            {{ lang('a-con-65') }}：
                            <input type="text" class="input-text" size="10" name="toid"/>
                            <input @if(!admin_auth($userinfo['roleid'], 'form-edit'))
                                   disabled @endif
                                   type="submit" class="btn btn-success btn-sm" value="{{ lang('a-con-66') }}"
                                   name="submit_join" onClick="$('#list_form').val('join')"/>&nbsp;
                         @endif
                    </td>
                </tr>
                @if(!empty($diy_file))
                    <tr>
                        <td colspan="99" align="left" style="font-size:12px">
                            当前使用的是表单格式默认模板（views/admin/form_default.html），您可以将默认模板文件复制命名为（{{ $diy_file }}
                            ），这样方便您重新布局列表显示。
                        </td>
                    </tr>
                     @endif
                    </tbody>
            </table>
            {{ $pagelist }}
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        window.top.art.dialog({id: 'clz'}).close();
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