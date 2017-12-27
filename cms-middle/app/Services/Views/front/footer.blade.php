    <!--底部信息-->
    <div class="copyright">
        <div class="foot">
        <a href="{{ SITE_PATH }}">首页</a>
		@foreach($cats as $t)
		@if($t['parentid']==0 && $t['ismenu'])

		<a href="{{ $t['url'] }}">{{ $t['catname'] }}</a>
		@endif

		@endforeach
		<a href="{{ url('member') }}">会员中心</a>
		<a href="http://www.finecms.net" target="_blank">技术支持</a>
		<a href="http://bbs.finecms.net" target="_blank" style="border-right:0px;">技术论坛</a>
        </div>
        <div id="copyright">{{ html_entity_decode($SITE_BOTTOM_INFO) }}</div>
        <div id="copyright">Powered by {{ CMS_NAME }} v{{ CMS_VERSION }} © 2012,Processed in {{ runtime() }} second(s).</div>
        <div id="copyright"><a rel="nofollow" href="http://www.miibeian.gov.cn/" target="_blank">{{ $SITE_ICP }}</a></div>
    </div>
</div>
    {{ $SITE_JS }}
<!--wrap end-->
</body>
</html>