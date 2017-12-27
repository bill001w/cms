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
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="table-list">
        <form method="post" action="" id="myform" name="myform">
            <input name="filename" id="filename" type="hidden" value="{{ $data['filename'] }}">
            <div class="pad-10">
                <div class="col-tab">
                    <div class="bk10"></div>
                    <div class="bk10"></div>
                    <table width="100%">
                        <tr>
                            <td align="center">{{ $data['msg'] }}</td>
                        </tr>
                    </table>
                    <div class="onShow">{{ $note }}</div>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>