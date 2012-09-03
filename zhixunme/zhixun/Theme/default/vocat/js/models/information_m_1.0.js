/*
 *资讯 - model类
 */
function Information(){
    this.id="blog_id";
    this.title="title";
    this.body="body";
    this.rcount="read_count";
    this.status="status";
    this.ctime="create_datetime";
    this.name="name";
    this.photo="photo";
    this.email_auth="is_auth_email";
    this.phone_auth="is_auth_phone";
    this.real_auth="is_auth_real";
}
Information.prototype={
    /* 功能：发布行业心得
     * 参数：
     * a：标题
     * b：内容
     * c：发布类型（2：提交审核，1：保存为草稿）
     * d：文章来源
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 行情数据数组
     */
    CreateBlog:function(a,b,c,d,sf,ff){
        var s={
            url:WEBURL.CreateBlog,
            params:"title="+a+"&body="+b+"&status="+c+"&src="+d,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /* 功能：获取猎头行业心得列表
     * 参数：
     * a：第几页
     * b：页数
     * c：状态（1-未审核/草稿，2-审核中，3-审核通过，4-审核未通过）
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 行情数据数组
     */
    AGetBlogs:function(a,b,c,sf,ff){
        var s={
            url:WEBURL.AGetBlogs,
            params:"page="+a+"&size="+b+"&status="+c,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /* 功能：猎头删除行业心得
     * 参数：
     * a：博客编号
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 行情数据数组
     */
    ADeleBlog:function(a,sf,ff){
        var s={
            url:WEBURL.ADeleBlog,
            params:"blog_id="+a,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /* 功能：猎头提交申请行业心得
     * 参数：
     * a：博客编号
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 行情数据数组
     */
    AValidateBlog:function(a,sf,ff){
        var s={
            url:WEBURL.AValidateBlog,
            params:"blog_id="+a,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /* 功能：猎头修改行业心得
     * 参数：
     * a：博客编号
     * b：标题
     * c：内容
     * d：发布类型（2：提交审核，1：保存为草稿）
     * e：文章来源
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 行情数据数组
     */
    AUpdateBlog:function(a,b,c,d,e,sf,ff){
        var s={
            url:WEBURL.AUpdateBlog,
            params:"blog_id="+a+"&title="+b+"&body="+c+"&status="+d+"&src="+e,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /* 功能：获取行业心得
     * 参数：
     * page：第几页
     * size：条数
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 行情数据数组
     */
    getTrexpList:function(page,size,sf,ff){
        var s={
            url:WEBURL.AgeExplist,
            params:"page="+page+"&size="+size,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /* 功能：职场经验赞一下
     * 参数：
     * a：职场经验id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 行情数据数组
     */
    blogPraise:function(a,sf,ff){
        var s={
            url:WEBURL.blogPraise,
            params:"blog_id="+a,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    },
    /* 功能：资讯赞一下
     * 参数：
     * a：资讯id
     * sf：异步获取数据成功后执行的方法对象
     * ff：异步获取数据失败后执行的方法对象
     * 返回值：array => 行情数据数组
     */
    InfoPraise:function(a,sf,ff){
        var s={
            url:WEBURL.infoPraise,
            params:"art_id="+a,
            sucrender:sf,
            failrender:ff
        };
        HGS.Base.HAjax(s);
    }
};
