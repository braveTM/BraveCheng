/*
 *我的账单 - model类
 */
function Bill(){}
//HGS.Base.Extend(User,BaseClass);
Bill.prototype={
    /* 功能：获取账单明细列表
     * 参数：
     * a: 账单类型（0为所有，1为收入，2为支出）
     * b：第几页
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：账单明细数组和总条数 => 是否唯一
     */
    GetBill:function(a,b,sf,ff){
        var s={
            url:BILLURL.GetBill,
            params:"type="+a+"&page="+b,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /* 功能：充值
     * 参数：
     * a: 充值金额
     * b：支付方式id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：账单明细数组和总条数 => 是否唯一
     */
    recharge:function(a,b,sf,ff){
        var s={
            url:BILLURL.Recharge,
            params:"money="+a+"&type="+b,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /**
     * 更换已拥有套餐,续费已拥有套餐
     * 缺少参数路径
     * @author jack
     * @date 2012-12-21
     */
//    updatePackage:function(v,s,f){
//        var settings={
//            url:BILLURL.UpdatePac,
//            params:"id="+v,
//            sucrender:s,
//            failrender:f
//        };
//        HGS.Base.HAjax(settings);
//    },
//    /*
//     *功能：获取可选择的推广位
//     *参数：page
//     */
//    getPromoteList:function(page,s,f){
//        var settings={
//            url:BILLURL.GetProtList,
//            params:"page="+page,
//            sucrender:s,
//            failrender:f
//        };
//        $("div").attr("pageid",page);
//        HGS.Base.HAjax(settings);
//    },
//    /*
//     *功能：抢占推广位
//     *参数：promote_id
//     *days
//     *jack
//     *2011.12.23
//     *
//     */
//    RobProPosition:function(id,day,s,f){
//        var settings={
//            url:BILLURL.RobProList,
//            params:"promote_id="+id+"&days="+day,
//            sucrender:s,
//            failrender:f
//        };
//        HGS.Base.HAjax(settings);
//    },
    /*
     *功能：猎头购买推广品牌为位
     *参数：id：服务编号
     *days：购买天数
     *sf：成功执行
     *ff:失败执行
     *jack
     *2012-2-23
     */
    BuyRecmmend:function(d,y,sf,ff){
        var settings={
            url:BILLURL.DoBuyRecommend,
            params:"id="+d+"&days="+y,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(settings);
    },
    /*
     *功能：采用线下汇款方式操作
     *参数：汇款金额 money
     *sf：成功：返回订单号
     *ff：失败执行函数
     *jack
     *2012-2-24
     */
    PayOfflineHan:function(a,sf,ff){
        var settings={
            url:BILLURL.DoHkOffline,
            params:"money="+a,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(settings);
    },
    /*
     *企业抢占品牌墙推广位
     *参数：
     *id：推广位编号
     *days：购买天数
     *sf：成功执行
     *ff：失败执行
     */
    RobRecomPos:function(i,d,sf,ff){
        var settings={
            url:BILLURL.DoRobRecomPos,
            params:"id="+i+"&days="+d,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(settings);
    },
    /* 功能：购买套餐
     * 参数：
     * a: 套餐id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：账单明细数组和总条数 => 是否唯一
     */
    BuyPackage:function(a,sf,ff){
        var settings={
            url:BILLURL.BuyPackage,
            params:"id="+a,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(settings);
    },
    /* 功能：套餐续费
     * 参数：
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：账单明细数组和总条数 => 是否唯一
     */
    RenewPackage:function(sf,ff){
        var settings={
            url:BILLURL.RenewPackage,
            params:"",
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(settings);
    },
    /* 功能：积分兑换套餐
     * 参数：
     * a: 套餐id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：
     * @author：joe 2012/7/22
     */
    ChangePackage:function(a,sf,ff){
        var settings={
            url:BILLURL.ChangePackage,
            params:"id="+a,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(settings);
    },
    /* 功能：积分续费
     * 参数：
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：
     */
    RechangePackage:function(sf,ff){
        var settings={
            url:BILLURL.ScorRenewPackage,
            params:"",
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(settings);
    },
    /* 功能：付费操作检测
     * 参数：
     * a：付费操作编号
     * b：其它参数字符串
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：账单明细数组和总条数 => 是否唯一
     */
    PayCheck:function(a,b,sf,ff){
        var settings={
            url:BILLURL.PayCheck,
            params:"mid="+a+b,
            sucrender:null,
            failrender:null
        };
        return HGS.Base.HAjax(settings,false);
    },
    /* 功能：我的套餐 - 单项续费 - 续费结果获取
     * 参数：
     * a：续费项
     * b：续费积分
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：账单明细数组和总条数 => 是否唯一
     */
    GetSChrRes:function(a,b,sf,ff){
        var settings={
            url:BILLURL.GetSChrRes,
            params:"id="+a+"&va="+b,
            sucrender:sf,
            failrender:ff
        };
        return HGS.Base.HAjax(settings);
    },
    /* 功能：使用统计 - 单项续费 - 立即续费
     * 参数：
     * a：续费项
     * b：续费积分
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：账单明细数组和总条数 => 是否唯一
     */
    RSChrRes:function(a,b,sf,ff){
        var settings={
            url:BILLURL.RSChrRes,
            params:"id="+a+"&va="+b,
            sucrender:sf,
            failrender:ff
        };
        return HGS.Base.HAjax(settings);
    },
    /* 功能：使用统计 - 单项续费 - 续费项提示获取
     * 参数：
     * a：续费项
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：账单明细数组和总条数 => 是否唯一
     */
    GetSChrTips:function(a,sf,ff){
        var settings={
            url:BILLURL.GetSChrTips,
            params:"id="+a,
            sucrender:sf,
            failrender:ff
        };
        return HGS.Base.HAjax(settings);
    },
    /* 功能：电话拨打充值面值请求
     * 参数：
     * a：续费项
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：账单明细数组和总条数 => 是否唯一
     */
    GetFaceValue:function(sf,ff){
        var settings={
            url:BILLURL.GetFaceValue,
            params:'',
            sucrender:sf,
            failrender:ff
        };
        return HGS.Base.HAjax(settings);
    }
}
