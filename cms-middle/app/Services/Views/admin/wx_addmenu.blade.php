<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/images/main.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet"><link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript">var sitepath = "{{ SITE_PATH }}{{ ENTRY_SCRIPT_NAME }}";</script>
    <script type="text/javascript">
        function ajaxletter() {
            var letter = $('#letter').val();
            if (letter == '') {
                $.post(sitepath+'?c=api&a=pinyin&id='+Math.random(), { name:$('#name').val() }, function(data){ $('#letter').val(data); });
            }
        }
    </script>
    <script type="text/javascript">
        $(function() {

            dr_set_type('{{ $data["type"] }}');
        });

        function dr_set_type(v) {
            $(".dr_hide").hide();
            $(".dr_"+v).show();
        }
    </script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/wx/menu') }}"><em>菜单列表</em></a><span>|</span>
        <a href="{{ url('admin/wx/sync') }}"><em>同步到微信</em></a><span>|</span>
        <a href="{{ url('admin/wx/add_menu') }}"  class="on"><em>@if($data['name'])
修改@else
添加 @endif
菜单</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-list">
        <form action="" method="post">
            <input name="id" type="hidden" value="{{ $data['id'] }}">
            <table width="100%" class="table_form">
                <tr>
                    <th width="200">菜单分类： </th>
                    <td>
                        <select name="data[pid]" id="type">
                            <option value="0">作为一级菜单</option>
                            @foreach($top as $t)
                            <option value="{{ $t['id'] }}" @if($t['id']==$pid or $t['id']==$data['pid'])
selected @endif
>{{ $t['name'] }}</option>
                            @end
                        </select>
                    </td>
                </tr>
                <tr>
                    <th width="200">* 菜单名称： </th>
                    <td>
                        <input class="input-text" type="text" name="data[name]" value="{{ $data['name'] }}" id="name" size="30"/>
                    </td>
                </tr>
                <tr>
                    <th>按钮类型： </th>
                    <td>
                        <input name="data[type]" onclick="dr_set_type(this.value)" type="radio" value="click" @if($data['type'] == 'click')
checked @endif
 />&nbsp;接口推送&nbsp;&nbsp;
                        <input name="data[type]" onclick="dr_set_type(this.value)" type="radio" value="view" @if($data['type'] == 'view')
checked @endif
 />&nbsp;地址链接
                    </td>
                </tr>
                <tr class="dr_click dr_hide " style="display:none;">
                    <th style="border:none"><font color="red">*</font>&nbsp;菜单KEY值： </th>
                    <td style="border:none">
                        <input class="input-text" id="dr_key" type="text" name="data[key]" value="{{ $data['key'] }}" size="30" />

                        <div class="onShow">KEY值可以设置为自动回复中的关键字。</div>
                    </td>
                </tr>

                <tr class="dr_view dr_hide" style="display:none;">
                    <th style="border:none"><font color="red">*</font>&nbsp;网页链接： </th>
                    <td style="border:none"><input class="input-text" type="text" name="data[url]" value="{{ $data['url'] }}" size="60" /></td>
                </tr>
                <tr>
                <th>&nbsp;</th>
                    <td><input class="btn btn-success btn-sm" type="submit" name="submit" value="{{ lang('a-submit') }}" /></td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>