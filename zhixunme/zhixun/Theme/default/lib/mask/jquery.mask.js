function Mask(){};
Mask.prototype={
    /*
    *选择框模板
    */
    slt_content:'<div class="cards_cover slt_card" id="{id}">'
    +'<div class="select_bg bcard_data">'
    +'<div class="bc_item">'
    +'<div class="top"><p class="lf"></p><p class="rf"></p></div><a href="javascript:;" class="close_slt" title="取消"></a>'
    +'<div class="middle">'
    +'<div class="mbg">'
    +'{content}'
    +'{btn}'
    +'</div>'
    +'</div>'
    +'<div class="bot"><p class="lf"></p><p class="rf"></p></div>'
    +'</div>'
    +'</div>'
    +'</div>',
    slt_email:'<div class="cards_cover slt_card" id="{id}">'
    +'<div class="select_bg ewt align_m">'
    +'<div class="ewraper">'
    +'<div class="etop"></div><a href="javascript:;" class="close_slt blue" title="关闭">关闭</a>'
    +'<div class="mect">'
    +   '<div class="ebg">'
    +        '<table class="eb">'
    +            '<tr><td class="ltd ltop"><span>收件人：</span></td><td><div class="slt_items"></div><input type="hidden" name="ids" /></td></tr>'
    +            '<tr><td class="ltd ltop"><span>主题：</span></td><td><div class="tm"><input type="text" class="tbox" /></div></td></tr>'
    +            '<tr><td class="ltd ltop"><span>内容：</span></td><td><div class="tm"><textarea class="cin mail_detail"></textarea></div></td></tr>'
    +       '</table>'
    +   '<span class="red lf error"></span>'
    + '<div class="sv_res save btn_common btn4_common btn4">'
    +   '<span class="b_lf"></span>'
    +   '<span class="b_rf"></span>'
    +   '<a href="javascript:;" id="send_mail" class="btn  jnext white">发送</a>'
    + '</div>'
    +'<div class="clr"></div>'
    +  '</div>'
    +'</div>'
    +'</div>'
    +'</div>'
    +'</div>',
    mod_hm:'<div class="m_wrap">添加人才资源</div>'
    +'<div class="mitem"><span class="gray name cmon">人才姓名：</span><span><input type="text" class="rname cbox" /></span></div>'
    +'<div class="mitem"><span class="gray cmon">客户来源：</span>'
    +'<span><select id="perid1"><option value="1">职讯网</option><option value="2">电话来访</option><option value="3">客户介绍</option><option value="4">独立开发</option><option value="5">魅力宣传</option><option value="12">其他</option><option value="6">促销活动</option><option value="7">老客户</option><option value="8">代理商</option><option value="9">合作伙伴</option><option value="10">公开招标</option><option value="11">其他网站</option></select></span>'
    +'</div>',
    mod_cm:'<div class="m_wrap">添加企业资源</div>'
    +'<div class="mitem"><span class="gray cmon">企业名称：</span><span><input type="text" class="cname cbox" /></span></div>'
    +'<div class="mitem"><span class="gray cmon">联系人：</span>'
    +'<span><input type="text" class="contacter cbox" />'
    +'</span></div>'
    +'<div class="mitem"><span class="gray cmon">客户来源：</span>'
    +'<span><select id="perid2"><option value="1">职讯网</option><option value="2">电话来访</option><option value="3">客户介绍</option><option value="4">独立开发</option><option value="5">魅力宣传</option><option value="12">其他</option><option value="6">促销活动</option><option value="7">老客户</option><option value="8">代理商</option><option value="9">合作伙伴</option><option value="10">公开招标</option><option value="11">其他网站</option></select></span>'
    +'</div>',
mod_import:'<div class="import"><div class="upfile_l">'
    +'<div class="title">导入{h_e}资源</div>'
    +'<div class="upfile_button">'
    +'<div class="up_button">'
    +'<span class="b_lf"></span><span class="b_rf"></span>'
    +'<form action="{url}" method="POST" target="{iframe_id}"  enctype="multipart/form-data" id="{formid}">'          
    +'<a href="javascript:;" class="btn blue" datacont="" id="sendmsgtozx">资源文件导入'    
    +'<input type="file" name="upfile" size="0" class="upcvsfile"/>'
    +'<input type="hidden" name="att_name" size="0" value="{att_name}" class="upcvsfile"/></a></form>'
    +'<iframe id="{iframe_id}" name="{iframe_id}" src="about:blank" style="display:none"></iframe></div><div class="notemsg"></div></div></div>'
    +'<div class="notemsg">提示：目前仅支持职讯提供的资源模板导入资源，请下载模板文件并录入准确的数据后导入。</div><div class="download_r">'
    +'<div class="downloadfile_button"><div class="down_button"><span class="b_lf"></span><span class="b_rf"></span>'
    +'<a href="{url_xls}" class="btn blue" datacont="" id="downloadcvs">下载模板文件</a></div></div></div>'
    +'<span id="notetxt" class="notetext red hidden">文件格式不正确，请选择csv或xls文件。</span>'
    +'<span id="error" class="notetext red"></span></div>',
mod_upfile:'<span>选择文件类型:</span><span class="gray">支持PDF文档、JPG、JPEG、PNG图片(最大不超过2M)</span>'
    +'<form action="{url}" method="POST" target="Upfiler_file_iframe"  enctype="multipart/form-data" id="{formid}">'
    +'<div class="upfile_detail"><div class="select_type">'
    +'<a href="javascript:;" cid="4" class="">资历证件</a>'
    +'<a href="javascript:;" cid="1" class="selected">身份证件</a>'
    +'<a href="javascript:;" cid="3" class="">合同文件</a>'
    +'<a href="javascript:;" cid="9" class="">其它文件</a>'    
    +'</div><div class="upfile_button"><div class="up_button"><span class="b_lf"></span><span class="b_rf"></span>'
    +'<a href="javascript:;" class="btn blue" datacont="" id="sendmsgtozx">浏览文件'
    +'<input type="hidden" name="{user_type}" value="{user_id}">'
    +'<input type="hidden" name="att_name" value="{att_name}">'                
    +'<input type="hidden" name="identifier" value="{identifier}">'
    +'<input type="file" name="upfile" size="0" class="d_upfile"/>'
    +'<input type="hidden" name="att_type_id" />'
    +'</a></div></div></div></form><iframe id="Upfiler_file_iframe" name="Upfiler_file_iframe" src="about:blank" style="display:none"></iframe>'
    +'<div class="notemsg"></div>',
    btn_md:'<div class="next"><span class="red  error"></span><div class="sv_res rf"><a href="javascript:;" class="btn jnext blue">创建档案</a></div></div>'
};
(function($){
    $.extend($.fn,{
        hmark: function(options){
            var slt=new Mask();
            var defaults={
                id:"jobslt",
                cont:null,
                type:"1",
                url:'',
                param:null,
                suc:null,
                fail:null,
                checknul:null,
                iniSltFun:function(){
                }, //初始化弹出框发送对象名字标签，该方法需返回一个data数组和真值
                delitBack:null//删除收件人回调函数
            };
            var opts = $.extend(defaults, options);
            var cur=this;
            var me=null;
            var mark={
                /******************* 共用方法 *******************/
                /*
                 * 绑定对象绑定事件
                 */
                _thatBind:function(){
                    $(cur).unbind("click").bind("click",function(){
                        //初始化遮罩
                        mark._iniSlt($(this));                        
                    });
                },
                /*
                 * 选择框关闭事件
                 */
                _close:function(){
                    var that=$("#"+opts.id);
                    that.find("a.close_slt").click(function(){
                        that.find("input[type='text'],textarea").val("");
                        that.find("span.error").text("");
                        that.find("div.slt_items").find("a").remove();
                        that.fadeOut();
                    });
                },
                /*
                 * 初始化按钮效果
                 */
                _iniBtn:function(){
                    var that=baseController;
                    that.BtnBind("#"+opts.id+" div.btn_common", "btn4", "btn4_hov", "btn4_click");
                },
                /*
                 * 初始化按钮效果
                 */
                _BtnClick:function(){
                    $("#"+opts.id+" div.sv_res a.jnext").click(function(){
                        mark._doResult();
                    });
                },
                /*
                 * 初始化上传CVS文件
                 */
                _IniUpCvsfile:function(){
                    if(!$("#notetxt").hasClass("hidden"))
                        $("#notetxt").addClass("hidden");
                    if(!$("#error").hasClass("hidden"))
                        $("#error").addClass("hidden");
                },
                /*
                 * 上传CVS文件
                 */
               _BtnUpCvsfile:function(){
                    var notemsg=$("#"+opts.p.formid).parent().next(".notemsg");
                    var close=$("#"+opts.id).children().children().find("a.close_slt");
                    $("#"+opts.id+" input.upcvsfile").bind("change",function(){
                        var file=$(this).val();                            
                        if(/^.*?\.(csv|xls)$/i.test(file)){//判断是否csv,xls文件                             
                            notemsg.removeClass("red");
                            mark._IniUpCvsfile();
                            notemsg.html(COMMONTEMP.T0030);
                            $('#'+opts.p.formid).submit();                                                        
                            close.unbind().bind("click",function(){
                                location.reload();                                
                            });
                        }
                        else{
                            mark._IniUpCvsfile();
                            notemsg.addClass("red");
                            notemsg.html('文件格式不正确，请选择csv或xls文件。');
                        }
                    });
                },
                 /*
                 * 初始化上传附件
                 */
                _BtnUpfile:function(me){
                    var notemsg=$("#"+opts.retemp.formid).next().next(".notemsg");                          
                    var filetype=opts.retemp.ftype(me);                          
                    var seled=$("#file_type option[value='"+filetype+"']");                    
                    seled.attr('selected', 'true');
                   // var ftext=seled.text();
                    //$("#file_type").prev().html(ftext);                    
                    notemsg.html('');                    
                    mark._UpfileBindSub(notemsg);
                },
                /*
                 * 上传附件提交事件绑定
                 */
                _UpfileBindSub:function(notemsg){                    
                    var sel=$("#"+opts.retemp.formid).find(".select_type");                    
                    var  ftype=1;
                    var maxnum=true;
                    maxnum=mark._CheckFileNum(ftype,notemsg);                                         
                    sel.children("a").unbind("click").bind("click",function(){                        
                        $(this).parent().find("a").removeClass("selected");
                        $(this).addClass("selected");                                               
                        ftype=$(this).attr("cid")*1;
                        maxnum=mark._CheckFileNum(ftype,notemsg);                           
                    });                      
                    $("#"+opts.id+" input.d_upfile").unbind("change").bind("change",function(){                                                 
                        var file=$(this).val();                                             
                        if(/^.*?\.(xls|docx|txt|doc|gif|png|jpg|jpeg|bmp|pdf)$/i.test(file)){//判断是否为指定格式                                                                                   
                            var att_name=$(this).prevAll("input[name='att_name']");
                            att_name.val(file);                                                      
                            $(this).next().val(ftype);                                                                                                                                         
                            if(maxnum){
                                notemsg.removeClass("red");                             
                                $('#upfile').submit();                                                            
                                notemsg.html(COMMONTEMP.T0030);                                
                                var close=$("#"+opts.id).children().children().find("a.close_slt");
                                close.unbind().bind("click",function(){
                                    location.reload();
                                });
                            }                            
                        }
                        else{
                            notemsg.addClass("red");
                            notemsg.html('格式不正确，请重新选择文件。');
                        }
                    });
                },
                 /*
                 * 上传附件文件数量核定
                 * 参数:ftype:文件类型
                 */
                _CheckFileNum:function(ftype,notes){
                    var type=null;
                    if(ftype==1){
                        type=$("#b_id");
                    }else if(ftype==3){
                        type=$("#c_id");
                    }else if(ftype==4){
                        type=$("#a_id");
                    }else if(ftype==9){
                        type=$("#d_id");
                    }
                    var f_num=type.children("div.m_file").length;
                    if(f_num>=5){
                        notes.addClass("red");
                        notes.html("当前文件类型数量已达上限!");                    
                        return false;
                    }
                    else{
                        notes.removeClass("red");
                        notes.html('');  
                        return true;
                    }
                },
                /*
                 * 初始化选择框
                 */
                _iniSlt:function(me){
                    if(!$.fn.hmark.defaults.stopevent){
                        if(this._genSlt(me)){
                            this._close();
                            this._iniBtn();
                            this._BtnClick();
                            if(opts.type==4)
                                this._BtnUpCvsfile();
                            else if(opts.type==5)
                                this._BtnUpfile(me);                            
                        }
                    // this._iniSltItem();
                    }
                },
                /*
                *绑定对象类型控制,
                */
                _doResult:function(){
                    var def=opts;
                    var par=$("#"+def.id);
                    var tt=opts.checknul();
                    if(tt==true){
                        var set={
                            url:def.url,
                            params:def.param(),
                            sf:def.suc,
                            ff:def.fail
                        };
                        var data=HGS.Base.HAjax(set,false);
                        data=(typeof(data)=="undefined"?[]:data);
                        if(!data.ret){
                            def.fail(data.data);
                        }else{
                            par.fadeOut();
                            def.suc(data.data);
                        }
                    }else{
                       par.find("span.error").text("");
                       par.find("span.error").text(tt); 
                    }
                },
                /*
                 *type为1：
                 *添加人才模板生成
                 */
                _genTemp0:function(){
                    var def=opts;
                    var st=slt;
                    var html='';
                    var ct="";
                    var ft="";
                    html=st.slt_content;
                    ct=st.mod_hm;
                    ft=st.btn_md;
                    html=html.replace("{id}",def.id)
                    .replace("{content}",ct).replace("{btn}",ft); 
                    return html;
                },
                   /*
                 *type为2：
                 *添加企业模板生成
                 */
                _genTemp1:function(){
                    var def=opts;
                    var st=slt;
                    var html='';
                    var ct="";
                    var ft="";
                    html=st.slt_content;
                            ct=st.mod_cm;
                            ft=st.btn_md;
                            html=html.replace("{id}",def.id)
                            .replace("{content}",ct).replace("{btn}",ft);
                    return html;
                },
                /*
                 *type：3
                 *群发邮件模板生成
                 */
                _genTemp2:function(){
                    var def=opts;
                    var st=slt;
                    var html='';
                    var ct="";
                    var ft="";
                    html=st.slt_email; 
                    html=html.replace("{id}",def.id)
                    .replace("{content}",ct).replace("{btn}",ft);
                    return html;
                },
                /*
                 *
                 *导入cvs人才资源文件
                 */
                _genTemp3:function(){
                    var def=opts;
                    var st=slt;
                    var html='';
                    var ct="";
                    var ft="";
                    html=st.slt_content;                    
                    var t=st.mod_import;
                    $.each(def.p,function(i,o){
                        t=t.replace('{'+i+'}',o);                        
                    });   
                    t=t.replace("{iframe_id}",def.p.iframe_id).replace("{iframe_id}",def.p.iframe_id);
                    ct=t;
                    html=html.replace("{id}",def.id)
                    .replace("{content}",ct).replace("{btn}",ft);
                    return html;
                },
                /*
                 *
                 *详情页上传附件模板
                 */
                _genTemp4:function(){
                    var def=opts;
                    var st=slt;
                    var html='';
                    var ct="";
                    var ft="";
                    html=st.slt_email; 
                    html=st.slt_content;
                    var t=st.mod_upfile;
                    $.each(def.retemp,function(i,o){
                        t=t.replace('{'+i+'}',o);                                
                    });   
                    ct=t;                            
                    html=html.replace("{id}",def.id)
                    .replace("{content}",ct).replace("{btn}",ft);
                    return html;
                },
                /*
                 *删除收件人
                 */
                _bdDeleitem:function(){
                   $("#"+opts.id+" div.slt_items a").unbind("click").bind("click",function(){
                       if($(this).parent().children().length>1){
                        $(this).remove();
                        opts.delitBack($(this).attr("rel"));
                       }else{
                           alert('至少有一个收件人');
                       }
                   });
                },
                /*
                 *
                 *导入资源文件
                 */
                _genNames:function(data){
                    var par=$("#"+opts.id+" div.slt_items");
                    par.html("");
                    var html="";
                    $.each(data,function(i,o){
                        html+='<a href="javascript:;" title="'+o.name+'" rel="'+o.id+'">'+o.name+'</a>';
                    });
                    par.html(html);
                    mark._bdDeleitem();
                },
                /**
                /*
                 * 生成选择框
                 */
                _genSlt:function(me){
                    var def=opts;
                    var bl=true;
                    var html='';
                    var that=$("#"+def.id);
                    var _type=def.type;
                    if(that.length==0){
                        if(_type=="1"){
                            html=mark._genTemp0();
                        }else if(_type=="2"){
                            html=mark._genTemp1();
                        }else if(_type=="3"){
                            html=mark._genTemp2();
                        }else if(_type=="4"){
                            html=mark._genTemp3();
                        }else if(_type=="5"){
                            html=mark._genTemp4();
                        }
                        $("body").append(html);
                        that=$("#"+def.id);
                        bl=false;
                    }
                    if(_type=="3"){
                        var ret=def.iniSltFun();
                        if(ret.ret){
                            mark._genNames(ret.data);
                            that.fadeIn(30);
                        }else{
                            alert("未选择收件人!");
                            bl=false;
                        }
                    }else if(_type==4){
                        mark._IniUpCvsfile();
                        that.fadeIn(30);
                    }
                    else if(_type==5){
                        mark._BtnUpfile(me);
                        that.fadeIn(30);
                    }
                    else{
                        that.fadeIn(30);                        
                    }
                    if(bl){
                        return false;
                    }
                    return true;
                }
            };
            mark._thatBind();
        }
    });
    $.fn.hmark.defaults={
        stopevent:false     //是否阻止文本框点击事件
    };
})(jQuery);
