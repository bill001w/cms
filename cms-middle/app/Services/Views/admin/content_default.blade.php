<thead>
<tr>
    <th width="20" align="left"><input name="deletec" id="deletec" type="checkbox" onClick="setC()"/></th>
    <th width="40" align="left">{{ lang('a-order') }}</th>
    <th width="40" align="left">ID</th>
    <th align="left" id="t_title">{{ lang('a-con-26') }}</th>
    <th width="80" align="left">{{ lang('a-con-30') }}</th>
    <th width="150" align="left">{{ lang('a-con-31') }}</th>
    <th align="left">{{ lang('a-option') }}</th>
</tr>
</thead>
<tbody>
@foreach($list as $t)
    <tr>
        <td align="left"><input name="del_{{ $t['id'] }}_{{ $t['catid'] }}" type="checkbox" class="deletec"/></td>
        <td align="left"><input type="text" name="order_{{ $t['id'] }}" class="input-text" style="width:35px;"
                                value="{{ $t['listorder'] }}"></td>
        <td align="left">{{ $t['id'] }}</td>
        <td align="left">
            <div id="s_title" style="height:20px;overflow: hidden;">
                <a href="@if($a!='index')
                {{ url('admin/content/editverify',array('id'=>$t['id'])) }}@else
                {{ url('admin/content/edit',array('id'=>$t['id'])) }} @endif
                        " title="{{ $t['title'] }}">{{ $t['title'] }}</a>
            </div>
        </td>
        <td align="left"><a @if($t['sysadd'])
                            style="color:red;" title="{{ lang('a-con-35') }}"  @endif
                            href="{{ url('admin/content/index',array('kw'=>$t['username'],'modelid'=>$t['modelid'],'stype'=>($t['sysadd']?2:1))) }}">{{ $t['username'] }}</a>
        </td>
        <td align="left"><span style="@if(date('Y-m-d', $t['updatetime']) == date('Y-m-d'))
                    color:#F00 @endif
                    ">{{ date(TIME_FORMAT, $t['updatetime']) }}</span></td>
        <td align="left">
            @if($a=='verify')
                <?php
                $del = url('admin/content/delverify/', array('catid' => $t['catid'], 'id' => $t['id']));
                ?>
                @if(admin_auth($userinfo['roleid'], 'content-editverify'))
                    <a class="btn btn-primary btn-xs"
                       href="{{ url('admin/content/editverify',array('id'=>$t['id'])) }}">{{ lang('a-edit')}}</a>
                 @endif
                @if(admin_auth($userinfo['roleid'], 'content-delverify'))
                    <a class="btn btn-primary btn-xs" href="javascript:;" clz="1"
                       onClick="if(confirm('{{ lang('a-confirm') }}')){ window.location.href='{{ $del }}'; }">{{ lang('a-del')}}</a>
                 @endif
            @else
                @foreach($join as $j)
                    <a class="btn btn-primary btn-xs"
                       href="{{ url('admin/form/list',array('cid'=>$t['id'], 'modelid'=>$j['modelid'])) }}">{{ $j['modelname'] }}</a>
                @endforeach
                <?php $del = url('admin/content/del', array('catid' => $t['catid'], 'id' => $t['id']));?>
                <a class="btn btn-primary btn-xs" href="{{ $site_url }}{{ $t['url'] }}" clz="1"
                   target="_blank">{{ lang('a-cat-23') }}</a>
                @if(admin_auth($userinfo['roleid'], 'content-edit'))
                    <a class="btn btn-success btn-xs"
                       href="{{ url('admin/content/edit',array('id'=>$t['id'])) }}">{{ lang('a-edit')}}</a>
                 @endif
                @if(admin_auth($userinfo['roleid'], 'content-duplicate'))
                    <a class="btn btn-info btn-xs"
                       href="{{ url('admin/content/duplicate',array('id'=>$t['id'])) }}">{{ lang('a-duplicate')}}</a>
                 @endif
                @if(admin_auth($userinfo['roleid'], 'content-del'))
                    <a href="javascript:;" class="btn btn-danger btn-xs" clz="1"
                       onClick="if(confirm('{{ lang('a-confirm') }}')){ window.location.href='{{ $del }}'; }">{{ lang('a-del')}}</a>
                 @endif
             @endif
        </td>
    </tr>
@endforeach