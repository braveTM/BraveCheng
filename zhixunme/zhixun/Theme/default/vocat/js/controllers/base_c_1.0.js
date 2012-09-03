/* 
 * 用户控制器，页面涉及到用户操作的方法都在这里定义
 */
var baseController={
//    /*
//     * 功能：判断当前浏览器版本
//     * 参数：
//     * 无
//     */
//    BrowserVersion:function(){
//        var b=$.browser.msie;
//        var v=$.browser.version;
//        if(b&&(v=="6.0")){
//           //$("body").prepend(COMMONTEMP.T0012);
//        }
////        else if(b&&(v=="6.0")&&PAGE!="0"){
////            location.href=WEBROOT+'/';
////        }
//    },
    /*
     * 功能：初始化弹出框
     * 参数：
     * 无
     */
    IniAlert:function(){
        window.alert=baseRender.OperTipShow;
    },
    /*
     * 功能：后台导航切换初始化
     * 参数：
     * 无
     */
    BKNav:function(){
        var len1=$("#bheader").length,
        len2=$("#bdheader").length;
        var that=baseRender;
        if(len1>0&&len2==0){
            var NAVTIMER1=[];
            var NAVTIMER2=[];
            $("#bheader div.bh_cont div.bh_nav a").each(function(index){
                $(this).hover(
                    function(){
                        var _self = this;
                        clearTimeout(NAVTIMER2[index]);
                        NAVTIMER1[index] = setTimeout(function() {
                            baseRender.aa(_self);
                        }, 150);
                    },
                    function(){
                        var _self = this;
                        clearTimeout(NAVTIMER1[index]);
                        NAVTIMER2[index] = setTimeout(function() {
                            baseRender.ab(_self);
                        }, 300);
                    });
            });
            $("#bheader div.bh_cont ul.bh_cm li").hover(function(){
                that.ac(this);
            }, function(){
                that.ad(this);
            });
        }else if(len2>0){
            $("#mliner").remove();
            $("#bheader div.bh_cont ul.bh_cm li").hover(function(){
                that.ac(this);
            }, function(){
                that.ad(this);
            });
        }
    },
    /*
     * 功能：初始化用户中心标签切换
     * 参数：
     * 无
     */
    TabChange:function(){
        var t=$("div.sm_tab");
        if(t.length>0&&t.find("ul li").length>1){
            t.find("ul li").click(function(){
                baseRender.TabChange(this);
            });
            this.TabFixedPos(false);
        }
    },
    /*
     * 功能：获取地址栏里标签的索引
     * 参数：
     * 无
     */
    GetUrlTabPos:function(){
        var url=window.location.href.split("/");
        var num=url[url.length-1];
        var index=parseInt(num,10);
        index=((num==""||isNaN(index))?0:index);
        return [index,num];
    },
    /*
     * 功能：用户中心标签定位
     * 参数：
     * 无
     */
    TabFixedPos:function(){
        var that=HGS.Base;
        var cur_index=this.GetUrlTabPos(),//当前连接中指向的标签索引
        his_index=that.GetCookie("h_index").split(","),
        h_index=his_index[0],//上一个页面中连接中指向的标签索引
        t_index=his_index[1],//上一个页面中标签的索引
        t_page=his_index[2],//上一个页面的索引
        index=0;//当前页面中标签的索引
        if(cur_index[1]!=h_index||!!!t_index||t_page!=PAGE){
            index=cur_index[0];
        }else{
            index=t_index;
            that.DelCookie("h_index");
        }
        var t=$("div.sm_tab");
        if(index>=0&&index<t.find("ul li").length){
            t.find("ul li:eq("+index+")").trigger("click");
        }else{
            return false;
        }
    },
    /*
     * 功能：标签页刷新
     * 参数：
     * i：标签索引 从0开始
     */
    TabFresh:function(){
        window.onunload=function(){
            var t=$("div.sm_tab ul");
            var that=HGS.Base;
            if(t.length>0){
                var index=t.find("li.cur_li").index();
                var hindex=baseController.GetUrlTabPos()[1];
                that.SetCookie("h_index",hindex+","+index+","+PAGE,1);
            }else{
                that.SetCookie("h_index",",,"+PAGE,1);
            }
        }
    },
    /*
     * 功能：用户中心列表模板生成
     * 参数：
     * l：左边模板（若l为空，则输出两列模板的列表）
     * m：中间模板
     * r：右边模板
     */
    GenBListTemp:function(l,m,r){
        var temp='';
        if(l!=null){
            temp=TEMPLE.T00032;
            temp=temp.replace("{list_l}",l);
        }
        else{
            temp=TEMPLE.T00033;
        }
        temp=temp.replace("{list_m}",m);
        temp=temp.replace("{list_r}",r);
        return temp;
    },
    /*
     * 功能：权限控制
     * 参数：
     * 无
     */
//    LimitContr:function(obj){
//        if(PAGE=="72"||PAGE=="73"||PAGE=="74"){
//            if(obj==null){
//                var par=$('div.layout1 div.layout1_r');                
//                obj=par.find('div a').not('div.nopermission a').not("div._count a").not("div.sev a");                 
//            }
//            $(obj).unbind("click").bind("click",function(){
//                if($("div.nopermission").length>0){
//                    alert("对不起,您暂时没有权限进行查看");
//                    return false;
//                }else{
//                    return true;
//                }
//            });
//        }
//    },
    /*
     * 功能：初始化长轮询
     * 参数：
     * 无
     */
    LTimeRequest:function(){
        //var hgs=HGS.Base;
        $.ajax({
            async: true,
            type: "POST",
            url: WEBURL.LTimeRequest,
            timeout: 30000,
            data: "",
            dataType: "jsonp",
            jsonp: "jsoncallback",
            success: function (jsonp) {
                if(jsonp!=null&&jsonp!=""){
                    var r=eval(jsonp);
                    var that=baseController;
                    if(r.ret){
                        that.MsgTips(r.data);
                    }
                    setTimeout(function(){
                        that.LTimeRequest();
                    },30000);
                }
            },
            error:function(XMLHttpRequest,textStatus,errorThrown){
                if(textStatus=="timeout"){
                    setTimeout(function(){
                        baseController.LTimeRequest();
                    },30000);
                }
            }
        });
    },
    /*
     * 功能：消息提示
     * 参数：
     * data：后台返回数据
     */
    MsgTips:function(data){
        var that=CONSTANT;
        var file=FILEROOT;
        var html='',total=0;
        var arr=[{
            a:data.hasOwnProperty("ypresume"),//投递来的简历
            b:data.ypresume,
            d:file+"/atm/3",
            e:that.M0001
        },{
            a:data.hasOwnProperty("ragent"),//委托来的简历
            b:data.ragent,
            d:file+"/atm/2",
            e:that.M0002
        },{
            a:data.hasOwnProperty("jagent"),//委托来的职位
            b:data.jagent,
            d:file+"/apm/2",
            e:that.M0003
        },{
            a:data.hasOwnProperty("system"),//站内信
            b:data.system,
            d:file+"/messages/",
            e:that.M0005
        },{
            a:data.hasOwnProperty("invite"),//简历邀请
            b:data.invite,
            d:file+"/messages/",
            e:that.M0006
        },{
            a:data.hasOwnProperty("edjob"),//取消委托职位
            b:data.edjob,
            d:file+"/apm/2",
            e:that.M0007
        },{
            a:data.hasOwnProperty("edresume"),//取消委托简历
            b:data.edresume,
            d:file+"/atm/2",
            e:that.M0008
        },{
            a:data.hasOwnProperty("user"),//用户消息
            b:data.user,
            d:file+"/messages/",
            e:that.M0009
        },{
            a:data.hasOwnProperty("birth"),//人才生日提醒
            b:data.birth,
            d:file+"/messages/",
            e:that.M00010
        },{
            a:data.hasOwnProperty("setup"),//企业成立纪念日将到
            b:data.setup,
            d:file+"/messages/",
            e:that.M00011
        },{
            a:data.hasOwnProperty("remit"),//企业汇款日期将到
            b:data.remit,
            d:file+"/messages/",
            e:that.M00012
        },{
            a:data.hasOwnProperty("employ"),//人才聘用到期
            b:data.employ,
            d:file+"/messages/",
            e:that.M00013
        },{
            a:data.hasOwnProperty("eypresume"),//投递来的简历
            b:data.eypresume,
            d:file+"/recruitment/3",
            e:that.M00014
        }];
        $.each(arr,function(i,o){
            if(o.b){
                html+='<p class="mitem"><a href="'+o.d+'" class="ms'+o.c+'"><span>'+o.b+'</span>'+o.e+'</a></p>';
                total++;
            }
        });
        if(total!=0){
            $("em#msgnum").prev("div.navborder").animate({left:"-15px"},100);
            $("em#msgnum").html(total).fadeIn(100);
        }else{            
            $("em#msgnum").fadeOut(100).html("");
            $("em#msgnum").prev("div.navborder").animate({left:"12px"},100);
        }
        if(html!=""){
            $("#msgtips").html(html);
            //ctr.DelMsg();
        }else{
            $("#msgtips").html("");
        }
    },
    /*
     * 功能：回到顶部
     * 参数：
     * 无
     */
    GoTop:function(){
        $("#gotop").click(function(){
            $('html,body').animate({
                scrollTop: '0px'
            }, 500);
        });
        $(window).scroll(function(){
            var mh=$(window).scrollTop();
            if(mh>0){
                $("#gotop").fadeIn(100);
            }else{
                $("#gotop").fadeOut(100);
            }
        });
    },
    /*
     * 功能：按钮通用事件绑定
     * 参数：
     * id：按钮id(即div.btn的id)
     * btn_com：正常状态下按钮样式
     * btn_over：移入时按钮的样式
     * btn_click：点击时按钮的样式
     */
    BtnBind:function(id,btn_com,btn_over,btn_click){
        $(id).unbind().bind({
            mouseenter:function(){
                baseRender.BtnChangeBg(this,btn_com,btn_over);
            },
            mouseleave:function(){
                baseRender.BtnChangeBg(this,btn_over,btn_com,btn_click);
            },
            click:function(){
                baseRender.BtnChangeBg(this,btn_over,btn_click);
            }
        });
    },
    /*
     * 功能：按钮通用事件解除绑定
     * 参数：
     * id：按钮id(即div.btn的id)
     */
    BtnUnbind:function(id){
        $(id).unbind("mouseenter");
        $(id).unbind("mouseleave");
        $(id).unbind("click");
    },
    /*
     * 功能：初始化对话框
     * 参数：
     * a:类型（1：我要竞标，2：想对某某说，3：登录框）
     * b:对话框id
     */
    IniDialog:function(a,b){
        var that=baseRender;
        that.l(a, b);
        $("#"+b+" .a_closebtn").click(function(){
            that.m(this);
        });
        baseController.BtnBind("#"+b+" div.btn3", 'btn3', 'btn3_hov', 'btn3_click');
    },
    /*
     * 功能：弹出框方式的登录
     * 参数：无
     * func：回调方法名
     * k：是否开启回车登录
     */
    Login:function(func,k){
        if($("#exit").length==0){
            this.IniDialog(3, "alrloginbox");
            $("#alrlogin").click(function(){
                var a=$("#alr_uname").val();
                var b=$("#alr_uid").val();
                if(a==""){
                    $("div#alrloginbox div.al_bt p.red").html(LANGUAGE.L0006);
                }
                else if(b==""){
                    $("div#alrloginbox div.al_bt p.red").html(LANGUAGE.L0010);
                }
                else{
                    var c="1";
                    var that=baseRender;
                    HGS.Base.Login(a,b,c,func,that.t,that.u);
                }
            });
            if(k==true){
                $(window).keydown(function(event){
                    var aid=document.activeElement.id;
                    if(event.keyCode==13&&(aid=="alr_uname"||aid=="alr_uid")){
                        $("#alrlogin").addClass("a_hov").trigger("click");
                    }
                });
            }
        }
    },
    /*
     * 功能：退出
     * 参数：
     * 无
     */
//    Exit:function(){
//        if($("#exit").length==1){
//            $("#exit").click(function(){
//                var that=baseRender;
//                HGS.Base.Exit(that.r,that.s);
//            });
//        }
//    },
    /*
     * 功能：包含确认取消按钮的弹出框（如确认购买套餐..）
     * 参数：
     * a：right：正确，error：错误
     * b：提示信息
     * c：确认按钮id
     * d：确认按钮显示文本
     * e：指定执行方法名
     */
    InitialSureDialog:function(a, b, c, d, f){
        baseRender.z(a, b, c, d);
        this.BtnBind("div.sure_dialog div.btn3", "btn3", 'btn3_hov', 'btn3_click');
        $("div.sure_dialog a.cancel").unbind("click").bind("click",function(){
            $(this).parent().parent().parent().parent().fadeOut(200);
        });
        if(typeof(f)!="undefined"&&f!=null){
            f();
        }
    },
    /*
     *取消关注某人
     *参数：
     *obj_sc
     */
    RemoveFocusPerson:function(obj,color){
        var that=baseRender;
        $(obj).unbind("click").bind("click",function(){
            var uid=$(this).attr("uid");
            var uname=$(this).attr("uname");
            if(typeof(color)=="undefined"||color==""){
                color="red";
            }
            $("div").data("uid",uid);
            $("div").data("uname",uname);
            $("div").data("ucolor",color);
            $("div").data("item",obj);
            var msg=confirm("确定不再关注"+uname);
            if(msg==true){
                var m=new Message();
                m.removeFocus(uid,that.rem_suc,that.p_fail);
            }
        });
    },
    /*
     *功能：加关注
     *参数：无
     *负责人：jack
     *时间：2012-2-20
     */
    Add_focus:function(obj,color){
        var that=baseRender;
        $(obj).unbind("click").bind("click",function(){
            var uid=$(this).attr("uid");
            var uname=$(this).attr("uname");
            if(typeof(color)=="undefined"||color==""){
                color="red";
            }
            $("div").data("uid",uid);
            $("div").data("uname",uname);
            $("div").data("ucolor",color);
            $("div").data("item",obj);
            var m=new Message();
            m.Add_FocusPerson(uid,that.p_suc,that.p_fail);
        });
    },
    /*
     *功能：举报
     *参数：无          
     *无
     */
    ReportSpam:function(){
        var reported_id ;
        var type=0;
        var newtype ;
        var content ;
        var that=baseRender;
        baseController.b();
        $("#s_report").unbind("click").bind("click",function(){            
            type=$("#retype input[checked=checked]").val();
            newtype=$(this).attr("type")*1;
            reported_id=$("#user").attr("uid")*1;            
            content=$.trim($("#addtext").val());
            if(content=="请详细填写举报理由")
                content='';
            if(!type)
                alert('请选择举报类型!');
            else{
                $("#bheader").data("win",window);                             
                var s={
                    url:WEBURL.DoreportSpam,
                    params:'reported_id='+reported_id+'&type='+type+'&newtype='+newtype+'&content='+content,
                    sucrender:that.ReportSuc,
                    failrender:that.ReprotFail
                };                         
                HGS.Base.HAjax(s);
            }
        });                
    },    
    /*
     *功能：举报单选事件绑定|按键|举报页补充说明初始化
     *参数：无          
     *无
     */
    b:function(){
        var that=baseRender;
        that.ao();        
        that.ap();
        baseController.BtnBind(".btn10", "btn10","btn10_hov","btn10_hov");        
    },
 /*
     * 功能：电话回拨，事件绑定
     * 参数：id:回拨按键id
     * 无
     */
//    CallBack:function(id){        
//        baseController.BtnBind(".btn15", "btn15","btn15_hov","btn15_hov");        
//        $("#"+id).unbind("click").bind("click",function(){
//            var that=baseRender;
//            var s={
//                url:WEBURL.callBackCheck,
//                params:"",
//                sucrender:that.zs,
//                failrender:that.zf
//            };
//            HGS.Base.HAjax(s);
//        })
//    },       
    /*
     *功能：初始化后台左侧按钮的绑定事件
     *参数：无
     */
    IniLeftBtn:function(){
      baseController.BtnBind(".btn24", "btn24", "btn24_hov", "btn24_hov");
    },
    /*
     * 功能：初始化
     * 参数：
     * 无
     */
    IniPage:function(){
        this.IniLeftBtn();
        //this.BrowserVersion();
        this.IniAlert();
        this.BKNav();
        this.TabFresh();
        this.TabChange();
        this.GoTop();
        //this.Exit();
        this.RemoveFocusPerson();
        this.Add_focus();
        //this.LimitContr(null);
        this.ReportSpam();    
//        if(PAGE==50||PAGE==54||PAGE==55||PAGE==60){
//            this.CallBack("call");
//        }
    /*举例
        $("#id").bind("click",function(){
            //event.stopPropagation(); 该方法阻止事件传递，但不阻止元素默认事件，如<a>的跳转
            //return false;该方法阻止事件传递，同时也阻止元素的默认事件
            //event.preventDefault();相反的，该方法组织元素的默认事件，但不阻止事件传递
            indexController.func1();
        });
         */
    },
    /*
     * 功能：初始化
     * 参数：
     * 无
     */
    IniPage1:function(){
        if($("div.bheader").length>0){
            this.LTimeRequest();
        }       
    }
};
$().ready(function(){
    var that=baseController;
    that.IniPage();
    that.IniPage1();
});
