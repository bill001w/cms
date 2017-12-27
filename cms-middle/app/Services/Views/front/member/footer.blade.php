
<div id="footer">
  <p><a href="{{ SITE_URL }}"><span>首页</span></a>
    @foreach($cats as $t)
    @if($t['parentid']==0 && $t['ismenu'])

    <a href="{{ $t['url'] }}"><span>{{ $t['catname'] }}</span></a>
    @endif

    @end
  </p>
  <p>Powered by {{ CMS_NAME }} v{{ CMS_VERSION }} © 2012,Processed in {{ runtime() }} second(s).</p>
</div>
</body>
</html>