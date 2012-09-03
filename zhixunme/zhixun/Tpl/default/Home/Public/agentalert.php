<!--猎头推送弹出框-->
<?php if($popup_agent != NULL): ?>
    <div class="agentalert">
        <p class="hd"></p>
        <div class="del_a">
            <a href="javascript:;" class="chg_view" id="chg_view"></a>
            <a href="javascript:;" id="del_alert"></a>
        </div>
        <div class="ag_bg">
            <div class="lf">
                <img class="small" src="{$popup_agent.agent_photo}"/>
                <?php if($popup_agent->is_follow == 1): ?>
                    <p class="cared_btn"><span>已关注</span></p>
                    <elseif condition="$popup_agent neq null"/>
                    <div class="care_btn">
                        <div class="btn_common btn22">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="javascript:;" id="careta" class="white btn" uid="{$popup_agent.agent_uid}">+ 关注</a>
                        </div>
                    </div>
                    <else/>
                <?php endif; ?>
            </div>
            <div class="rf">
                <?php if($role == 1): ?>
                    <p>{$popup_agent.human_name},您好：</p>
                    <p class="ag_msg">我是猎头<a href="{$web_root}/{$popup_agent.agent_uid}" class="blue">{$popup_agent.agent_name}</a>，请完善您的简历并委托给我，我将为您精推荐优质企业，期待与您合作！</p>
                    <div class="btn_cont">
                        <div class="btn_common btn15">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="{$web_root}/resume/0" class="btn white">完善简历</a>
                        </div>
                    </div>
                    <div class="btn_cont btn_cont2">
                        <div class="btn_common btn14">
                            <span class="b_lf"></span>
                            <span class="b_rf"></span>
                            <a href="{$web_root}/{$popup_agent.agent_uid}" class="btn">委托给我</a>
                        </div>
                    </div>
                <?php endif; ?>
                <if condition="$role eq 2">
                <p>{$popup_agent.company_name},您好：</p>
                <p class="ag_msg">我是猎头<a href="{$web_root}/{$popup_agent.agent_uid}" class="blue">{$popup_agent.agent_name}</a>，请创建需求职位并委托给我，我将为您精选合适人才，期待与您合作！</p>
                <div class="btn_cont">
                    <div class="btn_common btn15">
                        <span class="b_lf"></span>
                        <span class="b_rf"></span>
                        <a href="{$web_root}/epubjob/0" class="btn white">创建职位</a>
                    </div>
                </div>
                <div class="btn_cont btn_cont2">
                    <div class="btn_common btn14">
                        <span class="b_lf"></span>
                        <span class="b_rf"></span>
                        <a href="{$web_root}/{$popup_agent.agent_uid}" class="btn">委托给我</a>
                    </div>
                </div>
                </if>
                <p class="clr"></p>
            </div>
            <p class="clr"></p>
        </div>
    </div>
    <div class="small_view hidden">
        <a class="review lf" href="javascript:;" id="review">
            <em></em>
            <span>推荐猎头</span>
        </a>
        <a id="small_close" href="javascript:;" class="lf close">关闭</a>
    </div>
<?php endif; ?>