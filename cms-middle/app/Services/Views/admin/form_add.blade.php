<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css"/>
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet">
    <link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script language="javascript">var sitepath = "{{ SITE_PATH }}{{ ENTRY_SCRIPT_NAME }}";</script>
    <script language="javascript" src="/views/admin/js/core.js"></script>
    <script type="text/javascript" src="{{ LANG_PATH }}lang.js"></script>@include('admin.top')
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        {{ $join_info }}<span>|</span>
        <a href="{{ url('admin/form/list',array('status'=>1,'modelid'=>$modelid,'cid'=>$cid)) }}"><em>{{ lang('a-con-20')}}
                ({{ $count[1] }})</em></a><span>|</span>
        <a href="{{ url('admin/form/list',array('status'=>0,'modelid'=>$modelid,'cid'=>$cid)) }}"><em>{{ lang('a-con-21')}}
                ({{ $count[0] }})</em></a><span>|</span>
        <a href="{{ url('admin/form/list',array('status'=>3,'modelid'=>$modelid,'cid'=>$cid)) }}"><em>{{ lang('a-con-23')}}
                ({{ $count[3] }})</em></a><span>|</span>
        <a href="{{ url('admin/form/add',array('modelid'=>$modelid, 'cid'=>$cid)) }}"
           class="on"><em>{{ lang('a-con-24')}}</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'form-config'))
            <a href="{{ url('admin/form/config',array('modelid'=>$modelid, 'cid'=>$cid)) }}"><em>{{ lang('a-con-60')}}</em></a>
            <span>|</span>
         @endif
        <a href="{{ $site_url }}{{ url('form/post',array('modelid'=>$modelid, 'cid'=>$cid))}" target="_blank"><em>{{ lang('a-con-61')}}</em></a><span>|</span>
	<a href="{{ $site_url }}{{ url('form/list',array('modelid'=>$modelid, 'cid'=>$cid))}" target="_blank"><em>{{ lang('a-con-62')}}</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <form method="post" action="" id="myform" name="myform">
            <table width="100%" class="table table-striped">
                <tbody>
                <tr>
                    <th width="150">{{ lang('a-con-67') }}：</th>
                    <td>{{ $model['modelname'] }}</td>
                </tr>
                @if(!empty($join))
                    <tr>
                        <th>{{ lang('a-con-68') }}：</th>
                        <td><input type="text" class="input-text" size="10" value="{{ $cid }}" name="cid" required/>
                            <div class="onShow">{{ lang('a-con-69', array('1'=>$join_info)) }}</div>
                        </td>
                    </tr>
                 @endif
                {{ $fields }}
                <tr>
                    <th>{{ lang('a-con-46') }}：</th>
                    <td>
                        <input type="radio" @if(!isset($data['status']) || $data['status']==1)
                        checked @endif
                        value="1" name="data[status]" onClick="$('#verify').hide()"> {{ lang('a-con-20') }}
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" @if(isset($data['status']) && $data['status']==0)
                        checked @endif
                        value="0" name="data[status]" onClick="$('#verify').hide()"> {{ lang('a-con-21') }}
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td><input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-submit') }}" name="submit"
                               onClick="$('#load').show()">
                        <span id="load" style="display:none"><img src="/views/admin/images/loading.gif"></span></td>
                </tr>
                </tbody>
            </table>
            <br>
        </form>
    </div>
</div>
</body>
</html>
