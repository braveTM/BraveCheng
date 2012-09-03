(function($){
    $.extend({
        hgsGenBCardCover:function(id){
            if($("#"+id).length==0){
                var tmp='<div class="cards_cover prom_card" id="'+id+'"><div class="card_header"><div class="c_h_cont"><div class="c_h_l lf"><a href="javascript:;" class="card_close" title="关闭"></a><a href="javascript:;" class="card_close closetxt" title="关闭">返回</a></div><div class="c_h_r rf"><span class="gray">步骤: 1、选择合适的推广方式， 2、选购周数, 3、点击“立即推广”即可!</span></div><p class="clr"></p></div></div><div class="select_bg bcard_data"></div></div>';
                $("body").append(tmp);
                var par=$("#"+id);
                par.find("a.card_close").unbind("click").bind("click",function(){
                    par.fadeOut();
                });
            }
        },
        hgsParOptions:{}
    });
    $.extend($.fn,{
        hgsShowBCard: function(options){
            var defaults={
                id:"",
                url:"",             //按钮点击访问路径
                durl:"",            //获取插件初始化数据的路径
                getId:null,         //获取推广信息的编号
                type:"",             //信息类型（1：职位，2：简历，3：任务）
                cback:null          //推广成功后的回调函数
            };
            var cur=this;
            var opts = $.extend(defaults, options);
            var card={
                _showCard:function(){
                    if($("div#"+opts.id).length==0){
                        $.hgsGenBCardCover(opts.id);
                    }
                }
            };
            $(cur).unbind("click").bind("click",function(){
                $.hgsParOptions=opts;
                card._showCard();
                var id=opts.getId(this);
                $.hgsParOptions.proid=id;
                $.hgsParOptions.cur=this;
                cur.hgsGetBCards(opts.durl,id);
            });
        },
        hgsGenBCardsCnt:function(id,dt1,dt2){
            var par= $(id);            
            var opts1=par.hgsGenBOptions(dt1),
            opts2=par.hgsGenBOptions(dt2);                     
            var tmp='<div class="bc_item"><div class="top"><p class="lf"></p><p class="rf"></p></div><div class="middle"><div class="mbg"><div class="title"><span>推广方式</span><em>1</em><span class="grayer"> - 个人首页推荐</span></div><div class="lf prompic prompic1"></div><div class="lf promoper promoper1"><p class="baseintro">说明：您推广的职位、简历信息将由系统精准推荐到人才、企业、猎头的个人首页。</p><p class="prompay prompay1">费用：<em class="red">\u00A5</em><span class="red">'+dt1.price+'</span>/周</p><p class="getdays">请选择购买周数：<select class="pday">'+opts1+'</select> 周</p><p class="leftcount">已有 <span class="lftcount">'+(parseInt(dt1.m_count,10)-parseInt(dt1.s_count,10))+'</span> 人购买此服务,现剩余 <span class="red">'+dt1.s_count+'</span> 个名额</p><p class="nosell">购买名额已满,您暂不能购买,明天再来看看吧</p><p class="hasget">您已购买该服务,到期时间为 <span class="red">'+dt1.date+'</span></p><div class="probtn_cont"><div class="btn_common btn5"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white promotenow" st="'+dt1.id+'">立即推广</a></div></div></div><p class="clr"></p></div></div><div class="bot"><p class="lf"></p><p class="rf"></p></div></div>';
            tmp+='<div class="bc_item"><div class="top"><p class="lf"></p><p class="rf"></p></div><div class="middle"><div class="mbg"><div class="title"><span>推广方式</span><em>2</em><span class="grayer"> - 职讯推荐列表优先排序</span></div><div class="lf prompic prompic2"></div><div class="lf promoper promoper2"><p class="baseintro">说明：您推广的职位、简历信息将由系统精准推送至人才、企业、猎头的"推荐职位"、"推荐简历"列表中，并享优先排序权。</p><p class="prompay prompay2">费用：<em class="red">\u00A5</em><span class="red">'+dt2.price+'</span>/周</p><p class="getdays">请选择购买周数：<select class="pday1">'+opts2+'</select> 周</p><p class="leftcount">已有 <span class="lftcount">'+(parseInt(dt2.m_count,10)-parseInt(dt2.s_count,10))+'</span> 人购买此服务,现剩余 <span class="red">'+dt2.s_count+'</span> 个名额</p><p class="nosell">购买名额已满,您暂不能购买,明天再来看看吧</p><p class="hasget">您已购买该服务,到期时间为 <span class="red">'+dt2.date+'</span></p><div class="probtn_cont"><div class="btn_common btn5"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white zxpromotenow" st="'+dt2.id+'">立即推广</a></div></div></div><p class="clr"></p></div></div><div class="bot"><p class="lf"></p><p class="rf"></p></div></div>';            
            if(id=='#compromipostjob'){//企业模板
             tmp='<div class="bc_item"><div class="top"><p class="lf"></p><p class="rf"></p></div><div class="middle"><div class="mbg"><div class="title"><span>推广方式</span><em>1</em><span class="grayer"> - 个人首页推荐</span></div><div class="lf prompic prompic1"></div><div class="lf promoper promoper1"><p class="baseintro">说明：您推广的职位信息将由系统推荐到人才、猎头的个人首页。</p><p class="prompay prompay1">费用：<em class="red">\u00A5</em><span class="red">'+dt1.price+'</span>/周</p><p class="getdays">请选择购买周数：<select class="pday">'+opts1+'</select> 周</p><p class="leftcount">已有 <span class="lftcount">'+(parseInt(dt1.m_count,10)-parseInt(dt1.s_count,10))+'</span> 人购买此服务,现剩余 <span class="red">'+dt1.s_count+'</span> 个名额</p><p class="nosell">购买名额已满,您暂不能购买,明天再来看看吧</p><p class="hasget">您已购买该服务,到期时间为 <span class="red">'+dt1.date+'</span></p><div class="probtn_cont"><div class="btn_common btn5"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white promotenow" st="'+dt1.id+'">立即推广</a></div></div></div><p class="clr"></p></div></div><div class="bot"><p class="lf"></p><p class="rf"></p></div></div>';
             tmp+='<div class="bc_item"><div class="top"><p class="lf"></p><p class="rf"></p></div><div class="middle"><div class="mbg"><div class="title"><span>推广方式</span><em>2</em><span class="grayer"> - 职讯推荐列表优先排序</span></div><div class="lf prompic prompic2"></div><div class="lf promoper promoper2"><p class="baseintro">说明：您推广的职位信息将由系统精准推送至人才、猎头的"推荐职位"列表中，并享优先排序权。</p><p class="prompay prompay2">费用：<em class="red">\u00A5</em><span class="red">'+dt2.price+'</span>/周</p><p class="getdays">请选择购买周数：<select class="pday1">'+opts2+'</select> 周</p><p class="leftcount">已有 <span class="lftcount">'+(parseInt(dt2.m_count,10)-parseInt(dt2.s_count,10))+'</span> 人购买此服务,现剩余 <span class="red">'+dt2.s_count+'</span> 个名额</p><p class="nosell">购买名额已满,您暂不能购买,明天再来看看吧</p><p class="hasget">您已购买该服务,到期时间为 <span class="red">'+dt2.date+'</span></p><div class="probtn_cont"><div class="btn_common btn5"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn white zxpromotenow" st="'+dt2.id+'">立即推广</a></div></div></div><p class="clr"></p></div></div><div class="bot"><p class="lf"></p><p class="rf"></p></div></div>';            
            }
            par.find("div.bcard_data").append(tmp);
        },
        hgsGenBOptions:function(dt){
            var opts="";
            var min1=parseInt(dt.min_days,10),
            max1=parseInt(dt.max_days,10)+1;
            for(var i=min1;i<max1;i++){
                opts+="<option value='"+i+"'>"+i+"</option>";
            }
            return opts;
        },
        hgsIniBCards:function(pt,dt){
            var pcnt=$(pt);
            var obj=pcnt.find("div.btn5 a");
            if(obj.length==0){
                obj=pcnt.find("div.btn7 a");
            }
            if(dt.status==1){
                pcnt.find("p.baseintro,p.hasget").css("display","block");
                pcnt.find("p.hasget span.red").text(dt.date);
                var btn=pcnt.find("div.btn5");
                baseController.BtnUnbind(btn);
                btn.find("a").unbind("click");
                btn.removeClass("btn5").addClass("btn7");
            }else if(dt.m_count=="-1"){
                pcnt.find("p.baseintro,p.prompay,p.getdays").css("display","block");
                pcnt.find("p.prompay span.red").text(dt.price);
                var opts=pcnt.hgsGenBOptions(dt);
                pcnt.find("p.getdays select").html(opts);
                pcnt.hgsPromBtnClick(obj);
            }else if(dt.s_count>0){
                pcnt.find("p.promcount,p.prompay,p.getdays,p.leftcount").css("display","block");
                pcnt.find("p.promcount span.count").text(dt.m_count);
                pcnt.find("p.prompay span.red").text(dt.price);
                pcnt.find("p.leftcount span.lftcount").text(parseInt(dt.m_count,10)-parseInt(dt.s_count,10));
                pcnt.find("p.leftcount span.red").text(dt.s_count);
                pcnt.find("div.btn_common a").attr("st",dt.id);
                var opts1=pcnt.hgsGenBOptions(dt);
                pcnt.find("p.getdays select").html(opts1);
                pcnt.hgsPromBtnClick(obj);
            }else{
                pcnt.find("p.promcount,p.prompay,p.getdays,p.nosell").css("display","block");
                pcnt.find("p.promcount span.count").text(dt.m_count);
                pcnt.find("p.prompay span.red").text(dt.price);
                var opts3=pcnt.hgsGenBOptions(dt);
                pcnt.find("p.getdays select").html(opts3);
                var btn2=pcnt.find("div.btn5");
                baseController.BtnUnbind(btn2);
                btn2.find("a").unbind("click");
                btn2.removeClass("btn5").addClass("btn7");
            }
        },
        hgsGenBCards:function(data){
            var id="#"+$.hgsParOptions.id;
            var dt=data.data;
            var dt1=dt[0],dt2=dt[1];
            if($(id+" div.bc_item").length==0){
                $(id).hgsGenBCardsCnt(id,dt1,dt2);
            }
            $(id).find("div.promoper p").css("display","none");
            $(id).hgsIniBCards(id+" div.promoper1",dt1);
            $(id).hgsIniBCards(id+" div.promoper2",dt2);
            $(id).fadeIn(200);
        },
        hgsPromBtnClick:function(obj){
            var par=$(obj).parent();
            par.removeClass("btn7").addClass("btn5");
            baseController.BtnBind(par, "btn5", "btn5_hov", "btn5_click");
            $(obj).unbind("click").bind("click",function(){
                var that=$.hgsParOptions;
                var id=that.proid;
                var type=that.type;
                var url=that.url;
                var ser=$(this).attr("st");
                var days=$(this).parent().parent().parent().find("p select").val();
                $(this).hgsGetPromdata(id,type,url,ser,days);
            });
        },
        hgsGetPromdata:function(id,type,url,serv,days){
            var cu=this;
            var s={
                url:url,
                params:"id="+id+"&&type="+type+"&&service="+serv+"&&days="+days,
                sucrender:cu.hgsBtnSuc,
                failrender:cu.hgsBCardsFail
            };
            HGS.Base.HAjax(s);
        },
        hgsGetBCards:function(u,id){
            var cu=this;
            var s={
                url:u,
                params:"id="+id,
                sucrender:cu.hgsGenBCards,
                failrender:cu.hgsBCardsFail
            };
            HGS.Base.HAjax(s);
        },
        hgsBtnSuc:function(data){
            var opts=$.hgsParOptions;
            opts.cback(opts.cur);
            alert("推广成功!");
            $("#"+$.hgsParOptions.id).fadeOut(400);
        },
        hgsBCardsFail:function(data){
            if(typeof(data.data)=="undefined"){
                alert("推广功能暂未开放");
            }else{
                if(data.data=="YEBZ0001"){
                    paytipController.NoScore();
                }else{
                    alert(data.data);
                }
            }
        }
    });
})(jQuery);