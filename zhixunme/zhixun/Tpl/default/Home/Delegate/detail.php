<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>委托详细 - {$title}</title>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/base_1.0.css"/>
        <link type="text/css" rel="stylesheet" href="{$voc_root}/css/msgdetail_1.0.css"/>
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <!--[if IE 6]>
            <link type="text/css" rel="stylesheet" href="{$voc_root}/css/ie6_1.0.css"/>
        <![endif]-->
        <script type="text/javascript" src="{$voc_root}/config/loader.js" id="loader">24</script>       
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body>
        <!-- layout::{$bheader}::0 -->
        <div class="layout1 msgdetail deledetail">
            <div class="layout1_l">
                <div class="module_1">
                    <!-- layout::{$nav}::0 -->
                </div>
            </div>
            <div class="layout1_r">
                <div class="module_2">
                    <div class="sm_tab">
                        <ul>
                            <li class="cur_li"><a href="javascript:;">委托详细</a></li>
                        </ul>
                        <div class="sub_title">
                            <a href="javascript:;" title="" class="blue">委托管理</a>
                        </div>
                    </div>
                    <div class="infocontent">
                        <if condition="$detail.status eq 4">
                            <div class="msg_cont detail_info">
                                <else/><div class="msg_cont">
                                    </if>
                                    <div class="lf photo">
                                        <a href="{$web_root}/{$detail.uid}">
                                            <img class="small" src="{$detail.uphoto}" alt="{$detail.uname}" title="{$detail.uname}"/>
                                        </a>
                                    </div>
                                    <div class="lf intro">
                                        <a href="javascript:history.go(-1);" class="blue">返回</a>
                                        <if condition="$detail.status eq 4">
                                            <div>
                                                <span>{$detail.uname}</span>
            <!--                                <img class="l_small" src="{$web_root}/zhixun/Theme/default/imgs/temp/upic.png" alt="{$detail.uname}">
                                                <img class="l_small" src="{$web_root}/zhixun/Theme/default/imgs/temp/upic.png" alt="{$detail.uname}">
                                                <img class="l_small" src="{$web_root}/zhixun/Theme/default/imgs/temp/upic.png" alt="{$detail.uname}">
                                                <img class="l_small" src="{$web_root}/zhixun/Theme/default/imgs/temp/upic.png" alt="{$detail.uname}">-->
                                                <span class="gray">({$detail.date})</span>
                                            </div>
                                            <div class="gray">
                                                <span>电话: {$detail.phone}</span>
                                                <span>邮箱:{$detail.email}</span>
                                                <span>QQ: {$detail.qq}</span>
                                            </div>
                                            <else/>
                                            <p>{$detail.uname}</p>
                                            <p class="gray">{$detail.date}</p>
                                        </if>
                                    </div>
                                    <div class="clr"></div>
                                </div>
                                <div class="msg_content">
                                    <if condition="$detail.status eq 4">
                                        <p class="replay_msg">
                                        <else/><p>
                                    </if>
                                    &nbsp;&nbsp;&nbsp;&nbsp;{$detail.content}</p>
                                </div>
                                <div class="dele_replay">
                                    <if condition="$detail.status eq 2">
                                        <p class="replay_pic replay_pic_m">未回复</p>
                                    </if>
                                    <if condition="$detail.status eq 4">
                                        <p class="replay_pic replay_pic_yes">已接受</p>
                                    </if>
                                    <if condition="$detail.status eq 3">
                                        <p class="replay_pic replay_pic_no">已拒绝</p>
                                    </if>
                                    <!-----------------------委托人查看回复情况区-------------------------->
                                    <if condition="$detail.status eq 3">
                                        <div class="replay_situation">
                                            <p class="replay_title">回复:</p>
                                            <div class="msg_cont">
                                                <div class="lf photo">
                                                    <img class="small" src="{$file_root}zhixun/Theme/default/imgs/temp/upic.png" alt="{$detail.uname}">
                                                </div>
                                                <div class="lf intro">
                                                    <div>
                                                        <p>{$detail.runame}</p>
                                                        <p class="gray">({$detail.rdate})</p>
                                                    </div>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                            <p class="replay_msg">&nbsp;&nbsp;&nbsp;&nbsp;{$detail.rcontent}</p>
                                        </div>
                                    </if>
                                    <if condition="$detail.status eq 4"><!--已接受-->
                                        <div class="replay_situation">
                                            <p class="replay_title">回复:</p>
                                            <div class="detail_info rep_cont">
                                                <div class="lf photo">
                                                    <img class="small" src="{$file_root}zhixun/Theme/default/imgs/temp/upic.png" alt="{$detail.uname}">
                                                </div>
                                                <div class="lf intro">
                                                    <div>
                                                        <span>{$detail.runame}</span>
        <!--                                                <img class="l_small" src="{$file_root}zhixun/Theme/default/imgs/temp/upic.png" alt="{$detail.uname}">
                                                        <img class="l_small" src="{$file_root}zhixun/Theme/default/imgs/temp/upic.png" alt="{$detail.uname}">
                                                        <img class="l_small" src="{$file_root}zhixun/Theme/default/imgs/temp/upic.png" alt="{$detail.uname}">
                                                        <img class="l_small" src="{$file_root}zhixun/Theme/default/imgs/temp/upic.png" alt="{$detail.uname}">-->
                                                        <span class="gray">({$detail.rdate})</span>
                                                    </div>
                                                    <div class="gray">
                                                        <span>电话: {$detail.rphone}</span>
                                                        <span>邮箱:{$detail.remail}</span>
                                                        <span>QQ: {$detail.rqq}</span>
                                                    </div>
                                                </div>
                                                <div class="clr"></div>
                                            </div>
                                            <p class="replay_msg">&nbsp;&nbsp;&nbsp;&nbsp;{$detail.rcontent}</p>
                                        </div>
                                    </if>
                                    <!-----------------------代理回复区-------------------------->
                                    <if condition="$detail.show_reply eq 1"><!--未回复-->
                                        <div class="replay_area">
                                            <div class="replay_txt">
                                                <p>回复:</p> <textarea cols="" rows="" id="rep_content"></textarea>
                                            </div>
                                            <div class="a_contract">
                                                <p>请留下您的常用联系方式，便于职讯客服、企业或猎头/公司联系到您!</p>
                                                <p class="lst_p">请选择联系方式: </p>
                                                <div id="t_con_way" class="t_con_way">
                                                    <input type="checkbox" name="t_cont_tel"/><span>电话</span>
                                                    <input type="checkbox" name="t_cont_em"/><span>邮箱</span>
                                                    <input type="checkbox" name="t_cont_qq"/><span>QQ</span>
                                                </div>
                                                <div class="t_contract">
                                                    <div class="t_con_item">
                                                        <p>电话: </p><input type="text" id="t_cont_tel" value="{$detail.phone}"/>
                                                    </div>
                                                    <div class="t_con_item">
                                                        <p>邮箱: </p><input type="text" id="t_cont_em" value="{$detail.email}"/>
                                                    </div>
                                                    <div class="t_con_item">
                                                        <p>QQ : </p><input type="text" id="t_cont_qq" value="{$detail.qq}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accept lf" id="accept">
                                                <div class="btn_common btn5">
                                                    <span class="b_lf"></span>
                                                    <span class="b_rf"></span>
                                                    <a href="javascript:;" class="btn" id="accbtn" did="{$detail.id}">接受委托</a>
                                                </div>
                                            </div>
                                            <div class="refuse rf" id="refuse">
                                                <div class="btn_common btn3">
                                                    <span class="b_lf"></span>
                                                    <span class="b_rf"></span>
                                                    <a href="javascript:;" class="blue btn" id="refbtn" did="{$detail.id}">拒绝委托</a>
                                                </div>
                                            </div>
                                            <div class="clr"></div>
                                        </div>
                                    </if>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
            <!-- layout::Public:footersimple::60 -->
    </body>
</html>