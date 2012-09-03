/* 
* CRM客户管理页,添加、编辑交易记录 交互框渲染
* 
*/
(function($){
$.extend({
    /*
    *功能:生成对话框模板
    *参数:
    *options
    */
    CreatCardTemp:function(options){             
        var defaults={};
        var opts = $.extend(defaults,options);
        if($("#"+opts.id).length==0){
            var tmp='<div class="cards_cover" id="'+opts.id+'">'
            +'<div class="cardsbody"></div>'
            +'</div>';
            $("body").append(tmp);
            var msgcard='<div class="bc_item">'
            +'<div class="top"><p class="lf"></p><p class="rf"></p></div>'
            +'<div class="middle"><div class="mbg">';
            var msgthead='<div class="msghead"><span>目前阶段:</span><span class="nowstage">'
            +'<select id="cateNow"><option value="1">潜在客户</option><option value="2">正在合作</option><option value="3">失效客户</option><option value="4">其他</option></select>'
            +'<select id="proNow" class="prog">'
            +'<option value="1">已沟通</option>'
            +'<option value="2">已报价</option>'
            +'<option value="3">已做方案</option>'
            +'<option value="4">已签合同</option>'
            +'<option value="5">已成交</option>'
            +'<option value="6">谈判中</option>'
            +'<option value="7">已发合同</option>'
            +'<option value="8">售后完善</option>'
            +'<option value="9">后期维护</option>'
            +'<option value="10">其他</option></select></span></td></div>';               
            var msgt='<table><tbody><tr><td class="ltop"><span>交易记录:</span></td><td rowspan="5"><textarea id="editext" name="recoder"></textarea></td></tr>'
            +'</tbody></table><a class="card_close"></a><div class="al_bt"><span class="red lf"></span>'
            +'<div class="msgbutton"><div class="btn_common btn3"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn blue card_sub" datacont="" id="sendmsgtozx">确&nbsp;&nbsp;定</a></div></div></div></div>'
            +'</div><div class="bot"><p class="lf"></p><p class="rf"></p>';                
            var par=$("#"+opts.id);                 
            msgcard+=msgthead+msgt;
            par.find("div.cardsbody").append(msgcard);                     
            $.RenderCardData(opts);
            par.fadeIn();                
            $.BindCardSub(opts);                 //为按键绑定事件   
            baseController.BtnBind("#editCard div.btn_common", "btn3", "btn3_hov", "btn3_click");
        }
    },
    /*
    *功能:渲染表单数据
    *参数:
    *note
    */
    RenderCardData:function(obj){                      
        var eprobj=$("#proNow"); 
        var cate=$("#cateNow");             
        var cateid=obj.tosever.cate_id;
        var proid=obj.tosever.pro_id;
        var notes=$("#editext");
        notes.val(obj.tosever.notes);        
        eprobj.addClass("hidden");                  
        $("#proNow option").eq(proid-1).attr('selected', 'true');    
        if(obj.tosever.cate_id==2){
            eprobj.removeClass("hidden");                                
        }                       
        cate.change(function(){
            if($(this).val()==2)
                eprobj.removeClass("hidden");                 
            else
                eprobj.addClass("hidden");
        });            
        $("#cateNow option").eq(cateid-1).attr('selected', 'true');
        $('#cateNow').attr("disabled","disabled")
        $('#proNow').attr("disabled","disabled")
        if(obj.me.hasClass("ad_rd")){           //添加记录开启select                                
            $('#cateNow').removeAttr("disabled");
            $('#proNow').removeAttr("disabled");
            notes.val('');                       
        }
        else
            notes.val($.trim(obj.tosever.notes));        
    },       
    /*
    *功能:提交按键绑定事件
    *参数:
    *obj:         
    **/
    BindCardSub:function(obj){                
        var card=$("#"+obj.id);
        var pro=$("#proNow"),cate=$("#cateNow");            
        var pro_id;
        if(obj.me.hasClass("ad_rd")){
            $("#editext").focus();
        }
        card.find("a.card_close").unbind("click").bind("click",function(){
            card.fadeOut(200,function(){
                obj.me.removeClass('c');
                $("#editCard").remove();
            });                
        });            
        card.find("a.card_sub").unbind("click").bind("click",function(){                
            if(cate.val()!=2)
                pro_id=0;                
            else
                pro_id=pro.val();
            var check=$(this).CheckCardInput();//表单验证
            if(check){
                var pram={                
                    'cate_id':cate.val(),
                    'pro_id':pro_id,
                    'notes':$("#editext").val()               
                };              
                $.extend(obj.tosever,pram);
                $(this).hEditRecodeCards(obj);
            }
        });
    }
});
$.extend($.fn,{
    GetManageData: function(pramfun){     
        var cur=this;          
        $(cur).unbind("click").bind("click",function(){         //编辑按键绑定click 显示对话框后ajax 
            var prams=pramfun($(this));           
            var me=$(this);                           
            $(this).addClass("c");                                
            $.CreatCardTemp(prams);           
        });
    },
    /*
*功能:提交修改记录
*参数:
* cate_id:阶段ID
* pro_id:进度ID
* note:备注
* h_e_id:人才/企业ID
* human:是人才为ture,是企业为false
**/
    hEditRecodeCards:function(obj){  
        var params='';
        var prams='';
        $.each(obj.tosever,function(i,o){                 
            prams+='&'+i+'='+o;            
        });              
        prams=prams.substr(1);
        prams=prams.replace('&url='+obj.tosever.url,'');                    
        var cu=this;        
        var s={
            "url":obj.tosever.url,
            'params':prams,
            'sucrender':obj.sc,
            'failrender':cu.SendRecoderFail
        };       
        HGS.Base.HAjax(s);
    },        
    SendRecoderSuc:function(){ //提交成功后数据渲染              
        var msgnote=$("#msgnote");
        msgnote.html("成功修改数据!");
        $("#editCard").fadeOut(200,function(){
            msgnote.html('');
            $("#hr_list td.last a.ad_rd.c").removeClass('c');
            $(this).remove();
        });           
    },
    SendRecoderFail:function(data){            
        alert("对不起,暂时不能编辑数据!");
    },
/*
*功能:提交表单验证
*参数:
*
**/
    CheckCardInput:function(){
        var pass=null;
        var errormsg= $(this).parent().parent().prev();
        var note=$.trim($("#editext").val());
        //note.change(){}/
        if(!note){
            errormsg.html('交易记录不能为空!');
            pass=0;
        }
        else
            pass=1;
        return pass;           
    }
  })    
})(jQuery);
