function bootdata(){};
bootdata.prototype={
    /*
    *选择框模板
    */
    boot_content:'<div class="cards_cover boot_card" id="{id}" style="display: block; ">'
    +'<div class="select_bg">'
    +'<div class="bc_item">'
    +'<div class="top"><p class="lf"></p><p class="rf"></p></div>'
    +'<div class="middle">'
    +'<div class="mbg">'
    +'<div class="title"><span class="cur_span tle">第一步:&nbsp;&nbsp;求职意向</span><span class="arow arow1"></span><span class="tle">第二步:&nbsp;&nbsp;上传头像</span><span class="arow"></span><span class="tle">第三步:&nbsp;&nbsp;完成</span><p class="clr"></p></div>'
    +'<div class="stp_cover">{step}</div>'
    +'</div>'
    +'</div>'
    +'<div class="bot"><p class="lf"></p><p class="rf"></p></div>'
    +'</div>'
    +'</div>'
    +'</div>',
    /*
    *人才引导第一步
    */
    TStep1:'<div class="tstep1 steps" style="display:block;">'
    +'<p class="gray t_tip">欢迎来到职讯网! 请填写真实资料，系统将为您匹配推动更精准的职位信息!</p>'
    +'<div class="tb_title" id="jobtype">'
    +'<span class="red">* </span><span class="title">求职类型 : </span>'
    +'<input type="radio" name="intended" checked value="2" id="intended1"><label for="intended1">兼职</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
    +'<input type="radio" name="intended" value="1" id="intended2"><label for="intended2">全职</label>'
    +'</div><span class="red note">&nbsp;&nbsp;注：&nbsp;&nbsp;&nbsp;资质信息或职称证,至少填写一项</span>'
    +'<table class="tb tb_all">'
    +'<tr>'
    +'<td class="ltd">'
    +'<span class="red">* </span><span>资质信息 : </span>'
    +'</td>'
    +'<td>'
    +'<input class="mselect qual_select" type="text" id="jqual_select" readonly/>'
    +'</td>'
    +'</tr>'
    +'<tr>'
    +'<td class="ltd">'
    +'<span class="red">* </span><span>职称证 : </span>'
    +'</td>'
    +'<td>'
    +'<input class="mselect" type="text" id="jtitle_selt"/>'
    +'</td>'
    +'</tr>'
    +'<tr>'
    +'<td class="ltd">'
    +'<span class="red">* </span><span>期望待遇 : </span>'
    +'</td>'
    +'<td>'
    +'<select id="jthepay">'
    +'<option value="0">面议</option>'    
    +'<option value="7">&nbsp;&nbsp;0 ～ 1</option>'
    +'<option value="8">&nbsp;&nbsp;1 ～ 2</option>'
    +'<option value="9">&nbsp;&nbsp;2 ～ 3</option>'
    +'<option value="10">&nbsp;&nbsp;3 ～ 4</option>'
    +'<option value="11">&nbsp;&nbsp;4 ～ 5</option>'
    +'<option value="2">&nbsp;&nbsp;5 ～ 10</option>'
    +'<option value="3">10 ～ 20</option>'
    +'<option value="4">20 ～ 40</option>'
    +'<option value="5">40 ～ 99</option>'
    +'<option value="6">100 +</option>'
    +'<option value="12">手动填写</option>'
    +'</select>'
    +'<input value="" id="defpay1" class="defpay hidden" type="text" />'
    +'<span> 万/年</span>'
    +'</td>'
    +'</tr>'
    +'<tr>'
    +'<td class="ltd">'
    +'<span class="red">* </span><span>期望注册地 : </span>'
    +'</td>'
    +'<td>'
    +'<input class="mselect sm_input" type="text" id="jpselect" readonly/>'
    +'</td>'
    +'</tr>'
    +'<tr class="hidden">'
    +'<td class="ltd">'
    +'<span class="red">* </span><span>常用电子邮箱 : </span>'
    +'</td>'
    +'<td>'
    +'<input type="text" id="juemail"/><span class="gray hidden">&nbsp;&nbsp;方便企业和猎头联系到您!</span>'
    +'</td>'
    +'</tr>'
    +'<tr>'
    +'<td class="ltd">'
    +'<span class="red">* </span><span>常用手机 : </span>'
    +'</td>'
    +'<td>'
    +'<input type="text" id="juqq"/><span class="gray hidden">&nbsp;&nbsp;方便企业和猎头联系到您!</span>'
    +'</td>'
    +'</tr>'
    +'</table>'
    +'<table class="tb hidden">'
    +'<tr>'
    +'<td class="ltd">'
    +'<span>资质信息 : </span>'
    +'</td>'
    +'<td>'
    +'<input class="mselect qual_select" type="text" id="qqual_select" readonly/>'
    +'</td>'
    +'</tr>'
    +'<tr>'
    +'<td class="ltd">'
    +'<span>职称证 : </span>'
    +'</td>'
    +'<td>'
    +'<input class="mselect" type="text" id="qtitle_selt" readonly/>'
    +'</td>'
    +'</tr>'
    +'<tr class="lst_tr">'
    +'<td class="ltd">'
    +'<span class="red">* </span><span>职位类别 : </span>'
    +'</td>'
    +'<td class="fpos">'
    +'<a href="javascript:;" id="qposition" cids="" pids="" names="" class="blue">选择职位</a><span class="red hidden" id="jtip">职位选择不能为空!</span>'
    +'<div class="slt_pos" id="slt_pos">'
    +'</div>'
    +'</td>'
    +'</tr>'
    +'<tr>'
    +'<td class="ltd">'
    +'<span class="red">* </span><span>期望待遇 : </span>'
    +'</td>'
    +'<td>'
    +'<select id="thepay">'
    +'<option value="0">面议</option>'
    +'<option value="7">&nbsp;&nbsp;0 ～ 1</option>'
    +'<option value="8">&nbsp;&nbsp;1 ～ 2</option>'
    +'<option value="9">&nbsp;&nbsp;2 ～ 3</option>'
    +'<option value="10">&nbsp;&nbsp;3 ～ 4</option>'
    +'<option value="11">&nbsp;&nbsp;4 ～ 5</option>'
    +'<option value="2">&nbsp;&nbsp;5 ～ 10</option>'
    +'<option value="3">10 ～ 20</option>'
    +'<option value="4">20 ～ 40</option>'
    +'<option value="5">40 ～ 99</option>'
    +'<option value="6">100 +</option>'
    +'<option value="12">手动填写</option>'
    +'</select>'
    +'<input value="" id="defpay" class="defpay hidden" type="text" />'
    +'<span> 万/年</span>'
    +'</td>'
    +'</tr>'
    +'<tr>'
    +'<td class="ltd">'
    +'<span class="red">* </span><span>期望工作地 : </span>'
    +'</td>'
    +'<td>'
    +'<input class="mselect sm_input" type="text" id="qpselect" readonly>'
    +'</td>'
    +'</tr>'
    +'<tr class="hidden">'
    +'<td class="ltd">'
    +'<span class="red">* </span><span>常用电子邮箱 : </span>'
    +'</td>'
    +'<td><input type="text" id="quemail"/><span class="gray hidden">&nbsp;&nbsp;方便企业和猎头联系到您!</span>'
    +'</td>'
    +'</tr>'
    +'<tr>'
    +'<td class="ltd">'
    +'<span class="red">* </span><span>常用手机 : </span>'
    +'</td>'
    +'<td>'
    +'<input type="text" id="quqq"/><span class="gray hidden">&nbsp;&nbsp;方便企业和猎头联系到您!</span>'
    +'</td>'
    +'</tr>'
    +'</table>'
    +'<div class="bt_next rf"><div class="save btn_common btn12_common btn12">'
    +'<span class="b_lf"></span>'
    +'<span class="b_rf"></span>'
    +'<a href="javascript:;" id="tstep1save" class="btn white">保存,并下一步</a>'
    +'</div></div><p class="clr"></p>'
    +'</div>',
    /*
    *人才引导第二步
    */
    TStep2:'<div class="tstep2 steps">'
    +'<p class="gray t_tip">上传真实头像认证，让更多企业和猎头认识您!</p>'
    +'<table class="tb_info"><tr class="gray">'
    +'<td class="t_l" valign="top">上传头像:</td>'
    +'<td>'
    +'<table class="tb_info">'
    +'<tr>'
    +'<td class="ava_mtd">'
    +'<form action="'+WEBROOT+'/upload_photo" method="post" enctype="multipart/form-data" id="form_upload" target="Upfiler_file_iframe">'
    +'<div class="up_fileBox">'
    +'<div class="lf MIB_btn uploadInput">'
    +'<div class="btn_common btn9">'
    +'<span class="b_lf"></span>'
    +'<span class="b_rf"></span>'
    +'<a class="sbtn_normal btn" href="javascript:;">'
    +'<em>选择图片</em>'
    +'<q><input id="file_name" name="file_name" size="1" type="file"></q>'
    +'</a>'
    +'<span class="gray gtip">支持gif、jpg、png格式图片,且不大于2M</span>'
    +'</div>'
    +'</div>'
    +'</div>'
    +'<div class="clear"></div>'
    +'<p id="upload_status" style="display:none;" class="error_color">请等待图片上传...</p>'
    +'<input type="hidden" name="__hash__" value=""></form>'
    +'<iframe id="Upfiler_file_iframe" name="Upfiler_file_iframe" src="about:blank" style="display:none"></iframe>'
    +'</td>'
    +'</tr>'
    +'<tr>'
    +'<td>'
    +'<div>'
    +'<table class="avatar_show" cellpadding="0" cellspacing="0" width="100%">'
    +'<tr>'
    +'<td id="up_avatar_left" style="display:none;border:none;width:200px;" valign="middle">'
    +'<div class="avatar_box">'
    +'<div id="n_avatar_div" class="avatar_pic">'
    +'<img id="my_avatar" src="'+WEBROOT+'/Files/system/photo/user/big/default.png">'
    +'</div>'
    +'</div>'
    +'</td>'
    +'<td valign="middle" style="border:none;width: 120px;">'
    +'<div class="p_cont_b">'
    +'<div class="avatar_b_box">'
    +'<div id="b_avatar_div" class="avatar_b_pic">'
    +'<img src="'+WEBROOT+'/Files/system/photo/user/big/default.png" alt="">'
    +'</div>'
    +'<input type="hidden" name="photo" value="'+WEBROOT+'/Files/system/photo/user/big/default.png"/>'
    +'</div><br/>'
    +'</div>'
    +'</td>'
    +'<td style="padding-left:10px;border:none;" valign="middle">'
    +'<div class="p_cont_m">'
    +'<div class="avatar_m_box">'
    +'<div id="m_avatar_div" class="avatar_m_pic">'
    +'<img src="'+WEBROOT+'/Files/system/photo/user/big/default.png" alt="">'
    +'</div>'
    +'</div>'
    +'</div>'
    +'</td>'
    +'</tr>'
    +'</table>'
    +'<div class="clr"></div>'
    +'<p>'
    +'<input type="hidden" value="0" id="x">'
    +'<input type="hidden" value="0" id="y">'
    +'<input type="hidden" value="100" id="w">'
    +'<input type="hidden" value="100" id="h">'
    +'</p>'
    +'</div>'
    +'</td>'
    +'</tr>'
    +'</table>'
    +'</td>'
    +'</tr></table><p class="clr"></p><div class="select_area" style="position: absolute;"></div>'
    +'<div class="bt_next rf"><div class="save btn_common btn12_common btn12">'
    +'<span class="b_lf"></span>'
    +'<span class="b_rf"></span>'
    +'<a href="javascript:;" id="tstep2save" class="btn white">保存,并下一步</a>'
    +'</div></div><p class="clr"></p>'
    +'</div>',
    /*
    *人才引导第三步
    */
    TStep3:'<div class="tstep3 steps">'
    +'<p class="gray t_tip">您已成功填写求职意向，系统会为您精准推送适合您的职位或企业。<br/>您可以进行以下操作：</p>'
    +'<div class="a_s porf">'
    +'<span>1、&nbsp;&nbsp;获得更多更精准的职位，立即完善兼职简历!</span><span class="bd_liner"></span>'
    +'<div class="btn_common btn12_common btn12">'
    +'<span class="b_lf"></span>'
    +'<span class="b_rf"></span>'
    +'<a href="'+WEBROOT+'/resume/" class="btn aws white" >立即完善兼职简历</a></div><p class="clr"></p>'
    +'</div>'
    +'<div class="a_s a_s_div">'
    +'<span>2、&nbsp;&nbsp;暂不完善,立即去找职位、找企业、找猎头。</span><span class="bd_liner"></span>'
    +'<div class="brac">'
    +'<div class="lf bliner"></div>'
    +'<div class="lf bas">'
    +'<div class="btn_common btn12_common btn12 w f">'
    +'<span class="b_lf"></span>'
    +'<span class="b_rf"></span>'
    +'<a href="'+WEBROOT+'/tfj/" class="aws btn white">找职位</a>'
    +'</div>'    
    +'<div class="btn_common btn12_common btn12 w">'
    +'<span class="b_lf"></span>'
    +'<span class="b_rf"></span>'
    +'<a href="'+WEBROOT+'/tfe/" class="aws btn white">找企业</a>'
    +'</div>' 
    +'<div class="btn_common btn12_common btn12 w">'
    +'<span class="b_lf"></span>'
    +'<span class="b_rf"></span>'
    +'<a href="'+WEBROOT+'/tfa/" class="aws btn white">找猎头</a>'
    +'</div>'     
    +'<p class="clr"></p></div>'
    +'</div></div><p class="clr"></p>'
    +'<div class="bt_next rf"><div class="save btn_common btn19_common btn19">'
    +'<span class="lf"></span>'
    +'<span class="rf"></span>'
    +'<a href="'+WEBROOT+'/t_index/" id="tstep3save" class="btn gray">暂不完善,到首页看看</a>'
    +'</div>'
    +'</div>',
    PJResSave:function(a,b,c,d,e,f,f1,g,h,i,sf,ff){
        var set={
            url:WEBURL.PJResSave,
            params:"rc_ids="+a+"&rc_case="+b+"&rc_pros="+c+"&gcm_class="+d+"&gcm_id="+e+"&job_salary="+f+"&treatment="+f1+"&province_code="+g
                +"&phone="+h+"&email="+i,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(set);
    },
    FJResSave:function(a,b,c,d,e,f,g,g1,h,i,j,k,sf,ff){
        var set={
            url:WEBURL.FJResSave,
            params:"rc_ids="+a+"&rc_case="+b+"&rc_pros="+c+"&gcm_class="+d+"&gcm_id="+e+"&job_type="+f+"&job_salary="+g+"&treatment="+g1+"&province_code="+h+"&city_code="+i
                +"&phone="+j+"&email="+k,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(set);
    },
    PhoSave:function(a,b,c,d,e,sf,ff){
        var set={
            url:WEBURL.PhoSave,
            params:"photo="+a+"&x="+b+"&y="+c+"&w="+d+"&h="+e,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(set);
    }
};
/*
*人才引导流程第一步
*/
var iniTStep1={
    /* 功能: 初始化第一步
    * 参数：无
    * 说明：无
    */
    a:function(){
        var that=iniTStep1;
        that.b();
        that.c();
        that.d();
        that.e();
        that.g();
        that.h();
        that.m();
        that.n();
        that.j();
        that.s();
        that.t();
    },
    /* 功能: 初始化求职类型
        * 参数：无
        * 说明：无
        */
    b:function(){
        $("#jobtype input[name='intended']").click(function(){
            iniTStep1.ra(this);
        });
    },
    /*
     * 功能：初始化资质要求
     * 参数：
     * 无
     */
    c:function(){
        $("#jqual_select").hgsSelect({
            id:"jqselect",//资质添加第一步id
            pid:"jqplace",
            pshow:true,
            sprov:true,
            single:true,
            sure:iniTStep1.rb
        });
        $("#qqual_select").hgsSelect({
            id:"qqselect",
            pid:"qqplace",
            pshow:true,
            sprov:true,
            single:true,
            sure:iniTStep1.rb
        });
    },
    /*
     * 功能：初始化职称要求
     * 参数：
     * id：绑定对象id
     * tid：插件id
     * func：回调方法
     */
    d:function(){
        $("#jtitle_selt").hgsSelect({
            type:"jobtitle",//选择框类型
            tid:"jobtitles",
            sure:iniTStep1.rc
        });
        $("#qtitle_selt").hgsSelect({
            type:"jobtitle",//选择框类型
            tid:"qjobtitles",
            sure:iniTStep1.rc
        });
    },
    /*
     * 功能：初始化资质要求验证
     * 参数：
     * 无
     */
    e:function(){
        //        $("#jqual_select").focus(function(){
        //            baseRender.b(this);
        //        }).blur(function(){
        //            iniTStep1.f(this,LANGUAGE.L0151);
        //        });
        $("#qpselect").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            iniTStep1.f(this,LANGUAGE.L0155);
        });
        $("#jpselect").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            iniTStep1.f(this,LANGUAGE.L0156);
        });
        $("#jupselect").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            iniTStep1.f(this,LANGUAGE.L0157);
        });
    },
    /*
     * 功能：资质类文本框验证
     * 参数：
     * 无
     */
    f:function(id,lan){
        var msg='';
        var bl=true;
        var str=$(id).val().replace(new RegExp(" ","g"),"");
        if(str==""){
            msg=lan;
            bl=false;
        }
        if(!bl){
            baseRender.a(id, msg, "error",0);
        }
        else{
            baseRender.b(id);
        }
    },
    /*
     * 功能：初始化地区要求、工作地点要求
     * 参数：
     * 无
     */
    g:function(){
        $("#jpselect").hgsSelect({
            type:"place",//选择框类型
            pid:"place",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:true,//是否只精确到省
            single:false,  //是否为单选
            sure:iniTStep1.rh
        });
        $("#qpselect").hgsSelect({
            type:"place",//选择框类型
            pid:"qplace",//省id
            pshow:true,//是否显示省
            lishow:true,//是否显示不限省份
            sprov:false,//是否只精确到省
            single:true,  //是否为单选
            sure:iniTStep1.rl
        });
    },
    /*
     * 功能：职位类别
     * 参数：
     * 无
     */
    h:function(){
        $("#qposition").hgsSlt({
            id:"jobslt",          //选择框id
            title:'职位',         //提示选择的是什么的类别
            tip:'至多可选择5个',  //右上侧提示语
            col_num:3,            //最大列数
            max_slt:5,            //最大选择个数
            single:false,         //是否为单选
            limit:true,           //是否显示不限
            sure:iniTStep1.ri   //确定提交选择结果的时候执行的方法
        });
    },
    /*
     * 功能：删除已选职位
     * 参数：
     * cur：绑定对象
     */
    i:function(cur){
        $("#slt_pos a").unbind("click").bind("click",function(){
            var that=$(cur);
            var cid=$(this).attr("cid");
            $(this).remove();
            var scids="",spids="",snames="",k=0;
            var cids=that.attr("cids").split(","),
            pids=that.attr("pids").split(","),
            names=that.attr("names").split(",");
            $.each(cids,function(i,o){
                if(o!=cid&&k>0){
                    scids+=","+o,
                    spids+=","+pids[i],
                    snames+=","+names[i];
                    k++;
                }else if(o!=cid&&k==0){
                    scids+=o,
                    spids+=pids[i],
                    snames+=names[i];
                    k++;
                }
            })
            $(cur).attr("cids",scids);
            $(cur).attr("pids",spids);
            $(cur).attr("names",snames);
        });
    },
    /*
     * 功能：保存并下一步
     * 参数：
     * 无
     */
    j:function(){
        baseController.BtnBind("div.boot_card div.steps div.btn12", "btn12", "btn12_hov", "btn12_hov");
        baseController.BtnBind("div.boot_card div.steps div.btn19", "btn19", "btn19_hov", "btn19_hov");
        $("#tstep1save").click(function(){
            var type=$("#jobtype input[name='intended']:checked").val();
            if(type=="1"){
                var sp=$(this).parents("div.stp_cover").find("div.tstep3 div.porf>span:eq(0)");
                sp.html("1、&nbsp;&nbsp;获得更多更精准的职位，立即完善全职简历!");                
                sp.parent().find("a.aws").attr("href",WEBROOT+"/resume/1").text("立即完善全职简历");
                iniTStep1.p();
            }else{
                iniTStep1.o();
            }
        });
    },
    /*
     * 功能：邮箱验证
     * 参数：
     * 无
     */
    k:function(){
        $("#juemail,#quemail").focus(function(){
            baseRender.a(this, LANGUAGE.L0001, "right" ,0);
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0002;
                b=false;
            }
            else if(!/\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(str)){
                msg=LANGUAGE.L0003;
                b=false;
            }
            if(!b){
                baseRender.a(this, msg, "error" ,0);
            }
            else{
                baseRender.b(this);
            }
        });
    },
    /*
     * 功能：手机验证
     * 参数：
     * 无
     */
    l:function(){
        $("#juqq,#quqq").focus(function(){
            baseRender.a(this,LANGUAGE.L0039, "right");
        }).blur(function(){
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            $(this).val(str);
            var msg="";
            var b=true;
            if(str==""){
                msg=LANGUAGE.L0041;
                b=false;
            }
            else{
                var x=baseRender.c(str);
                var y=baseRender.d(str);
                if(x==false&&y==false)
                {
                    msg=LANGUAGE.L0040;
                    b=false;
                }
                else{
                    b=true;
                }
            }
            if(!b){
                baseRender.a(this, msg, "error");
            }else{
                baseRender.b(this);
            }
        });  
    },
    /*
     * 功能：初始化邮箱或手机的填写
     * 参数：
     * 无
     */
    m:function(){
        var bl=$("#em_or_ph").val()=="2";
        if(bl){
            var that=$("div.boot_card div.stp_cover div.tstep1 table tr.hidden");
            that.next().addClass("hidden");
            that.removeClass("hidden");
            iniTStep1.k();
        }else{
            iniTStep1.l();
        }
    },
    /*
     * 功能：初始化资质和职称证的二选一验证
     * 参数：
     * 无
     */
    n:function(){
        $("#jqual_select").focus(function(){
            baseRender.b(this);
        }).blur(function(){
            var msg='';
            var bl=true;
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            var str1=$("#jtitle_selt").val().replace(new RegExp(" ","g"),"");
            if(str==""&&str1==""){
                msg=LANGUAGE.L0221;
                bl=false;
            }
            if(!bl){
                baseRender.a(this, msg, "error",0);
            }
            else{
                baseRender.b(this);
            }
        });
    },
    /*
     * 功能：完善兼职
     * 参数：
     * 无
     */
    o:function(){
        var ids="#jqual_select,#jpselect,#juqq,#juemail";
        $(ids).trigger("blur");
        if($("table.tb_all").find("div.tip").length==0){
            var ta=["",""];
            if($("#jtitle_selt").data("ids")){
                ta=$("#jtitle_selt").data("ids").split(",");
            }
            var slt=$("table.tb_all").find("input.qual_select");
            var a="",            
            b="",
            c="",
            d=ta[0],
            e=ta[1],
            f=$("#jthepay").val(),
            f1=$("#defpay1").val(),
            g=$("#jpselect").data("ids"),
            h=$("#juqq").val(),
            i=$("#juemail").val();
            if(f!=12){
                f1=0;
            }
            $.each(slt,function(i,o){
                var tmp="";
                var mid=$(o).data("mid");
                var zid=$(o).data("zid");
                if(!!mid){
                    tmp=mid;
                }
                else if(!!zid){
                    tmp=zid;
                }
                if(i>0&&tmp!=""){
                    a+=","+tmp;
                    b+=","+$(o).data("rid");
                    c+=","+$(o).data("pid");
                }
                else if(i==0&&tmp!=""){
                    a+=tmp;
                    b+=$(o).data("rid");
                    c+=$(o).data("pid");
                }
            });
            var that=iniTStep1;
            var bd=new bootdata();
            bd.PJResSave(a, b, c, d, e, f, f1, g, h, i, that.rj, that.rk);
        }
    },
    /*
     * 功能：完善全职
     * 参数：
     * 无
     */
    p:function(){
        var ids="#qpselect,#quqq,#quemail";
        var bl=true;
        if($("#slt_pos").children().length==0){
            $("#jtip").removeClass("hidden").addClass("error");
            bl=false;
        }
        $(ids).trigger("blur");
        if($("table.tb").not("table.tb_all").find("div.tip").length==0&&bl){
            var ta=["",""];
            if($("#qtitle_selt").data("ids")){
                ta=$("#qtitle_selt").data("ids").split(",");
            }
            var slt=$("table.tb").not("table.tb_all").find("input.qual_select");
            var a="",
            b="",
            c="",
            d=ta[0],
            e=ta[1],
            f=$("#qposition").attr("cids"),
            g=$("#thepay").val(),
            g1=$("#defpay").val(),
            h=$("#qpselect").data("prov"),
            i=$("#qpselect").data("city"),
            j=$("#quqq").val(),
            k=$("#quemail").val();
            $.each(slt,function(i,o){
                var tmp="";
                var mid=$(o).data("mid");
                var zid=$(o).data("zid");
                if(!!mid){
                    tmp=mid;
                }
                else if(!!zid){
                    tmp=zid;
                }
                if(i>0&&tmp!=""){
                    a+=","+tmp;
                    b+=","+$(o).data("rid");
                    c+=","+$(o).data("pid");
                }
                else if(i==0&&tmp!=""){
                    a+=tmp;
                    b+=$(o).data("rid");
                    c+=$(o).data("pid");
                }
            });
            var that=iniTStep1;
            var bd=new bootdata();
            bd.FJResSave(a, b, c, d, e, f, g, g1, h, i, j, k, that.rj, that.rk);
        }
    },
    /*
    * 功能：兼职全职切换效果
    * 参数：
    * obj:当前
    */
    ra:function(obj){
        var index=$(obj).attr("id").substring(8)-1;
        var tb=$(obj).parent().parent();
        tb.find("table").not(".hidden").addClass("hidden");
        tb.find("table:eq("+index+")").removeClass("hidden");
    },
    /*
     * 功能：添加资质显示添加结果
     * 参数：
     * r:插件返回结果
     */
    rb:function(r){
        var mname="";
        var that=r.obj;
        if(r.majname!=""){
            mname=" - "+r.majname;
        }
        var txt=r.cname+mname+" - "+r.regname+" - "+r.provname;
        that.val(txt);
        if(typeof(r.zid)=="undefined"){
            r.zid="";
        }
        that.data("mid",r.maj);
        that.data("zid",r.zid);
        that.data("rid",r.reg);
        that.data("pid",r.prov);
        baseRender.b(that);
        iniTStep1.rf(that);
    },
    /*
     * 功能：添加职称证显示添加结果
     * 参数：
     * r:插件返回结果
     */
    rc:function(r){
        var that=r.obj;
        var txt=r.jtlname+" - "+r.jtype+" - "+r.jtname;
        var ids=r.jtlid+","+r.jtid;
        that.val(txt);
        that.data("ids", ids);
        baseRender.b(that);
    },
    /*
    *功能：资质添加完成后绑定添加功能
    */
    rd:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var that=$(this).parent().find("input.qual_select");
            $(this).parent().find("span.blue").remove();
            $(this).parent().find("a.emptyqual").remove();
            $(this).remove();
            var html=that.parent().parent().html();
            var txt=that.parent().find("input.qual_select");
            var id=txt.attr("id");
            var val=txt.val();
            var num=id.substring(12);
            var tp=id.substring(0,1);
            num=parseInt((num==""?0:num),10)+1;
            var nid=id.substring(0,12)+num;
            html=html.replace(id,nid).replace(val,"");
            html="<tr>"+html+"</tr>";
            that.parent().parent().after(html);
            var par=$("#"+nid);
            if(num==1){
                par.after(COMMONTEMP.T0016);
            }
            par.parent().prev().find("span.red").remove();
            par.hgsSelect({
                id:tp+"qselect"+num,
                pid:tp+"qplace"+num,
                pshow:true,
                sprov:true,
                single:true,
                sure:iniTStep1.rb
            });
            iniTStep1.re(par.parent().find("a.delqual"));
            par.trigger("click");
        });
    },
    /*
    *功能：资质添加完成后绑定删除功能
    */
    re:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var slt=$(this).parent().parent().parent();
            var len=slt.find("input.qual_select").length-1;
            var lid=slt.find("input.qual_select:eq("+len+")").attr("id");
            var cid=$(this).parent().find("input.qual_select").attr("id");
            if(lid==cid){
                var com=COMMONTEMP;
                var html=com.T0015;
                var index=$(this).parent().parent().parent().find("input.qual_select").length;
                if(index>2){
                    html="<span class='blue'>| </span>"+html;
                }else if(index==2){
                    html=com.T0029+"<span class='blue'> | </span>"+html;
                }
                var cslt=slt.find("input.qual_select:eq("+(index-2)+")").parent();
                cslt.append(html);
                iniTStep1.rd(cslt.find("a.addqual"));
                if(index==2){
                    iniTStep1.rg(cslt.find("a.emptyqual"));
                }
            }
            var sid="#"+cid.substring(0,1)+"qselect"+cid.substring(12);
            var pid="#"+cid.substring(0,1)+"qplace"+cid.substring(12);
            $(sid).remove();
            $(pid).remove();
            $(this).parent().parent().remove();
        });
    },
    /*
    *功能：资质添加完成后显示添加或删除
    *参数：
    *obj
    */
    rf:function(obj){
        var that=$(obj);
        var len=that.parent().parent().parent().find("input.qual_select").length;
        var ish=that.parent().parent().parent().find("a.addqual").length;
        var com=COMMONTEMP;
        if(len==1&&ish==0){
            that.after(com.T0029+"<span class='blue'> | </span>"+com.T0015);
            this.rd(that.parent().find("a.addqual"));
            this.rg(that.parent().find("a.emptyqual"));
        }
        else if(len>1&&ish==0){
            that.parent().append("<span class='blue'>| </span>"+com.T0015);
            this.rd(that.parent().find("a.addqual"));
        }
    },
    /*
    * 功能：清空资质要求
    * 参数：
    * obj：绑定对象
    */
    rg:function(obj){
        $(obj).unbind("click").bind("click",function(){
            var par=$(this).parent().find("input[class*='qual_select']");
            par.val("");
            par.data("mid","");
            par.data("zid","");
            par.data("rid","");
            par.data("count","");
            par.parent().find(".blue").remove();
        });
    },
    /*
     * 功能：添加地区显示添加结果
     * 参数：
     * r:插件返回结果
     */
    rh:function(r){
        var txt="";
        var ids="";
        var that=r.obj;
        if(r.nolmt){
            txt=r.noname;
            ids="0";
        }
        else{
            txt=r.provname;
            ids=r.prov;
        }
        that.val(txt);
        baseRender.b(that);
        that.data("ids",ids);
    },
    /*
     * 功能：全职添加招聘职位
     * 参数：
     * r:插件返回结果
     */
    ri:function(r){
        $("#slt_pos").html("").append(r.jhtml);
        if(!$("#jtip").hasClass("hidden")){
            $("#jtip").addClass("hidden");
        }
        iniTStep1.i(r.obj);
    },
    /*
     * 功能：保存成功
     * 参数：
     * 无
     */
    rj:function(data){
        $.hgsBoot.defaults.nextStep($("#tstep1save").parents("div.tstep1"),$.hgsBoot.defaults.inifuncs[1]);
    },
    /*
     * 功能：保存失败
     * 参数：
     * 无
     */
    rk:function(data){
        alert(data.data);
    },
    /*
     * 功能：全职添加地区显示添加结果
     * 参数：
     * r:插件返回结果
     */
    rl:function(r){
        var txt="";
        var ids=r.prov;
        var that=r.obj;
        if(r.nolmt){
            txt=r.noname;
            ids="0";
        }
        else{
            txt=r.provname+" - "+r.cityname;
        }
        that.val(txt);
        baseRender.b(that);
        that.data("prov",ids);
        that.data("city",r.city);
    },
    /*
     * 功能：初始化期望待遇验证
     * 参数：
     * 无
     */
    s:function(){
        $("#defpay,#defpay1").focus(function(){
            baseRender.a(this, LANGUAGE.L0163, "right",30);
        }).blur(function(){
            var msg='';
            var bl=true;
            var str=$(this).val().replace(new RegExp(" ","g"),"");
            if(str==""){
                msg=LANGUAGE.L0164;
                bl=false;
            }
            else if(!/(^(\-?)\d{1,5}\.\d{1,2}$)|(^(\-?)\d{1,5}$)/.test(str)){
                msg=LANGUAGE.L0248;
                bl=false;
            }
            else if(parseFloat(str,10)<0){
                msg=LANGUAGE.L0166;
                bl=false;
            }
            if(bl){
                baseRender.ai(this,50);
            }
            else{
                baseRender.a(this, msg, "error",30);
            }
        });
    },
    /*
     * 功能：期望待遇事件绑定
     * 参数：
     * data：后台返回数据
     */
    t:function(){
        $("#jthepay,#thepay").bind("change",function(){            
            if($(this).val()==12){
                $(this).next("input.defpay").removeClass("hidden");
            }
            else{
                $(this).nextAll("div.tip").remove();
                $(this).next("input.defpay").addClass("hidden").removeClass("red_border");
                $(this).next("input.defpay").val('')
            }
        })
    }
};
/*
*人才引导流程第二步
*/
var iniTStep2={
    /* 功能: 初始化第一步
    * 参数：无
    * 说明：无
    */
    a:function(){
        var that=iniTStep2;
        that.b();
        that.c();
//        that.d();
    },
    /*
     * 头像控件绑定
     */
    b:function(){
        baseController.BtnBind("div.tstep2 table.tb_info tr td div.btn9", "btn9", "btn9_hov", "btn9_hov");
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
     * 功能：保存并下一步
     * 参数：
     * 无
     */
    c:function(){
        $("#tstep2save").click(function(){
            var a=$("input[name='photo']").val(),
                b=$("#x").val(),
                c=$("#y").val(),
                d=$("#w").val(),
                e=$("#h").val();
            var that=iniTStep2;
            var bd=new bootdata();
            bd.PhoSave(a, b, c, d, e, that.ra, that.rb);
        });
    },
    /*
     * 功能：跳过
     * 参数：
     * 无
     */
//    d:function(){
//        $("#tstep2save").parent().parent().next().click(function(){
//            iniTStep2.ra();
//        });
//    },
    /*
     * 功能：保存成功
     * 参数：
     * 无
     */
    ra:function(data){
        $.hgsBoot.defaults.nextStep($("#tstep2save").parents("div.tstep2"),$.hgsBoot.defaults.inifuncs[2]);
    },
    /*
     * 功能：保存失败
     * 参数：
     * 无
     */
    rb:function(data){
        alert(data.data);
    }
};
/*
*人才引导流程第三步 暂无
*/
(function($){
    $.extend({
        hgsBoot: function(options){
            var boot=new bootdata();
            var defaults={
                id:"jobboot",          //引导流程对话框id
                titles:["第一步:&nbsp;&nbsp;求职意向","第二步:&nbsp;&nbsp;上传头像","第三步:&nbsp;&nbsp;完成"],//每一步的标题
                inifuncs:[iniTStep1.a,iniTStep2.a,null],            //每一步的初始化方法名
                stepcount:3,                                        //总步骤数
                curstep:0                                           //当前是第几步
            };
            defaults.stepcount=defaults.titles.length;
            var opts = $.extend(defaults, options);
            $.extend($.hgsBoot.defaults,defaults);
            //var cur=this;
            var hboot={
                /******************* 共用方法 *******************/
                /*
                 * 初始化选择框
                 */
                _iniBoot:function(){
                    if(!$.hgsBoot.defaults.stopevent){
                        if(this._genBoot()){
                            var that=opts.inifuncs[0];
                            if(that!=null){
                                that();
                            }
                        }
                    }
                },
                /*
                 * 生成选择框
                 */
                _genBoot:function(){
                    var def=opts;
                    var st=boot;
                    var that=$("#"+def.id);
                    if(that.length==0){
                        var html=st.boot_content;
                        html=html.replace("{id}",def.id)
                        .replace("{step}",st.TStep1+st.TStep2+st.TStep3);
                        $("body").append(html);
                        that=$("#"+def.id);
                        var h=that[0].clientHeight;
                        that.css("height",$('body')[0].scrollHeight);
                        that.find("div.select_bg").css("top", h/2+"px");
                        hboot._alignCenter(that.find("div.select_bg"));
                        return true;
                    }else{
                        that.fadeIn(30);
                    }
                    return false;
                },
                 /*
                 * 垂直居中设置
                 * obj:居中设置对话框
                 */
                _alignCenter:function(obj){      
                    var p,top;
                    p=obj.attr("style").match(/[0-9]{1,}/)[0]*1;
                    $(window).scroll(function(){ 
                        top=p+$(window).scrollTop();                                                
                        setTimeout(function(){
                            obj.animate({
                            "top":top+"px"
                            },300);},100);                        
                    })
                }                
            };
            hboot._iniBoot();
        }
    });
    $.hgsBoot.defaults={
        stopevent:false,     //是否阻止文本框点击事件
        nextStep:function(par,func){//par:当前模块的父容器
            var that=$(par);
            if(that.next().length>0){
                that.fadeOut(function(){
                    var f=func;
                    if(f!=null){
                        f();
                    }
                    var index=that.index();
                    var tpar=that.parent().prev();
                    tpar.find("span.arow:eq("+index+")").removeClass("arow1").addClass("arow2");
                    tpar.find("span.tle:eq("+(index+1)+")").addClass("cur_span");
                    tpar.find("span.arow:eq("+(index+1)+")").addClass("arow1");
                    that.next().fadeIn();
                }); 
            }else{
                that.parents("div.boot_card").fadeOut();
            }
        }
    };
})(jQuery);
$.hgsBoot({});