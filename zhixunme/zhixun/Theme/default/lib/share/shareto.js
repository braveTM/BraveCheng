~function(){
    var shareTo={
        //qq空间
        a:function(tit,u,des,sum,pic){
            var p = {
                url:u,
                showcount:'0',/*是否显示分享总数,显示：'1'，不显示：'0' */
                desc:!!des?des:"",/*默认分享理由(可选),文本框内文字*/
                summary:!!sum?sum:"",/*分享摘要(可选)*/
                title:tit,/*分享标题(可选)*/
                site:' 职讯网',/*分享来源 如：腾讯网(可选)*/
                pics:!!pic?pic:"", /*分享图片的路径(可选)*/
                style:'203',
                width:22,
                height:22
            };
            var s = [];
            for(var i in p){
                s.push(i + '=' + encodeURIComponent(p[i]||''));
            }
            window.open("http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?"+s.join('&'),"","toolbar=0,status=0,resizable=1,width=615,height=505");
        },
        //腾讯
        b:function (){
            var para=arguments[0]||{};
            var qarea=para["qarea"];
            var follower=para["follower"];
            qarea=qarea&&(function(qa){
                if((typeof qa=="object"&&qa.length)||(qa.constructor==Array)){
                    return qa;
                }else{
                    return[qa];
                }
            }(qarea))||[document.body];
            follower=follower||"";
            String.prototype.elength=function(){
                return this.replace(/[^\u0000-\u00ff]/g,"aa").length;
            };

            String.prototype.tripurl=function(){
                return this.replace(new RegExp("((news|telnet|nttp|file|http|ftp|https)://){1}(([-A-Za-z0-9]+(\\.[-A-Za-z0-9]+)*(\\.[-A-Za-z]{2,5}))|([0-9]{1,3}(\\.[0-9]{1,3}){3}))(:[0-9]*)?(/[-A-Za-z0-9_\\$\\.\\+\\!\\*\\(\\),;:@&=\\?/~\\#\\%]*)*","gi"),new Array(12).join("aa"));
            };

            if(!!window.find){
                HTMLElement.prototype.contains=function(B){
                    return this.compareDocumentPosition(B)-19>0
                }
            };
            var _web={
                "name":arguments[1]||"",
                "href":(arguments[2]||location.href).replace(/([^\x00-\xff]+)/g,encodeURIComponent("$1")),
                "target":"toolbar=0,status=0,resizable=1,width=630,height=530"
            };
            var _pic=function(area){
                var _imgarr=area.getElementsByTagName("img");
                var _srcarr=[];
                for(var i=0;i<_imgarr.length;i++){
                    if(_imgarr[i].width<50||_imgarr[i].height<50){
                        continue;
                    }
                    _srcarr.push(encodeURIComponent(_imgarr[i].src));
                }
                return _srcarr.join("|");
            };
            var _text=function(){
                var s1=arguments[0]||"",s2=Array().slice.call(arguments,1).join(" ").replace(/[\s\n]+/g," "),k=257-s1.tripurl().elength();
                var s=s2.slice(0,(k-4)>>1);
                if(s2.elength()>k){
                    k=k-3;
                    for(var i=k>>1;i<=k;i++){
                        if((s2.slice(0,i)).tripurl().elength()>=k){
                            break;
                        }else{
                            s=s2.slice(0,i);
                        }
                    }
                    s+="...";
                }else{
                    s=s2;
                }
                return[s1,s];
            };

            var _u = "http://share.v.t.qq.com/index.php?c=share&a=index&f=q2&url=$url$&appkey=801149248&assname=" + follower + "&title=$title$ @izhixun&pic=$pic$";
            //                var current_area=qarea[0];
            window.open(_u.replace("$title$",encodeURIComponent(_text(_web.name,"").join(" "))).replace("$url$",encodeURIComponent(_web.href)).replace("$pic$",_pic(qarea[0])).substr(0,2048),'null',_web.target);
            return false;
        },
        //新浪
        c:function(title,url){
            window.open("http://service.weibo.com/share/share.php?url="+url+"&appkey=3237567416&title="+title+"&pic=&ralateUid=2510731662&language='zh_cn","","width=615,height=505");
        //addCount()
        }
    };
    var __zxshare=function(type,param){
            var s=shareTo;
            switch(type){
                case "sina":
                    s.c(param[0],param[1]);
                    break;
                case "tencent":
                    s.b(null,param[0],param[1]);
                    break;
                case "qzone":
                    s.a(param[0],param[1],param[2],param[3],param[4]);
                    break;
                default:
                    break;
            }
        };
    this.zxshare=__zxshare;
}();


