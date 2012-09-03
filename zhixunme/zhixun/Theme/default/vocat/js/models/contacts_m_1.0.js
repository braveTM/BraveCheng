/*
 * 人脉 - model类
 */
function Contacts(){}
Contacts.prototype={
    /* 功能：查看联系信息
     * 参数：
     * object_id:职位ID
     * object_type:类型：2
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array =>
     */
    CheckContWay:function(a,type,sf,ff){
        var s={
            url:WEBURL.GetContact,
            params:"object_id="+a+"&object_type="+type,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(s);
    }
}
