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
    <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet">
    <script type="text/javascript" src="/views/admin/js/jquery.min.js"></script>
    <script type="text/javascript">
        var sitepath = "{{ SITE_PATH }}{{ ENTRY_SCRIPT_NAME }}";
        var finecms_admin_document = "{{ $setting['document'] }}";
    </script>
    <script type="text/javascript" src="{{ LANG_PATH }}lang.js"></script>
    <script type="text/javascript" src="/views/admin/js/core.js"></script>
    <script type="text/javascript">
        function ajaxdir() {
            var dir = $('#dir_text').val();
            if (dir == '') {
                $.post(sitepath + '?c=api&a=pinyin&id=' + Math.random(), {name: $('#dir').val()}, function (data) {
                    $('#dir_text').val(data);
                });
            }
        }
    </script>
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="content-menu ib-a blue line-x">
        <a href="{{ url('admin/category/') }}"><em>{{ lang('a-cat-12')}}</em></a><span>|</span>
        <a href="{{ url('admin/category/add') }}" class="on"><em>{{ lang('a-cat-13')}}</em></a><span>|</span>
        @if(admin_auth($userinfo['roleid'], 'category-cache'))
            <a href="{{ url('admin/category/cache') }}"><em>{{ lang('a-cache')}}</em></a>
         @endif
    </div>
    <div class="table-list">
        <form method="post" action="" id="myform" name="myform">
            <input type="hidden" value="{{ $catid }}" name="catid"/>
            <div class="pad-10">
                <div class="col-tab">
                    <ul class="tabBut cu-li">
                        <li onClick="SwapTab('setting','on','',5,1);" class="on"
                            id="tab_setting_1">{{ lang('a-cat-25') }}</li>
                        <li onClick="SwapTab('setting','on','',5,2);" id="tab_setting_2"
                            class="">{{ lang('a-cat-26') }}</li>
                        <li onClick="SwapTab('setting','on','',5,3);" id="tab_setting_3"
                            class="">{{ lang('a-cat-27') }}</li>
                        <li onClick="SwapTab('setting','on','',5,4);" id="tab_setting_4"
                            class="">{{ lang('a-cat-28') }}</li>
                    </ul>
                    <div class="contentList pad-10" id="div_setting_1" style="display: block;">
                        <table width="100%" class="table_form">
                            <tbody>
                            <tr>
                                <th><font color="red">*</font> {{ lang('a-cat-32') }}：</th>
                                <td>
                                    <select id="parentid" name="data[parentid]">
                                        <option value="0">{{ lang('a-cat-33') }}</option>
                                        {{ $category_select }}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><font color="red">*</font> {{ lang('a-cat-17') }}：</th>
                                <td>
                                    <select id="modelid" name="data[modelid]" @if(!empty($catid)) disabled  @endif />
                                    <option value="">--</option>
                                    @foreach($model as $t)
                                        <option value="{{ $t['modelid'] }}"
                                                @if($t['modelid']==$data['modelid']) selected  @endif>{{ $t['tablename'] }}
                                        </option>
                                        @endforeach
                                        </select>
                                </td>
                            </tr>
                            @if(!empty($add))
                                <tr>
                                    <th>{{ lang('a-cat-34') }}：</th>
                                    <td>
                                        <input type="radio" value="0" name="addall"
                                               onclick='$("#addall").hide();$("#_addall").show();'
                                               checked/> {{ lang('a-no') }}&nbsp;&nbsp;
                                        <input type="radio" value="1" name="addall"
                                               onclick='$("#addall").show();$("#_addall").hide();'/> {{ lang('a-yes') }}
                                    </td>
                                </tr>
                            <tbody id='addall' style="display:none">
                            <tr>
                                <th><font color="red">*</font> {{ lang('a-cat-15') }}：</th>
                                <td><textarea style="width:200px;height:110px" name="names"/></textarea>
                                    <div class="onShow">{{ lang('a-cat-35') }}</div>
                                </td>
                            </tr>
                            </tbody>
                             @endif
                            <tbody id='_addall'>
                            <tr>
                                <th><font color="red">*</font> {{ lang('a-cat-15') }}：</th>
                                <td><input type="text" class="input-text" size="25" value="{{ $data['catname'] }}"
                                           name="data[catname]" id="dir" onBlur="ajaxdir()"/></td>
                            </tr>
                            <tr>
                                <th><font color="red">*</font> {{ lang('a-cat-36') }}：</th>
                                <td><input type="text" class="input-text" size="25" value="{{ $data['catdir'] }}"
                                           name="data[catdir]" id="dir_text"/></td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-mod-201') }}：</th>
                                <td><input type="text" class="input-text" size="25" value="{{ $setting['document'] }}"
                                           name="setting[document]" onBlur="set_document(this.value)"/>
                                    <div id="result_document" class="onShow">{{ lang('a-mod-202') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-cat-37') }}：</th>
                                <td><input type="text" class="input-text" size="50" value="{{ $data['image'] }}"
                                           name="data[image]" id="image"/>
                                    <input type="button" style="width:66px;cursor:pointer;"
                                           class="btn btn-success btn-sm" onClick="preview('image')"
                                           value="{{ lang('a-image') }}"/>
                                    <input type="button" style="width:66px;cursor:pointer;"
                                           class="btn btn-success btn-sm" onClick="uploadImage('image')"
                                           value="{{ lang('a-upload') }}"/>
                                    <div class="onShow">{{ lang('a-pic') }}</div>
                                </td>
                            </tr>
                            </tbody>
                            <tr>
                                <th>{{ lang('a-cat-38') }}：</th>
                                <td>
                                    <input type="radio" @if(!isset($data['ismenu']) || $data['ismenu']==1)
                                    checked  @endif
                                           value="1" name="data[ismenu]"/> {{ lang('a-yes') }}&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" @if(isset($data['ismenu']) && $data['ismenu']==0)
                                    checked  @endif
                                           value="0" name="data[ismenu]"/> {{ lang('a-no') }}
                                    <div class="onShow">{{ lang('a-cat-39') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-cat-58') }}：</th>
                                <td><input name="setting[url][tohtml]" type="radio" value="1"
                                           @if($setting['url']['tohtml'])
                                           checked  @endif
                                           onClick="$('#html').show()"> {{ lang('a-yes') }}
                                    &nbsp;&nbsp;&nbsp;
                                    <input name="setting[url][tohtml]" type="radio" value="0"
                                           @if(!$setting['url']['tohtml'])
                                           checked  @endif
                                           onClick="$('#html').hide()"> {{ lang('a-no') }} </td>
                            </tr>
                            <tr id="html" style="display:@if($setting['url']['tohtml'])
                                    table-row@else
                                    none @endif
                                    ">
                                <th>{{ lang('a-cat-59') }}：</th>
                                <td><input class="input-text" type="text" name="setting[url][htmldir]"
                                           value="@if(isset($setting['url']['htmldir']))
                                           {{ $setting['url']['htmldir'] }} @else
                                                   html  @endif
                                                   " size="15"/>
                                    <div class="onShow">{{ lang('a-cat-60') }}</div>
                                </td>
                            </tr>
                            @include("admin/category_filed")
                            </tbody>
                        </table>
                    </div>
                    <div class="contentList pad-10 hidden" id="div_setting_2" style="display: none;">
                        <table width="100%" class="table_form ">
                            <tbody>
                            <tr>
                                <th width="200">{{ lang('a-cat-42') }}：</th>
                                <td>
                                    <input type="text" class="input-text" size="30" value="{{ $data['pagesize'] }}"
                                           name="data[pagesize]">
                                    <div class="onShow">{{ lang('a-cat-43') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-cat-44') }}：</th>
                                <td id="category_template">
                                    <input type="text" class="input-text" size="30" value="{{ $data['categorytpl'] }}"
                                           name="data[categorytpl]" id="categorytpl">
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-cat-45') }}：</th>
                                <td id="list_template">
                                    <input type="text" class="input-text" size="30" value="{{ $data['listtpl'] }}"
                                           name="data[listtpl]" id="listtpl">
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-cat-46') }}：</th>
                                <td id="show_template">
                                    <input type="text" class="input-text" size="30" value="{{ $data['showtpl'] }}"
                                           name="data[showtpl]" id="showtpl">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="contentList pad-10 hidden" id="div_setting_3" style="display: none;">
                        <table width="100%" class="table_form ">
                            <tbody>
                            <tr>
                                <th width="200">{{ lang('a-cat-47') }}：</th>
                                <td><input type="text" maxlength="60" size="60" value="{{ $data['meta_title'] }}"
                                           id="meta_title" name="data[meta_title]" class="input-text"></td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-cat-48') }}：</th>
                                <td><textarea style="width:90%;height:40px" id="meta_keywords"
                                              name="data[meta_keywords]">{{ $data['meta_keywords'] }}</textarea></td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-cat-49') }}：</th>
                                <td><textarea style="width:90%;height:50px" id="meta_description"
                                              name="data[meta_description]">{{ $data['meta_description'] }}</textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="contentList pad-10 hidden" id="div_setting_4" style="display: none;">
                        <table width="100%" class="table_form">
                            @if($data['child'])

                                <tr>
                                    <th width="200">{{ lang('a-cat-91') }}：</th>
                                    <td>
                                        <input name="data[synpost]" type="checkbox" value="1"
                                               checked=""/>&nbsp;&nbsp;{{ lang('a-yes') }}
                                    </td>
                                </tr>
                             @endif
                            <tr>
                                <th width="200">{{ lang('a-mod-215') }}：</th>
                                <td>
                                    <input name="setting[verifypost]" type="radio" value="0"
                                           @if($setting['verifypost']==0)
                                           checked  @endif
                                           onClick="$('#verifypost').hide()">&nbsp;{{ lang('a-mod-216') }}
                                    &nbsp;&nbsp;&nbsp;
                                    <input name="setting[verifypost]" type="radio" value="1"
                                           @if($setting['verifypost']==1)
                                           checked  @endif
                                           onClick="$('#verifypost').show()">&nbsp;{{ lang('a-mod-217') }}
                                </td>
                            </tr>
                            <tr id="verifypost" @if(!$setting['verifypost'])
                            style="display:none"  @endif
                            >
                                <th>{{ lang('a-cat-99') }}：</th>
                                <td>
                                    @foreach($rolemodel as $t)
                                        <input name="setting[verifyrole][]" type="checkbox" value="{{ $t['roleid'] }}"
                                               @if($t['roleid']==1)
                                               disabled  @endif
                                               @if(@in_array($t['roleid'], $setting['verifyrole']))
                                               checked  @endif
                                        />
                                        {{ $t['rolename'] }}&nbsp;
                                    @endforeach
                                    <div class="onShow">{{ lang('a-mod-218') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-cat-97') }}：</th>
                                <td>
                                    <input name="setting[adminpost]" type="radio" value="0"
                                           @if($setting['adminpost']==0)
                                           checked  @endif
                                           onClick="$('#adminpost').hide()">&nbsp;{{ lang('a-cat-51') }}
                                    &nbsp;&nbsp;&nbsp;
                                    <input name="setting[adminpost]" type="radio" value="1"
                                           @if($setting['adminpost']==1)
                                           checked  @endif
                                           onClick="$('#adminpost').show()">&nbsp;{{ lang('a-cat-52') }}
                                </td>
                            </tr>
                            <tr id="adminpost" @if(!$setting['adminpost'])
                            style="display:none"  @endif
                            >
                                <th>{{ lang('a-cat-99') }}：</th>
                                <td>
                                    @foreach($rolemodel as $t)
                                        <input name="setting[rolepost][]" type="checkbox" value="{{ $t['roleid'] }}"
                                               @if($t['roleid']==1)
                                               disabled  @endif
                                               @if(@in_array($t['roleid'], $setting['rolepost']))
                                               checked  @endif
                                        />
                                        {{ $t['rolename'] }}&nbsp;
                                    @endforeach
                                    <div class="onShow">{{ lang('a-cat-98') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-cat-50') }}：</th>
                                <td>
                                    <input name="setting[memberpost]" type="radio" value="0"
                                           @if($setting['memberpost']==0)
                                           checked  @endif
                                           onClick="$('#memberpost').hide()">&nbsp;{{ lang('a-cat-51') }}
                                    &nbsp;&nbsp;&nbsp;
                                    <input name="setting[memberpost]" type="radio" value="1"
                                           @if($setting['memberpost']==1)
                                           checked  @endif
                                           onClick="$('#memberpost').show()">&nbsp;{{ lang('a-cat-52') }}
                                </td>
                            </tr>
                            <tbody id="memberpost" @if(!$setting['memberpost'])
                            style="display:none"  @endif
                            >
                            <tr>
                                <th>{{ lang('a-cat-53') }}：</th>
                                <td>
                                    @foreach($membermodel as $t)
                                        <input name="setting[modelpost][]" type="checkbox" value="{{ $t['modelid'] }}"
                                               @if(@in_array($t['modelid'], $setting['modelpost']))
                                               checked  @endif
                                        />
                                        {{ $t['modelname'] }}&nbsp;
                                    @endforeach
                                    <div class="onShow">{{ lang('a-cat-54') }}</div>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ lang('a-cat-55') }}：</th>
                                <td>
                                    @foreach($membergroup as $t)
                                        <input name="setting[grouppost][]" type="checkbox" value="{{ $t['id'] }}"
                                               @if(@in_array($t['id'], $setting['grouppost']))
                                               checked  @endif
                                        />
                                        {{ $t['name'] }}&nbsp;
                                    @endforeach
                                    <div class="onShow">{{ lang('a-cat-56') }}</div>
                                </td>
                            </tr>
                            </tbody>
                            <tr>
                                <th>{{ lang('a-cat-92') }}：</th>
                                <td>
                                    <input name="setting[guestpost]" type="radio" value="1" @if($setting['guestpost'])
                                    checked  @endif
                                           onClick="$('#guestpost').show();$('#_guestpost').val(1);">&nbsp;{{ lang('a-cat-51') }}
                                    &nbsp;&nbsp;&nbsp;
                                    <input name="setting[guestpost]" type="radio" value="0"
                                           @if(!isset($setting['guestpost']) || $setting['guestpost']==0)
                                           checked  @endif
                                           onClick="$('#guestpost').hide();$('#_guestpost').val(0);">&nbsp;{{ lang('a-cat-52') }}
                                </td>
                            </tr>
                            <tr id="guestpost" style="@if(empty($setting['guestpost']))
                                    display:none; @endif
                                    ">
                                <th>{{ lang('a-cat-93') }}：</th>
                                <td>
                                    <input class="input-text" id="_guestpost" type="text" name="setting[guestpost]"
                                           value="{{ $setting['guestpost'] }}" size="10"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="bk15"></div>
                    <input type="submit" class="btn btn-success btn-sm" value="{{ lang('a-submit') }}" name="submit"/>
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

    var data = '';//{{ $json_model }};

    function settype(id) {
        $(".type_1").hide();
        $(".type_2").hide();
        $(".type_3").hide();
        $(".type_4").hide();
        $(".type_" + id).show();
        if (id == 2) {
            var page = $("#showtpl").val();
            if (page) {
            }
            else {
                $("#showtpl").val("page.html")
            }
        }
    }

    function change_tpl(mid) {
        $("#categorytpl").val(data[mid]['categorytpl']);
        $("#listtpl").val(data[mid]['listtpl']);
        $("#showtpl").val(data[mid]['showtpl']);
    }
    settype({{ $data[typeid] }});

    function setURL(id) {
        if (id) {
            $("#url").show();
        } else {
            $("#url").hide();
        }
    }
    setURL({{ $setting['url']['use'] }});

    function set_document(dir) {
        var reg = /^[a-zA-Z_0-9]+$/;
        var r = dir.match(reg);
        if (dir != '' && r == null) {
            $("#result_document").addClass("onError");
            $("#result_document").html("{{ lang('a-mod-203') }}");
        } else {
            $("#result_document").addClass("onCorrect");
            $("#result_document").removeClass("onError");
            $("#result_document").html("&nbsp;");
            finecms_admin_document = dir;
        }
    }
</script>