/*
 * 证书 - model类
 */
function Cert(){}
Cert.prototype={
    /* 功能：删除人才证书
     * 参数：
     * a：证书编号
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    DeleTCert:function(a,sf,ff){
        var set={
            url:WEBURL.DeleTCert,
            params:"cid="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：人才添加证书
     * 参数：
     * a：注册证书编号（多个用,隔开）
     * b：注册地（多个用,隔开）
     * c：注册情况（多个用,隔开）
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    AddTCert:function(a,b,c,sf,ff){
        var set={
            url:WEBURL.AddTCert,
            params:"rs="+a+"&&ps="+b+"&&cs="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：修改人才职称证书
     * 参数：
     * a：证书编号
     * b：职称证书编号
     * c：职称证书等级
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    UpdateTTitle:function(a,b,c,sf,ff){
        var set={
            url:WEBURL.UpdateTtitle,
            params:"cid="+a+"&&gid="+b+"&&gclass="+c,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    },
    /* 功能：修改人才职称证书
     * 参数：
     * a：证书id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：真值 => true | false
     */
    RemoveTitleCt:function(a,sf,ff){
        var set={
            url:WEBURL.RemoveTitleCt,
            params:"cid="+a,
            sucrender:sf,
            failrender:ff
        };
	HGS.Base.HAjax(set);
    }
}
