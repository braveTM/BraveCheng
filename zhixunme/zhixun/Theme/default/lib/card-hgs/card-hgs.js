(function($){
    $.extend({
        hgsGenCardCover:function(options){
            var defaults={
                id:"",             //设置选择框父容器id
                url:"",             //设置按钮后台访问路径
                btnfunc:$.hgsBtnBind//按钮绑定事件
            };
            var opts = $.extend(defaults, options);
            if($("#"+opts.id).length==0){
                var tmp='<div class="cards_cover res_card" id="'+opts.id+'"><div class="card_header"><div class="c_h_cont"><div class="c_h_l lf"><a href="javascript:;" class="card_close" title="关闭"></a><a href="javascript:;" class="card_close closetxt" title="关闭">返回</a></div><div class="c_h_r rf"><span class="gray des">亲, 勾选卡片左侧为蓝色,可多选投递哦!</span><div class="btn_cont"><div class="btn_common btn8"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white" id="card_sendRes">立即投递简历</a></div></div></div><p class="clr"></p></div></div><div class="select_bg" id="card_data"></div></div>';
                $("body").append(tmp);
                var par=$("#"+opts.id);
                par.find("a.card_close").unbind("click").bind("click",function(){
                    par.fadeOut();
                });
                par.find("div.c_h_l span").unbind("click").bind("click",function(){
                    $(this).parent().find("span").removeClass("red");
                    $(this).addClass("red");
                });
                opts.btnfunc(par.find("div.btn8"),opts.url);
            }
        },
        hgsBtnBind:function(obj,u){
            baseController.BtnUnbind(obj);
            baseController.BtnBind(obj, "btn8"," btn8_hov", "btn8_click");
            $("#card_sendRes").unbind("click").click(function(){
                paytipController.ASendResumesTip($.hgsASendResumes,[this,u],this);
            });
        },
        hgsASendResumes:function(parm){
            var obj=parm[0],
            u=parm[1];
            var jid=$(obj).data("jid");
            var cards=$("div#card_data div.card_col div.card div.middle a.rightpic");
            var rids='';
            $.each(cards,function(i,o){
                if($(o).hasClass("hovered")){
                    if(rids!=""){
                        rids+=","+$(o).attr("rid");
                    }else{
                        rids+=$(o).attr("rid");
                    }
                }
            });
            var s={
                url:u,
                params:"job_id="+jid+"&&resume_ids="+rids,
                sucrender:$.hgsSendSuc,
                failrender:$.hgsSendFail
            };
            HGS.Base.HAjax(s);
        },
        hgsCheckBind:function(){
            $("div.cards_cover a.rightpic").unbind("click").bind("click",function(){
                if($(this).hasClass("hovered")){
                    $(this).removeClass("hovered");
                }else{
                    $(this).addClass("hovered");
                }
            });
        },
        hgsSendFail:function(data){
            if(data.data=="YEBZ0001"){
                paytipController.NoScore();
            }else{
                alert(data.data);
            }
        },
        hgsSendSuc:function(data){
            alert("投递成功");
            $("div.cards_cover").fadeOut(200);
        }
    });
    $.extend({
        hgsGenJobCardCover:function(options){
            var defaults={
                id:"",             //设置选择框父容器id
                url:"",             //设置按钮后台访问路径
                btnfunc:$.hgsJobBtnBind//按钮绑定事件
            };
            var opts = $.extend(defaults, options);
            if($("#"+opts.id).length==0){
                var tmp='<div class="cards_cover job_card" id="'+opts.id+'"><div class="card_header"><div class="c_h_cont"><div class="c_h_l lf"><a href="javascript:;" class="card_close" title="关闭"></a><a href="javascript:;" class="card_close closetxt" title="关闭">返回</a><span class="gray">请选择职位，以便邀请简历至合适的职位</span></div><div class="c_h_r rf"><span class="gray">亲, 勾选卡片左侧为蓝色,可多选投递哦!</span><div class="btn_cont"><div class="btn_common btn8"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white" id="card_sendtojob">立即邀请简历</a></div></div></div><p class="clr"></p></div></div><div class="select_bg" id="card_jobdata"></div></div>';
                $("body").append(tmp);
                var par=$("#"+opts.id);
                par.find("a.card_close").unbind("click").bind("click",function(){
                    par.fadeOut();
                });
                opts.btnfunc(par.find("div.btn8"),opts.url);
            }
        },
        hgsJobBtnBind:function(obj,u){
            baseController.BtnBind(obj, "btn8"," btn8_hov", "btn8_click");
            $("#card_sendtojob").unbind("click").bind("click",function(){
                paytipController.VisitResumesTip($.hgsVisitResume,[this,u],this);
            });
        },
        hgsVisitResume:function(parm){
            var obj=parm[0],
            u=parm[1];
            var rid=$(obj).data("rid");
            var cards=$("div#card_jobdata div.card_col div.card div.middle a.rightpic");
            var jid='';
            $.each(cards,function(i,o){
                if($(o).hasClass("hovered")){
                    jid=$(o).attr("jid");
                    return false;
                }
            });
            var s={
                url:u,
                params:"jid="+jid+"&&rid="+rid,
                sucrender:$.hgsJobSendSuc,
                failrender:$.hgsSendFail
            };
            HGS.Base.HAjax(s);
        },
        hgsJobSendSuc:function(data){
            alert("邀请简历成功");
            $("div.cards_cover").fadeOut(200);
        },
        hgsSCheckBind:function(){
            $("div.cards_cover a.rightpic").unbind("click").bind("click",function(){
                $("div.cards_cover a.rightpic").removeClass("hovered");
                if($(this).hasClass("hovered")){
                    $(this).removeClass("hovered");
                }else{
                    $(this).addClass("hovered");
                }
            });
        }
    });
    $.extend($.fn,{
        hgsShowCard: function(options){
            var defaults={
                accurl:'',//按钮访问路径
                dataurl:"",//获取职位数据的路径
                getcat:null,//获取职位类型的方法 参数当前点击a标签
                getjid:null,//获取职位id的方法 参数为当前点击a标签
                cat:""//当前职位类型
            };
            var opts = $.extend(defaults, options);
            var cur=this;
            var card={
                _showCard:function(){
                    if($("div.res_card").length==0){
                        $.hgsGenCardCover({
                            id:"card_defualt",
                            url:opts.accurl
                        });
                    }
                }
            };
            $(cur).unbind("click").bind("click",function(){
                card._showCard();
                var jid=opts.getjid(this);
                $("#card_sendRes").data("jid",jid);
                var cat=opts.getcat(this);
                opts.cat=cat;
                cur.hgsGetCards(cat,opts.dataurl);
            });
        },
        hgsGenCards:function(data){
            var w=document.body.clientWidth;
            var col='',num=2,dt=data.data,len=dt.length;
            var inum=0;
            if(w<1475){
                col='<div class="card_col card_col1 hgstemp" id="card_col1"></div><div class="card_col card_col2 hgstemp" id="card_col2"></div>';
            }
            else{
                col='<div class="card_col card_col1 hgstemp" id="card_col1"></div><div class="card_col card_col2 hgstemp" id="card_col2"></div><div class="card_col card_col3 hgstemp" id="card_col3"></div>';
                num=3;
            }
            $("#card_data").html(col+"<p class='clr'></p>");
            $("#card_data").css("width",(num*495-10)+"px");
            inum=len/num;
            var mytmp=[];
            mytmp[0]='<div class="card"><p class="top"></p><div class="middle"><a href="javascript:;" class="rightpic" rid="{resume_id}"></a><em class="identpic {ident}"></em><p><a href="javascript:;" class="blue">{name}</a><span class="gray"> (简历委托于 {delegate_datetime})</span></p><p><span class="gray">期望注册地: </span><span>{register_place}</span></p>{cert}</div><p class="bot"></p></div>';
            mytmp[1]='<div class="card"><p class="top"></p><div class="middle"><a href="javascript:;" class="rightpic" rid="{resume_id}"></a><em class="identpic {ident}"></em><p><a href="javascript:;" class="blue">{name}</a><span class="gray"> (简历委托于 {delegate_datetime})</span></p><p><span class="gray">求职岗位: </span><span>{job_name}</span></p><p><span class="gray">期望工作地点: </span><span>{job_addr}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray">工作年限: </span><span>{work_exp}</span></p>{cert}</div><p class="bot"></p></div>';
            var data1=[],data2=[],data3=[],a=0,b=0,c=0;
            $.each(dt,function(i,o){
                $("div.res_card").fadeIn(200);
                var certs='';
                var type=o.job_category;
                var own=o.type;
                if(type=="1"){
                    o.temp=1;
                }
                else{
                    o.temp=0;
                }
                if(typeof(o.RC_list)=="undefined"){
                    o.RC_list=[];
                }
                $.each(o.RC_list,function(k,item){
                    certs+='<p>'+item+'</p>';
                });
                o.cert=certs;
                if(own==2){
                    o.ident="person";
                }else{
                    o.ident="";
                }
                if(i<inum){
                    data1[a]=o;
                    a++;
                }
                else if(i<inum*2){
                    data2[b]=o;
                    b++;
                }
                else if(i<inum*3){
                    data3[c]=o;
                    c++;
                }
            });
            var varr=[];//兼职 全职
            varr[0]=["name","delegate_datetime","cert","register_place","resume_id","ident"];
            varr[1]=["name","delegate_datetime","cert","job_addr","resume_id","work_exp","job_name","ident"];
            HGS.Base.GenMTemp("card_col1",varr,data1,mytmp);
            HGS.Base.GenMTemp("card_col2",varr,data2,mytmp);
            HGS.Base.GenMTemp("card_col3",varr,data3,mytmp);
            $.hgsCheckBind();
            $("div#card_data div.card_col div.card div.middle a.rightpic:eq(0)").addClass("hovered");
        },
        hgsGetCards:function(cat,u){
            var cu=this;
            var s={
                url:u,
                params:"page=1&&size=20&&job_category="+cat,
                sucrender:cu.hgsGenCards,
                failrender:cu.hgsGetCardsFail
            };
            HGS.Base.HAjax(s);
        },
        hgsGetCardsFail:function(data){
            alert("对不起,您暂时没有可以投递的简历");
        }
    });
    /*************************职位卡片列表*************************/
    $.extend($.fn,{
        hgsShowJobCard: function(options){
            var defaults={
                accurl:'',//按钮访问路径
                dataurl:"",//获取职位数据的路径
                getcat:null,//获取职位类型的方法 参数当前点击a标签
                getrid:null,//获取职位id的方法 参数为当前点击a标签
                cat:""//当前职位类型
            };
            var opts = $.extend(defaults, options);
            var cur=this;
            var card={
                _showCard:function(){
                    if($("div.job_card").length==0){
                        $.hgsGenJobCardCover({
                            id:"card_jobs",
                            url:opts.accurl
                        });
                    }
                }
            };
            $(cur).unbind("click").bind("click",function(){
                card._showCard();
                $("#card_jobs div.card_header div.c_h_r>span.gray").html("亲, 勾选卡片左侧为蓝色,职位选择为单选哦!");
                var rid=opts.getrid(this);
                $("#card_sendtojob").data("rid",rid);
                var cat=opts.getcat(this);
                opts.cat=cat;
                cur.hgsGetJobCards(cat,opts.dataurl);
            });
        },
        hgsGenJobCards:function(data){
            var w=document.body.clientWidth;
            var col='',num=2,dt=data.data,len=dt.length;
            var inum=0;
            if(w<1475){
                col='<div class="card_col card_col1 hgstemp" id="jcard_col1"></div><div class="card_col card_col2 hgstemp" id="jcard_col2"></div>';
            }
            else{
                col='<div class="card_col card_col1 hgstemp" id="jcard_col1"></div><div class="card_col card_col2 hgstemp" id="jcard_col2"></div><div class="card_col card_col3 hgstemp" id="jcard_col3"></div>';
                num=3;
            }
            $("#card_jobdata").html(col+"<p class='clr'></p>");
            $("#card_jobdata").css("width",(num*495-10)+"px");
            inum=len/num;
            var mytmp=[];//兼职 全职
            mytmp[0]='<div class="card"><p class="top"></p><div class="middle"><a href="javascript:;" class="rightpic" jid="{id}"></a><p><span class="red">[兼职] </span><a href="javascript:;" class="blue">{title}</a></p><p><span class="gray">发布时间: {date}</span></p><p><span class="gray">证书使用地: </span><span>{location}</span></p><p><span class="gray">地区要求: </span><span>{place}</span></p>{cert}</div><p class="bot"></p></div>';
            mytmp[1]='<div class="card"><p class="top"></p><div class="middle"><a href="javascript:;" class="rightpic" jid="{id}"></a><p><span class="red">[全职] </span><a href="javascript:;" class="blue">{title}</a></p><p><span class="gray">发布时间: {date}</span></p><p><span class="gray">招聘岗位: </span><span>{name}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray">招聘人数: </span><span>{count}</span></p><p><span class="gray">工作地点: </span><span>{location}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="gray">学历要求: </span><span>{degree}</span></p>{cert}</div><p class="bot"></p></div>';
            var data1=[],data2=[],data3=[],a=0,b=0,c=0;
            $.each(dt,function(i,o){
                var certs='';
                var type=o.category;
                if(type=="1"){
                    o.temp=1;
                }
                else{
                    o.temp=0;
                }
                if(typeof(o.cert)=="undefined"){
                    o.cert=[];
                }
                $.each(o.cert,function(k,item){
                    certs+='<p>'+item+'</p>';
                });
                o.cert=certs;
                if(i<inum){
                    data1[a]=o;
                    a++;
                }
                else if(i<inum*2){
                    data2[b]=o;
                    b++;
                }
                else if(i<inum*3){
                    data3[c]=o;
                    c++;
                }
            });
            var varr=[];//兼职 全职
            varr[0]=["company","date","cert","location","id","place","title"];
            varr[1]=["company","date","cert","degree","location","count","name","place","id","title"];
            HGS.Base.GenMTemp("jcard_col1",varr,data1,mytmp);
            HGS.Base.GenMTemp("jcard_col2",varr,data2,mytmp);
            HGS.Base.GenMTemp("jcard_col3",varr,data3,mytmp);
            $.hgsSCheckBind();
            $("div#card_jobdata div.card_col div.card div.middle a.rightpic:eq(0)").addClass("hovered");
            $("div.job_card").fadeIn(200);
        },
        hgsGetJobCards:function(cat,u){
            var cu=this;
            var s={
                url:u,
                params:"page=1&&size=20&&status=1&&type="+cat,
                sucrender:cu.hgsGenJobCards,
                failrender:cu.hgsGetJobFail
            };
            HGS.Base.HAjax(s);
        },
        hgsGetJobFail:function(data){
            alert("对不起,您暂时没有相关职位可以对简历进行邀请");
        }
    });
})(jQuery);