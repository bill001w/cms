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
    <script type="text/javascript" src="/views/admin/js/dialog.js"></script>
    @include('admin.top')
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="bk10"></div>
    <div class="explain-col">
        <form action="" method="post">
            {{ lang('a-att-30') }}： <input type="text" class="input-text" size="40" name="kw"><input type="submit"
                                                                                                     class="btn btn-success btn-sm"
                                                                                                     value="{{ lang('a-search')}}"
                                                                                                     name="submit">
        </form>
    </div>
    <div class="bk10"></div>
    <div class="table-responsive mytable">
        <table class="table table-striped" width="100%" cellspacing="0" id="imgPreview">
            <tbody>
            <tr>
                <td align="left">{{ lang('a-att-4') }}：{{ $dir }}</td>
                <td></td>
            </tr>
            @if(!empty($istop))
                <tr>
                    <td align="left"><a href="{{ $pdir }}"><img
                                    src="/views/admin/images/folder-closed.gif">{{ lang('a-att-5') }}</a></td>
                    <td></td>
                </tr>
             @endif
            @foreach($list as $k => $t)
                <script type="text/javascript">
                    function fileview_ {{ $k }}() {
                        var content = "{{ lang('a-att-6') }}：{{ $t['fileinfo']['path'] }}<br>{{ lang('a-att-7') }}：{{ $t['fileinfo']['time'] }}<br>{lang('a-att-8')}：{{ $t['fileinfo']['size'] }}<br>{lang('a-att-9')}：{{ $t['fileinfo']['ext'] }} &nbsp;&nbsp;<a href='{{ $t['fileinfo']['path'] }}' target=_blank>{lang('a-att-10')}}</a>";
                        window.top.art.dialog({title: '{{ lang('a-att-11') }}', fixed: true, content: content});
                    }
                </script>
                <tr>
                    <td align="left">
                        <input name="id" id="thumb_{{ $k }}" type="hidden" value="{{ $dir }}{{ $t['name'] }}">
                        <img src="/views/admin/images/ext/{{ $t['ico'] }}">&nbsp;<a
                                href="@if($t['url']) {{ $t['url'] }} @else
                                @if($t['isimg']) javascript:preview('thumb_{{ $k }}'); @else javascript:fileview_{{ $k }}();  @endif
                                 @endif
                                        " @if($t['isimg']) rel="{{ $dir }}{{ $t['name'] }}"
                                title="{{ $t['name'] }}" @endif >{{ $t['name'] }}</a></td>
                    <td width="30%">
                        @if(!$t['isdir'])
                            <a onClick="@if($t['isimg']) preview('thumb_{{ $k }}') @else fileview_{{ $k }}()  @endif
                                    " href="javascript:;">{{ lang('a-att-12') }}</a> |  @endif

                        <a onClick="copyToClipboard('{{ $dir }}{{ $t['name'] }}')"
                           href="javascript:;">{{ lang('a-att-13') }}</a>
                        @if(admin_auth($userinfo['roleid'], 'attachment-del'))
                            |
                            <a onClick="del('{{ $t['dir'] }}',{{ $t['isdir'] }})"
                               href="javascript:;">{{ lang('a-del') }}</a>
                         @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    (function (c) {
        c.expr[':'].linkingToImage = function (a, g, e) {
            return !!(c(a).attr(e[3]) && c(a).attr(e[3]).match(/\.(gif|jpe?g|png|bmp)$/i))
        };
        c.fn.imgPreview = function (j) {
            var b = c.extend({
                imgCSS: {},
                distanceFromCursor: {top: 10, left: 10},
                preloadImages: true,
                onShow: function () {
                },
                onHide: function () {
                },
                onLoad: function () {
                },
                containerID: 'imgPreviewContainer',
                containerLoadingClass: 'loading',
                thumbPrefix: '',
                srcAttr: 'href'
            }, j), d = c('<div/>').attr('id', b.containerID).append('<img/>').hide().css('position', 'absolute').appendTo('body'), f = c('img', d).css(b.imgCSS), h = this.filter(':linkingToImage(' + b.srcAttr + ')');

            function i(a) {
                return a.replace(/(\/?)([^\/]+)$/, '$1' + b.thumbPrefix + '$2')
            }

            if (b.preloadImages) {
                (function (a) {
                    var g = new Image(), e = arguments.callee;
                    g.src = i(c(h[a]).attr(b.srcAttr));
                    g.onload = function () {
                        h[a + 1] && e(a + 1)
                    }
                })(0)
            }
            h.mousemove(function (a) {
                d.css({
                    top: a.pageY + b.distanceFromCursor.top + 'px',
                    left: a.pageX + b.distanceFromCursor.left + 'px'
                })
            }).hover(function () {
                var a = this;
                d.addClass(b.containerLoadingClass).show();
                f.load(function () {
                    d.removeClass(b.containerLoadingClass);
                    f.show();
                    b.onLoad.call(f[0], a)
                }).attr('src', i(c(a).attr(b.srcAttr)));
                b.onShow.call(d[0], a)
            }, function () {
                d.hide();
                f.unbind('load').attr('src', '').hide();
                b.onHide.call(d[0], this)
            });
            return this
        }
    })(jQuery);
    $(function () {
        var obj = $("#imgPreview a[rel]");
        if (obj.length > 0) {
            $('#imgPreview a[rel]').imgPreview({
                srcAttr: 'rel',
                imgCSS: {width: 200}
            });
        }
    });
    function del(name, id) {
        var msg = '';
        if (id == 1) {
            msg = '{{ lang('a-att-14') }}';
        } else {
            msg = '{{ lang('a-att-15') }}';
        }
        if (confirm(msg)) {
            var url = "{{ url('admin/attachment/del/',array('name'=>'')) }}" + name;
            window.location.href = url;
        }
    }
    function preview(obj) {
        var filepath = $('#' + obj).val();
        if (filepath) {
            var content = '<img src="{{ SITE_PATH }}' + filepath + '" onload="if(this.width>$(window).width()/2)this.width=$(window).width()/2;" />';
        } else {
            var content = '{{ lang('a-att-16') }}';
        }
        window.top.art.dialog({title: '{{ lang('a-att-17') }}', fixed: true, content: content});
    }
    function copyToClipboard(meintext) {
        if (window.clipboardData) {
            window.clipboardData.setData("Text", meintext);
        } else if (window.netscape) {
            try {
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
            } catch (e) {
                alert("{{ lang('a-att-18') }}");
            }
            var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
            if (!clip) return;
            var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
            if (!trans) return;
            trans.addDataFlavor('text/unicode');
            var len = new Object();
            var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
            var copytext = meintext;
            str.data = copytext;
            trans.setTransferData("text/unicode", str, copytext.length * 2);
            var clipid = Components.interfaces.nsIClipboard;
            if (!clip) return false;
            clip.setData(trans, null, clipid.kGlobalClipboard);
        }
        alert("{{ lang('a-att-19') }}");
        return false;
    }
</script>
</body>
</html>