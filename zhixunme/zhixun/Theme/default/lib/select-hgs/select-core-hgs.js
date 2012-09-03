function seldata(){
    this._area=["华北","华东","华南","东北","西北","西南","华中"];
    this._count = 34;
    this._city = new Array(this._count);
    this._city[0] = new Array(["1"],["安徽", "合肥", "宣城", "池州", "巢湖", "六安", "黄山", "安庆", "铜陵", "芜湖", "马鞍山", "滁州", "淮南", "蚌埠", "阜阳", "淮北", "宿州", "亳州"], ["1001", "101", "116", "115", "114", "113", "112", "111", "110", "109", "108", "107", "106", "105", "104", "103", "102", "117"]);
    this._city[1] = new Array(["0"],["北京", "北京"], ["1002", "118"]);
    this._city[2] = new Array(["5"],["重庆", "重庆"], ["1003", "119"]);
    this._city[3] = new Array(["1"],["福建", "厦门", "福州", "南平", "三明", "莆田", "泉州", "漳州", "龙岩", "宁德"], ["1004", "120", "121", "122", "123", "124", "125", "126", "127", "128"]);
    this._city[4] = new Array(["4"],["甘肃", "兰州", "定西", "平凉", "庆阳", "武威", "张掖", "酒泉", "天水", "白银", "金昌", "嘉峪关", "陇南"], ["1005", "129", "139", "138", "137", "136", "135", "134", "133", "132", "131", "130", "140"]);
    this._city[5] = new Array(["2"],["广东", "广州", "珠海", "中山", "江门", "佛山", "肇庆", "云浮", "阳江", "茂名", "东莞", "惠州", "汕尾", "深圳", "清远", "韶关", "河源", "梅州", "潮州", "汕头", "揭阳", "湛江"], ["1006", "141", "153", "154", "155", "156", "157", "158", "159", "160", "152", "151", "150", "142", "143", "144", "145", "146", "147", "148", "149", "161"]);
    this._city[6] = new Array(["2"],["广西", "南宁", "来宾", "河池", "百色", "崇左", "防城港", "北海", "钦州", "玉林", "贵港", "梧州", "柳州", "桂林", "贺州"], ["1007", "162", "174", "173", "172", "171", "170", "169", "168", "167", "166", "165", "164", "163", "175"]);
    this._city[7] = new Array(["5"],["贵州", "贵阳", "六盘水", "遵义", "安顺"], ["1008", "176", "177", "178", "179"]);
    this._city[8] = new Array(["2"],["海南", "海口", "三亚"], ["1009", "180", "181"]);
    this._city[9] = new Array(["0"],["河北", "石家庄", "廊坊", "沧州", "承德", "张家口", "邢台", "秦皇岛", "保定", "唐山", "邯郸", "衡水"], ["1010", "182", "191", "190", "189", "188", "187", "186", "185", "184", "183", "192"]);
    this._city[10] = new Array(["3"],["黑龙江", "哈尔滨", "牡丹江", "鸡西", "七台河", "双鸭山", "佳木斯", "鹤岗", "伊春", "大庆", "黑河", "齐齐哈尔", "绥化"], ["1011", "193", "203", "202", "201", "200", "199", "198", "197", "196", "195", "194", "204"]);
    this._city[11] = new Array(["6"],["河南", "郑州", "驻马店", "周口", "商丘", "南阳", "三门峡", "漯河", "许昌", "濮阳", "焦作", "新乡", "鹤壁", "安阳", "平顶山", "洛阳", "开封", "信阳"], ["1012", "205", "220", "219", "218", "217", "216", "215", "214", "213", "212", "211", "210", "209", "208", "207", "206", "221"]);
    this._city[12] = new Array(["6"],["湖北", "武汉", "宜昌", "荆州", "咸宁", "黄石", "鄂州", "黄冈", "孝感", "荆门", "襄樊", "十堰", "随州"], ["1013", "222", "232", "231", "230", "229", "228", "227", "226", "225", "224", "223", "233"]);
    this._city[13] = new Array(["6"],["湖南", "长沙", "怀化", "邵阳", "永州", "郴州", "衡阳", "湘潭", "株洲", "岳阳", "益阳", "常德", "张家界", "娄底"], ["1014", "234", "245", "244", "243", "242", "241", "240", "239", "238", "237", "236", "235", "246"]);
    this._city[14] = new Array(["0"],["内蒙古", "呼和浩特", "包头", "乌海", "赤峰", "呼伦贝尔", "通辽", "乌兰察布", "鄂尔多斯", "巴彦淖尔"], ["1015", "247", "248", "249", "250", "251", "252", "253", "254", "255"]);
    this._city[15] = new Array(["1"],["江苏", "南京", "无锡", "常州", "镇江", "南通", "泰州", "扬州", "盐城", "淮安", "宿迁", "连云港", "徐州", "苏州"], ["1016", "256", "267", "266", "265", "264", "263", "262", "261", "260", "259", "258", "257", "268"]);
    this._city[16] = new Array(["1"],["江西", "南昌", "宜春", "抚州", "上饶", "赣州", "萍乡", "新余", "鹰潭", "景德镇", "九江", "吉安"], ["1017", "269", "278", "277", "276", "275", "274", "273", "272", "271", "270", "279"]);
    this._city[17] = new Array(["3"],["吉林", "长春", "吉林", "白城", "松原", "四平", "辽源", "通化", "白山"], ["1018", "280", "281", "282", "283", "284", "285", "286", "287"]);
    this._city[18] = new Array(["3"],["辽宁", "沈阳", "锦州", "盘锦", "营口", "丹东", "鞍山", "辽阳", "本溪", "抚顺", "铁岭", "阜新", "朝阳", "大连", "葫芦岛"], ["1019", "288", "300", "299", "298", "297", "296", "295", "294", "293", "292", "291", "290", "289", "301"]);
    this._city[19] = new Array(["4"],["宁夏", "银川", "石嘴山", "吴忠", "中卫", "固原"], ["1020", "302", "303", "304", "305", "306"]);
    this._city[20] = new Array(["4"],["青海", "西宁", "玉树"], ["1021", "307", "308"]);
    this._city[21] = new Array(["0"],["山西", "太原", "临汾", "晋中", "吕梁", "忻州", "晋城", "长治", "阳泉", "朔州", "大同", "运城"], ["1022", "309", "318", "317", "316", "315", "314", "313", "312", "311", "310", "319"]);
    this._city[22] = new Array(["1"],["山东", "济南", "滨州", "莱芜", "泰安", "济宁", "枣庄", "临沂", "日照", "威海", "烟台", "潍坊", "淄博", "东营", "德州", "聊城", "青岛", "菏泽"], ["1023", "320", "335", "334", "333", "332", "331", "330", "329", "328", "327", "326", "325", "324", "323", "322", "321", "336"]);
    this._city[23] = new Array(["1"],["上海", "上海"], ["1024", "337"]);
    this._city[24] = new Array(["5"],["四川", "成都", "眉山", "资阳", "达州", "巴中", "攀枝花", "宜宾", "泸州", "自贡", "乐山", "内江", "遂宁", "广安", "南充", "德阳", "绵阳", "广元", "雅安"], ["1025", "338", "354", "353", "352", "351", "350", "349", "348", "347", "346", "345", "344", "343", "342", "341", "340", "339", "355"]);
    this._city[25] = new Array(["0"],["天津", "天津"], ["1026", "356"]);
    this._city[26] = new Array(["5"],["西藏", "拉萨"], ["1027", "357"]);
    this._city[27] = new Array(["4"],["新疆", "乌鲁木齐", "克拉玛依", "石河子", "阿拉尔", "图木舒克", "五家渠"], ["1028", "358", "359", "360", "361", "362", "363"]);
    this._city[28] = new Array(["5"],["云南", "昆明", "曲靖", "玉溪", "丽江", "昭通", "思茅", "临沧", "保山"], ["1029", "364", "365", "366", "367", "368", "369", "370", "371"]);
    this._city[29] = new Array(["1"],["浙江", "杭州", "温州", "台州", "金华", "衢州", "绍兴", "舟山", "嘉兴", "湖州", "宁波", "丽水"], ["1030", "372", "381", "380", "379", "378", "377", "376", "375", "374", "373", "382"]);
    this._city[30] = new Array(["4"],["陕西", "西安", "商洛", "榆林", "汉中", "宝鸡", "咸阳", "渭南", "铜川", "延安", "安康"], ["1031", "383", "391", "390", "389", "388", "387", "386", "385", "384", "392"]);
    this._city[31] = new Array(["1"],["台湾", "台北", "高雄", "基隆", "台中", "台南", "新竹", "嘉义"], ["1032", "393", "394", "395", "396", "397", "398", "399"]);
    this._city[32] = new Array(["2"],["香港", "香港"], ["1033", "400"]);
    this._city[33] = new Array(["2"],["澳门", "澳门"], ["1034", "401"]);
//    this._jtitle=[["1","2","3"],["1","2","1"],["101","102","103"],["职称一","职称二","职称三"]];//级别id/类型id/职称id/职称名称
};
seldata.prototype={
    /*
    *资质添加模板
    */
    quality:'<div class="select_cover" id="{id}"><div class="select_bg qual_sbg"><div class="select_cont"><a href="javascript:;" class="close_slt" title="返回上一步"></a><div class="rainbow rainbow1 reg_cat"><span>注册类别</span><div class="items"></div><div class="clr"></div></div><div class="rainbow rainbow2 reg_solu"><span>注册情况</span><div class="items"><a href="javascript:;" type="1">初始注册</a><a href="javascript:;" type="2">变更注册</a><a href="javascript:;" type="3">重新注册</a></div><div class="clr"></div></div><div class="reg_qual sc_items"><div class="top"><p class="lf"></p><p class="rf"></p></div><div class="mid"><div class="items"></div></div><div class="bot"><p class="lf"></p><p class="rf"></p></div></div><div class="next"><div class="btn_common  btn3"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn blue qual_next">{text}</a></div></div></div></div>',
    /*
    *职称的模板
    */
    jobtitle:'<div class="select_cover" id="{id}"><div class="select_bg jtitle_sbg"><div class="select_cont"><a href="javascript:;" class="close_slt" title="返回上一步"></a><div class="rainbow rainbow1 jt_level"><span>职称等级</span><div class="items"><a href="javascript:;" lv="1">初级</a><a href="javascript:;" lv="2">中级</a><a href="javascript:;" lv="3">高级</a></div><div class="clr"></div></div><div class="rainbow rainbow2 jt_type"><span>专业类型</span><div class="items"></div><div class="clr"></div></div><div class="sc_items jt_name"><div class="top"><p class="lf"></p><p class="rf"></p></div><div class="mid"><div class="items"></div></div><div class="bot"><p class="lf"></p><p class="rf"></p></div></div><div class="next"><span class="gray">职称选择步骤: 1、选职称等级 2、选类型 3、选专业</span><div class="btn_common  btn3"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn blue jtitle_next">确&nbsp;&nbsp;定</a></div></div></div></div></div>',
    /*
    *地区的模板
    */
    place:'<div class="select_cover" id="{id}"><div class="select_bg"><div class="select_cont"><a href="javascript:;" class="close_slt" title="返回上一步"></a><div class="province"></div><div class="next"><div class="btn_common  btn3"><span class="b_lf"></span><span class="b_rf"></span><a href="javascript:;" class="btn prov_next blue">确&nbsp;&nbsp;定</a></div></div></div></div></div>',
    /*
    *地区省多选时再次点击取消选择提示语
    */
    multptip:'<span class="gray">若您误选,再点击一次即可取消选择</span>',
    /*
    *获取所有分类
    */
    GetAllCats:function(a){
        //return this._cat;
        var set={
            url:a,
            params:""
        };
        var data=HGS.Base.HAjax(set,false);
        data=(typeof(data)=="undefined"?[]:data);
        if(!data.ret){
            data.data=[];
        }
        return data;
    },
    /*
    *获取分类级别指定注册情况下的专业
    */
    GetMajors:function(a,cid){
        var set={
            url:a,
            params:"id="+cid
        };
        var data=HGS.Base.HAjax(set,false);
        data=(typeof(data)=="undefined"?[]:data);
        if(!data.ret||data.sup){
            data.data=[];
        }
        return data;
    },
    /*
    *获取职称类别
    */
    GetTiType:function(a){
        var set={
            url:a,
            params:""
        };
        var data=HGS.Base.HAjax(set,false);
        data=(typeof(data)=="undefined"?[]:data);
        if(!data.ret){
            data.data=[];
        }
        return data;
    },
    /*
    *获取指定分类级别的职称类别
    */
    GetJTitle:function(a,tid){
        var set={
            url:a,
            params:"id="+tid
        };
        var data=HGS.Base.HAjax(set,false);
        data=(typeof(data)=="undefined"?[]:data);
        if(!data&&!data.ret){
            data.data=[];
        }
        return data;
    },
    /*
    *获取省名称
    */
    GetProvince:function(aindex,b){
        if(b==false){
            var data=this._city;
            var ndata=[[],[]],k=0;
            $.each(data,function(i,o){
                if(o[0][0]==aindex+''){
                    ndata[0][k]=o[1][0];
                    ndata[1][k]=o[2][0];
                    k++;
                }
            });
            return ndata;
        }else{
           var setings={
                url:aindex,
                params:"id=0"
            };
            return HGS.Base.HAjax(setings,false);
        }
    },
    /*
    *获取指定省id市id的省市名称
    */
    GetTheProvOrCity:function(pid,cid){
        var data=this._city;
        var name=["",""];
        $.each(data,function(i,o){
            if(o[2][0]==pid+''){
                var index=0;
                name[0]=o[1][0];
                if(cid!=null){
                    $.each(o[2],function(k,item){
                        if(item==cid){
                            index=k;
                            return false;
                        }
                    });
                    name[1]=o[1][index];
                }
                return false;
            }
        });
        return name;
    },
    /*
    *获取区域
    */
    GetArea:function(){
        return this._area;
    },
    /*
    *获取市名称
    */
    GetCity:function(pid){
        var data=this._city;
        var cdata=[[],[]];
        $.each(data,function(i,o){
            if(o[2][0]==pid){
                cdata[0]=o[1];
                cdata[1]=o[2];
            }
        });
        return cdata;
    }
};
(function($){
    $.extend($.fn,{
        hgsSelect: function(options){
            var defaults={
                type:'default',    //default:资质添加，place：地区添加，jobtitle：职称添加
                level:1,	   //当前选择框的层次,从1开始
                id:"",             //设置选择框父容器id
                pid:"",            //省市添加的父容器id
                tid:"",            //职称添加的父容器id
                pshow:false,       //是否显示地区选择
                cshow:false,       //是否显示人数
                lishow:false,      //是否显示省份不限
                regshow:true,      //是否显示注册情况
                reglishow:false,   //是否显示注册情况不限
                step:1,		   //当前为第几步
                sprov:false,       //是否只精确到省
                single:true,       //省是否为单选
                sure:null,         //确定提交选择结果的时候执行的方法
                qurl:WEBURL.GetCerts,//资质注册类型数据获取路径
                murl:WEBURL.GetCertsMajor,//获取对应资质专业路径
                gcurl:WEBURL.GetGCertType,//获取职称类别
                zurl:WEBURL.GetGCerts,//获取指定类别职称类别名称
                async:false,//是否异步获取数据
                isshowarea:true,//是否显示地区
                prvurl:""//获取省份路径
            };
            var opts = $.extend(defaults, options);
            var cur=this;
            var slt=new seldata();
            var select={};
            $.extend(select, {
                /******************* 共用方法 *******************/
                /*
                *绑定对象类型控制,
                */
                _bindClick:function(){
                    var def=opts;
                    var type=def.type;
                    var selt=select;
                    if(type=="default"){
                        selt._qualClick();
                    }
                    else if(type=="jobtitle"){
                        selt._jtitleClick();
                    }
                    else if(type=="place"){
                        selt._placeClick();
                    }
                },
                /*
                *绑定对象类型控制,
                */
                _bindBtn:function(obj){
                    var that=baseController;
                    that.BtnUnbind(obj);
                    that.BtnBind(obj, "btn3", "btn3_hov", "btn3_click");
                },
                /*
                *绑定对象类型控制,
                */
                _itemsClick:function(obj){
                    var item=$(obj).parent().parent().next();
                    if(item.find("div.items").children().length>0){
                        item.slideDown(200);
                    }
                    else{
                        item.slideUp(200);
                    }
                },
                /*
                *绑定对象类型控制,
                */
                _doResult:function(){
                    var def=opts;
                    var ps=null;
                    var jtlid='',
                    jtlname='',
                    jtypeid='',
                    jtype='',
                    jtid='',
                    jtname='';
                    var nolmt=opts.lishow&&$("#"+opts.pid).find("a#nolimit").hasClass("cur_a");
                    var noname='';
                    if(def.pid!=""){
                        ps=$("#"+def.pid).find("div.province div.rainbow div.items a.cur_a");
                    }
                    if(!def.single&&def.pshow&&ps.length>1){
                        var psid='';
                        var psname='';
                        $.each(ps,function(i,o){
                            if(i>0){
                                psid+=","+$(o).attr("pid");
                                psname+="、"+$(o).text();
                            }
                            else{
                                psid+=$(o).attr("pid");
                                psname+=$(o).text();
                            }
                        });
                    }
                    else if(ps!=null&&!nolmt){
                        psid=ps.attr("pid");
                        psname=ps.text();
                    }
                    else if(nolmt){
                        nolmt=true;
                        noname="不限";
                    }
                    if(def.type=="jobtitle"){
                        var par=$("#"+def.tid);
                        jtlid=par.find("div.jt_level div.items a.cur_a").attr("lv");
                        jtlname=par.find("div.jt_level div.items a.cur_a").text();
                        jtypeid=par.find("div.jt_type div.items a.cur_a").attr("type");
                        jtype=par.find("div.jt_type div.items a.cur_a").text();
                        jtid=par.find("div.jt_name div.items a.cur_a").attr("jtid");
                        jtname=par.find("div.jt_name div.items a.cur_a").text();
                    }
                    var r={
                        zid:def.id!=""?$("#"+def.id).find("div.reg_cat div.items a.cur_a").data("zid"):"",//证书id
                        cname:def.id!=""?$("#"+def.id).find("div.reg_cat div.items a.cur_a").text():"",//分类名称
                        maj:def.id!=""?$("#"+def.id).find("div.reg_qual div.items a.cur_a").attr("mid"):"",//专业id
                        majname:def.id!=""?$("#"+def.id).find("div.reg_qual div.items a.cur_a").text():"",//专业名称
                        reg:def.id!=""?$("#"+def.id).find("div.reg_solu div.items a.cur_a").attr("type"):"",//注册类型
                        regname:def.id!=""?$("#"+def.id).find("div.reg_solu div.items a.cur_a").text():"",//注册名称
                        prov:psid,//省id
                        provname:psname,//省名称
                        city:def.pid!=""?$("#"+def.pid).find("div.province div.citys div.items a.cur_a").attr("cid"):"",//市id
                        cityname:def.pid!=""?$("#"+def.pid).find("div.province div.citys div.items a.cur_a").text():"",//市名称
                        pcount:def.id!=""?$("#"+def.id).find("input.pcount").val():"",//招聘人数
                        nolmt:nolmt,//是否限制地区
                        noname:noname,//不限
                        jtlid:jtlid,
                        jtlname:jtlname,
                        jtypeid:jtypeid,
                        jtype:jtype,
                        jtid:jtid,
                        jtname:jtname,
                        obj:cur
                    };
                    def.sure(r);
                },
                /*
                *生成添加模板
                */
                _genSelect:function(type){
                    var tmp='';
                    var bl=false;
                    var def=opts;
                    if(type=="default"){
                        if(def.id!=""&&$("#"+def.id).length==0){
                            tmp=slt.quality;
                            tmp=tmp.replace("{id}",def.id);
                            if(!def.pshow){
                                tmp=tmp.replace("{text}","确&nbsp;&nbsp;定");
                            }
                            else{
                                tmp=tmp.replace("{text}","继&nbsp;&nbsp;续");
                            }
                            bl=true;
                        }
                    }
                    else if(type=="jobtitle"){
                        if(def.tid!=""&&$("#"+def.tid).length==0){
                            tmp=slt.jobtitle;
                            tmp=tmp.replace("{id}",def.tid);
                            bl=true;
                        }
                    }
                    else if(type=="place"&&def.pshow){
                        if(def.pid!=""&&$("#"+def.pid).length==0){
                            tmp=slt.place;
                            tmp=tmp.replace("{id}",def.pid);
                            bl=true;
                        }
                    }
                    if(bl){
                        $('body').append(tmp);
                        if($.browser.mozilla){
                            $("div.select_cover div.select_bg").css("padding-top","0");
                        }
                    }
                    return bl;
                },
                /*
                *资质添加返回按钮点击事件
                */
                _closeClick:function(cid,pid){
                    var that=$("#"+cid);
                    var def=opts;
                    that.find("a.close_slt").click(function(){
                        that.fadeOut(200,function(){
                            if(pid!=null){
                                $("#"+pid).fadeIn(200);
                                def.step-=1;
                                if(def.step==0){
                                    def.step=1;
                                }
                            }
                        });
                    });
                },
                /*
                *a选项点击事件
                */
                _aClick:function(obj){
                    $(obj).unbind("click");
                    $(obj).bind("click",function(){
                        var tar=$(this);
                        tar.parent().find("a.cur_a").removeClass("cur_a");
                        tar.addClass("cur_a");
                    });
                },
                /******************* 资质添加 *******************/
                /*
                *生成分类列表
                */
                _genCatList:function(){
                    var tmp="<a href='javascript:;' cid='{cid}'>{cat}</a>";
                    var data=slt.GetAllCats(opts.qurl);
                    var str=[],t='',html='';
                    $.each(data.data,function(i,item){
                        t=tmp;
                        t=t.replace("{cid}",item.id).replace("{cat}",item.name);
                        str.push(t);
                    });
                    html=str.join('');
                    var par=$("div#"+opts.id).find("div.reg_cat div.items");
                    par.html(html);
                },
                /*
                *生成人数输入框
                */
                _genPeople:function(){
                    var ptmp='<div class="rainbow rainbow3 ftcount"><span>证书个数</span><div class="items"><input type="text" class="pcount"/> 个 <em class="gray">(须为整数)</em></div><p class="clr"></p></div>';
                    $("#"+opts.id).find("div.select_bg div.next").before(ptmp);
                },
                /*
                *资质添加文本框点击事件
                */
                _qualClick:function(){
                    cur.click(function(){
                        var def=opts;
                        if(!$(cur).hgsSelect.defaults.stopevent){
                            if(def.step==1){
                                var that=$("div#"+def.id);
                                if(that.length>0){
                                    that.fadeIn(200);
                                }
                                else{
                                    var selt=select;
                                    if(selt._genSelect(def.type)){
                                        selt._genCatList();
                                        that=$("div#"+def.id);
                                        if(!def.regshow){
                                            that.find("div.select_cont div.reg_solu").addClass("hidden");
                                            that.find("div.select_cont div.reg_solu div.items a:eq(1)").addClass("cur_a");
                                        }
                                        if(def.regshow&&def.reglishow){
                                            selt._genRegNoLimit();
                                        }
                                        selt._qualCatClick();
                                        selt._qualRegSolClick();
                                        selt._closeClick(def.id,null);
                                        selt._qualNextClick();
                                        //是否显示招聘人数文本框
                                        if(def.cshow){
                                            selt._genPeople();
                                        }
                                    }
                                }
                            }
                        }else{
                            return false;
                        }
                    });
                },
                /*
                *获取专业
                */
                _getMajor:function(cid,cname){
                    var data=slt.GetMajors(opts.murl,cid);
                    var html='';
                    $.each(data.data,function(i,o){
                        html+='<a href="javascript:;" mid="'+o.id+'">'+o.name+'</a>';
                    });
                    $("#"+opts.id).find("div.reg_qual div.mid div.items").html(html);
                    var items=$("#"+opts.id).find("div.reg_qual div.items a");
                    select._aClick(items);
                    if(data.sup){
                        $("#"+opts.id).find("div.reg_cat div.items a.cur_a").data("zid",data.sup);
                    }
                },
                /*
                *资质添加-分类/注册情况点击事件
                */
                _catRegClick:function(obj){
                    $(obj).bind("click",function(){
                        var par=$("div#"+opts.id);
                        var r=par.find("div.reg_solu div.items a.cur_a").attr("type");
                        var cid=par.find("div.reg_cat div.items a.cur_a").attr("cid");
                        var cname=par.find("div.reg_cat div.items a.cur_a").text()=="注册监理工程师"?true:false;
                        if((r=="1"||r=="3"||r=="4")&&cname){
                            $("#"+opts.id).find("div.reg_qual div.mid div.items").html("");
                            par.find("div.reg_cat div.items a.cur_a").data("zid",91);
                        }
                        else if($(this).parent().parent().hasClass("reg_cat")||r=="2"&&cname||!opts.regshow){
                            select._getMajor(cid,cname);
                        }
                        select._itemsClick($("#"+opts.id).find("div.reg_solu div.items a.cur_a"));
                    });
                },
                /*
                *资质添加分类点击事件
                */
                _qualCatClick:function(){
                    var that=$("div#"+opts.id).find("div.reg_cat div.items a");
                    select._aClick(that);
                    select._catRegClick(that);
                },
                /*
                *资质添加注册情况点击事件
                */
                _qualRegSolClick:function(){
                    var that=$("div#"+opts.id).find("div.reg_solu div.items a");
                    select._aClick(that);
                    select._catRegClick(that);
                },
                /*
                *资质添加注册情况点击事件
                */
                _genRegNoLimit:function(){
                    var tmp='<a href="javascript:;" type="4">不限</a>';
                    $("#"+opts.id).find("div.reg_solu div.items").append(tmp);
                },
                /*
                *资质添加继续按钮点击事件
                */
                _qualNextClick:function(){
                    var def=opts;
                    var that=$("#"+def.id);
                    select._bindBtn(that.find("div.btn3"));
                    that.find("a.qual_next").unbind("click").bind("click",function(){
                        var a=that.find("div.reg_cat div.items a.cur_a").length;
                        var b=that.find("div.reg_solu div.items a.cur_a").length;
                        var c=that.find("div.reg_qual div.items a.cur_a").length;
                        var d=that.find("input.pcount");
                        var e=true;
                        var f=true;
                        if(def.cshow&&(d.val()==""||!/^(\-?)(\d+)$/.test(d.val()))){
                            e=false;
                        }
                        if(that.find("div.reg_qual div.items").children().length>0&&c==0){
                            f=false;
                        }
                        if(a>0&&b>0&&f&&e){
                            that.fadeOut(200,function(){
                                if(def.pshow){
                                    opts.step=2;
                                }
                                select._iniPlace();
                                if(def.pshow&&$("#"+def.pid).length>0){
                                    $("#"+def.pid).fadeIn(200);
                                }
                                else{
                                    opts.step=1;
                                    select._doResult();
                                }
                            });
                        }
                        else{
                            alert("请先确认是否已选择或正确填写完所有相关信息以便继续下一步");
                        }
                    });
                },
                /******************* 地区添加 *******************/
                /*
                *生成省选择
                */
                _genPlace:function(){
                    var html='';
                    if(!opts.async){
                        var data=slt.GetArea();
                        var tmp='<div class="rainbow rainbow{count}"><span>';
                        $.each(data,function(i,o){
                            var pro=slt.GetProvince(i,opts.async);
                            var tp=tmp;
                            tp=tp.replace("{count}",i+1);
                            tp+=o+"</span><div class='items'>"
                            $.each(pro[1],function(n,item){
                                tp+='<a href="javascript:;" pid="'+pro[1][n]+'">'+pro[0][n]+'</a>';
                            });
                            tp+='</div><div class="clr"></div></div><div class="citys sc_items"></div>';
                            html+=tp;
                        });
                    }else{
                        var temp='<div class="rainbow">';
                            var pro=slt.GetProvince(opts.prvurl,opts.async);
                            var tp=temp;
                            tp+="<div class='items'>";
                            if(pro&&pro.ret==true){
                                $.each(pro.data,function(n,item){
                                    tp+='<a href="javascript:;" pid="'+item.id+'">'+item.name+'</a>';
                                });
                            }
                            tp+='</div><div class="clr"></div></div><div class="citys sc_items"></div>';
                            html+=tp;
                    }
                    $("#"+opts.pid+" div.province").html(html);
                },
                /*
                *省份不限
                */
                _genNoLimit:function(){
                    var tmp='<div class="rainbow rainbow0"><span>不限</span><div class="items"><a href="javascript:;" pid="0" id="nolimit">不限</a></div><p class="clr"></p></div>';
                    $("#"+opts.pid).find("div.province div.rainbow1").before(tmp);
                    select._noLimitClick();
                },
                /*
                *省份不限选中事件绑定
                */
                _noLimitClick:function(){
                    var par=$("#"+opts.pid).find("div.province a#nolimit");
                    par.toggle(function(){
                        $("#"+opts.pid).find("div.province div.items a.cur_a").removeClass("cur_a");
                        $(this).addClass("cur_a");

                    },function(){
                        $(this).removeClass("cur_a");
                    });
                    par.click(function(){
                        if($(this).hasClass("cur_a")){
                            if(!opts.sprov){
                                $("#"+opts.pid).find("div.province div.citys div.mid div.items").html("");
                                $("#"+opts.pid).find("div.province div.citys").slideUp(200);
                            }
                        }
                    });
                },
                /*
                *省点击事件(只具体到省，单选)
                */
                _provOnlyClick:function(){
                    var pro=$("#"+opts.pid).find("div.province div.items a");
                    pro.unbind("click");
                    pro.bind("click",function(){
                        var b=true;
                        if(opts.lishow&&$("#"+opts.pid).find("a#nolimit").hasClass("cur_a")){
                            b=false;
                        }
                        if(b){
                            var tar=$(this);
                            $("#"+opts.pid).find("div.province div.items a.cur_a").removeClass("cur_a");
                            tar.addClass("cur_a");
                        }else{
                            alert("若要指定地区,请取消不限选项");
                        }
                    });
                },
                /*
                *省点击事件(只具体到省，多选)
                */
                _provMultClick:function(){
                    $("#"+opts.pid).find("div.next").prepend(slt.multptip);
                    var pro=$("#"+opts.pid).find("div.province div.items a");
                    pro.toggle(function(){
                        var bl=true;
                        if($("#"+opts.pid).find("a#nolimit").hasClass("cur_a")){
                            bl=false;
                        }
                        if(bl){
                            var tar=$(this);
                            var cura=$("#"+opts.pid).find("div.province div.items a.cur_a");
                            if(cura.length<5){
                                tar.addClass("cur_a");
                            }
                            else{
                                alert("选择个数不能超过5个!");
                            }
                        }
                        else{
                            alert("若要指定地区,请取消不限选项");
                        }
                    },function(){
                        if($("#"+opts.pid).find("a#nolimit").hasClass("cur_a")){
                            alert("若要指定地区,请取消不限选项");
                        }else{
                            if($(this).hasClass("cur_a")){
                                $(this).removeClass("cur_a");
                            }else{
                                $(this).addClass("cur_a");
                            }
                        }
                    });
                },
                /*
                *省点击事件(具体到市，单选)
                */
                _provCityClick:function(){
                    var pro=$("#"+opts.pid).find("div.province div.items a");
                    var cbg='<div class="top"><p class="lf"></p><p class="rf"></p></div><div class="mid"></div><div class="bot"><p class="lf"></p><p class="rf"></p></div>';
                    $("#"+opts.pid).find("div.province div.citys").html(cbg);
                    pro.bind("click",function(){
                        var b=true;
                        if(opts.lishow&&$("#"+opts.pid).find("a#nolimit").hasClass("cur_a")){
                            b=false;
                        }
                        if(b){
                            var pid=$(this).attr("pid");
                            var html=select._genCity(pid);
                            var par=$(this).parent().parent().parent();
                            par.find("div.citys div.mid").html("");
                            par.find("div.citys").not($(this).parent().parent().next()).slideUp(200);
                            $(this).parent().parent().next().find("div.mid").html(html);
                            select._itemsClick($(this));
                            select._cityClick();
                        }
                    });
                },
                /*
                *生成城市
                */
                _genCity:function(pid){
                    var data=slt.GetCity(pid);
                    var html='';
                    $.each(data[0],function(i,o){
                        if(i>0){
                            html+='<a href="javascript:;" cid="'+data[1][i]+'">'+data[0][i]+'</a>';
                        }
                    });
                    html="<div class='items'>"+html+"</div>";
                    return html;
                },
                /*
                *城市点击事件(具体到市，单选)
                */
                _cityClick:function(){
                    select._aClick($("div.province div.citys div.mid a"));
                },
                /*
                *初始化地区选择
                */
                _iniPlace:function(){
                    var def=opts;
                    var selt=select;
                    if(selt._genSelect("place")){
                        if($("#"+def.pid).find("div.province").html()==""){
                            selt._genPlace();
                            if(def.step==1){
                                selt._closeClick(def.pid,null);
                            }
                            else{
                                selt._closeClick(def.pid,def.id);
                            }
                        }
                        //是否只精确到省且为单选
                        if(def.sprov&&def.single){
                            selt._provOnlyClick();
                        }
                        //是否只精确到省且为多选
                        if(def.sprov&&!def.single){
                            selt._provMultClick();
                        }
                        //是精确到城市且为单选
                        if(!def.sprov){
                            selt._provOnlyClick();
                            selt._provCityClick();
                        }
                        //是否显示不限选项
                        if(def.lishow){
                            selt._genNoLimit();
                        }
                        select._placeNextClick();
                    }
                },
                /*
                *绑定省选择
                */
                _placeClick:function(){
                    var def=opts;
                    cur.click(function(){
                        if(!$(cur).hgsSelect.defaults.stopevent){
                            select._iniPlace();
                            if($("#"+def.pid).length>0){
                                $("#"+def.pid).fadeIn(200);
                            }
                        }else{
                            return false;
                        }
                    });
                },
                /*
                *绑定省选择
                */
                _placeNextClick:function(){
                    var that=$("#"+opts.pid);
                    select._bindBtn(that.find("div.btn3"));
                    that.find("a.prov_next").unbind("click").bind("click",function(){
                        var r=that.find("div.province div.items");
                        var b=that.find("div.province div.citys");
                        var c=that.find("a#nolimit").hasClass("cur_a");
                        var bl=true;
                        if(!c&&r.find("a.cur_a").length==0){
                            bl=false;
                        }
                        else if(!c&&!opts.sprov&&b.find("a.cur_a").length==0){
                            bl=false;
                        }
                        if(!bl){
                            alert("请先确认是否已选择或填写完所有相关信息以便提交信息");
                        }
                        else{
                            select._doResult();
                            that.fadeOut(200);
                            opts.step=1;
                        }
                    });
                },
                /******************* 职称添加 *******************/
                /*
                *初始化职称证列表
                */
                _iniTitType:function(){
                    var data=slt.GetTiType(opts.gcurl);
                    var html='';
                    $.each(data.data,function(i,o){
                        html+='<a href="javascript:;" type="'+o.id+'">'+o.name+'</a>';
                    });
                    $("#"+opts.tid+" div.jt_type div.items").html(html);
                },
                /*
                *初始化职称证列表
                */
                _iniTitles:function(){
                    var t=$("#"+opts.tid).find("div.jt_type a.cur_a").attr("type");
                    var data=slt.GetJTitle(opts.zurl,t);
                    var html='';
                    $.each(data.data,function(i,o){
                        html+='<a href="javascript:;" jtid="'+o.id+'">'+o.name+'</a>';
                    });
                    $("#"+opts.tid).find("div.jt_name div.mid div.items").html(html);
                    select._aClick($("#"+opts.tid).find("div.jt_name div.mid div.items a"));
                },
                /*
                *初始化职称选择
                */
                _iniJTitle:function(){
                    if(select._genSelect("jobtitle")){
                        var selt=select;
                        selt._iniTitType();
                        //selt._iniTitles();
                        selt._condClick();
                        selt._closeClick(opts.tid,null);
                        selt._jtitleNextClick();
                    }
                    else{
                        $("#"+opts.tid).fadeIn(200);
                    }
                },
                /*
                *筛选条件点击事件绑定
                */
                _condClick:function(){
                    var that=$("#"+opts.tid);
                    var l=that.find("div.jt_level a");
                    var t=that.find("div.jt_type a");
                    select._aClick(l);
                    select._aClick(t);
//                    l.click(function(){
//                        select._iniTitles();
//                        select._itemsClick(that.find("div.jt_type div.items a.cur_a"));
//                    });
                    t.click(function(){
                        select._iniTitles();
                        select._itemsClick($(this));
                    });
                },
                /*
                *绑定职称选择
                */
                _jtitleClick:function(){
                    cur.unbind("click");
                    cur.bind("click",function(){
                        if(!$(cur).hgsSelect.defaults.stopevent){
                            select._iniJTitle();
                        }
                        else{
                            return false;
                        }
                    });
                },
                /*
                *绑定职称选择
                */
                _jtitleNextClick:function(){
                    var par=$("#"+opts.tid);
                    select._bindBtn(par.find("div.btn3"));
                    par.find("a.jtitle_next").bind("click",function(){
                        var a=par.find("div.jt_level a.cur_a").length;
                        var b=par.find("div.jt_name a.cur_a").length;
                        if(a<1){
                            alert("请确认选择了职称等级");
                        }else if(b<1){
                            alert("请确认选择了职称证");
                        }else{
                            select._doResult();
                            par.fadeOut(200);
                        }
                    });
                }
            });
            //初始化资质选择框
            select._bindClick();
        }
    });
    $.fn.hgsSelect.defaults={
        stopevent:false     //是否阻止文本框点击事件
    };
})(jQuery);