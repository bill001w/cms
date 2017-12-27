<thead>
<tr>
    <th style="width:20px;" align="left"><input name="deletec" id="deletec" type="checkbox" onClick="setC()"/></th>
    <th style="width:30px;" align="left">{{ lang('a-order') }}</th>
    <th style="width:40px;" align="left">ID</th>
    @foreach($model['setting']['form']['show'] as $f)
        <th align="left">{{ $model['fields']['data'][$f]['name'] }}</th>
    @endforeach
    @if(!empty($join))
        <th style="width:80px;" align="left">{{ lang('a-con-64') }}</th>
     @endif
    <th style="width:90px;" align="left">{{ lang('a-con-30') }}</th>
    <th style="width:120px;" align="left">{{ lang('a-con-31') }}</th>
    <th style="width:130px;" align="left">{{ lang('a-option') }}</th>
</tr>
</thead>
<tbody>
@foreach($list as $t)
    <tr>
        <td align="left"><input name="del_{{ $t['id'] }}" type="checkbox" class="deletec"/></td>
        <td align="left"><input type="text" name="order_{{ $t['id'] }}" class="input-text" style="width:35px;"
                                value="{{ $t['listorder'] }}"/></td>
        <td align="left">{{ $t[id] }}</td>
        @foreach($model['setting']['form']['show'] as $f)
            <td align="left">{{ $t[$f] }}</td>
        @endforeach
        @if(!empty($join))
            <td align="left"><a
                        href="{{ url('admin/form/list',array('userid'=>$t['userid'],'modelid'=>$modelid,'status'=>$status, 'cid'=>$t['cid'])) }}">{{ $t['cid'] }}</a>
            </td> @endif
        <td align="left">@if($t['username'])
                <a href="{{ url('admin/form/list',array('userid'=>$t['userid'],'modelid'=>$modelid,'status'=>$status, 'cid'=>$cid)) }}">{{ $t['username'] }}</a>@else
                {{ $t['ip'] }} @endif
        </td>
        <td align="left"><span style="@if(date('Y-m-d', $t['updatetime']) == date('Y-m-d'))
                    color:#F00 @endif
                    ">{{ date(TIME_FORMAT, $t['updatetime']) }}</span></td>
        <td align="left">
            <?php
            $del = url('admin/form/del/', array('modelid' => $modelid, 'id' => $t['id'], 'cid' => $cid));
            ?>
            <a href="{{ $site_url }}{{ form_show_url($modelid, $t)}" target="_blank">{{ lang('a-cat-23')}}</a> |
    @if(admin_auth($userinfo['roleid'], 'form-edit'))
                    <a href="{{ url('admin/form/edit',array('id'=>$t['id'],'modelid'=>$modelid, 'cid'=>$cid)) }}
            ">{{ lang('a-edit')}}</a> |
             @endif
            @if(admin_auth($userinfo['roleid'], 'form-del'))
                <a href="javascript:;"
                   onClick="if(confirm('{{ lang('a-confirm') }}')){ window.location.href='{{ $del }}'; }">{{ lang('a-del')}}</a>
             @endif
        </td>
    </tr>
@endforeach