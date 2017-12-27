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
    <title>admin</title>
</head>
<body style="font-weight: normal;">
<div class="subnav">
    <div class="table-list">
        <table width="100%" cellspacing="0" id="imgPreview">
            <tbody>
            <tr>
                <td align="left">{{ lang('a-att-4') }}：{{ $dir }}</td>
            </tr>
            @if(!empty($istop))
                <tr>
                    <td align="left"><a href="{{ $pdir }}"><img
                                    src="/views/admin/images/folder-closed.gif">{{ lang('a-att-5') }}</a></td>
                </tr>
             @endif
            @foreach($list as $k => $t)
                <tr>
                    <td align="left" onclick="@if(!$t['url'])
                            album_cancel(this) @endif
                            ">
                        <img src="/views/admin/images/ext/{{ $t[ico] }}">
                        &nbsp;<a href="
@if($t['url'])
                        {{ $t['url'] }}
                        @else
                                javascript:;
 @endif
                                " rel="{{ $dir }}{{ $t['name'] }}" title="{{ $t['name'] }}">{{ $t['name'] }}</a></td>
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
    $(function () {
        set_status_empty();
    });
    function set_status_empty() {
        parent.window.$('#att-status').html('');
        parent.window.$('#att-name').html('');
    }
    function album_cancel(obj) {
        var src = $(obj).children("a").attr("rel");
        var filename = $(obj).children("a").attr("title");
        if ($(obj).hasClass('on')) {
            $(obj).removeClass("on");
            var imgstr = parent.window.$("#att-status").html();
            var length = $("a[class='on']").children("a").length;
            var strs = filenames = '';
            for (var i = 0; i < length; i++) {
                strs += '|' + $("a[class='on']").children("a").eq(i).attr('rel');
                filenames += '|' + $("a[class='on']").children("a").eq(i).attr('title');
            }
            parent.window.$('#att-status').html(strs);
            parent.window.$('#att-name').html(filenames);
        } else {
            var num = parent.window.$('#att-status').html().split('|').length;
            var file_upload_limit = '';
            $(obj).addClass("on");
            parent.window.$('#att-status').append('|' + src);
            parent.window.$('#att-name').append('|' + filename);
        }
    }
</script>
</body>
</html>