<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="/views/admin/images/reset.css" rel="stylesheet" type="text/css" />
        <link href="/views/admin/images/system.css" rel="stylesheet" type="text/css" />
        <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet">
        <link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
        <link href="/views/admin/luos/css/style.min.css?v=4.1.0" rel="stylesheet">
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
            <li onClick="SwapTab('setting','on','',6,1);" id="tab_setting_1" class="<?php if ($type==1) { ?>on<?php } ?>"><?php echo lang('a-men-65'); ?></li>
            <li onClick="SwapTab('setting','on','',6,2);" id="tab_setting_2" class="<?php if ($type==2) { ?>on<?php } ?>"><?php echo lang('a-men-12'); ?></li>
            <li onClick="SwapTab('setting','on','',6,3);" id="tab_setting_3" class="<?php if ($type==3) { ?>on<?php } ?>"><?php echo lang('a-men-15'); ?></li>
            <li onClick="SwapTab('setting','on','',6,4);" id="tab_setting_4" class="<?php if ($type==4) { ?>on<?php } ?>"><?php echo lang('a-men-16'); ?></li>
            <li onClick="SwapTab('setting','on','',6,5);" id="tab_setting_5" class="<?php if ($type==5) { ?>on<?php } ?>"><?php echo lang('a-men-17'); ?></li>
            <li onClick="SwapTab('setting','on','',6,6);" id="tab_setting_6" class="<?php if ($type==6) { ?>on<?php } ?>"><?php echo lang('a-men-13'); ?></li>
        </ul>

        <div class="contentList pad-10 hidden" id="div_setting_1" style="display: none;">
        <table width="100%" class="table_form">
        <tbody>
            <tr>
                <th><?php echo $string['SITE_ADMINLOG']; ?>： </th>
                <td><input name="data[SITE_ADMINLOG]" type="radio" value="true" <?php if ($data['SITE_ADMINLOG']) { ?>checked<?php } ?>> <?php echo lang('a-open'); ?>
                &nbsp;&nbsp;&nbsp;<input name="data[SITE_ADMINLOG]" type="radio" value="false" <?php if ($data['SITE_ADMINLOG']==false) { ?>checked<?php } ?>> <?php echo lang('a-close'); ?>
                &nbsp;&nbsp;&nbsp;<div class="onShow"><?php echo lang('a-ind-104'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo $string['SYS_ATTACK_LOG']; ?>： </th>
                <td><input name="data[SYS_ATTACK_LOG]" type="radio" value="true" <?php if ($data['SYS_ATTACK_LOG']) { ?>checked<?php } ?> onclick="$('#atmaill').show();"> <?php echo lang('a-open'); ?>
                    &nbsp;&nbsp;&nbsp;<input name="data[SYS_ATTACK_LOG]" type="radio" value="false" <?php if ($data['SYS_ATTACK_LOG']==false) { ?>checked<?php } ?> onclick="$('#atmaill').hide();"> <?php echo lang('a-close'); ?>
                    &nbsp;&nbsp;&nbsp;<div class="onShow"><?php echo lang('a-ind-106'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo $string['SITE_BDPING']; ?>： </th>
                <td><input name="data[SITE_BDPING]" type="radio" value="true" <?php if ($data['SITE_BDPING']) { ?>checked<?php } ?>> <?php echo lang('a-open'); ?>
                    &nbsp;&nbsp;&nbsp;<input name="data[SITE_BDPING]" type="radio" value="false" <?php if ($data['SITE_BDPING']==false) { ?>checked<?php } ?>> <?php echo lang('a-close'); ?>
                    &nbsp;&nbsp;&nbsp;<div class="onShow">百度Ping服务开关</div></td>
            </tr>
            <tr>
                <th><?php echo $string['SYS_ILLEGAL_CHAR']; ?>： </th>
                <td><input name="data[SYS_ILLEGAL_CHAR]" type="radio" value="true" <?php if ($data['SYS_ILLEGAL_CHAR']) { ?>checked<?php } ?>> <?php echo lang('a-open'); ?>
                &nbsp;&nbsp;&nbsp;<input name="data[SYS_ILLEGAL_CHAR]" type="radio" value="false" <?php if ($data['SYS_ILLEGAL_CHAR']==false) { ?>checked<?php } ?>> <?php echo lang('a-close'); ?>
                &nbsp;&nbsp;&nbsp;<div class="onShow"><?php echo lang('a-ind-105'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo $string['SYS_MEMBER']; ?>： </th>
                <td><input name="data[SYS_MEMBER]" type="radio" value="true" <?php if ($data['SYS_MEMBER']) { ?>checked<?php } ?>> <?php echo lang('a-open'); ?>
                    &nbsp;&nbsp;&nbsp;<input name="data[SYS_MEMBER]" type="radio" value="false" <?php if ($data['SYS_MEMBER']==false) { ?>checked<?php } ?>> <?php echo lang('a-close'); ?>
                    &nbsp;&nbsp;&nbsp;<div class="onShow"><?php echo lang('t-001'); ?></div></td>
            </tr>
            <tr id="atmaill" <?php if (empty($data['SYS_ATTACK_LOG'])) { ?>style="display:none"<?php } ?>>
                <th><?php echo $string['SYS_ATTACK_MAIL']; ?>： </th>
                <td><input name="data[SYS_ATTACK_MAIL]" type="radio" value="true" <?php if ($data['SYS_ATTACK_MAIL']) { ?>checked<?php } ?>> <?php echo lang('a-yes'); ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="data[SYS_ATTACK_MAIL]" type="radio" value="false" <?php if ($data['SYS_ATTACK_MAIL']==false) { ?>checked<?php } ?>> <?php echo lang('a-no'); ?>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="onShow"><?php echo lang('a-ind-107'); ?></div></td>
            </tr>
            <tr style="display: none;">
                <th><?php echo $string['SITE_ADMIN_CODE']; ?>： </th>
                <td><input name="data[SITE_ADMIN_CODE]" type="radio" value="true" <?php if ($data['SITE_ADMIN_CODE']) { ?>checked<?php } ?>> <?php echo lang('a-open'); ?>
                &nbsp;&nbsp;&nbsp;<input name="data[SITE_ADMIN_CODE]" type="radio" value="false" <?php if ($data['SITE_ADMIN_CODE']==false) { ?>checked<?php } ?>> <?php echo lang('a-close'); ?>
                &nbsp;&nbsp;&nbsp;<div class="onShow"><?php echo lang('a-ind-108'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo $string['SITE_ADMIN_PAGESIZE']; ?>： </th>
                <td><input class="input-text" type="text" name="data[SITE_ADMIN_PAGESIZE]" value="<?php if (isset($data['SITE_ADMIN_PAGESIZE'])) {  echo $data['SITE_ADMIN_PAGESIZE'];  } else { ?>8<?php } ?>" style="width:86px" />
                &nbsp;&nbsp;&nbsp;<div class="onShow"><?php echo lang('a-ind-109'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo lang('a-cfg-3'); ?>： </th>
                <td><input class="input-text" type="text" name="data[SITE_SYSMAIL]" value="<?php echo $data['SITE_SYSMAIL']; ?>" size="30"/><div class="onShow"><?php echo $string['SITE_SYSMAIL']; ?></div>
                </td>
            </tr>
        </tbody>
        </table>
        </div>
        <div class="contentList pad-10 hidden" id="div_setting_2" style="display: none;">
            <table width="100%" class="table_form">
                <tr>
                    <th width="200"><?php echo lang('a-sit-3'); ?>： </th>
                    <td><select name="data[SITE_LANGUAGE]">
                        <?php if (is_array($langs)) { $count=count($langs);foreach ($langs as $t) { ?>
                        <option value="<?php echo $t; ?>" <?php if ($data['SITE_LANGUAGE']==$t) { ?>selected<?php } ?>><?php echo $t; ?></option>
                        <?php } } ?>
                    </select><div class="onShow"><?php echo lang('a-cfg-73'); ?></div></td>
                </tr>
                <tr>
                    <th><?php echo lang('a-ind-47'); ?>： </th>
                    <td><select name="data[SITE_THEME]">
                        <option value=""> -- </option>
                        <?php echo $theme; ?>
                    </select><div class="onShow"><?php echo lang('a-sit-2'); ?></div></td>
                </tr>
                <tr>
                    <th><?php echo lang('a-ind-48'); ?>： </th>
                    <td><select name="data[SITE_TIMEZONE]">
                        <option value=""> -- </option>
                        <option value="-12" <?php if ($data['SITE_TIMEZONE']=="-12") { ?>selected<?php } ?>>(GMT -12:00)</option>
                        <option value="-11" <?php if ($data['SITE_TIMEZONE']=="-11") { ?>selected<?php } ?>>(GMT -11:00)</option>
                        <option value="-10" <?php if ($data['SITE_TIMEZONE']=="-10") { ?>selected<?php } ?>>(GMT -10:00)</option>
                        <option value="-9" <?php if ($data['SITE_TIMEZONE']=="-9") { ?>selected<?php } ?>>(GMT -09:00)</option>
                        <option value="-8" <?php if ($data['SITE_TIMEZONE']=="-8") { ?>selected<?php } ?>>(GMT -08:00)</option>
                        <option value="-7" <?php if ($data['SITE_TIMEZONE']=="-7") { ?>selected<?php } ?>>(GMT -07:00)</option>
                        <option value="-6" <?php if ($data['SITE_TIMEZONE']=="-6") { ?>selected<?php } ?>>(GMT -06:00)</option>
                        <option value="-5" <?php if ($data['SITE_TIMEZONE']=="-5") { ?>selected<?php } ?>>(GMT -05:00)</option>
                        <option value="-4" <?php if ($data['SITE_TIMEZONE']=="-4") { ?>selected<?php } ?>>(GMT -04:00)</option>
                        <option value="-3.5" <?php if ($data['SITE_TIMEZONE']=="-3.5") { ?>selected<?php } ?>>(GMT -03:30)</option>
                        <option value="-3" <?php if ($data['SITE_TIMEZONE']=="-3") { ?>selected<?php } ?>>(GMT -03:00)</option>
                        <option value="-2" <?php if ($data['SITE_TIMEZONE']=="-2") { ?>selected<?php } ?>>(GMT -02:00)</option>
                        <option value="-1" <?php if ($data['SITE_TIMEZONE']=="-1") { ?>selected<?php } ?>>(GMT -01:00)</option>
                        <option value="0" <?php if ($data['SITE_TIMEZONE']=="0") { ?>selected<?php } ?>>(GMT)</option>
                        <option value="1" <?php if ($data['SITE_TIMEZONE']=="1") { ?>selected<?php } ?>>(GMT +01:00)</option>
                        <option value="2" <?php if ($data['SITE_TIMEZONE']=="2") { ?>selected<?php } ?>>(GMT +02:00)</option>
                        <option value="3" <?php if ($data['SITE_TIMEZONE']=="3") { ?>selected<?php } ?>>(GMT +03:00)</option>
                        <option value="3.5" <?php if ($data['SITE_TIMEZONE']=="3.5") { ?>selected<?php } ?>>(GMT +03:30)</option>
                        <option value="4" <?php if ($data['SITE_TIMEZONE']=="4") { ?>selected<?php } ?>>(GMT +04:00)</option>
                        <option value="4.5" <?php if ($data['SITE_TIMEZONE']=="4.5") { ?>selected<?php } ?>>(GMT +04:30)</option>
                        <option value="5" <?php if ($data['SITE_TIMEZONE']=="5") { ?>selected<?php } ?>>(GMT +05:00)</option>
                        <option value="5.5" <?php if ($data['SITE_TIMEZONE']=="5.5") { ?>selected<?php } ?>>(GMT +05:30)</option>
                        <option value="5.75" <?php if ($data['SITE_TIMEZONE']=="5.75") { ?>selected<?php } ?>>(GMT +05:45)</option>
                        <option value="6" <?php if ($data['SITE_TIMEZONE']=="6") { ?>selected<?php } ?>>(GMT +06:00)</option>
                        <option value="6.5" <?php if ($data['SITE_TIMEZONE']=="6.6") { ?>selected<?php } ?>>(GMT +06:30)</option>
                        <option value="7" <?php if ($data['SITE_TIMEZONE']=="7") { ?>selected<?php } ?>>(GMT +07:00)</option>
                        <option value="8" <?php if ($data['SITE_TIMEZONE']=="" || $data['SITE_TIMEZONE']=="8") { ?>selected<?php } ?>>(GMT +08:00)</option>
                        <option value="9" <?php if ($data['SITE_TIMEZONE']=="9") { ?>selected<?php } ?>>(GMT +09:00)</option>
                        <option value="9.5" <?php if ($data['SITE_TIMEZONE']=="9.5") { ?>selected<?php } ?>>(GMT +09:30)</option>
                        <option value="10" <?php if ($data['SITE_TIMEZONE']=="10") { ?>selected<?php } ?>>(GMT +10:00)</option>
                        <option value="11" <?php if ($data['SITE_TIMEZONE']=="11") { ?>selected<?php } ?>>(GMT +11:00)</option>
                        <option value="12" <?php if ($data['SITE_TIMEZONE']=="12") { ?>selected<?php } ?>>(GMT +12:00)</option>
                    </select>&nbsp;<div class="onShow"><?php echo $string['SITE_TIMEZONE']; ?></div></td>
                </tr>
                <tr>
                    <th><?php echo lang('a-ind-102'); ?>： </th>
                    <td><input class="input-text" type="text" name="data[SITE_TIME_FORMAT]" value="<?php echo $data['SITE_TIME_FORMAT']; ?>" size="25" /><div class="onShow"><?php echo $string['SITE_TIME_FORMAT']; ?></div></td>
                </tr>
                <tr>
                    <th><?php echo lang('a-ind-46'); ?>： </th>
                    <td><input class="input-text" type="text" name="data[SITE_NAME]" value="<?php echo $data['SITE_NAME']; ?>" size="25" /><div class="onShow"><?php echo $string['SITE_NAME']; ?></div></td>
                </tr>
                <tr>
                    <th><?php echo lang('a-cfg-18'); ?>： </th>
                    <td><input class="input-text" type="text" name="data[SITE_TITLE]" value="<?php echo $data['SITE_TITLE']; ?>" style="width:450px;" />
                        <div class="onShow"><?php echo lang('a-cfg-ex-2'); ?>：<?php echo '{'; ?>$SITE_TITLE}</div>
                    </td>
                </tr>
                <tr>
                    <th><?php echo lang('a-cfg-19'); ?>：</th>
                    <td class="y-bg"><textarea name="data[SITE_KEYWORDS]" style="width:510px;height:30px;" class="text"><?php echo $data['SITE_KEYWORDS']; ?></textarea>
                        <div class="onShow"><?php echo lang('a-cfg-ex-2'); ?>：<?php echo '{'; ?>$SITE_KEYWORDS}</div>
                    </td>
                </tr>
                <tr>
                    <th><?php echo lang('a-cfg-20'); ?>：</th>
                    <td><textarea name="data[SITE_DESCRIPTION]" style="width:510px;height:40px;" class="text"><?php echo $data['SITE_DESCRIPTION']; ?></textarea>
                        <div class="onShow"><?php echo lang('a-cfg-ex-2'); ?>：<?php echo '{'; ?>$SITE_DESCRIPTION}</div>
                    </td>
                </tr>
                <tr>
                    <th><?php echo lang('a-site-tps'); ?>：</th>
                    <td><textarea name="data[SITE_JS]" style="width:510px;height:70px;" class="text"><?php echo $data['SITE_JS']; ?></textarea>
                        <div class="onShow"><?php echo lang('a-cfg-ex-2'); ?>：<?php echo '{'; ?>$SITE_JS}</div>
                    </td>
                </tr>
                <tr>
                    <th><?php echo lang('a-site-tcp'); ?>： </th>
                    <td><input class="input-text" type="text" name="data[SITE_ICP]" value="<?php echo $data['SITE_ICP']; ?>" style="width:300px;" />
                        <div class="onShow"><?php echo lang('a-cfg-ex-2'); ?>：<?php echo '{'; ?>$SITE_ICP}</div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="contentList pad-10 hidden" id="div_setting_3" style="display: none;">
        <table width="100%" class="table_form">
            <tbody>
            <tr>
                <th width="200"><?php echo lang('a-ind-68'); ?>： </th>
                <td class="y-bg">
                 <input type="text" value="<?php echo $data['SITE_MAP_UPDATE']; ?>" size="10" name="data[SITE_MAP_UPDATE]" class="input-text">
                <div class="onShow"><?php echo $string['SITE_MAP_UPDATE']; ?></div>
                </td>
            </tr>
            </tbody>
            <tr>
                <th><?php echo lang('a-ind-69'); ?>：</th>
                <td class="y-bg"><input type="text" value="<?php echo $data['SITE_MAP_TIME']; ?>" size="10" name="data[SITE_MAP_TIME]" class="input-text">
                <div class="onShow"><?php echo $string['SITE_MAP_TIME']; ?></div></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-70'); ?>：</th>
                <td class="y-bg"><input type="text" value="<?php echo $data['SITE_MAP_NUM']; ?>" size="10" name="data[SITE_MAP_NUM]" class="input-text">
                <div class="onShow"><?php echo $string['SITE_MAP_NUM']; ?></div></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-71'); ?>：</th>
                <td class="y-bg">
                <input type="radio" <?php if ($data['SITE_MAP_AUTO']==true) { ?> checked=""<?php } ?> value="true" checkbox="auto" name="data[SITE_MAP_AUTO]"> <?php echo lang('a-open'); ?>
                &nbsp;&nbsp;
                <input type="radio" <?php if ($data['SITE_MAP_AUTO']==false) { ?> checked=""<?php } ?> value="false" checkbox="auto" name="data[SITE_MAP_AUTO]"> <?php echo lang('a-close'); ?>
                <div class="onShow"><?php echo $string['SITE_MAP_AUTO']; ?></div></td>
            </tr>
        </table>
        </div>
        <div class="contentList pad-10 hidden" id="div_setting_4" style="display: none;">
        <table width="100%" class="table_form">
            <tr>
                <th width="200"><?php echo lang('a-ind-72'); ?>： </th>
                <td><input class="input-text" type="text" name="data[SITE_SEARCH_PAGE]" value="<?php echo $data['SITE_SEARCH_PAGE']; ?>" size="10"/>
                <div class="onShow"><?php echo lang('a-ind-73'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-74'); ?>：</th>
                <td class="y-bg"><input type="text" value="<?php echo $data['SITE_SEARCH_DATA_CACHE']; ?>" size="10" name="data[SITE_SEARCH_DATA_CACHE]" class="input-text">
                <div class="onShow"><?php echo lang('a-ind-75'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-76'); ?>：</th>
                <td class="y-bg"><input type="text" value="<?php echo $data['SITE_SEARCH_URLRULE']; ?>" size="40" name="data[SITE_SEARCH_URLRULE]" class="input-text"><div class="onShow"><?php echo lang('a-ind-77'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-78'); ?>： </th>
                <td class="y-bg">
                <input type="radio" <?php if ($data['SITE_SEARCH_TYPE']==1) { ?> checked=""<?php } ?> value="1" checkbox="auto" name="data[SITE_SEARCH_TYPE]" onclick="setSearchType(1)"> <?php echo lang('a-ind-79'); ?>
                &nbsp;&nbsp;
                <input type="radio" <?php if ($data['SITE_SEARCH_TYPE']==2) { ?> checked=""<?php } ?> value="2" checkbox="auto" name="data[SITE_SEARCH_TYPE]" onclick="setSearchType(2)"> Sphinx
                </td>
            </tr>
            <tbody id="search_1">
            <tr>
                <th><?php echo lang('a-ind-80'); ?>：</th>
                <td class="y-bg"><input type="text" value="<?php echo $data['SITE_SEARCH_INDEX_CACHE']; ?>" size="10" name="data[SITE_SEARCH_INDEX_CACHE]" class="input-text">
                <div class="onShow"><?php echo lang('a-ind-81'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-82'); ?>：</th>
                <td class="y-bg"><input type="text" value="<?php echo $data['SITE_SEARCH_KW_FIELDS']; ?>" size="50" name="data[SITE_SEARCH_KW_FIELDS]" class="input-text">
                <div class="onShow"><?php echo lang('a-ind-83'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-84'); ?>：</th>
                <td class="y-bg"><input type="radio" <?php if ($data['SITE_SEARCH_KW_OR']==true) { ?> checked=""<?php } ?> value="true" checkbox="auto" name="data[SITE_SEARCH_KW_OR]"> OR
                &nbsp;&nbsp;
                <input type="radio" <?php if ($data['SITE_SEARCH_KW_OR']==false) { ?> checked=""<?php } ?> value="false" checkbox="auto" name="data[SITE_SEARCH_KW_OR]"> AND
                <div class="onShow"><?php echo lang('a-ind-85'); ?></div></td>
            </tr>
            </tbody>
            <tbody id="search_2">
            <tr>
                <th><?php echo lang('a-ind-86'); ?>：</th>
                <td class="y-bg"><input type="text" value="<?php echo $data['SITE_SEARCH_SPHINX_HOST']; ?>" size="30" name="data[SITE_SEARCH_SPHINX_HOST]" class="input-text"></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-87'); ?>：</th>
                <td class="y-bg"><input type="text" value="<?php echo $data['SITE_SEARCH_SPHINX_PORT']; ?>" size="10" name="data[SITE_SEARCH_SPHINX_PORT]" class="input-text"></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-88'); ?>：</th>
                <td class="y-bg"><input type="text" value="<?php echo $data['SITE_SEARCH_SPHINX_NAME']; ?>" size="30" name="data[SITE_SEARCH_SPHINX_NAME]" class="input-text"></td>
            </tr>
            </tbody>
        </table>
        <script type="text/javascript">
        function setSearchType(id) {
            $('#search_1').hide();
            $('#search_2').hide();
            $('#search_'+id).show();
        }
        setSearchType(<?php echo $data['SITE_SEARCH_TYPE']; ?>);
        </script>
        </div>
        <div class="contentList pad-10 hidden" id="div_setting_5" style="display: none;">
        <table width="100%" class="table_form">
            <tr>
                <th width="200"><?php echo lang('a-ind-89'); ?>：</th>
                <td><input class="input-text" type="text" name="data[SITE_KEYWORD_NUMS]" value="<?php echo $data['SITE_KEYWORD_NUMS']; ?>" size="10"/>
                <div class="onShow"><?php echo lang('a-ind-90'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-91'); ?>： </th>
                <td class="y-bg">
                <input type="radio" <?php if ($data['SITE_TAG_LINK']) { ?> checked=""<?php } ?> value="true" checkbox="auto" name="data[SITE_TAG_LINK]" /> <?php echo lang('a-yes'); ?>
                &nbsp;&nbsp;&nbsp;
                <input type="radio" <?php if (empty($data['SITE_TAG_LINK'])) { ?> checked=""<?php } ?> value="false" checkbox="auto" name="data[SITE_TAG_LINK]" /> <?php echo lang('a-no'); ?> &nbsp;&nbsp;&nbsp;<div class="onShow"><?php echo lang('a-ind-92'); ?></div>
                </td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-93'); ?>：</th>
                <td class="y-bg"><input type="text" value="<?php echo $data['SITE_KEYWORD_CACHE']; ?>" size="10" name="data[SITE_KEYWORD_CACHE]" class="input-text">
                <div class="onShow"><?php echo lang('a-ind-81'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-94'); ?>：</th>
                <td><input class="input-text" type="text" name="data[SITE_TAG_PAGE]" value="<?php echo $data['SITE_TAG_PAGE']; ?>" size="10"/>
                <div class="onShow"><?php echo lang('a-ind-95'); ?></div></td>
            </tr>
            <tr>
                <th><?php echo lang('a-ind-96'); ?>：</th>
                <td class="y-bg"><input type="text" value="<?php echo $data['SITE_TAG_CACHE']; ?>" size="10" name="data[SITE_TAG_CACHE]" class="input-text">
                <div class="onShow"><?php echo lang('a-ind-81'); ?></div></td>
            </tr>
            </tbody>
        </table>
        </div>
        <div class="contentList pad-10 hidden" id="div_setting_6" style="display: none;">
            <table width="100%" class="table_form">
                <tr>
                    <th width="200"><?php echo lang('a-mod-204'); ?>： </th>
                    <td><input name="data[SITE_THUMB_TYPE]" type="radio" value="1" <?php if ($data['SITE_THUMB_TYPE']==1) { ?>checked<?php } ?> /> <?php echo lang('a-mod-205'); ?>
                        &nbsp;&nbsp;&nbsp;<input name="data[SITE_THUMB_TYPE]" type="radio" value="0" <?php if (empty($data['SITE_THUMB_TYPE'])) { ?>checked<?php } ?> /> <?php echo lang('a-mod-206'); ?>
                        <div class="onShow"><?php echo lang('a-mod-207'); ?></div>
                    </td>
                </tr>
                <tr>
                    <th><?php echo lang('a-ind-49'); ?>： </th>
                    <td><input name="data[SITE_WATERMARK]" type="radio" value="1" <?php if ($data['SITE_WATERMARK']==1) { ?>checked<?php } ?> onClick="setSateType(1)"> <?php echo lang('a-ind-50'); ?>
                        &nbsp;&nbsp;&nbsp;<input name="data[SITE_WATERMARK]" type="radio" value="2" <?php if ($data['SITE_WATERMARK']==2) { ?>checked<?php } ?> onClick="setSateType(2)" /> <?php echo lang('a-ind-51'); ?>
                        &nbsp;&nbsp;&nbsp;<input name="data[SITE_WATERMARK]" type="radio" value="0" <?php if ($data['SITE_WATERMARK']==0) { ?>checked<?php } ?> onClick="setSateType(0)" /> <?php echo lang('a-close'); ?></td>
                </tr>
                <tbody id="w_0">
                <tr class="w_1">
                    <th><?php echo lang('a-ind-52'); ?>： </th>
                    <td><input class="input-text" type="text" name="data[SITE_WATERMARK_ALPHA]" value="<?php echo $data['SITE_WATERMARK_ALPHA']; ?>" size="25" />
                        <div class="onShow"><?php echo lang('a-ind-53'); ?></div></td>
                </tr>
                <tr class="w_1">
                    <th><?php echo lang('a-sit-1'); ?>： </th>
                    <td><select name="data[SITE_WATERMARK_IMAGE]">
                        <option value=""> -- </option>
                        <?php if (is_array($images)) { $count=count($images);foreach ($images as $t) {  if (strpos($t, '.png') !== false) { ?>
                        <option value="<?php echo $t; ?>" <?php if ($data['SITE_WATERMARK_IMAGE']==$t) { ?>selected<?php } ?>><?php echo $t; ?></option>
                        <?php }  } } ?>
                    </select>
                        <div class="onShow"><?php echo lang('a-sit-0'); ?></div></td>
                </tr>
                <tr class="w_2">
                    <th><?php echo lang('a-ind-54'); ?>： </th>
                    <td><input class="input-text" type="text" name="data[SITE_WATERMARK_TEXT]" value="<?php echo $data['SITE_WATERMARK_TEXT']; ?>" size="25" />
                        <div class="onShow"><?php echo lang('a-ind-55'); ?></div></td>
                </tr>
                <tr class="w_2">
                    <th><?php echo lang('a-cfg-69'); ?>： </th>
                    <td><input class="input-text" type="text" name="data[SITE_WATERMARK_SIZE]" value="<?php echo $data['SITE_WATERMARK_SIZE']; ?>" size="25" />
                        <div class="onShow"><?php echo lang('a-cfg-70'); ?></div></td>
                </tr>
                <tr>
                    <th><?php echo lang('a-cfg-67'); ?>： </th>
                    <td>
                        <table width="400">
                            <tr>
                                <td><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==1) { ?>checked=""<?php } ?> value="1" name="data[SITE_WATERMARK_POS]" /> <?php echo lang('a-cfg-58'); ?></td>
                                <td><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==2) { ?>checked=""<?php } ?> value="2" name="data[SITE_WATERMARK_POS]" /> <?php echo lang('a-cfg-59'); ?></td>
                                <td><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==3) { ?>checked=""<?php } ?> value="3" name="data[SITE_WATERMARK_POS]" /> <?php echo lang('a-cfg-60'); ?></td>
                            </tr>
                            <tr>
                                <td><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==4) { ?>checked=""<?php } ?> value="4" name="data[SITE_WATERMARK_POS]" /> <?php echo lang('a-cfg-61'); ?></td>
                                <td><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==5) { ?>checked=""<?php } ?> value="5" name="data[SITE_WATERMARK_POS]" /> <?php echo lang('a-cfg-62'); ?></td>
                                <td><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==6) { ?>checked=""<?php } ?> value="6" name="data[SITE_WATERMARK_POS]" /> <?php echo lang('a-cfg-63'); ?></td>
                            </tr>
                            <tr>
                                <td><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==7) { ?>checked=""<?php } ?> value="7" name="data[SITE_WATERMARK_POS]" /> <?php echo lang('a-cfg-64'); ?></td>
                                <td><input type="radio" <?php if ($data['SITE_WATERMARK_POS']==8) { ?>checked=""<?php } ?> value="8" name="data[SITE_WATERMARK_POS]" /> <?php echo lang('a-cfg-65'); ?></td>
                                <td><input type="radio" <?php if (empty($data['SITE_WATERMARK_POS'])) { ?>checked=""<?php } ?> value="" name="data[SITE_WATERMARK_POS]" /> <?php echo lang('a-cfg-66'); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </tbody>
                <tr>
                    <th><?php echo lang('a-ind-56'); ?>： </th>
                    <td>
                        <input class="input-text" type="text" name="data[SITE_THUMB_WIDTH]" value="<?php echo $data['SITE_THUMB_WIDTH']; ?>" size="6" />
                        x&nbsp;
                        <input class="input-text" type="text" name="data[SITE_THUMB_HEIGHT]" value="<?php echo $data['SITE_THUMB_HEIGHT']; ?>" size="6" />
                        &nbsp;px
                    </td>
                </tr>
            </table>
            <script type="text/javascript">
                function setSateType(id) {
                    if (id == 0) {
                        $('.w_1').hide();
                        $('.w_2').hide();
                        $('#w_0').hide();
                    } else if(id == 1) {
                        $('.w_2').hide();
                        $('.w_1').show();
                        $('#w_0').show();
                    } else if(id == 2) {
                        $('.w_1').hide();
                        $('.w_2').show();
                        $('#w_0').show();
                    }
                }
                setSateType(<?php echo (int)$data['SITE_WATERMARK'] ?>);
            </script>
        </div>
        <div class="bk15"></div>
        <p><input type="submit" class="btn btn-success btn-sm" value="<?php echo lang('a-submit'); ?>" name="submit"></p>
        </div>
        </div>
        </form>
        </div>
        </div>
    </body>
</html>
<script type="text/javascript">
$('#div_setting_<?php echo $type; ?>').show();
function SwapTab(name,cls_show,cls_hide,cnt,cur){
	for(i=1;i<=cnt;i++){
		if(i==cur){
			$('#div_'+name+'_'+i).show();
			$('#tab_'+name+'_'+i).attr('class',cls_show);
		}else{
			$('#div_'+name+'_'+i).hide();
			$('#tab_'+name+'_'+i).attr('class',cls_hide);
		}
	}
}
</script>