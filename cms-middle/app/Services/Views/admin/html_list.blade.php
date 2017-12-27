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
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet">
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="table-list">
        <div class="pad-10">
            <div class="col-tab">
                <div class="explain-col mb10">
                    @if(!empty($ck_ob))
                        <font color="red">{{ lang('a-con-116') }}</font>
                     @endif
                    @if(!empty($check))
                        <font color="red">{{ lang('a-con-117', array('1'=>APP_ROOT, '2'=>$check)) }}</font>
                    @else
                        {{ lang('a-con-118') }}
                     @endif
                </div>
                <div class="contentList pad-10">
                    @if(!$ismb)
                        <input type="button" class="btn btn-success btn-sm" value="{{ lang('a-con-119') }}"
                               name="submit" onClick="window.location.href='{{ url("admin/html/indexc")}}';">&nbsp;
                        &nbsp;
                     @endif
                    <input type="button" class="btn btn-success btn-sm" value="{{ lang('a-con-120') }}" name="submit"
                           onClick="window.location.href='{{ url("admin/html/category")}}';">&nbsp;&nbsp;
                    <input type="button" class="btn btn-success btn-sm" value="{{ lang('a-con-121') }}" name="submit"
                           onClick="window.location.href='{{ url("admin/html/show")}}';">&nbsp;&nbsp;
                    <input type="button" class="btn btn-success btn-sm" value="{{ lang('a-men-70') }}" name="submit"
                           onClick="window.location.href='{{ url("admin/html/form")}}';">&nbsp;&nbsp;
                    <input type="button" class="btn btn-success btn-sm" value="{{ lang('a-con-122') }}" name="submit"
                           onClick="window.location.href='{{ url("admin/html/clear")}}';">&nbsp;&nbsp;
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>