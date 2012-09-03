<!-- layout::Home:Public:ie6::60 -->
<!---------------------------企业 back header--------------------------->
<div class="bheader" id="bheader">
    <div class="bh_cont">
        <a class="logo lf title" id="logo_a" href="{$web_root}/{$user_id_self}/index/" title="回到首页">
            <img src="{$voc_root}/imgs/system/logo.png" alt="" /> 
        </a>
        </script>
        <span class="mliner" id="mliner"></span>
        <input type="hidden" id="utp" value="1"/>
        <div class="lf bh_nav">
            <a href="{$web_root}/{$user_id_self}/index/">个人中心</a>
            <a href="{$web_root}/recruitment/">招聘管理</a>
            <a href="{$web_root}/efc/">找人才</a>
            <a href="{$web_root}/efa/">找猎头</a>
            <a href="{$web_root}/contacts/">人脉</a>
            <a href="{$web_root}/news/" target="_blank">行业资讯</a>
        </div>         
        <ul class="bh_cm">
            <li class="fr_li">
                <div class="navborder lf"></div>                
                <em id="msgnum">2</em>
                <a href="{$web_root}/messages/" class="lin">消息</a>
                <div class="children lstchild">
                    <p class="top"></p>
                    <div class="mid">
                        <div class="mid_bg">
                            <div id="msgtips">
                            </div>
                        </div>
                    </div>
                    <p class="bot"></p>
                </div>
            </li>
            <li class="fst_li"><a href="{$web_root}/invitation/" class="lin">邀请</a></li>
            <li class="sc_li">
                <a href="{$web_root}/profiles/" class="lin">帐号</a>
                <div class="children">
                    <p class="top"></p>
                    <div class="mid">
                        <div class="mid_bg">
                            <div class="lf photo">
                                <img class="lf m_small" src="{$info.photo}"  alt="{$info.name}"/>
                            </div>
                            <div class="lf">
                                <p class="name"><span>{$info.name}</span><span class="gray"> - 企业</span></p>
                                <a href="{$web_root}/profiles/" class="blue">帐号资料</a>
                            </div>
                            <p class="clr"></p>
                            <p class="uhomea">
                                <a href="{$web_root}/bill/" class="blue">我的账户</a><span class="blue"> | </span><a href="{$web_root}/mpackage/" class="blue">我的套餐</a><span class="blue"> | </span><a href="{$web_root}/epromotion/" class="blue">我要推广</a>
                            </p>
                        </div>
                    </div>
                    <p class="bot"></p>
                </div>
            </li>
            <li class="lst_li"><a href="{$web_root}/user_exit" id="exit" class="lin">安全退出</a></li>
        </ul>
    </div>
</div>