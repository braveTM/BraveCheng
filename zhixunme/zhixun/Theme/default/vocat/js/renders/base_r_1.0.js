/* 
 * 基本渲染器
 */
var baseRender={
    /*
     * 功能：初始化标签点击效果
     * 参数：
     * obj:当前tab
     */
    TabIni:function(obj){
        $(obj).find("div.t_item:gt(0)").addClass("hidden");
        $(obj).find("div.t_item:eq(0)").addClass("show");
    },
    /*
     * 功能：初始化标签点击效果
     * 参数：
     * obj：当前li标签
     */
    TabChange:function(obj){
        var that=$(obj);
        var index=that.index();
        if(that.find("a").attr("href")!="javascript:;"&&that.find("a").hasClass('nodata')){
            location.href=that.find("a").attr("href");
        }
        var ct=that.parent().parent().parent().find("div.t_container");
        that.parent().find("li.cur_li").removeClass("cur_li");
        that.addClass("cur_li");
        ct.find(">div.show").addClass("hidden").removeClass("show");
        ct.find("div.t_item").eq(index).addClass("show").removeClass("hidden");
    },
    /*
     * 功能：弹出框提示消失
     * 参数：
     * o：弹出框父容器
     * t：消失时间
     * fun：确定按钮的回调函数
     */
    OperTipShowOut:function(o,t,fun){
        if(!!!t){
            t=0;
        }
        setTimeout(function(){
            o.fadeOut(300,function(){
                if(!!fun){
                    fun();
                }
            });
        },t);
    },
    /*
     * 功能：弹出框提示
     * 参数：
     * msg：提示信息
     * cls：错误提示：error，正确提示：right
     * bl：是否显示确定按钮
     * t：消失时间
     * fun：确定按钮的回调函数
     */
    OperTipShow:function(msg,cls,bl,t,fun){
        if(!!!cls){
            cls="error";
        }
        var temp=COMMONTEMP;
        var al=$("div.no_sure_dialog");
        if(al.length>0){  
            al.remove();
        }
        var tmp=temp.T0008.replace("{msg}",msg).replace("{class}",cls);
        $("body").prepend(tmp);
        al=$("div.no_sure_dialog");
        var btn="div.sr_btn a.btn";
        var b=$.browser.msie;
        var v=$.browser.version;
        if(b&&(v=="6.0")){
            var _height=window.screen.height;
            $("div.no_sure_dialog").css({
                "height":_height
            });
            $("div.no_sure_dialog div.alr_msgbox").css("top", document.body.scrollTop+_height*0.5+"px");
        }
        if(!!bl){
            al.find("div.sr_btn").remove();
            al.find("div.oper_alr").append(temp.T0002);
            btn="a.dia_ok";
        }
        baseController.BtnBind(al.find("div.btn3"), "btn3", "btn3_hov", "btn3_click");
        al.find(btn).unbind("click").bind("click",function(){
            baseRender.OperTipShowOut(al,t,fun);
        });
        al.fadeIn(10,function(){
            var ms=al.find('div.oper_alr p.msg');
            al.find('div.oper_alr div.oper_middle').css("width","auto");
            var pos = $.extend({}, ms.offset(), {
                width: ms[0].offsetWidth
            });
            var w=pos.width;
            if(pos.width>223){
                w=223;
            }
            al.find('div.oper_alr div.oper_middle').css("width",w+"px");
        });
    },
    /*
     * 功能：鼠标移入按钮时的效果
     * 参数：
     * obj：但前按钮
     * btn_old：当前状态下按钮的样式
     * btn_new：新状态下按钮的样式
     * btn_click：点击时的样式
     */
    BtnChangeBg:function(obj,btn_old,btn_new,btn_click){
        var that=$(obj);
        if(btn_click!=null&&that.hasClass(btn_click)){
            that.removeClass(btn_click);
        }
        that.removeClass(btn_old);
        that.addClass(btn_new);
    },
    /*
     * 功能：验证提示
     * 参数：
     * obj:提示对象
     * a：提示信息
     * b：提示的样式
     * c：提示距文本框的距离
     */
    a:function(obj,a,b,c){
        $(obj).removeClass("green_border").removeClass("red_border");
        if(b=="right"){
            $(obj).addClass("green_border");
        }
        else if(b=="error"){
            $(obj).addClass("red_border");
        }
        var p=$(obj).parent();
        if(c==null){
            c=5;
        }
        if($(".tip").length!=0){
            p.find(".tip").remove();
        }
        if($(".result").length!=0){
            p.find(".result").remove();
        }
        if($.browser.mozilla){
            p.css("display","inline-block");
        }
        p.css("position","relative");
        var cur=null;
        if(b=="result"){
            p.append(COMMONTEMP.T0014);
            cur=p.find("div.result");
        }
        else{
            p.append(COMMONTEMP.T0001);
            cur=p.find("div.tip");
            cur.find("div.msg").html(a);
        }
        var pos = $.extend({}, $(obj).offset(), {
            width: $(obj)[0].offsetWidth,
            height: $(obj)[0].offsetHeight
        });
        var pos1=$.extend({}, p.offset(), {
            width: p[0].offsetWidth,
            height: p[0].offsetHeight
        });
        var actualWidth = cur[0].offsetWidth;
        if(actualWidth>260){
            actualWidth=260;
        }
        cur.css("width",actualWidth+"px");
        var actualHeight = cur[0].offsetHeight;
        cur.css({
            "left": (pos.width+(pos.left-pos1.left)+c)+"px"
        });
        actualHeight = cur[0].offsetHeight;
        cur.css({
            "top":((pos.top-pos1.top)+pos.height/2-actualHeight/2)+"px"
        });
        cur.addClass(b);
        var sp=cur.find("span.tri");
        sp.css("margin-top",actualHeight/2-9+"px");
        cur.css("visibility","visible");
    },
    /*
     * 功能：移除验证提示
     * 参数：
     * obj:提示对象
     */
    b:function(obj){
        $(obj).parent().find("div.tip").remove();
        $(obj).removeClass("green_border").removeClass("red_border");
    },
    /**
     * 判断是否为电话号码
     */
    c:function(v){
        return (/^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/.test($.trim(v)));
    },
    /**
     * 判断是否为手机号码
     */
    d:function(v){
        return (/^(?:13\d|15[01235689]|18[02356789])-?\d{5}(\d{3}|\*{3})$/.test($.trim(v)));
    },
    /**
     * 验证qq号码
     */
    e:function(v){
        return (/^[^0]\d{5,9}/).test($.trim(v));
    },
    /**
     * 验证身份证号码(18位)
     */
    iden:function(v){
        return (/((1[1-5])|(2[1-3])|(3[1-7])|(4[1-6])|(5[0-4])|(6[1-5])|71|(8[12])|91)\d{4}((19\d{2}(0[13-9]|1[012])(0[1-9]|[12]\d|30))|(19\d{2}(0[13578]|1[02])31)|(19\d{2}02(0[1-9]|1\d|2[0-8]))|(19([13579][26]|[2468][048]|0[48])0229))\d{3}(\d|X|x)?$/.test($.trim(v)));
    },
    /*验证银行卡号*(有bug)*/
    y:function(v){
        return (/\d[0,9],{19}$/).test($.trim(v));
    },
    /*汉字输入(有bug)*/
    //    x:function(v){
    //          return (/^(?!_)(?!.*?_$)[a-zA-Z0-9_\u4e00-\u9fa5]+$ /.test($.trim(v)));
    //    },
    /*
     * 功能：初始化对话框
     * 参数：
     * a:类型（1：我要竞标，2：想对某某说，3：登录框，4：给职讯提点意见）
     * b:对话框id
     */
    l:function(a,b){
        if($("#"+b).length==0){
            var tm=COMMONTEMP;
            var cont=tm.T0003;
            var cont1=tm.T0004;
            var cont2=tm.T0005;
            var cont3=tm.T0006;
            var cont4=tm.T0028;
            if(a==1){
                cont=cont.replace("{detail_cont}",cont1);
            }
            else if(a==2){
                cont=cont.replace("{detail_cont}",cont2);
            }
            else if(a==3){
                cont=cont.replace("{detail_cont}",cont3);
            }
            else if(a==4){
                cont=cont.replace("{detail_cont}",cont4);
            }
            cont=cont.replace("{alrid}",b);
            $("body").append(cont);
        }
    },
    /*
     * 功能：关闭对话框
     * 参数：
     * obj:当前关闭按钮a标签
     */
    m:function(obj){
        var par=$(obj).parent().parent().parent();
        par.css("display","none");
        par.find("p.red").html("");
        par.find("p.red").css("color", "#C00");
    },
    /*
     * 功能：退出成功
     * 参数：
     * data:后台返回数据
     */
    r:function(data){
        location.href=WEBROOT+"/";
    },
    /*
     * 功能：退出失败
     * 参数：
     * data:后台返回数据
     */
    s:function(){
        window.location.reload();
    },
    /*
     * 功能：登录成功
     * 参数：
     * data:后台返回数据
     */
    t:function(data){
        var tip=$("#alrloginbox div.al_bt p.red");
        tip.css("color","#00589A");
        tip.html(LANGUAGE.L0102);
        if(typeof(data.sup)!="undefined"&&data.sup!="undefined"){
            var func=eval(data.sup);
            func(data);
        }
        setTimeout(function(){
            $("#alrloginbox a.a_closebtn").trigger("click");
            tip.css("color","#C00");
        },1500);
    },
    /*
     * 功能：登录失败
     * 参数：
     * data:后台返回数据
     */
    u:function(data){
        $("#alrloginbox div.al_bt p.red").html(LANGUAGE.L0103);
    },
    /*
     * 功能：初始化确认对话框
     * 参数：
     * a：right：正确，error：错误
     * b：提示信息
     * c：确认按钮id
     * d：确认按钮显示文本
     */
    z:function(a, b, c, d){
        var al=$("div.sure_dialog");
        if(al.length>0){
            al.remove();
        }
        var tmp=COMMONTEMP.T0011.replace("{msg}",b)
        .replace("{class}",a)
        .replace("{sureid}",c)
        .replace("{btntext}",d);
        $("body").prepend(tmp);
        var ba=$.browser.msie;
        var v=$.browser.version;
        if(ba&&(v=="6.0")){
            var _height=window.screen.height;
            $("div.sure_dialog").css({
                "height":_height
            });
            $("div.sure_dialog div.alr_msgbox").css("top", document.body.scrollTop+_height*0.5+"px");
        }
        $("div.sure_dialog").fadeIn(200);
    },
    /*
     * 功能：后台导航鼠标移入效果
     * 参数：
     * obj：当前a标签或索引
     */
    aa:function(obj){
        $(obj).addClass("hovered");
        baseRender.af(obj, 150);
    },
    /*
     * 功能：后台导航鼠标移出效果
     * 参数：
     * obj：当前a标签
     */
    ab:function(obj){
        $(obj).removeClass("hovered");
        var par=$("#bheader div.bh_cont div.bh_nav");
        if(par.find("a.hovered").length==0){
            var o=par.find("a.cur_a");
            baseRender.af(o, 150);
        }
    },
    /*
     * 功能：后台导航右侧鼠标移入效果
     * 参数：
     * obj：当前li标签
     */
    ac:function(obj){
        if(!$(obj).hasClass("hovered")){
            $(obj).addClass("hovered");
            var that=$(obj).find("div.children");
            if(that.find("div.mid_bg div").children().length>0){
                $(obj).find("div.children").fadeIn(200);
            }
        }
    },
    /*
     * 功能：后台导航右侧鼠标移出效果
     * 参数：
     * obj：当前li标签
     */
    ad:function(obj){
        $(obj).find("div.children").fadeOut(200,function(){
            $(obj).removeClass("hovered");
        });
    },
    /*
     * 功能：初始化后台导航
     * 参数：
     * i：当前导航的索引
     */
    ae:function(i){
        var obj=$("#bheader div.bh_cont div.bh_nav a:eq("+i+")");
        baseRender.af(obj, 0);
        $("div.bheader div.bh_cont span.mliner").css("opacity","1");
        $(obj).parent().find("a.cur_a").removeClass("cur_a");
        $(obj).addClass("cur_a");
    },
    /*
     * 功能：后台导航共用代码
     * 参数：
     * obj：当前a标签
     * t：动画时间
     */
    af:function(obj,t){
        var ln=$("#mliner");
        if(ln.length>0){
            var b=$.browser.msie;
            var v=$.browser.version;
            var l=$(obj)[0].offsetLeft+($(obj)[0].offsetWidth-ln[0].offsetWidth)/2;
            if(b&&v=="7.0"){
                l=l+$("#bheader div.bh_nav")[0].offsetLeft;
            }
            if(t>0){
                ln.animate({
                    "left":l+"px"
                },t);
            }
            else{
                ln.css("left",l+"px");
            }
        }
    },
    /*
     * 功能：移除验证提示
     * 参数：
     * obj:提示对象
     */
    ai:function(obj,d){
        if(!d){
            d=10;
        }
        $(obj).parent().find("div.tip").remove();
        $(obj).removeClass("green_border");
        baseRender.a(obj, "", "result", d);
    },
    //    /*
    //     *功能：发送站内信成功
    //     *参数：当前父分类
    //     *data:后台返回数据
    //     */
    //    aj:function(data){
    //        var tip=$("#wtos div.al_bt p.red");
    //        tip.css("color","#00589A");
    //        tip.html(LANGUAGE.L0093);
    //        setTimeout(function(){
    //            $("#wtos a.a_closebtn").trigger("click");
    //            tip.css("color","#C00");
    //        },500);
    //    },
    //    /*
    //     *功能：发送站内信失败
    //     *参数：当前父分类
    //     *data:后台返回数据
    //     */
    //    ak:function(data){
    //        $("div.alr_msgbox_cover div.al_bt p.red").html(LANGUAGE.L0094);
    //    },
    /**
     * 添加绿色边框
     * @author yoyiorlee
     * @date 2012-12-05
     */
    adgren:function(id) {
        $(id).addClass("green_border");
    },
    /**
     * 添加红色边框
     * @author yoyiorlee
     * @date 2012-12-05
     */
    addred:function (id) {
        $(id).addClass("red_border");
    },
    /**
     * 移除绿色边框
     * @author yoyiorlee
     * @date 2012-12-05
     */
    remgren:function(id){
        $(id).removeClass("green_border");
    },
    /**
     * 移除红色边框
     * @author yoyiorlee
     * @date 2012-12-05
     */
    remred:function(id){
        $(id).removeClass("red_border");
    },
    /**
     * 功能：生成数据显示对话框
     * 参数：
     * id：对话框id
     * sbtn：是否显示按钮
     * txt：按钮文本
     * func：按钮触发方法
     */
    al:function(id,sbtn,txt,func){
        if($("#"+id).length==0){
            var tmp=COMMONTEMP.T0018;
            tmp=tmp.replace("{id}",id);
            if(sbtn){
                tmp=tmp.replace("{text}",txt);
            }
            $("body").append(tmp);
            var par=$("#"+id);
            if(!sbtn||typeof(sbtn)=="undefined"){
                par.find("div.next").remove();
            }
            par.fadeIn(200);
            par.find("a.close_slt").unbind("click");
            par.find("a.close_slt").bind("click",function(){
                par.fadeOut(200);
            });
            par.find("div.next a.okbtn").unbind("click");
            if(func!=null&&typeof(func)!="undefined"){
                par.find("div.next a.okbtn").bind("click",function(){
                    func(this);
                });
            }
        }
        else{
            $("#"+id).fadeIn(200);
        }
    },
    /*
     *关注/取消关注失败执行
     *jack
     *2012-2-20
     */
    p_fail:function(ret){
        alert(ret.data);
    },
    /*
     *添加关注成功执行
     *jack
     *2012-2-20
     */
    p_suc:function(){
        var obj=$("div").data("item");
        var uname=$("div").data("uname");
        var uid=$("div").data("uid");
        var color=$("div").data("ucolor");
        var t=$(obj).parents("div.follow");
        var items=$(obj).parent().find("a[uid*='"+uid+"']");
        if(!t.hasClass("follow")){
            items.replaceWith('<a href="javascript:;" title="取消关注" class="remove_focus '+color+'"uname="'+uname+'" uid="'+uid+'">取消关注</a>');
        }else{
            items.parent().parent().addClass("hflow");
            items.replaceWith('<a href="javascript:;" title="已关注" class="'+color+'"uname="'+uname+'">已关注</a>');
        }
        baseController.RemoveFocusPerson("a.remove_focus");
    },
    /*
     *取消关注成功执行
     *jack
     *2012-2-20
     */
    rem_suc:function(){
        var obj=$("div").data("item");
        var uname=$("div").data("uname");
        var uid=$("div").data("uid");
        var color=$("div").data("ucolor");
        var t=$(obj).parents("div.follow");
        var items=$(obj).parent().find("a[uid*='"+uid+"']");
        if(!t.hasClass("follow")){
            items.parents("li").slideUp(300);
            var page=parseInt($("#pagination2").find("span.current").not("span.prev,span.next").text(),10);
            page=page-1;
            if($("ul#focus_person li").length=="0"){
                page=0;
                personnetController.b(0);
            }else{
                personnetController.b(page);
            }
        }else{
            items.parent().parent().removeClass("hflow");
            items.replaceWith('<a href="javascript:;" title="已关注" class="'+color+'"uname="'+uname+'">已关注</a>');
        }
        baseController.Add_focus("a.add_focus");
    },
    /*
     *推广成功执行
     *参数：当前对象
     */
    t_s:function(_s){
        if(!$(_s).hasClass("promote")){
            $(_s).addClass("promote");
            $(_s).attr("title","已推广");
        }
    },
    /*
     *功能：举报页单选事件绑定
     *参数：无
     *返回当前选中项
     */
    ao:function(){       
        $("#retype td").unbind("click").bind("click",function(){            
            $("#retype").find("input").removeAttr("checked");
            $(this).find("input").attr("checked","checked");            
            $(this).find("input");
        });      
    },
    /*
     *功能：举报页补充说明初始化
     *参数：无     
     */
    ap:function(){
        $("#addtext").unbind("focus").bind("focus",function(){
            var t=$.trim($(this).val());  
            if(t=='请详细填写举报理由'){
                $(this).val('');
                $(this).css("color","#000");
            }
        });
        $("#addtext").unbind("blur").bind("blur",function(){
            var t=$.trim($(this).val());             
            if(t.length==0){
                $(this).css("color","#888");
                $(this).val('请详细填写举报理由');
            }
        })
    },
    /*
     *功能：举报发送成功
     *参数：     
     */
    ReportSuc:function(){
        alert("举报已发送!");
        setTimeout('$("#bheader").data("win").close()',2000);
    },
    /*
     *功能：举报失败
     *参数：无     
     */
    ReprotFail:function(data){
        alert(data.data);       
    },
    /*
     * 功能：打开一个新窗口
     * 参数：url:窗口链接,width,宽,height高
     * 无
     */
    OpenWin:function(url,width,ht){        
        var wscr=screen.width;
        var toolbar='no';
        var location='no';
        var directories='no';
        var status='no';
        var menubar='no';
        var scrollbars='no';
        var resizable='no';
        var copyhistory='yes';      
        var height=ht+'px';
        var left=(wscr-width)/2+'px';
        var top=0+'px';
        var param='toolbar='+toolbar+', location='+location+', directories='+directories+','
        +'status='+status+',menubar='+menubar+', scrollbars='+scrollbars+','
        +'resizable='+resizable+', copyhistory='+copyhistory+','
        +'width='+width+', height='+height+',left='+left+'top='+top;        
        window.open(url,"_blank",param);        
    },
    /*
     *功能：反馈内容成功
     *参数：无
     */
    post_suc:function(ret){
        if(ret.ret){
            alert('您的反馈我们已收到,感谢您对职讯网的支持！');
        }
    },
    /*
     *功能：反馈内容失败
     *参数：无
     */
    post_fail:function(ret){
        alert(ret.data);
    },
    /*
     *功能：建设部门通迅录导航固定
     *参数：无
     */
    za:function(){
        var tit=$("div.conbook div.t_title").offset();     
        var nav=$("div.conbook div.toolnav").find("a");
        nav.unbind("click").bind("click",function(){
            $(this).siblings("a").removeClass("sel");
            $(this).addClass("sel");
        })
        $(window).scroll(function(){                      
            if ($(window).scrollTop() > tit.top){
                $("div.conbook div.sort_in").css({                 
                    "border-bottom":"1px solid #ccc"
                });
            }
            else if($(window).scrollTop()<=100){
                $("div.conbook div.t_title,div.conbook div.sort_in").removeAttr("style");             
            }
        });                             
    },
    /*
     *功能：电话回拨通话前验证成功
     *参数：无
     */
    //    zs:function(){        
    //        var id=$("#call").attr("userid");
    //        baseRender.zg();
    //        var s={
    //            url:WEBURL.callBack,
    //            params:"passive_user_id="+id,
    //            sucrender:baseRender.zd,
    //            failrender:baseRender.ze
    //        };
    //        HGS.Base.HAjax(s);
    //    },
    /*
     *功能：电话回拨通话前验证失败
     *参数：无
     */
    //    zf:function(data){
    //        var btn='<div class="yes_btn_cont rf"><div class="btn_common btn3"><span class="b_lf"></span>'
    //        +'<span class="b_rf"></span>'
    //        +'<a href="javascript:;" class="btn blue" id="cancel">{msg}</a></div></div>';      
    //    //验证失败后回调
    //        var c=function(msg,method){            
    //            btn=btn.replace('{msg}',msg);            
    //            $("div.alr_opermsg_cover").find("a.cancel").replaceWith(btn);
    //            if(method==1){//购买分钟数
    //                $("#select").click(function(){
    //                    window.location.href=WEBROOT+'/mpackage/';
    //                })
    //                $("#cancel").unbind("click").bind("click",function(){
    //                    $(this).parents("div.alr_opermsg_cover").fadeOut(200);
    //                })
    //            }else if(method==2){//拨打电话
    //                $("#cancel").unbind("click").bind("click",function(){                    
    //                    baseRender.zs();
    //                });
    //                $("#select").unbind("click").bind("click",function(){
    //                    window.location.href=WEBROOT+'/mpackage/';
    //                    })
    //            }else if(method==3){//立即认证
    //                $("#select").click(function(){
    //                    if($("#call").attr("rel")=='3')
    //                        window.location.href=WEBROOT+'/profiles/2';
    //                    if($("#call").attr("rel")=='1'||$("#call").attr("rel")=='2')
    //                        window.location.href=WEBROOT+'/profiles/3';
    //                })
    //                $("#cancel").unbind("click").bind("click",function(){
    //                    $(this).parents("div.alr_opermsg_cover").fadeOut(200);
    //                })
    //            }else{
    //                alert(data.data);
    //            }
    //            $("#select,#cancel").parent().parent().css({
    //                "margin-right":"0"
    //            });
    //            $("#cancel").parent().parent().css({
    //                "float":"right"
    //            });                        
    //        };   
    //        if(data.data.type==1){                                                
    //            baseController.InitialSureDialog("error",data.data.message, "select",'立即认证',function(){
    //                c("暂不认证",3);
    //            });            
    //        }
    //        else if(data.data.type==2){
    ////            var msg="您当前套餐剩余分钟数为"+data.time+"分,为了避免影响您正常使用此功能，请及时购买分钟数，您也可以继续拨打:";   
    //            baseController.InitialSureDialog("error",data.data.message, "select",'立即购买',function(){
    //                c("拨打电话",2);
    //            });            
    //        } 
    //        if(data.data.type==3){
    //            var msg="您当前套餐剩余分钟数为0分,是否立即去购买分钟数?";   
    //            baseController.InitialSureDialog("error",msg, "select",'立即购买',function(){
    //                c('暂不购买',1);
    //            });      
    //        }                                           
    //    },
    //     /*
    //     *功能：成功通话结束后
    //     *参数：无
    //     */
    //    zd:function(){
    //        
    //    },
    //     /*
    //     *功能：通话失败
    //     *参数：无
    //     */
    //    ze:function(data){
    //        alert(data.data,'','','',baseRender.zi);
    //    },       
    //    /*
    //     *功能：通话中按钮替换
    //     *参数：无
    //     */
    //    zg:function(){
    //        var id=$("#call").attr("userid");
    //        var btn9='<div id="calling" userid="{uid}" class="calling">'
    //        +'<a href="javascript:;">通话中...</a>'
    //        +'</div>';
    //        btn9=btn9.replace("{uid}",id);
    //        $("div.alr_opermsg_cover").fadeOut(200);        
    //        $("#call").parent().replaceWith(btn9);
    //    },
    /*
     * 功能：实名|手机|邮箱认证判断
     * 参数：n:姓名,p:手机,e:邮箱,1为认证,0未认证
     * 无
     */
    zh:function(n,p,e){
        var nam,pho,mil,tnam,tpho,tmil,parm;                
        nam=FILEROOT+'/Files/system/auth/gnam.png';
        pho=FILEROOT+'/Files/system/auth/gpho.png';
        mil=FILEROOT+'/Files/system/auth/gmes.png';
        tnam='未实名认证';
        tpho='未手机认证';
        tmil='未邮箱认证';
        if(n==1){
            nam=FILEROOT+'/Files/system/auth/nam.png';
            tnam='已实名认证';
        }
        if(p==1){   
            pho=FILEROOT+'/Files/system/auth/pho.png';
            tpho='已手机认证';
        }
        if(e==1){                  
            mil=FILEROOT+'/Files/system/auth/mes.png';
            tmil='已邮箱认证';
        }
        parm={
            nam:nam,
            tnam:tnam,
            pho:pho,
            tpho:tpho,
            mil:mil,
            tmil:tmil
        }
        return parm;
    }
/*
     *功能：通话按钮替换
     *参数：无
     */
//    zi:function(){
//        var id=$("#calling").attr("userid");
//        var btn15='<div class="em_s btn15_common btn_common btn15_hov">'                                              
//        +'<span class="b_lf"></span>'
//        +'<span class="b_rf"></span>'
//        +'<a href="javascript:;" id="call" userid="{uid}" rel="1" class="btn white">拨打电话</a>'
//        +'</div>';
//        btn15=btn15.replace("{uid}",id);
//        $("#calling").replaceWith(btn15); 
//        baseController.CallBack("call");        
//    }         
};
