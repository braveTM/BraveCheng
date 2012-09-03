/*
 * 用户控制器，页面涉及到用户操作的方法都在这里定义
 */
var accountController={
    /*
     * 功能：后台管理-----个人账户页面----Home_User_proiles
     * 参数：无
     * 说明：页面按钮效果，点击事件
     */
    Inibtn:function(){
        var that=baseController;
        $("div.sm_tab ul li").click(function(){
            baseRender.b("#n_email,#n_pnum,#rname,#fd_cd,#iden,#bd_cd,#opd,#npd,#copd,#nickname");
            $(".v_cont,.va_cont").hide();
            $(".v_exit span.pointer").removeClass("pointer");
        });
        that.BtnBind(".btn4", "btn4", "btn4_hov", "btn4_click");
        that.BtnBind(".btn9", "btn9", "btn9_hov", "btn9_hov");
        $("input[type='text']").addClass("text");
    },
   
    /*
     *提交保存基本资料验证
     *jack
     *2012-1-17
     */
    check_bef:function(){
        var pv=$("#fro_pv").val();
        if(pv==''){
            baseRender.addred("#fro_pv");
            baseRender.a("#fro_pv",LANGUAGE.L0138,"error");
        }else{
            baseRender.ai("#fro_pv");
        }
    },
    /**
     * 选择性别
     * @author jack 
     * @date 2012-2-1
     */
    opOfsex:function(){
        $(".p_gender").click(function(){
            accountRender.k(this);
        });
    },
    /**
     * 保存修改密码按钮
     * @ahthor jack
     * @date  2012-12-05
     */
    savepwd:function(){
        $("#sav_npd").click(function(){
            var op=$("#opd").val();
            var np=$("#npd").val();
            var cnp=$("#copd").val();
            if(op==""){
                baseRender.a("#opd",LANGUAGE.L0010,"error");
            }
            else if(np==""){
                baseRender.a("#npd",LANGUAGE.L0010,"error");
            }
            else if(cnp==""){
                baseRender.a("#copd",LANGUAGE.L0010,"error");
            }
            else {
                baseRender.b(this);
            }
            if($(".module_4 div.tip.error").length<=0){
                var m=new  AccountCat();
                var q={
                    op:$("#opd").val(),
                    np:$("#npd").val()
                };
                m.updatepwd(q,accountRender.succ,accountRender.fail);
            }
        });
    },
    /*
     *手机认证/邮箱认证/实名认证
     * @ahthor jack
     * @date 2012-1-30
     */
    savebasicbtn:function(){
        /*邮箱认证*/
        $("#v_mail").click(function(){
            var emva=$("#n_email").val();
            if(emva==''){baseRender.a("#n_email", LANGUAGE.L0002, "error");}
            else if($(".app_ve div.tip.error").length<=0){
                var ac=new AccountCat();
                ac.appVemail(emva,accountRender.succ,accountRender.fail);
            }else{accountRender.f();}
        });
        /*发送到手机获取验证码*/      
         $("#v_send").click(function(){
            if($("#v_send").attr("disabled")){
                return;
            }
            var pv=$("#n_pnum").val();
            if(pv==""){baseRender.a("#u_phone",LANGUAGE.L0030,"error");}
            else{
                if(!$(this).hasClass("clicked")){
                    $(this).addClass("clicked");                
                    $(".ftx-01").text(59);
                    var ac=new AccountCat();
                    var th=accountRender;                                 
                    ac.sendValidnum(pv,th.sendsucc,th.sendfail);
                }
            }
        });          
        /*手机认证*/
        $("#v_phone").click(function(){
            var vali=$("#n_valinum").val();
            if(vali==""){baseRender.a("#n_valinum",LANGUAGE.L0056,"error");}
            else if($(".app_vp div.tip.error").length<=0){
                var ac=new AccountCat();
                ac.setNphonenum(vali,accountRender.succ,accountRender.savephfail);
            }else{accountRender.f();}
        });
        /*申请实名认证(个人)*/
        $("#v_relname").click(function(){
            var rname=$("#rname").val();//姓名
            var rnum=$("#iden").val();//身份证
            var ft=$("input[name='front_side']").val();//正面图片
            var bside=$("input[name='back_side']").val();//背面图片
            if(rname==""){baseRender.a("#rname",LANGUAGE.L0068,"error");}
            else if(rnum==""){baseRender.a("#iden",LANGUAGE.L0069,"error");}
            else if(ft==""){
                baseRender.a("#fd_cd",LANGUAGE.L0070,"error");
            }
            else if(bside==""){
                baseRender.a("#bd_cd",LANGUAGE.L0170,"error");
            }
            else{
                baseRender.b(this);
            }
            $("#fd_cd").click(function(){
                baseRender.b("#fd_cd");
            });
            $("#bd_cd").click(function(){
                baseRender.b("#bd_cd");
            });
            if($(".app_vn div.tip.error").length<=0){
                var ac=new AccountCat();
                ac.appVrealName(rname,rnum,ft,bside,accountRender.succ,accountRender.fail);
            }else{
                accountRender.f();
            }
        });
        /*申请实名认证(企业)*/
        $("#cv_relname").click(function(){
            var rname=$("#e_name").val();//企业名称
            var rnum=$("#licnum").val();//营业执照编号
            var pic=$("input[name='front_side']").val();//组织机构代码图片
            var code=$("input[name='back_side']").val();//营业执照图片
            if(rname==""){baseRender.a("#e_name",LANGUAGE.L0117,"error");}
            else if(rnum==""){baseRender.a("#licnum",LANGUAGE.L0153,"error");}
            else if(pic==""){
                baseRender.a("#fd_cd",LANGUAGE.L0197,"error");
            }
            else if(code==""){
                baseRender.a("#bd_cd",LANGUAGE.L0198,"error");
            }
            else{
                baseRender.b(this);
            }
            $("#fd_cd").click(function(){
                baseRender.b("#fd_cd");
            });
            $("#bd_cd").click(function(){
                baseRender.b("#bd_cd");
            });
            if($(".app_vn div.tip.error").length<=0){
                var ac=new AccountCat();
                ac.appVeName(rname,rnum,pic,code,accountRender.succ,accountRender.fail);
            }else{
                accountRender.f();
            }
        });
    },
    
    /*
     *初始化验证码发送状态(申请)
     *jack
     *2012-2-2
     */
    InigetVerfy:function(){
        var time=$(".ftx-01").text();
        $(".ftx-01").text(time-1);
        if(time==1){
            $("#countDown").hide();
            $("em.gtcode").removeClass("hidden");
            $("#v_send").removeClass("btn_gray").addClass("btn_normal").removeAttr("disabled");
            $("#n_pnum").removeClass("text-none").removeAttr("disabled");
            $("#v_send").removeClass("clicked");
        }else{
            setTimeout(accountController.InigetVerfy,1000);
        }
    },
    /*
     *保存人才基本资料(账户页面)
     *jack
     *2012-1-30
     */
    SaveTanlent:function(){
        $("#t_s").click(function(){
            $("#nickname,#phone").trigger("blur");
            accountController.check_bef();
            if($(".module_3 div.tip.error").length<=0){
                var em="";
                var ph="";
                if($("input.em_box").hasClass("nbd")){
                    em=$("#v_em").val();
                }else{
                    em=$("#log_email").val();
                }
                 if($("input.ep_box ").hasClass("nbd")){
                    ph=$("#v_ph").val();
                }else{
                    ph=$("#phone").val();
                }
                var p = {
                    name:$("#nickname").val(),
                    gender:$("#gender").val(),
                    birth:$("#date").val(),
                    pid:$("input[name='t_prov']").val(),
                    cid:$("input[name='t_city']").val(),
                    qq:$("#qq").val(),
                    email:em,
                    phone:ph
                };
                var m = new AccountCat();
                m.uptalbasic(p, accountRender.succ, accountRender.fail);
            }else{
                accountRender.f();
            }
        });  
    },
    /*
     *功能：保存人才头像数据
     *参数：无
     */
    t_sp:function(){
        $("#sv_photo").unbind("click").bind("click",function(){
            var p={
               photo:$("input[name='photo']").val(),
               x:$("#x").val(),
               y:$("#y").val(),
               w:$("#w").val(),
               h:$("#h").val()
            }
            var that=accountRender;
            var ac=new AccountCat();
            ac.SvTalentPhoto(p,that.succ,that.fail);
        });
    },
    /*
     *功能;保存企业基本资料(账户页面)
     *参数：无
     *@jack 2012-1-30
     *修改 @jack 2012-7-13
     */
    EnterpriseSave:function(){
        $("#e_s").click(function(){
            $("#cont_p").trigger("blur");
            accountController.check_bef();
            if($(".module_3 div.tip.error").length<=0){
                var em="";
                var ph="";
                if($("input.em_box").hasClass("nbd")){
                    em=$("#v_em").val();
                }else{
                    em=$("#log_email").val();
                }
                 if($("input.ep_box ").hasClass("nbd")){
                    ph=$("#v_ph").val();
                }else{
                    ph=$("#phone").val();
                }
                var p = {
                    qq:$("#qq").val(),
                    ca:$("#e_attr").val(),/*企业性质*/
                    company_phone:$("#cphone").val(),
                    summary:$("#sub_detail").val(),/*企业简介*/
                    name:$("#cont_p").val(),/*联系人名称*/
                    company_qualification:$("#cquali").val(),/*企业资质*/
                    company_regtime:$("#fdate").val(),/*成立时间*/
                    company_scale:$("#comscale").val(),/*企业规模*/
                    pid:$("input[name='t_prov']").val(),
                    cid:$("input[name='t_city']").val(),
                    email:em,
                    phone:ph
                };
                var m = new AccountCat();
                m.upcombasic(p, accountRender.succ, accountRender.fail);
            }else{
                accountRender.f();
            }
        });  
    },
    /*
     *功能：保存企业头像
     *参数：无
     */
   SveEnterphoto:function(){
        $("#enter_photo").unbind("click").bind("click",function(){
            var p={
               photo:$("input[name='photo']").val(),
               x:$("#x").val(),
               y:$("#y").val(),
               w:$("#w").val(),
               h:$("#h").val()
            }
            var that=accountRender;
            var ac=new AccountCat();
            ac.Company_PhotoSave(p,that.succ,that.fail);
        }); 
    },
    /*
     *保存猎头基本资料(账户页面)
     *jack
     *2012-1-30
     */
    AgentSave:function(){
        $("#a_s").click(function(){
            $("#cont_p").trigger("blur");
            accountController.check_bef();
            if($(".module_3 div.tip.error").length<=0){
                var uv="";
                if($("#t_intro").hasClass("gray")){
                    uv="";
                }else{
                    uv=$("#t_intro").val();
                }
                var em="";
                var ph="";
                if($("input.em_box").hasClass("nbd")){
                    em=$("#v_em").val();
                }else{
                    em=$("#log_email").val();
                }
                 if($("input.ep_box ").hasClass("nbd")){
                    ph=$("#v_ph").val();
                }else{
                    ph=$("#phone").val();
                }
                var p = {
                    qq:$("#qq").val(),
                    summary:uv,/*猎头介绍*/
                    name:$("#nickname").val(),/*猎头名称*/
                    pid:$("input[name='t_prov']").val(),
                    cid:$("input[name='t_city']").val(),
                    gender:$("#gender").val(),
                    company:$("#m_o").val(),
                    phone:ph,
                    email:em
                };
                var m = new AccountCat();
                m.upagentbasic(p, accountRender.succ, accountRender.fail);
            }else{
                accountRender.f();
            }
        });  
    },
    /*
     *功能：保存猎头头像
     *参数：
     *auhor:joe date:2012/7/7
     */
   SveMidmanphoto:function(){
        $("#midmanphoto").unbind("click").bind("click",function(){
            var p={
               photo:$("input[name='photo']").val(),
               x:$("#x").val(),
               y:$("#y").val(),
               w:$("#w").val(),
               h:$("#h").val()
            }
            var that=accountRender;
            var ac=new AccountCat();
            ac.Midman_PhotoSave(p,that.succ,that.fail);
        }); 
    },
    /**
     * 表单验证绑定
     * @ahthor jack
     * @date  2012-12-13
     */
    formValid:function(){
        /*密码验证*/
        $("#opd,#npd,#copd").focus(function(){
            baseRender.a(this, LANGUAGE.L0009, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            var len=str.length;
            if(len==0){
                msg=LANGUAGE.L0010;
                b=false;
            }
            else if(len>0&&len<6){
                msg=LANGUAGE.L0011;
                b=false;
            }
            else if(len>16){
                msg=LANGUAGE.L0012;
                b=false;
            }
            else if(!/^[A-Za-z0-9/!/@/#/$/%/^/&/*/_]{4,16}$/.test(str)){
                msg=LANGUAGE.L0013;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        /*确认密码验证*/
        $("#copd").focus(function(){
            baseRender.a(this, LANGUAGE.L0016, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var pstr=$("#npd").val();
            var len=str.length;
            if(len==0){
                msg=LANGUAGE.L0010;
                b=false;
            }
            else if(str!=pstr){
                baseRender.a(this, LANGUAGE.L0017, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        /*姓名验证*/
        /**/
        $("#nickname").focus(function(){
            baseRender.a(this, LANGUAGE.L0060, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0068;
                b=false;
            } 
            else if(/[^\u4E00-\u9FA5]/.test(str)){
                msg=LANGUAGE.L0061;
                b=false;
            }else if(str.length>6){
                 msg=LANGUAGE.L0234;
                 b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        /*认证真实姓名*/
        $("#rname").focus(function(){
            baseRender.a(this, LANGUAGE.L0060, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0068;
                b=false;
            } 
            else if(/[^\u4E00-\u9FA5]/.test(str)){
                msg=LANGUAGE.L0061;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        $("#fro_pv").focus(function(){
            baseRender.remgren(this);
            baseRender.remred(this);
            baseRender.b(this);
        });
        /*企业名称验证*/
        $("#e_name").focus(function(){
            baseRender.a(this, LANGUAGE.L0126, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0117;
                b=false;
            } 
            else if(!/^[a-zA-Z0-9\u4e00-\u9fa5]+$/.test(str)){
                msg=LANGUAGE.L0130;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });/*营业执照编号验证*/
        $("#licnum").focus(function(){
            baseRender.a(this, LANGUAGE.L0152, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0153;
                b=false;
            } 
            else if(!/^[a-zA-Z0-9\u4e00-\u9fa5]+$/.test(str)){
                msg=LANGUAGE.L0130;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        /*企业联系人格式验证*/
        $("#cont_p").focus(function(){
            baseRender.remgren(this);
            baseRender.remred(this);
            baseRender.a(this, LANGUAGE.L0135, "right");
        }).blur(function(){
            var str=$(this).val();
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0136;
                b=false;
            } 
            else if(!/^[a-zA-Z0-9\u4e00-\u9fa5]+$/.test(str)){
                msg=LANGUAGE.L0130;
                b=false;
            }
            if(!b){
                baseRender.addred(this);
                baseRender.a(this, msg, "error");
            }
            else{
                baseRender.ai(this);
            }
        });
        /*企业固定电话格式验证*/
        $("#cphone").focus(function(){
            baseRender.a(this,LANGUAGE.L0232, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0233;
                b=false;
            }
            else{
                if(!/^\d{3,4}-\d{7,8}(-\d{3,4})?$/.test(str))
                { msg=LANGUAGE.L0040;
                   b=false;
                }
                else{
                    b=true;
                    baseRender.ai(this);
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*企业简介*/
        $("#sub_detail").focus(function(){
            baseRender.a(this,LANGUAGE.L0137, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                baseRender.b(this);
            }
            else if(str.length>300){
                msg=LANGUAGE.L0043;
                b=false;
            }
            else{
                b=true;
                baseRender.ai(this);
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*QQ号码验证*/
        $("#qq").focus(function(){
            baseRender.a(this, LANGUAGE.L0032, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                baseRender.b(this);
            }
            else{
                if(!/^(\-?)(\d+)$/.test(str)){
                        msg=LANGUAGE.L0034;
                        b=false;
                    }
                else{
                    baseRender.ai(this);
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*邮箱认证*/
        $("#n_email,#log_email").focus(function(){
            $("div").data("ele",$(this));
            baseRender.a(this,LANGUAGE.L0001,"right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            var that=accountRender;
            if(str==""){
                msg=LANGUAGE.L0002;
                b=false;
            }
            else if(!/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(str)){
                msg=LANGUAGE.L0003;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
            else{
                if($(this).attr("valide")!=str){
                    var ac=new AccountCat();
                    ac.EmailIsUnique(str, that.appsucc, that.appfail);
                }
                else{
                    baseRender.ai(this);
                }
            }
        });
        /*电话验证(不能为空)*/
        $("#n_pnum,#phone").focus(function(){
            baseRender.a(this,LANGUAGE.L0039, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0030;
                b=false;
            }
            else{
                var x=baseRender.d(str);
                if(x==false)
                {
                    msg=LANGUAGE.L0031;
                    b=false;
                }
                else{
                    baseRender.ai(this);
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*短信验证码验证(非空)*/
        $("#n_valinum").focus(function(){
            baseRender.a(this,LANGUAGE.L0059,"right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                baseRender.b(this);
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }else{
                baseRender.b(this);
            }
        });
        /*身份证格式*/
        $("#iden").focus(function(){
            baseRender.a(this,LANGUAGE.L0062,"right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0154;
                b=false;
            }
            else if(!/((1[1-5])|(2[1-3])|(3[1-7])|(4[1-6])|(5[0-4])|(6[1-5])|71|(8[12])|91)\d{4}((19\d{2}(0[13-9]|1[012])(0[1-9]|[12]\d|30))|(19\d{2}(0[13578]|1[02])31)|(19\d{2}02(0[1-9]|1\d|2[0-8]))|(19([13579][26]|[2468][048]|0[48])0229))\d{3}(\d|X|x)?$/.test(str)){
                msg=LANGUAGE.L0063;//身份证匹配18位
                b=false;
            }
            else{
                baseRender.ai(this);
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*猎头介绍*/
        $("#t_intro").focus(function(){
            if($(this).hasClass("gray")){
                $(this).removeClass("gray");
                $(this).val("");
            }
            baseRender.a(this,LANGUAGE.L0042, "right");
        }).keydown(function(e){
            if($(this).hasClass("gray")){
                $(this).removeClass("gray");
                $(this).val("");
            }
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                $(this).addClass("gray");
                $(this).val(LANGUAGE.L0249);
                baseRender.b(this);
            }
            else if(str.length>140){
                msg=LANGUAGE.L0043;
                b=false;
            }
            //                else if(!/^[a-zA-Z0-9\u4e00-\u9fa5]+$/.test(str)){
            //                    msg=LANGUAGE.L0130;
            //                    b=false;
            //                }
            else{
                b=true;
                baseRender.ai(this);
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        /*企业认证(企业，猎头/公司，劳务商)*/
        $("#cname").focus(function(){
            baseRender.a(this,LANGUAGE.L0075,"right");
        }).blur(function(){
            var str=$(this).val();
            var msg="";
            var b=true;
            if(str==""){
                baseRender.b(this);
            }
            else if(!/^[a-zA-Z0-9_\u4e00-\u9fa5]{1,40}$/.test(str)){
                msg=LANGUAGE.L0007;
                b=false;
            }
            else{
                baseRender.ai(this);
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
        $("#cnum").focus(function(){
            baseRender.a(this,LANGUAGE.L0076,"right");
        }).blur(function(){
            var str=$(this).val();
            var msg="";
            var b=true;
            if(str==""){
                baseRender.b(this);
            }
            else if(!(/^\w{3,40}$/.test(str))){
                msg=LANGUAGE.L0079;
                b=false
            }
            else{
                baseRender.ai(this);
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }
        });
    },
    /**
     * 日期选择
     * @ahthor jack
     * @date  2012-1-30
     */
    opOfdate:function(){
        $("#date,#fdate").datepicker({
            showOn: "both",
            buttonImageOnly: true,
            yearRange:'1900:2012',
            buttonText:'点击选择日期',
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true
        });
    },
    /*
     *初始化省份城市
     *jack
     *2012-2-1
     */
    SelpProv:function(){
        var pid=$("input[name='t_prov']").val();
        var cid=$("input[name='t_city']").val();
        var slt=new seldata();
        var name=slt.GetTheProvOrCity(pid,cid);
        if(name[0]=="0"&&name[1]=="0"){
             $("#fro_pv").val("");
        }else if(name[0]==name[1]){
            $("#fro_pv").val(name[0]); 
        }else{
            $("#fro_pv").val(name[0]+"-"+name[1]);
        } 
    },
    /**
     * 地区选择 + 资质选择
     * @ahthor jack
     * @date  2012-1-30
     */
    opOfAreaqua:function(){
        $("#fro_pv").hgsSelect({
            type:'place',    //default:资质添加，place：地区添加，jobtitle：职称添加
            //id:"pslt",             //设置选择框父容器id
            pid:"pslt",            //省市添加的父容器id
            //tid:"",            //职称添加的父容器id
            pshow:true,       //是否显示地区选择
            //cshow:false,       //是否显示人数
            sprov:false,       //是否只精确到省
            single:true,       //省是否为单选
            sure:function(ret){
                accountController.BindProC(ret);
            }
        });
    },
    /*
     *处理返回的省市数据的绑定
     *jack
     *2012-1-16
     */
    BindProC:function(data){
        $("input[name='t_prov']").val(data.prov);
        $("input[name='t_city']").val(data.city);
        $("#fro_pv").val(data.provname+"-"+data.cityname);
        baseRender.ai("#fro_pv");
    },
    /*
     *功能：初始化性别
     *参数:无
     *说明：@jack
     *2011.12.8
     **/
    Inisex:function(){
        accountRender.h();
    },
    /*
     * 头像控件绑定
     */
    uploadImg:function(){
        /*上传头像*/
        $('input#file_name').bind('change',function(){
            avatarRender.b(this);
        });
        /*重新选择图片*/
        $('input#file_name').click(function(){
            $('.select_area').html('');
        });
    },

    /*
     *初始化上传身份证复印件
     */
    up_idcd:function(){
         $("input[name='front_side']").val("");
         $("input[name='back_side']").val("");
         $("#fd_cd").val("");
         $("#bd_cd").val("");
        $('input#fd_cd').bind('change',function(){
            if(accountRender.upfront(this))
                accountRender.dofrontup($("#up_f1"));
        });
        $('input#bd_cd').bind('change',function(){                        
           if(accountRender.upback(this))
                accountRender.dobackup($("#up_f2"));
        });
/*        $("#up_f1").bind("click",function(){
            accountRender.dofrontup(this);
        });
        $("#up_f2").bind("click",function(){
            accountRender.dobackup(this);
        });*/
    },
    /*
     *修改认证
     *功能：触发隐藏认证内容切换事件
     *参数:this,当前选中认证
     *说明：无
     */
    Inittab:function(){
        $("ul#v_li li").each(function(i,o){
            $(o).click(function(){
                $(this).parent().parent().next().find("div.error,div.result").remove();
                $(this).parent().parent().next().find(".red_border").removeClass("red_border");
                $(this).parent().find("span.pointer").removeClass("pointer");
                $("ul#v_li li").removeClass("cur_p");
                accountRender.stab(this);
            });
        });
    },
    /*
     *可申请的认证
     *功能：触发隐藏可申请内容切换事件
     *参数:this,当前选中认证
     *说明：无
     */
    Iniapvtab:function(){
        $(".tab_c").hide();
        $("ul.v_list li").each(function(i,o){
            $(o).click(function(){
                $(o).parent().find("span.pointer").removeClass("pointer");
                $("ul.v_list li").removeClass("cur_p");
                accountRender.tab(this);
            });
        });
    },
    
    /*
     *功能：判断是否具有已经拥有的信用认证
     *可申请的信用认证
     *参数：无
     */
    IniConfirm:function(){
        if($('#v_li li').length<=0){
            $(".val_p").hide();//已拥有认证
            $(".profiles .module_6 .avaible_v").css("border-top","none");
        }
        if($('#va_li li').length<=0){
           $(".avaible_v").hide();//可申请认证
        }
    },
    /*
     *初始化公司性质/初始化企业规模
     *参数：无
     *修改：@jack 2012-7-13
     */
    IniChangeAttr:function(){
       accountRender.a();
    },
    /*
     * 功能：初始化首页
     * 参数：无
     * 无
     */
    iniPage:function(){
        baseRender.ae(0);
        this.Inisex();/*初始化性别*/
        this.Inibtn();
        this.Inittab();
        this.Iniapvtab();
        this.InigetVerfy();
        this.up_idcd();/*身份证文件上传*/
        this.SelpProv();/*初始化省份城市*/
        this.formValid();/*表单验证绑定*/
        this.opOfsex();/*选择性别*/
        this.opOfdate();/*日期选择*/
        this.opOfAreaqua();/*省市，资质选择*/
        this.uploadImg();/*头像控件绑定*/
        this.savebasicbtn();/*修改认证基本资料信息*/
        this.savepwd();/*保存修改后的密码*/
        this.IniConfirm();
    },
    /*
     * 功能：初始化首页
     * 参数：无
     * 无
     */
    iniPage1:function(){
        this.iniPage();
        this.AgentSave();/*保存猎头基本信息*/
        this.SveMidmanphoto();        
    },
    /*
     * 功能：初始化首页
     * 参数：无
     * 无
     */
    iniPage2:function(){
        this.iniPage();
        this.SaveTanlent();/*保存人才基本信息*/
        this.t_sp();/*保存人才头像*/
    },
    /*
     * 功能：初始化首页
     * 参数：无
     * 无
     */
    iniPage3:function(){
        this.iniPage();
        this.EnterpriseSave();/*保存企业基本信息*/
        this.IniChangeAttr();/*修改公司性质*/
        this.SveEnterphoto();
    }
};
$().ready(function(){
    if(typeof(PAGE)=="undefined"){
        PAGE="";
    }
    if(PAGE=="23"){
        accountController.iniPage();
    }
    if(PAGE=="29"){
        accountController.iniPage1();
    }
    if(PAGE=="30"){
        accountController.iniPage2();
    }
    if(PAGE=="31"||PAGE=="32"){
        accountController.iniPage3();
    }
});
