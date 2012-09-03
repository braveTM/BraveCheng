function sharebarto(m) {
        if (m == "tsina") {
        void ((function(s, d, e) {
            try {
            } catch (e) {
            }
            var f = 'http://v.t.sina.com.cn/share/share.php?', u = d.location.href, p = [
            'url=', e(u), '&title=', e(d.title), '&appkey=' ]
            .join('');
            function a() {
                if (!window.open(
                    [ f, p ].join(''),
                    'mb',
                    ['toolbar=0,status=0,resizable=1,width=620,height=450,left=',
                    (s.width - 620) / 2, ',top=',
                    (s.height - 450) / 2 ].join('')))
                    u.href = [ f, p ].join('');
            }
            if (/Firefox/.test(navigator.userAgent)) {
                setTimeout(a, 0)
            } else {
                a()
            }
        })(screen, document, encodeURIComponent));
    } else if (m == "douban") {
        void (function() {
            var d = document, e = encodeURIComponent, s1 = window.getSelection, s2 = d.getSelection, s3 = d.selection, s = s1 ? s1()
            : s2 ? s2() : s3 ? s3.createRange().text : '', r = 'http://www.douban.com/recommend/?url='
            + e(d.location.href)
            + '&title='
            + e(d.title)
            + '&sel='
            + e(s) + '&v=1', x = function() {
                if (!window.open(r, 'douban','toolbar=0,resizable=1,scrollbars=yes,status=1,width=450,height=355,left='
                    + (screen.width - 450) / 2 + ',top='
                    + (screen.height - 330) / 2))
                    location.href = r + '&r=1'
            };
            if (/Firefox/.test(navigator.userAgent)) {
                setTimeout(x, 0)
            } else {
                x()
            }
        })();
    } else if (m == "renren") {
        // 官方分享方式1
        //		var connect_url = "http://www.connect.renren.com";
        //		var url = window.location.href;
        //		var addQS = function(url, qs) {
        //			var a = [];
        //			for ( var k in qs)
        //				if (qs[k])
        //					a.push(k.toString() + '=' + encodeURIComponent(qs[k]));
        //			return url + '?' + a.join('&');
        //		}
        //		var href = addQS(connect_url + '/sharer.do', {
        //			'url' : url,
        //			'title' : url == window.location.href ? document.title : null
        //		});
        //		window.open(href, 'sharer',
        //				'toolbar=0,status=0,width=550,height=400,left='
        //						+ (screen.width - 550) / 2 + ',top='
        //						+ (screen.height - 500) / 2);

        // 官方分享方式2
        void ((function(s, d, e) {
            if (/renren\.com/.test(d.location))
                return;
            var f = 'http://share.renren.com/share/buttonshare.do?link=', u =
            d.location, l = d.title, p = [
            e(u), '&title=', e(l) ].join('');
            function a() {
                if (!window.open(
                    [ f, p ].join(''),
                    'xnshare',
                    [
                    'toolbar=0,status=0,resizable=1,width=626,height=436,left=',
                    (s.width - 626) / 2, ',top=',
                    (s.height - 436) / 2 ].join('')))
                    u.href = [ f, p ].join('');
            };
            if (/Firefox/.test(navigator.userAgent))
                setTimeout(a, 0);
            else
                a();
        })(screen, document, encodeURIComponent));
    } 
    return false;
}