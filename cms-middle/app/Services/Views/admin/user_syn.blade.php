@include('header.html')
<form action="" method="post" name="myform" id="myform">
    <div class="subnav">
        <div class="content-menu ib-a blue line-x" style="padding:10px 0">
            <a href="{{ url('admin/user/syn') }}" class="on"><em>会员同步转移</em></a>
        </div>
        <div class="bk10"></div>
        <div class="explain-col mb10">此功能作用是将本站会员信息整合进《FineCMS高级版》之中，实现会员的整合</div>
        <div class="table-list col-tab">
            <div class="contentList pad-10">
                <table width="100%" class="table_form">
                    @if(!empty($has_config))
                        <tr>
                            <th>高级版主域名：</th>
                            <td>
                                <input class="input-text" type="text" name="data[domain]" value="{{ $domain }}"
                                       size="40"/>
                            </td>
                        </tr>
                        <tr>
                            <th>转移会员积分为会员经验值：</th>
                            <td>
                                <input type="radio" name="data[exp]" value="1" size="40" checked/>是&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="data[exp]" value="0" size="40"/>否
                            </td>
                        </tr>
                        <tr>
                            <th>转换会员模型：</th>
                            <td>
                                @foreach($userModels as $userModel)
                                    <p>&nbsp;</p>
                                    <p>{{ $userModel['modelname'] }} 转换为
                                        <select name="data[model][{{ $userModel['modelid'] }}]" id="data[model]">
                                            @foreach($newUserModels as $newUserModel)
                                                <option value="{{ $newUserModel['id'] }}" @if($newUserModel['id'] == 3)
                                                selected
                                                         @endif
                                                >{{ $newUserModel['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </p>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th width="200" style="border:none;">&nbsp;</th>
                            <td><input class="btn btn-success btn-sm" type="submit" name="submit"
                                       value="@if(!empty($is_syn))
                                               再次转移@else
                                               开始转移 @endif
                                               "/>
                                @if(!empty($is_syn))
                                    <div class="onShow">{{ lang('a-user-ex-1') }}</div>
                                 @endif
                            </td>
                        </tr>
                    @else
                        <tr>
                            <th>请先完成数据库配置：</th>
                            <td>
                                <div class="onShow">复制database.ini.php为database.user.ini.php并改为《FineCMS高级版》的数据库</div>
                            </td>
                        </tr>
                     @endif
                </table>
            </div>
        </div>
    </div>
</form>
</body>
</html>