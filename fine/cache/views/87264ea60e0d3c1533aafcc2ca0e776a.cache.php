    <!--底部信息-->
    <div class="copyright">
        <div class="foot">
        <a href="<?php echo SITE_PATH; ?>">首页</a>
		<?php if (is_array($cats)) { $count=count($cats);foreach ($cats as $t) {  if ($t['parentid']==0 && $t['ismenu']) { ?>
		<a href="<?php echo $t['url']; ?>"><?php echo $t['catname']; ?></a>
		<?php }  } } ?>
		<a href="<?php echo url('member'); ?>">会员中心</a>
		<a href="http://www.finecms.net" target="_blank">技术支持</a>
		<a href="http://bbs.finecms.net" target="_blank" style="border-right:0px;">技术论坛</a>
        </div>
        <div id="copyright"><?php echo html_entity_decode($SITE_BOTTOM_INFO); ?></div>
        <div id="copyright">Powered by <?php echo CMS_NAME; ?> v<?php echo CMS_VERSION; ?> © 2012,Processed in <?php echo runtime(); ?> second(s).</div>
        <div id="copyright"><a rel="nofollow" href="http://www.miibeian.gov.cn/" target="_blank"><?php echo $SITE_ICP; ?></a></div>
    </div>
</div>
    <?php echo $SITE_JS; ?>
<!--wrap end-->
</body>
</html>