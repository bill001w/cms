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
    </script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/wx/index') }}"><em>素材列表</em></a><span>|</span>
        <a href="{{ url('admin/wx/add_resource') }}"  class="on"><em> @if(!empty($data))

            修改素材
            @else

            添加素材
         @endif
 </em></a>
    </div>
    <div class="bk10"></div>
    <div class="table-list">
        <form action="" method="post">
            <input name="id" type="hidden" value="{{ $data['id'] }}">
            <table width="100%" class="table_form">

                <tr>
                    <th width="200">*标题： </th>
                    <td>
                        <input class="input-text" type="text" name="data[title]" value="{{ $data['title'] }}" id="name" size="30"/>
                    </td>
                </tr>
                <tr>
                    <th>缩略图：</th>
                    <td><input type="text" class="input-text" size="50" value="{{ $data[thumb] }}" name="data[thumb]" id="thumb" />
                        <input type="button" style="width:66px;cursor:pointer;" class="btn btn-success btn-sm" onClick="preview('thumb')" value="预览" />
                        <input type="button" style="width:66px;cursor:pointer;" class="btn btn-success btn-sm" onClick="uploadImage('thumb','360','200')" value="上传" />
                        <div class="onShow">可直接输入图片完整的URL地址</div></td>
                </tr>


                <tr>
                    <th width="200">
                        *正文：
                    </th>
                    <td>
                        <?php App::auto_load('fields');echo content_editor('content',array(0=> $data['content']), array('system'=>1,'pagebreak'=>1,'type' =>2,'height'=>'200')); ?>
                    </td>
                </tr>
                <tr>
                    <th width="200">
                        外部地址：
                    </th>
                    <td>
                        <input  class="input-text" type="text" name="data[url]" value="{{ $data['url'] }}" size="80">
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