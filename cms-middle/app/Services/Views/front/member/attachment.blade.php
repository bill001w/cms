{template member/header}
<!--Wrapper-->
<link href="/views/admin/images/table_form.css" rel="stylesheet" type="text/css" />
<link href="/views/admin/images/dialog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/views/admin/js/dialog.js"></script>
<script type="text/javascript" src="{{ LANG_PATH }}lang.js"></script>
<script type="text/javascript" src="/views/admin/js/core.js"></script>
<div id="wrapper">
	<div class="top"></div>
	<div class="center">
	    <div class="center_left">
	        <h3>内容管理</h3>
			<div class="menu_left">
			<ul>
            @foreach($navigation as $n => $t)
                <li @if($n==='attachment')
 class="on"@endif
><a href="{{ $t['url'] }}">{{ $t['name'] }}</a></li>
            @endforeach
			</ul>
			</div>
        </div>
		<div class="center_right">
			<div class="content_info" style="padding-top:7px;">
                <div class="p_mobile" style="padding:0">
					<ul>
						<li><a @if(empty($type))
class="select"@endif
 href="{{ url('member/content/attachment', array('type'=>0)) }}">图片附件</a></li>
						<li><a @if($type==1)
class="select"@endif
  href="{{ url('member/content/attachment', array('type'=>1)) }}">文件附件</a></li>
					</ul>
				</div>
				<table width="100%" class="table_form" border="0" cellpadding="0" cellspacing="0" id="imgPreview">
				<tbody>
				<tr>
				<td align="left">当前目录({{ $countsize }})：{{ $dir }}</td><td></td>
				</tr>
				@if($istop)

				<tr>
				<td align="left"><a href="{{ $pdir }}"><img src="/views/admin/images/folder-closed.gif" border="0">上一层目录</a></td><td></td>
				</tr>
				@endif

				@foreach($list as $k => $t)
				<script type="text/javascript">
				function fileview_{{ $k }}() {
					var content = "文件路径：{{ $t['info']['path'] }}<br>上传时间：{{ $t['info']['time'] }}<br>文件大小：{{ $t['info']['size'] }}<br>文件类型：{{ $t['info']['ext'] }} &nbsp;&nbsp;<a href='{{ $t['info']['path'] }}' target=_blank>点击下载该文件</a>";
					window.top.art.dialog({title:'文件信息',fixed:true, content: content});
				}
				</script>
				<tr>
				<td align="left">
				<input name="id" id="thumb_{{ $k }}" type="hidden" value="{{ $t['path'] }}">
				<img align="absmiddle" src="/views/admin/images/ext/{{ $t['ico'] }}" border="0">&nbsp;<a href="@if($t['url'])
{{ $t['url'] }}@else
@if($t['isimg'])
 javascript:preview('thumb_{{ $k }}');@else
javascript:fileview_{{ $k }}();@endif
@endif
" @if($t['isimg'])
rel="{{ $t['path'] }}" title="{{ $t['name'] }}"@endif
>{{ $t['name'] }}</a></td>
				<td>
				@if(!$t['isdir'])

				<a onClick="@if($t['isimg'])
javascript:preview('thumb_{{ $k }}');@else
javascript:fileview_{{ $k }}();@endif
" href="javascript:;">预览</a> |
				@endif

				<a onClick="copyToClipboard('{{ $t['path'] }}')" href="javascript:;">复制路径</a> |
				<a onClick="del('{{ $t['dir'] }}',{{ $t['isdir'] }})" href="javascript:;">删除</a>
				 </td></tr>
				<tr>
				@endforeach
				</tbody>
				</table>

		    </div>
        </div>
	</div>
    <div class="bottom"></div>
</div>
<script type="text/javascript">
(function(c){c.expr[':'].linkingToImage=function(a,g,e){return!!(c(a).attr(e[3])&&c(a).attr(e[3]).match(/\.(gif|jpe?g|png|bmp)$/i))};c.fn.imgPreview=function(j){var b=c.extend({imgCSS:{},distanceFromCursor:{top:10,left:10},preloadImages:true,onShow:function(){},onHide:function(){},onLoad:function(){},containerID:'imgPreviewContainer',containerLoadingClass:'loading',thumbPrefix:'',srcAttr:'href'},j),d=c('<div/>').attr('id',b.containerID).append('<img/>').hide().css('position','absolute').appendTo('body'),f=c('img',d).css(b.imgCSS),h=this.filter(':linkingToImage('+b.srcAttr+')');function i(a){return a.replace(/(\/?)([^\/]+)$/,'$1'+b.thumbPrefix+'$2')}if(b.preloadImages){(function(a){var g=new Image(),e=arguments.callee;g.src=i(c(h[a]).attr(b.srcAttr));g.onload=function(){h[a+1]&&e(a+1)}})(0)}h.mousemove(function(a){d.css({top:a.pageY+b.distanceFromCursor.top+'px',left:a.pageX+b.distanceFromCursor.left+'px'})}).hover(function(){var a=this;d.addClass(b.containerLoadingClass).show();f.load(function(){d.removeClass(b.containerLoadingClass);f.show();b.onLoad.call(f[0],a)}).attr('src',i(c(a).attr(b.srcAttr)));b.onShow.call(d[0],a)},function(){d.hide();f.unbind('load').attr('src','').hide();b.onHide.call(d[0],this)});return this}})(jQuery);
$(function(){
	var obj=$("#imgPreview a[rel]");
	if(obj.length>0) {
		$('#imgPreview a[rel]').imgPreview({
			srcAttr: 'rel',
			imgCSS: { width: 200 }
		});
	}
});	
function del(name, id){
	var msg = "";
	if(id==1) {
		msg = '将会删除该目录下的所以文件，确定删除吗？';
	} else {
		msg = '将会删除该文件，确定删除吗？';
	}
	if(confirm(msg)){
		var url = "{{ url('member/content/delattachment/') }}&dir="+name+"&type={{ $type }}";
		window.location.href=url;
	}
}
function copyToClipboard(meintext) {
    if (window.clipboardData){
        window.clipboardData.setData("Text", meintext);
    } else if (window.netscape){
        try {
            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
        } catch (e) {
            alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将 'signed.applets.codebase_principal_support'设置为'true'"); 
		} 
        var clip = Components.classes['@mozilla.org/widget/clipboard;1'].
        createInstance(Components.interfaces.nsIClipboard);
        if (!clip) return;
        var trans = Components.classes['@mozilla.org/widget/transferable;1'].
        createInstance(Components.interfaces.nsITransferable);
        if (!trans) return;
        trans.addDataFlavor('text/unicode');
        var len = new Object();
        var str = Components.classes["@mozilla.org/supports-string;1"].
        createInstance(Components.interfaces.nsISupportsString);
        var copytext=meintext;
        str.data=copytext;
        trans.setTransferData("text/unicode",str,copytext.length*2);
        var clipid=Components.interfaces.nsIClipboard;
        if (!clip) return false;
        clip.setData(trans,null,clipid.kGlobalClipboard);
    }
    alert("复制成功，您可以粘贴到您模板中了");
    return false;
}
</script>
{template member/footer}