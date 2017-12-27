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
            <div class="pad-10">
                <div class="col-tab">
                    <ul class="tabBut cu-li">
                        <li onClick="SwapTab('setting','on','',5,1);" class="@if($type=='user')
                                on @endif
                                " id="tab_setting_1">{{ lang('a-mem-88') }}</li>
                        <li onClick="SwapTab('setting','on','',5,5);" id="tab_setting_5" class="@if($type=='reg')
                                on @endif
                                ">{{ lang('a-mem-89') }}</li>
                        <li onClick="SwapTab('setting','on','',5,2);" id="tab_setting_2" class="@if($type=='oauth')
                                on @endif
                                ">{{ lang('a-mem-90') }}</li>
                        <li onClick="SwapTab('setting','on','',5,3);" id="tab_setting_3" class="@if($type=='email')
                                on @endif
                                ">{{ lang('a-mem-91') }}</li>
                    </ul>
                    <div class="contentList pad-10" id="div_setting_1" style="display: @if($type=='user')
                            block@else
                            none @endif
                            ;">
                        <table width="100%" class="table_form">
                            <tr>
                                <th width="200">{{ lang('a-mem-94') }}：</th>
                                <td><input name="data[logincode]" type="radio" value="1" @if($data['logincode']==1)
                                    checked @endif
                                    > {{ lang('a-open') }}
                                    &nbsp;&nbsp;&nbsp;<input name="data[logincode]" type="radio" value="0"
                                                             @if($data['logincode']==0)
                                                             checked @endif
                                    > {{ lang('a-close') }}</td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mem-95') }}：</th>
                                <td><input name="data[avatar]" type="radio" value="1" @if($data['avatar']==1)
                                    checked @endif
                                    > {{ lang('a-mem-101') }}
                                    &nbsp;&nbsp;&nbsp;<input name="data[avatar]" type="radio" value="0"
                                                             @if($data['avatar']==0)
                                                             checked @endif
                                    > {{ lang('a-mem-102') }}
                                    <div class="onShow">{{ lang('a-mem-96') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mem-97') }}：</th>
                                <td><input type="text" class="input-text" name="data[pagesize]" size="10"
                                           value="<?php echo isset($data['pagesize']) && $data['pagesize'] ? $data['pagesize'] : 8; ?>"/>
                                    <div class="onShow">{{ lang('a-mem-98') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mem-99') }}：</th>
                                <td><input type="text" class="input-text" name="data[postcredits]" size="10"
                                           value="{{ $data['postcredits'] }}"/>
                                    <div class="onShow">{{ lang('a-mem-100') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mem-103') }}：</th>
                                <td><input type="text" class="input-text" name="data[delcredits]" size="10"
                                           value="{{ $data['delcredits'] }}"/>
                                    <div class="onShow">{{ lang('a-mem-100') }}</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="contentList pad-10" id="div_setting_5" style="display: @if($type=='reg')
                            block@else
                            none @endif
                            ;">
                        <table width="100%" class="table_form">
                            <tr>
                                <th width="200">{{ lang('a-mem-104') }}：</th>
                                <td><input name="data[register]" type="radio" value="1" @if($data['register']==1)
                                    checked @endif
                                    > {{ lang('a-open') }}
                                    &nbsp;&nbsp;&nbsp;<input name="data[register]" type="radio" value="0"
                                                             @if($data['register']==0)
                                                             checked @endif
                                    > {{ lang('a-close') }}</td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mem-105') }}：</th>
                                <td><input name="data[status]" type="radio" value="1" @if($data['status']==1)
                                    checked @endif
                                    > {{ lang('a-open') }}
                                    &nbsp;&nbsp;&nbsp;<input name="data[status]" type="radio" value="0"
                                                             @if($data['status']==0)
                                                             checked @endif
                                    > {{ lang('a-close') }}</td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mem-106') }}：</th>
                                <td><input name="data[regcode]" type="radio" value="1" @if($data['regcode']==1)
                                    checked @endif
                                    > {{ lang('a-open') }}
                                    &nbsp;&nbsp;&nbsp;<input name="data[regcode]" type="radio" value="0"
                                                             @if($data['regcode']==0)
                                                             checked @endif
                                    > {{ lang('a-close') }}</td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mem-109') }}：</th>
                                <td><input name="data[email]" type="radio" value="1" @if($data['email']==1)
                                    checked @endif
                                    > {{ lang('a-open') }}
                                    &nbsp;&nbsp;&nbsp;<input name="data[email]" type="radio" value="0"
                                                             @if($data['email']==0)
                                                             checked @endif
                                    > {{ lang('a-close') }}
                                    <div class="onShow">{{ lang('a-mem-110') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mem-107') }}：</th>
                                <td><input type="text" class="input-text" name="data[regiptime]" size="10"
                                           value="{{ $data['regiptime'] }}"/>
                                    <div class="onShow">{{ lang('a-mem-108') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mod-158') }}：</th>
                                <td><input type="text" class="input-text" name="data[username_pattern]" size="40"
                                           value="@if(empty($data['username_pattern']))
                                                   /^[a-zA-Z0-9_][a-zA-Z0-9_]+$/@else
                                           {{ $data['username_pattern'] }} @endif
                                                   "/>
                                    <div class="onShow">{{ lang('a-mod-159') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mem-111') }}：</th>
                                <td><textarea name="data[banuser]" rows="3" cols="80" class="text"
                                              style="overflow:auto">{{ $data['banuser'] }}</textarea>
                                    <br>
                                    <div class="onShow">{{ lang('a-mem-112') }}</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="contentList pad-10 hidden" id="div_setting_2" style="display: @if($type=='oauth')
                            block@else
                            none @endif
                            ;">
                        <table width="100%" class="table_form ">
                            <tr>
                                <th width="200">{{ lang('a-mem-113') }}：</th>
                                <td><input name="data[isoauth]" type="radio" value="1" @if($data['isoauth']==1)
                                    checked @endif
                                    > {{ lang('a-open') }}
                                    &nbsp;&nbsp;&nbsp;<input name="data[isoauth]" type="radio" value="0"
                                                             @if($data['isoauth']==0)
                                                             checked @endif
                                    > {{ lang('a-close') }}</td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mem-114') }}：</th>
                                <td><a href="http://connect.qq.com/intro/login/"
                                       target="_blank">{{ lang('a-mem-116') }}</a>
                            </tr>
                            <tbody id="qq">
                            <tr>
                                <th>APPID：</th>
                                <td><input class="input-text" type="text" name="oauth[qq][appid]"
                                           value="{{ $data['oauth']['qq']['appid'] }}" size="25"/></td>
                            </tr>
                            <tr>
                                <th>APPKEY：</th>
                                <td><input class="input-text" type="text" name="oauth[qq][appkey]"
                                           value="{{ $data['oauth']['qq']['appkey'] }}" size="50"/></td>
                            </tr>
                            </tbody>
                            <tr>
                                <th>{{ lang('a-mem-115') }}：</th>
                                <td><a href="http://open.weibo.com/connect" target="_blank">{{ lang('a-mem-116') }}</a>
                            </tr>
                            <tbody id="sina">
                            <tr>
                                <th>APPID：</th>
                                <td><input class="input-text" type="text" name="oauth[sina][appid]"
                                           value="{{ $data['oauth']['sina']['appid'] }}" size="25"/></td>
                            </tr>
                            <tr>
                                <th>APPKEY：</th>
                                <td><input class="input-text" type="text" name="oauth[sina][appkey]"
                                           value="{{ $data['oauth']['sina']['appkey'] }}" size="50"/></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="contentList pad-10 hidden" id="div_setting_3" style="display: @if($type=='email')
                            block@else
                            none @endif
                            ;">
                        <table width="100%" cellspacing="0" class="table_form">
                            <tbody>
                            <tr>
                                <td>{{ lang('a-mem-117') }}</td>
                            </tr>
                            <tr>
                                <td>1、{{ lang('a-mem-118') }}</td>
                            </tr>
                            <tr>
                                <td><textarea id="reg_tpl" style="height: 250px; width: 90%;" name="data[reg_tpl]"
                                              class="text">{{ $data['reg_tpl'] }}</textarea></td>
                            </tr>
                            <tr>
                                <td>2、{{ lang('a-mem-119') }}</td>
                            </tr>
                            <tr>
                                <td><textarea id="pass_tpl" style="height: 250px; width: 90%;" name="data[pass_tpl]"
                                              class="text">{{ $data['pass_tpl'] }}</textarea></td>
                            </tr>
                            <tr>
                                <td>3、{{ lang('a-mem-120') }}</td>
                            </tr>
                            <tr>
                                <td><textarea id="group_tpl" style="height: 250px; width: 90%;" name="data[group_tpl]"
                                              class="text">{{ $data['group_tpl'] }}</textarea></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bk15"></div>
                    <input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-submit') }}" name="submit">
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    function SwapTab(name, cls_show, cls_hide, cnt, cur) {
        for (i = 1; i <= cnt; i++) {
            if (i == cur) {
                $('#div_' + name + '_' + i).show();
                $('#tab_' + name + '_' + i).attr('class', cls_show);
            } else {
                $('#div_' + name + '_' + i).hide();
                $('#tab_' + name + '_' + i).attr('class', cls_hide);
            }
        }
    }
    function mysql_test() {
        $.get('<?php echo url('admin/member/test')?>', {
            host: $('#uc_dbhost').val(),
            username: $('#uc_dbuser').val(),
            password: $('#uc_dbpw').val()
        }, function (data) {
            if (data == 1) {
                alert('ok');
            } else {
                alert('error');
            }
        });
    }
</script>