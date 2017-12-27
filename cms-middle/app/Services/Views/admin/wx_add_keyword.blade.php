<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/images/switchbox.css" rel="stylesheet" type="text/css" />
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet"><link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript" src="/views/admin/js/dialog.js"></script>
    <script type="text/javascript">
        var sitepath = '{{ SITE_PATH }}{{ ENTRY_SCRIPT_NAME }}';
        var finecms_admin_document = "{{ $cats[$data['catid']]['setting']['document'] }}";
    </script>
    <script type="text/javascript" src="{{ LANG_PATH }}lang.js"></script>
    <script type="text/javascript" src="/views/admin/js/core.js"></script>
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

        function resources_on(){
            $('#resources').show();
            $('#content').hide();
        }
        function resources_off(){
            $('#resources').hide();
            $('#content').show();
        }
        function app_on(){

        }
        function app_off(){

        }
    </script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/wx/keyword') }}"><em>关键字列表</em></a><span>|</span>
        <a href="{{ url('admin/wx/add_keyword') }}" class="on"><em>@if(!empty($data))
修改@else
添加 @endif
回复关键字</em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-list">
        <form action="" method="post">
            <input name="id" type="hidden" value="{{ $data['id'] }}">
            <table width="100%" class="table_form">

                <tr>
                    <th width="200">*关键词： </th>
                    <td>
                        <input class="input-text" type="text" name="data[keyword]" value="{{ $data['keyword'] }}" id="name" size="30"/> <div class="onShow">多个关键词以空格分开！</div>
                    </td>
                </tr>

                <tr>
                    <th width="200">回复类型： </th>
                    <td>
                        <input type="radio" name="data[type]" value="0" checked onclick="return resources_off()">文本内容&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="data[type]" value="1" @if($data['type']==1)

                            checked
                         @endif
 onclick="return resources_on()">素材内容&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="data[type]" value="1" @if($data['type']==2)

                            checked
                         @endif
 onclick="return app_on()">微信应用
                    </td>
                </tr>


                <tr id="content" style="display: @if($data['type']!=0)
 none  @endif
 ">
                    <th width="200">
                        *内容：
                    </th>
                    <td>
                        <textarea name="data[content]" id="" cols="120" rows="10">{{ $data['content'] }}</textarea>
                    </td>
                </tr>
                <tr id="resources"
                    @if($data['type']!=1)

                            style="display: none"
                     @endif
 >
                    <th width="200">
                        选择素材：
                    </th>
                    <td>
                        @if(!empty($resources))

                        <select name="data[cid]" id="cid" >
                            @foreach($resources as $resource)
                                <option value="{{ $resource['id'] }}" @if($data['cid']==$resource['id'])

                                    selected
                                 @endif
>{{ $resource['title'] }}</option>
                            @end
                        </select>
                        @else

                        暂时还没有素材！
                         @endif

                    </td>
                </tr>
                <tr id="app"
                    @if($data['type']!=2)

                            style="display: none"
                     @endif
 >
                    <th width="200">
                        选择应用：
                    </th>
                    <td>
                        @if(!empty($resources))

                        <select name="data[app]" id="" >
                            @foreach($resources as $resource)
                                <option value="{{ $resource['id'] }}" @if($data['app']==$app['id'])

                                    selected
                                 @endif
>{{ $app['name'] }}</option>
                            @end
                        </select>
                        @else

                        暂时还没有应用！
                         @endif

                    </td>
                </tr>

                <tr>
                    <th></th>
                    <td>
                        <input  class="btn btn-success btn-sm" type="submit" name="submit" value="提交" size="80">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>