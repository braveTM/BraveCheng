(function($){
    $.extend({
        sharebtn:function(){
            var d = document, isStrict = d.compatMode == "CSS1Compat", dd = d.documentElement, db = d.body, m = Math.max,
            ua = navigator.userAgent.toLowerCase(), ie = !!d.all, head = d.getElementsByTagName('head')[0],
            getWH = function() {
                return {
                    h : (isStrict ? dd : db).clientHeight,
                    w : (isStrict ? dd : db).clientWidth
                }
            }, getS = function() {
                return {
                    t : m(dd.scrollTop, db.scrollTop),
                    l : m(dd.scrollLeft, db.scrollLeft)
                }
            }, getP = function(o) {
                var l, t;
                if (o.getBoundingClientRect) {
                    var p = getS();
                    var el = o.getBoundingClientRect();
                    l = p.l + el.left;
                    t = p.t + el.top;
                } else {
                    l = o.offsetLeft;
                    t = o.offsetTop;
                    while (o = o.offsetParent) {
                        l += o.offsetLeft;
                        t += o.offsetTop;
                    }
                }
                return {
                    x : l,
                    y : t
                };
            }, creElm = function(o, t, a) {
                var b = d.createElement(t || 'div');
                for ( var p in o) {
                    p == 'style' ? b[p].cssText = o[p] : b[p] = o[p]
                }
                return (a || db).insertBefore(b, (a || db).firstChild)
            }, div = creElm( {
                style : "position:absolute;z-index:1000000000;display:none;overflow:auto;margin:0px"
            }), div1 = creElm( {
                style : "position:fixed;z-index:1000000000;display:none;overflow:auto;margin:0px"
            }), timer, inputTimer, list, clist, h, texts = {}, clickpopjs;
            sharebarBtn = {
                pop : div,
                centerpop : div1,
                disappear : function(b) {
                    var c = window.event || b, t = c.srcElement || c.target, contain = div1.contains ? div1
                    .contains(t)
                    : !!(div1.compareDocumentPosition(t) & 16), contain1 = div.contains ? div
                    .contains(t)
                    : !!(div.compareDocumentPosition(t) & 16);
                    if (!contain && !contain1
                        && t.className.indexOf('sharebar_button_compact') == -1
                        && t.parentNode.className != 'sharebar_button') {
                        div1.style.display = 'none';
                    }
                },
                over : function(e) {
                    var c = window.event || e, target = c.srcElement || c.target, T = this, timerCont, fn = function() {
                        timerCont = setInterval(function() {
                            if (div.innerHTML) {
                                var p = getP(target);
                                with (div.style) {
                                    display = "block";
                                    var a = T.style.display;
                                    T.style.display = 'block';
                                    top = p.y + target.offsetHeight + 'px';
                                    left = p.x + 'px';
                                    T.style.display = a;
                                    };
                                clearInterval(timerCont)
                            }
                        }, 50)
                    };
                    if (!clickpopjs) {
                        clickpopjs = creElm( {
                            src : 'http://s.sharebar.cn/js/sharebar_button_menu.js',
                            charset : 'utf-8'
                        }, 'script', head);
                        clickpopjs.onloaded = 0;
                        clickpopjs.onload = function() {
                            clickpopjs.onloaded = 1;
                            fn()
                        };
                        clickpopjs.onreadystatechange = function() {
                            /complete|loaded/.test(clickpopjs.readyState)
                            && !clickpopjs.onloaded && fn()
                        }
                    } else {
                        fn()
                    }
                    return false
                },
                out : function() {
                    timer = setTimeout(function() {
                        div.style.display = 'none';
                        div1.style.display != 'block';
                    }, 100)
                },
                move : function() {
                    clearTimeout(timer)
                },
                center : function() {
                    if (!this.script) {
                        this.script = creElm( {
                            src : 'http://s.sharebar.cn/js/sharebar_button_window.js',
                            charset : 'utf-8'
                        }, 'script', head);
                        db.style.position = 'static'
                    } else {
                        var b = getS(),w = getWH();
                        with (div1.style) {
                            display = "block";
                            top = ((w.h-div1.offsetHeight) / 2) + "px";
                            left = ((w.w-div1.offsetHeight) / 2) + "px";
                            };
                        list = d.getElementById('ckelist'), clist = list
                        .cloneNode(true), h = clist
                        .getElementsByTagName('input');
                        for ( var i = 0, ci; ci = h[i++];) {
                            texts[ci.value] = ci.parentNode
                        };
                    };
                    return false;
                },
                choose : function(o) {
                    clearTimeout(inputTimer);
                    inputTimer = setTimeout(function() {
                        var s = o.value.replace(/^\s+|\s+$/, ''), frag = d
                        .createDocumentFragment();
                        for ( var p in texts) {
                            eval("var f = /" + (s || '.') + "/ig.test(p)");
                            f && frag.appendChild(texts[p].cloneNode(true))
                        }
                        list.innerHTML = '';
                        list.appendChild(frag)
                    }, 100)
                },
                centerClose : function() {
                    div1.style.display = 'none'
                }
            };
            var h = d.getElementsByTagName('a');
            for ( var i = 0, ci, tmp; ci = h[i++];) {
                if (/\bsharebar_button\b/.test(ci.className)) {
                    ci.onmouseout = sharebarBtn.out;
                    ci.onmousemove = sharebarBtn.move;
                    ci.onclick = sharebarBtn.center;
                    ci.onmouseover = sharebarBtn.over;
                    ci.hideFocus = true;
                    continue
                }
                ;
                if (/\bsharebar_button_compact\b/.test(ci.className)) {
                    ci.className = 'sharebar_button_compact st_button stico stico_sharebar';
                    ci.onmouseout = sharebarBtn.out;
                    ci.onmousemove = sharebarBtn.move;
                    ci.onclick = sharebarBtn.center;
                    ci.onmouseover = sharebarBtn.over;
                    ci.hideFocus = true;
                    continue
                };
                if (ci.className
                    && (tmp = ci.className.match(/^sharebar_button_(\w+)$/))
                    && tmp[1]) {
                    ci.innerHTML = '<span class="stico st_button stico_' + tmp[1] + '"></span>';
                    ci.onclick = function(a) {
                        return function() {
                            sharebarto(a)
                        }
                    }(tmp[1]);
                    ci.href = 'javascript:void(0);';
                    ci.title = '分享条' + tmp[1]
                }
            };
            div.onmouseover = function() {
                clearTimeout(timer)
            };
            div.onmouseout = function() {
                sharebarBtn.out()
            };
            ie ? d.attachEvent("onclick", sharebarBtn.disappear) : d.addEventListener("click", sharebarBtn.disappear, false);

            creElm({
                src : THEMEROOT+'/lib/share/sharebar_to.js',	
                charset : 'utf-8'
            }, 'script', head);
        }
    });
})(jQuery);
function st_addBookmark(title){
    var url = parent.location.href;
    if (window.sidebar) { // Mozilla Firefox Bookmark
        window.sidebar.addPanel(title, url,"");
    } else if(document.all) { // IE Favorite
        window.external.AddFavorite( url, title);
    } else if(window.opera) { // Opera 7+
        return false;
    } else { 
        alert('请按 Ctrl + D 为chrome浏览器添加书签!');
    }
}
//document.write('<div style="display:none"><script src="http://hm.baidu.com/h.js?02b6dc09f2ef4658bd562b3f12e202ca"></script></div>');