//新浪
//function getQuery(a){
//    var b=new RegExp("(^|&)"+a+"=([^&]*)(&|$)");
//    var c=window.location.search.substr(1).match(b);
//    return c!=null?c[2]:""
//}
//function addCount(){}
//
////var language="";
//window.onload=function(){
//    var language="";
//    try{
//        var d=document.getElementsByTagName("body")[0];
//        if(d){
//            d.style.backgroundColor="transparent"
//        }
//    }
//    catch(h){}
//    if(getQuery("count")!=1){
//        return
//    }
//    language=getQuery("language")?getQuery("language"):"";
//    var i=3237567416;
//    var j=+new Date;
//    var b=getQuery("url");
//    var f=null;
//    function g(t){
//        var l;
//        var q;
//        var n=+new Date;
//        var e=/=\?(&|$)/g;t.data=t.data||"";
//        t.data=(t.data?t.data+"&":"")+"callback=?";
//        q="jsonp"+j++;
//        t.data=(t.data+"").replace(e,"="+q+"$1");
//        window[q]=function(s){
//            clearTimeout(f);
//            l=s;
//            r();
//            window[q]=undefined;
//            try{
//                delete window[q]
//            }catch(u){}
//            if(p){
//                p.removeChild(o)
//            }
//        };
//        
//        var m=t.url.replace(/(\?|&)_=.*?(&|$)/,"$1_="+n+"$2");
//        t.url=m+((m==t.url)?(t.url.match(/\?/)?"&":"?")+"_="+n:"");
//        if(t.data){
//            t.url+=(t.url.match(/\?/)?"&":"?")+t.data;
//            t.data=null
//        }
//        clearTimeout(f);
//        f=setTimeout(function(){},30000);
//        var k=false;
//        var p=document.getElementsByTagName("head")[0];
//        var o=document.createElement("script");
//        if(t.scriptCharset){
//            o.charset=t.scriptCharset
//        }
//        o.src=t.url;
//        var r=function(){
//            if(t.success){
//                t.success(l)
//            }
//        };
//    
//        p.appendChild(o)
//    }
//    var a=function(e){
//        var k="http://api.t.sina.com.cn/short_url/shorten.json";
//        var m="http://api.t.sina.com.cn/short_url/share/counts.json";
//        var l="source="+i+"&url_long="+e;
//        g({
//            url:k,
//            data:l,
//            scriptCharset:"utf-8",
//            success:function(n){
//                if(!n||!n[0]){
//                    c();
//                    return
//                }
//                var o="source="+i+"&url_short="+encodeURIComponent(n[0].url_short||"");
//                g({
//                    url:m,
//                    data:o,
//                    scriptCharset:"utf-8",
//                    success:function(p){
//                        if(!p){
//                            c();
//                            return
//                        }
//                        c(p)
//                    }
//                })
//            }
//        })
//    };
//    var c=function(o){
//        var l=0;
//        try{
//            l=o[0].share_counts||0;
//            var q=l/10000>>0;
//            if(q>0){
//                var k=(l%10000)/1000>>0;
//                k=k>0?"."+k:"";
//                l=""+q+k+(language==="zh_tw"?"":"")
//            }
//        }catch(p){}
//        document.getElementById("count").innerHTML=l
//    };
//    addCount=function(){
//        var e=document.getElementById("count");
//        var k=e.innerHTML;
//        if(k=="..."){
//            k="0"
//        }
//        if(/^\d+$/.test(k)){
//            k=parseInt(k)+1
//        }
//        e.innerHTML=k
//    };
//    a(b)
//}
