<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>{{ $SITE_NAME }}{{ lang('admin') }}</title>
    <link href="/views/admin/luos/css/bootstrap.min.css" rel="stylesheet">
    <link href="/views/admin/luos/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/views/admin/luos/css/animate.min.css" rel="stylesheet">
    <link href="/views/admin/luos/css/style.min.css" rel="stylesheet">
    <link href="/views/admin/luos/css/login.min.css" rel="stylesheet">
    <script>
        if (window.top !== window.self) {
            window.top.location = window.location
        }
    </script>
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#user").focus();
        });
    </script>
</head>

<body class="signin">
<div class="signinpanel">
    <div class="row">
        <div class="col-sm-7">
            <div class="signin-info">
                <div class="logopanel m-b">
                    <h1>后台管理中心</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <form method="post" action="">
                <h4 class="no-margins">后台登录</h4>
                <input type="text" class="form-control uname" id="user" name="username" placeholder="用户名"/>
                <input type="password" class="form-control pword m-b" name="password" placeholder="密码"/>
                <a href="{{ SITE_URL }}" target="_blank">访问前台</a>
                <button id="submit" name="submit" class="btn btn-success btn-block">{{ lang('a-login') }}</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
