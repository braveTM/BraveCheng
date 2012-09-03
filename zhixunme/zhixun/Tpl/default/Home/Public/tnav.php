<!--人才左侧导航-->
<div class="acc_set human">
    <div class="acc_de">
        <div class="my_pic">
            <a href="{$web_root}/{$info.user_id}"><img class="lf small" src="{$info.photo}"  alt="{$info.name}"/></a>
            <div class="lf role_info">
                <a class="name blue" href="{$web_root}/{$info.user_id}" title="{$info.name}">{$info.name}</a>
                 <span class="role gray">人才</span>
                <div class="auth_con">
                    <if condition="$info.real_auth eq 0">
                        <a href="{$web_root}/profiles/3" title="未通过实名认证"><img src="{$file_root}Files/system/auth/gnam.png"  class="l_small" alt="申请实名认证" /></a>
                        <else/>
                        <a href="{$web_root}/profiles/3" title="已通过实名认证"><img src="{$file_root}Files/system/auth/nam.png"  class="l_small" alt="修改实名认证" /></a>
                    </if>
                    <if condition="$info.phone_auth eq 0">
                         <a href="{$web_root}/profiles/3" title="未通过手机认证"><img src="{$file_root}Files/system/auth/gpho.png"  class="l_small" alt="申请手机认证" /></a>
                        <else/>
                         <a href="{$web_root}/profiles/3" title="已通过手机认证"><img src="{$file_root}Files/system/auth/pho.png"  class="l_small" alt="修改手机认证" /></a>
                    </if>
                    <if condition="$info.email_auth eq 0">
                         <a href="{$web_root}/profiles/3" title="未通过邮箱认证"><img src="{$file_root}Files/system/auth/gmes.png"  class="l_small" alt="申请邮箱认证"/></a>
                        <else/>
                         <a href="{$web_root}/profiles/3" title="已通过邮箱认证"><img src="{$file_root}Files/system/auth/mes.png"  class="l_small" alt="修改邮箱认证" /></a>
                    </if>
                </div>
            </div>
            <div class="clr"></div>
        </div>
        <p class="wszl">
            <span>资料完善度</span>
            <span class="compl_pro"><a class="blue" href="{$web_root}/profiles/">立即完善</a></span>
        </p>
        <div class="my_detail">
            <div class="pro">
                <span class="pro_per">{$info.soph}%</span>
                <div class="pro_bar">
                    <div class="bar1">
                        <div class="bar2" style="width:{$info.soph}px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clr"></div>
    </div>
    <!--简历管理-->
    <div class="b_com my_prof">
        <div class="area_title">
            <h2 class="a_title">简历管理</h2>
        </div>
        <div class="sub_p blue">
            <a href="{$web_root}/resume/" title="现在去完善" class="blue"><em></em>兼职简历完善</a>
        </div>
        <div class="sub_p blue">
            <a href="{$web_root}/resume/1" title="现在去完善" class="blue"><em></em>全职简历完善</a>
        </div>
        <div class="sub_p blue">
            <a href="{$web_root}/resume/2" title="我的全职求职意向" class="blue"><em></em>我的全职求职意向</a>
        </div>
        <div class="sub_p las_v">
            <a href="{$web_root}/resume/3" class="blue"><em></em>我的证书</a>
        </div>
    </div> 
    <!--职讯推荐-->
     <div class="b_com">
        <div class="area_title">
            <h2 class="a_title">职讯推荐</h2>
        </div>
         <div class="sub_p">
            <a href="{$web_root}/thome/" class="blue"><em></em>推荐职位</a>
        </div>
          <div class="sub_p">
            <a href="{$web_root}/thome/1" class="blue"><em></em>推荐企业</a>
        </div>
          <div class="sub_p las_v">
            <a href="{$web_root}/thome/2" class="blue"><em></em>推荐猎头</a>
        </div>
    </div>   
     <!--帐户中心-->
<!--    <div class="b_com">
        <div class="area_title">
            <h2 class="a_title">帐户中心</h2>
        </div>
        <div class="sub_p">
            <a href="{$web_root}/bill/"class="blue"><em></em>帐户充值</a>
        </div>
        <div class="sub_p las_v">
            <a href="{$web_root}/profiles/"class="blue"><em></em>帐户资料</a>
        </div>
        <div class="sub_p las_v">
            <a href="javascrip:;"class="blue"><em></em>隐私设置</a>
        </div>
         <div class="sub_p">
            <a href="{$web_root}/apromotion/"class="blue"><em></em>推广帐户</a>
        </div>
    </div>-->
     <!--职讯帮助指导-->
    <div class="b_com nbd">
        <div class="area_title">
            <h2 class="a_title">站内应用</h2>
        </div>
<!--        <div class="sub_p">
            <a href="{$web_root}/arefer/"class="blue" target="_blank"><em></em>受理发证信息查询</a>
        </div>-->
        <div class="sub_p">
            <a href="{$web_root}/prefer/"class="blue" target="_blank"><em></em>人员资格查询</a>
        </div>
         <div class="sub_p">
            <a href="{$web_root}/refer/"class="blue" target="_blank"><em></em>单位资质查询</a>
        </div>
        <div class="sub_p">
            <a href="{$web_root}/contactbook/"class="blue" target="_blank"><em></em>建设部门通讯录</a>
        </div>
        <div class="sub_p">
            <a href="{$web_root}/pdmail/"class="blue" target="_blank"><em></em>人事部门通讯录</a>
        </div>
         <div class="sub_p">
            <a href="{$web_root}/contract/"class="blue" target="_blank"><em></em>合同模板下载</a>
        </div>
    </div>
<!--    职讯小窍门
    <div class="b_com zxtips">
        <p class="a_title gray">职讯小窍门</p>
        <p><a href="{$web_root}/thome/" class="red">职讯推荐</a></p>
    </div>-->
    <!--推荐猎头/公司-->
<!--    <div class="b_com recom_b">
        <div class="area_title">
            <h2 class="a_title">推荐猎头</h2>
        </div>
        <div class="my_pic">
            <img class="lf small"  src="{$file_root}zhixun/Theme/default/imgs/temp/photo.png"  alt="名称"/>
            <h2><a class="red" href="javascript:;" title="">张三李四</a></h2>
            <p>四川-成都</p>
        </div>
        <div class="clr"></div>
        <p>服务：猎头服务</p>
        <div class="auth_con">
            <span class="name_con"><a href="{$page.arurl}" title="实名认证"><img src="{$page.auth_real}" alt="" class="l_small"/></a></span>
            <span class="phone_con "><a href="{$page.apurl}" title="手机认证"><img src="{$page.auth_phone}" class="l_small" alt=""/></a></span>
            <span class="email_con"><a href="{$page.aeurl}" title="邮箱认证"><img src="{$page.auth_email}" class="l_small" alt=""/></a></span>
        </div>
    </div>-->
</div>