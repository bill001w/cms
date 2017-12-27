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
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/model/index',  array('typeid'=>$typeid)) }}"><em>{{ lang('a-aut-14')}}</em></a><span>|</span>
        <a href="{{ url('admin/model/add', array('typeid'=>$typeid)) }}"
           class="on"><em>{{ lang('a-add')}}</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'model-import'))
            <a href="{{ url('admin/model/import', array('typeid'=>$typeid)) }}"><em>{{ lang('a-import')}}</em></a><span>|</span> @endif
        @if(admin_auth($userinfo['roleid'], 'model-cache'))
            <a href="{{ url('admin/model/cache', array('typeid'=>$typeid)) }}"><em>{{ lang('a-cache')}}</em></a> @endif
    </div>
    <div class="table-list">
        <form action="" method="post">
            <input name="modelid" type="hidden" value="{{ $data['modelid'] }}"/>
            <div class="pad-10">
                <div class="col-tab">
                    <ul class="tabBut cu-li">
                        <li onClick="SwapTab('setting','on','',2,1);" class="on"
                            id="tab_setting_1">{{ lang('a-cat-25') }}</li>
                        <li onClick="SwapTab('setting','on','',2,2);" id="tab_setting_2"
                            class="">{{ lang('a-mod-134') }}</li>
                    </ul>
                    <div class="contentList pad-10" id="div_setting_1" style="display: block;">
                        <table width="100%" class="table_form">
                            <tr>
                                <th><font color="red">*</font> {{ lang('a-mod-19') }}：</th>
                                <td><input class="input-text" type="text" name="tablename"
                                           value="{{ $data['tablename'] }}" size="30" @if($data['modelid'])
                                           disabled @endif
                                           required/>
                                    <div class="onShow">{{ lang('a-mod-20') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th><font color="red">*</font> {{ lang('a-mod-23') }}：</th>
                                <td><input class="input-text" type="text" name="categorytpl"
                                           value="{{ $data['categorytpl'] }}" size="30"/>
                                    <div class="onShow">{{ lang('a-mod-28') }}：category.html</div>
                                </td>
                            </tr>
                            <tr>
                                <th><font color="red">*</font> {{ lang('a-mod-25') }}：</th>
                                <td><input class="input-text" type="text" name="listtpl" value="{{ $data['listtpl'] }}"
                                           size="30"/>
                                    <div class="onShow">{{ lang('a-mod-28') }}：list.html</div>
                                </td>
                            </tr>
                            <tr>
                                <th><font color="red">*</font> {{ lang('a-mod-26') }}：</th>
                                <td><input class="input-text" type="text" name="showtpl" value="{{ $data['showtpl'] }}"
                                           size="30"/>
                                    <div class="onShow">{{ lang('a-mod-28') }}：show.html</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="contentList pad-10 hidden" id="div_setting_2" style="display: none;">
                        <table width="100%" class="table_form">
                            <tr>
                                <th width="200">{{ lang('a-cat-97') }}：</th>
                                <td>
                                    <input name="setting[auth][adminpost]" type="radio" value="0"
                                           @if($setting['auth']['adminpost']==0)
                                           checked @endif
                                           onClick="$('#adminpost').hide()"/>&nbsp;{{ lang('a-cat-51') }}
                                    &nbsp;&nbsp;&nbsp;
                                    <input name="setting[auth][adminpost]" type="radio" value="1"
                                           @if($setting['auth']['adminpost']==1)
                                           checked @endif
                                           onClick="$('#adminpost').show()"/>&nbsp;{{ lang('a-cat-52') }}
                                </td>
                            </tr>
                            <tr id="adminpost" @if(!$setting['auth']['adminpost'])
                            style="display:none" @endif
                            >
                                <th>{{ lang('a-cat-99') }}：</th>
                                <td>
                                    @foreach($rolemodel as $t)
                                        <input name="setting[auth][rolepost][]" type="checkbox"
                                               value="{{ $t['roleid'] }}" @if($t['roleid']==1)
                                               disabled @endif
                                               @if(@in_array($t['roleid'], $setting['auth']['rolepost']))
                                               checked @endif
                                        />
                                        {{ $t['rolename'] }}&nbsp;
                                    @endforeach
                                    <div class="onShow">{{ lang('a-mod-135') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th width="200">{{ lang('a-cat-50') }}：</th>
                                <td>
                                    <input name="setting[auth][memberpost]" type="radio" value="0"
                                           @if($setting['auth']['memberpost']==0)
                                           checked @endif
                                           onClick="$('#memberpost').hide()"/>&nbsp;{{ lang('a-cat-51') }}
                                    &nbsp;&nbsp;&nbsp;
                                    <input name="setting[auth][memberpost]" type="radio" value="1"
                                           @if($setting['auth']['memberpost']==1)
                                           checked @endif
                                           onClick="$('#memberpost').show()"/>&nbsp;{{ lang('a-cat-52') }}
                                </td>
                            </tr>
                            <tbody id="memberpost" @if(!$setting['auth']['memberpost'])
                            style="display:none" @endif
                            >
                            <tr>
                                <th>{{ lang('a-cat-53') }}：</th>
                                <td>
                                    @foreach($membermodel as $t)
                                        <input name="setting[auth][modelpost][]" type="checkbox"
                                               value="{{ $t['modelid'] }}"
                                               @if(@in_array($t['modelid'], $setting['auth']['modelpost']))
                                               checked @endif
                                        />
                                        {{ $t['modelname'] }}&nbsp;
                                    @endforeach
                                    <div class="onShow">{{ lang('a-mod-135') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-cat-55') }}：</th>
                                <td>
                                    @foreach($membergroup as $t)
                                        <input name="setting[auth][grouppost][]" type="checkbox" value="{{ $t['id'] }}"
                                               @if(@in_array($t['id'], $setting['auth']['grouppost']))
                                               checked @endif
                                        />
                                        {{ $t['name'] }}&nbsp;
                                    @endforeach
                                    <div class="onShow">{{ lang('a-mod-135') }}</div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bk15"></div>
                    <input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-submit') }}" name="submit"/>
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
</script>