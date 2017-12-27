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
    <style>
        #ui-upload-holder {
            position: relative;
            width: 60px;
            height: 25px;
            border: 1px solid silver;
            overflow: hidden;
            float: left;
        }

        #ui-upload-input {
            position: absolute;
            top: 0px;
            right: 0px;
            height: 100%;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity:0);
            z-index: 999;
            float: left;
        }

        #ui-upload-txt {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            line-height: 25px;
            text-align: center;
        }

        #ui-upload-button {
            position: relative;
            padding-left: 10px;
            padding-top: 1px;
            height: 25px;
            overflow: hidden;
            float: left;
        }

        #ui-upload-filepath {
            position: relative;
            border: 1px solid silver;
            width: 200px;
            height: 25px;
            overflow: hidden;
            float: left;
            border-right: none;
        }

        #ui-upload-filepathtxt {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 25px;
            border: 0px;
            line-height: 25px;
        }

        .uploadlay {
            padding-left: 25px;
        }
    </style>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="table-list">
        <form method="post" action="" id="myform" name="myform" enctype="multipart/form-data">
            <input name="size" id="size" type="hidden" value="{{ $size }}"/>
            <input name="admin" id="admin" type="hidden" value="{{ $admin }}"/>
            <input name="ofile" id="ofile" type="hidden" value="{{ $ofile }}"/>
            <input name="filename" id="filename" type="hidden" value="{{ $fielname }}"/>
            <input name="document" id="document" type="hidden" value="{{ $document }}"/>
            <div class="pad-10">
                <div class="col-tab">
                    <table width="100%">
                        <tr>
                            <td align="center">
                                <div class="uploadlay">
                                    <div id="ui-upload-filepath">
                                        <input type="text" id="ui-upload-filepathtxt" class="filepathtxt" disabled/>
                                    </div>
                                    <div id="ui-upload-holder">
                                        <div id="ui-upload-txt">{{ lang('a-mod-208') }}</div>
                                        <input type="file" id="ui-upload-input" name="file"/>
                                    </div>
                                    <div id="ui-upload-button">
                                        <input type="submit" class="btn btn-success btn-sm"
                                               value="{{ lang('a-upload') }}" name="submit" align="absmiddle"
                                               @if(!empty($isimage))
                                               onClick="this.value='uploading'" @else
                                               onClick="uploading()" @endif
                                        />
                                    </div>
                                </div>
                                <script>
                                    document.getElementById("ui-upload-input").onchange = function () {
                                        document.getElementById("ui-upload-filepathtxt").value = this.value;
                                    }
                                    function uploading() {
                                        $("#result").html("<img src='views/admin/images/loading.gif'>");
                                    }
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" id="result">
                                @if(!empty($isimage))

                                    {{ lang('a-con-51') }}：<input type="text" class="input-text" style="width:32px;"
                                                                  name="width" value="@if(!empty($w))
                                    {{ $w }} @endif
                                            "/>&nbsp;X&nbsp;&nbsp;<input type="text" class="input-text"
                                                                         style="width:32px;" name="height"
                                                                         value="@if(!empty($h))
                                                                         {{ $h }} @endif
                                                                                 "/>&nbsp;
                                    {{ lang('a-con-52') }} <input name="type" type="radio" value="0" checked/>
                                    &nbsp; {{ lang('a-con-53')}} <input name="type" type="radio" value="1"/>
                                    &nbsp;
                                 @endif
                            </td>
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