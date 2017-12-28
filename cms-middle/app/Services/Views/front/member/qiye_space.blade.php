<?php $meta_title=$qiyemingcheng . '-首页' ?>
@include('header')
    <div class="navigation">
    您当前位置：<a  href="{{ SITE_PATH }}">首页</a> >> 企业店铺
    </div>
    <div class="blank10 clear"></div>
    <div class="companyshow">
        <div class="left">
	        <div class="left01">
		        <div class="title">企业基本信息</div>
			    <div class="left01box">
			        <ul>
					<li>公司名称：{{ $qiyemingcheng }}</li>
					<li>经营模式：<?php $data=string2array($jingyingmoshi);echo @implode(',', $data); ?></li>
					<li>经营范围：<?php $data=string2array($jingyingfanwei);echo @implode(',', $data); ?></li>
				  </ul>
			    </div>
		    </div>
		    <div class="clear blank10"></div>
	        <div class="left01">
		        <div class="title">企业名片</div>
			    <div class="left01box">
			        <ul>
					<li>联&#12288;&#12288;系：{{ $lianxiren }}</li>
					<li>电&#12288;&#12288;话：{{ $dianhua }}</li>
					<li>地&#12288;&#12288;址：{{ $dizhi }}</li>
				   </ul>
			    </div>
		    </div>
	    </div>
	    <div class="right">
	        <div class="right01">
		        <div class="title"><h2>企业简介</h2></div>
				<div class="right01box">
				    {{ $content }}
				</div>
		    </div>
		    <div class="clear blank10"></div>
		    <div class="right01">
		        <div class="title"><h2>企业产品</h2></div>
				<div class="right01box">
				    <table width="100%" cellspacing="1" cellpadding="3" border="0" align="center">
                    <tbody>
                    <tr bgcolor="#E7E7E7">
                        <td width="111" height="26" align="center">图片</td>
                        <td width="300" align="center">名称</td>
                        <td width="85" align="center">价格</td>
                        <td width="150" align="center">发布日期</td>
                    </tr>
                    {list catid=21 more=1 order=updatetime userid=$userid sysadd=0 num=5 cache=36000}
                    <tr>
                      <td height="26" align="center"><img width="100" height="100" src="{{ thumb($t['thumb']) }}"></td>
                      <td align="center"><a href="{{ $t['url'] }}">{{ $t['title'] }}</a></td>
                      <td align="center">{{ $t['danjia'] }}元/{{ $t['danwei'] }}</td>
                      <td align="center">{{ date('Y-m-d H:i:s', $t['updatetime']) }}</td>
                    </tr>
                    {/list}
                    </tbody>
                    </table>
				</div>
		    </div>
	    </div>
    </div>
    <div class="clear blank10"></div>
@include('footer')