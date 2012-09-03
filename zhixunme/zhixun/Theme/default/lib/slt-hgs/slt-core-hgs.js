function sltdata(){};
sltdata.prototype={
    /*
    *选择框模板
    */
    slt_content:'<div class="cards_cover slt_card" id="{id}" style="display: block; ">'
            +'<div class="select_bg bcard_data">'
                +'<div class="bc_item">'
                    +'<div class="top"><p class="lf"></p><p class="rf"></p></div><a href="javascript:;" class="close_slt" title="取消"></a>'
                    +'<div class="middle">'
                        +'<div class="mbg">'
                            +'<div class="title">{title}</div><div class="slt_items"></div><div class="slt_cat lf">{slt_cat}</div><div class="slt_citm lf"><p class="clr"></p></div><p class="clr"></p>'
                            +'<div class="next"><span class="gray">若您误选,再点击一次即可取消选择</span><div class="btn_common btn3_hov"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn jnext blue">确&nbsp;&nbsp;定</a></div></div>'
                        +'</div>'
                    +'</div>'
                    +'<div class="bot"><p class="lf"></p><p class="rf"></p></div>'
                +'</div>'
            +'</div>'
        +'</div>',
    /*
    *title模板
    */
    slt_title:'<span>请选择{title}类别:</span><span class="rf">{tip}</span>',
    /*
    *子分类列模板col_fst：一级自分类第一列样式
    */
    col:'<div class="col {fst}">{items}</div>',
    /*
    *获取大分类分类
    */
    GetCats:function(){
        var set={
            url:WEBURL.GetPJobs,
            params:""
        };
        var data=HGS.Base.HAjax(set,false);
        data=(typeof(data)=="undefined"?[]:data);
        if(!data.ret){
            data.data=[];
        }
        return data.data;
    },
    /*
    *获取指定分类下的子分类
    *参数：
    *pid：父类id
    */
    GetCatCdr:function(pid){
        var set={
            url:WEBURL.GetCJobs,
            params:"pid="+pid
        };
        var data=HGS.Base.HAjax(set,false);
        data=(typeof(data)=="undefined"?[]:data);
        if(!data.ret){
            data.data=[];
        }
        return data.data;
    }
    /*
    *获取指定分类下的子分类
    *参数：
    *pid：父类id
    */
//    GetSCatCdr:function(pid){}
};
(function($){
    $.extend($.fn,{
        hgsSlt: function(options){
            var slt=new sltdata();
            var defaults={
                id:"jobslt",          //选择框id
                title:'职位',         //提示选择的是什么的类别
                tip:'至多可选择5个',  //右上侧提示语
                data:[slt.GetCats,slt.GetCatCdr],            //获取大分类、一级分类、二级分类...的数据获取方法名，插件将自动将上一级相关信息传递到调用的方法
//                level:2,            //类别的总层次，从大分类开始算
                col_num:3,            //最大列数
                max_slt:5,            //最大选择个数
                cur_lv:1,             //当前层数
                single:false,         //是否为单选
                limit:true,           //是否显示不限
                sure:null             //确定提交选择结果的时候执行的方法
            };
            var opts = $.extend(defaults, options);
            var cur=this;
            var select={
                /******************* 共用方法 *******************/
                /*
                 * 绑定对象绑定事件
                 */
                _thatBind:function(){
                    $(cur).unbind("click").bind("click",function(){
                        //初始化资质选择框
                        select._iniSlt();
                    });
                },
                /*
                 * 选择框关闭事件
                 */
                _close:function(){
                    var that=$("#"+opts.id);
                    that.find("a.close_slt").click(function(){
                        that.fadeOut();
                    });
                },
                /*
                 * 初始化按钮效果
                 */
                _iniBtn:function(){
                    var that=baseController;
                    that.BtnBind("#"+opts.id+" div.btn_common", "btn3", "btn3_hov", "btn3_click");
                },
                /*
                 * 初始化按钮效果
                 */
                _BtnClick:function(){
                    $("#"+opts.id+" div.btn_common a.jnext").click(function(){
                        select._doResult();
                    });
                },
                /*
                 * 初始化已选项
                 */
                _iniSltItem:function(){
                    var that=$(cur);
                    var cids=that.attr("cids").split(",");
                    var pids=that.attr("pids").split(",");
                    var names=that.attr("names").split(",");
                    var par=$("#"+opts.id);
                    var html='';
                    par.find("div.slt_citm div.col a.cur_a").removeClass("cur_a");
                    par.find("div.slt_items").html("");
                    if(cids[0]!=""){
                        $.each(cids,function(i,o){
                            html+='<a href="javascript:;" cid="'+o+'" pid="'+pids[i]+'">'+names[i]+'</a>';
                        });
                        par.find("div.slt_items").append(html);
                        select._delSltItemClick(par.find("div.slt_items a"));
                    }
                },
                /*
                 * 初始化选择框
                 */
                _iniSlt:function(){
                    if(!$.fn.hgsSlt.defaults.stopevent){
                        if(this._genSlt()){
                            this._iniCatClick();
                            this._close();
                            this._iniBtn();
                            this._BtnClick();
                        }
                        this._iniSltItem();
                    }
                },
                /*
                *绑定对象类型控制,
                */
                _doResult:function(){
                    var def=opts;
                    var par=$("#"+opts.id);
                    var res=par.find("div.slt_items a");
                    var cid="",pid="",name='';
                    $.each(res,function(i,o){
                        var that=$(o);
                        if(i>0){
                            cid+=","+that.attr("cid");
                            pid+=","+that.attr("pid");
                            name+=","+that.text();
                        }else{
                            cid=$(o).attr("cid");
                            pid=that.attr("pid");
                            name=that.text();
                        }
                    });
                    var r={
                        cid:cid,//所选职位子分类id，以逗号分开
                        pid:pid,//所选职位子分类id，以逗号分开
                        name:name,//所选所有职位名称，以顿号分开
                        jhtml:par.find("div.slt_items").html(),
                        obj:cur//当前绑定对象
                    };
                    par.fadeOut();
                    $(cur).attr("cids",r.cid);
                    $(cur).attr("pids",r.pid);
                    $(cur).attr("names",r.name);
                    def.sure(r);
                },
                /*
                 * 生成选择框
                 */
                _genSlt:function(){
                    var def=opts;
                    var st=slt;
                    var that=$("#"+def.id);
                    if(that.length==0){
                        var html=st.slt_content;
                        var cat=this._genCat();
                        html=html.replace("{id}",def.id)
                             .replace("{title}",st.slt_title.replace('{title}',def.title).replace("{tip}",def.tip))
                             .replace("{slt_cat}",cat);
                        $("body").append(html);
                        return true;
                    }else{
                        that.fadeIn(30);
                    }
                    return false;
                },
                /*
                 * 生成大分类
                 */
                _genCat:function(){
                    var data=opts.data[0]();
                    var html='';
                    $.each(data,function(i,o){
                        html+='<p><a href="javascript:;" class="cat_a" cid="'+o.id+'">'+o.name+'</a><a href="javascript:;" class="tri"></a></p>';
                    });
                    return html;
                },
                /*
                 * 生成指定分类的子分类
                 */
                _genCatCdr:function(pid){
                    var data=opts.data[opts.cur_lv](pid);
                    var html='',tmp=slt.col;
                    if(opts.limit){
                        html='<a href="javascript:;" cid="'+pid+'" class="nolimit">不限</a>';
                    }
                    $.each(data,function(i,o){
                        html+='<a href="javascript:;" cid="'+o.id+'">'+o.name+'</a>';
                    });
                    html=tmp.replace("{fst}","col_fst col_"+opts.col_num).replace("{items}",html)+"</div><p class='clr'></p>";
                    var par=$("#"+opts.id);
                    par.find("div.slt_citm div.col:eq("+(opts.cur_lv-1)+")").remove();
                    par.find("div.slt_citm").html(html);
                },
                /*
                 * 大分类点击事件
                 */
                _catClick:function(){
                    var par=$("#"+opts.id);
                    par.find("div.slt_cat p").unbind("click").bind("click",function(){
                        $(this).parent().find("p.cur_p").removeClass("cur_p");
                        $(this).addClass("cur_p");
                        var pid=$(this).find("a.cat_a").attr("cid");
                        opts.cur_lv=1;
                        select._genCatCdr(pid);
                        select._itemClick();
                    });
                },
                /*
                 * 初始化大分类
                 */
                _iniCatClick:function(){
                    this._catClick();
                    $("#"+opts.id).find("div.slt_cat p:eq(0)").trigger("click");
                },
                /*
                 * 生成已选择类别
                 */
                _genSltItems:function(cid,name){
                    var par=$("#"+opts.id);
                    if(par.find("div.slt_items a[cid='"+cid+"']").length==0){
                        var cat=par.find("div.slt_cat p.cur_p a.cat_a");
                        var html='<a href="javascript:;" cid="'+cid+'" pid="'+cat.attr("cid")+'">'+cat.text()+' - '+name+'</a>';
                        par.find("div.slt_items").append(html);
                        select._delSltItemClick(par.find("div.slt_items a:last-child"));
                    }
                },
                /*
                 * 删除已选择类别
                 */
                _delSltItemClick:function(obj){
                    $(obj).click(function(){
                        var cid=$(this).attr("cid");
                        select._delSltItems(cid);
                        $("#"+opts.id).find("div.slt_citm div.col a[cid='"+cid+"']").trigger("click");
                    });
                },
                /*
                 * 删除已选择类别
                 */
                _delSltItems:function(cid){
                    $("#"+opts.id).find("div.slt_items a[cid='"+cid+"']").remove();
                },
                /*
                 * 子项点击事件
                 */
                _itemClick:function(){
                    var par=$("#"+opts.id);
                    par.find("div.slt_citm div.col a").unbind("click").bind("click",function(){
                        opts.cur_lv=$(this).parent().parent().index()+2;
                        var bl=false,lim=$(this).hasClass("nolimit");
                        var cid=$(this).attr("cid");
                        if($(this).hasClass("cur_a")){
                            $(this).removeClass("cur_a");
                            select._delSltItems(cid);
                        }else{
                            if(opts.single||lim){
                                $(this).parent().parent().find("a.cur_a").removeClass("cur_a");
                                $(this).addClass("cur_a");
                                par.find("div.slt_items a").remove();
                                if(lim){
                                    par.find("div.slt_items a:not([pid!='"+par.find("div.slt_cat p.cur_p a.cat_a").attr("cid")+"'])").remove();
                                }
                                bl=true;
                            }else{
                                var nom=$(this).parent().parent().find("a.nolimit");
                                if(nom.hasClass("cur_a")){
                                    par.find("div.slt_items a[cid='"+nom.attr("cid")+"']").remove();
                                    nom.removeClass("cur_a");
                                }                                
                            }
                            if(!opts.single){
                                if(par.find("div.slt_items a").length<opts.max_slt){
                                    $(this).addClass("cur_a");
                                    bl=true;
                                }else{
                                    alert("至多能选"+opts.max_slt+"个!");
                                    bl=false;
                                }
                            }
                            if(bl){
//                                var pid=$(this).attr("cid");
//                                select._genCatCdr(pid);
                                select._genSltItems($(this).attr("cid"),$(this).text());
                            }
                            else{
                                if($(this).hasClass("cur_a"))
                                  $(this).removeClass("cur_a");
                            }
                        }                        
                    });
                }
            };
            select._thatBind();
        }
    });
    $.fn.hgsSlt.defaults={
        stopevent:false     //是否阻止文本框点击事件
    };
})(jQuery);