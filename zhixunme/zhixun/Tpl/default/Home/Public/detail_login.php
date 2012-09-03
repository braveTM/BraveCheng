<!--未登录详细页登录框-->
<div class="detail_login" id="detailogin">
    <div class="des hidden">
        <if condition="$agent.name neq ''">
            <h1>您好，欢迎访问我的主页，我是猎头{$agent.name}，您可以在这里:</h1>
            <elseif condition="$company.name neq ''"/>
            <h1>您好，欢迎访问{$company.name}，您可以在这里:</h1>
            <elseif condition="$profile.name neq ''"/>     
            <h1>您好，欢迎访问我的主页，我是{$profile.name}，您可以在这里:</h1>
            <else/>
            <h1>职讯网,专注于打造中国最专业的建筑职业平台,您可以在这里:</h1>
        </if>
        <div id="close" class="close"></div>
        <ul><li><div class="icon fw"></div><div class="text">①找工作</div></li>
            <li><div class="icon fh"></div><div class="text">②招高级人才</div></li>
            <li><div class="icon bnet"></div><div class="text">③建立行业人脉</div></li>
            <li><div class="icon info"></div><div class="text">④了解一手行业资讯</div></li>
            <li><div class="icon mor"></div><div class="text">更多内容,尽在职讯!</div></li>
        </ul>
        <div class="border1"></div>
        <div class="border"></div></div>
    <div class="lf login_lf gray">
        <if condition="$agent.name neq ''">
            <span>您好，欢迎访问我的主页，我是猎头{$agent.name}，登陆后浏览更多求职招聘信息!</span>
            <elseif condition="$company.name neq ''"/>
            <span>您好，欢迎访问{$company.name}，登陆后浏览更多求职招聘信息!</span>
            <elseif condition="$profile.name neq ''"/>     
            <span>您好，欢迎访问我的主页，我是{$profile.name}，登陆后浏览更多求职招聘信息!</span>
            <else/><span>登陆后浏览更多求职招聘信息!</span>
        </if>                
        <div class="icon"></div>        
    </div>
    <div class="login gray">
        <div class="user">帐 号:<input type="text" id="user" class="gray" value="电子邮箱/手机"></div>
        <div class="note_msg blue"><em class="remb"></em><span class="remb" id="remb">忘记密码?</span>
            <em class="sel" id="rec" rel="1"></em><span class="anto" id="rec1">下次自动登录</span></div>
        <div class="psw">密 码:<input id="psw" type="password"></div>
        <div class="btn15_common btn_common btn15">
            <span class="b_lf"></span>
            <span class="b_rf"></span>
            <a href="javascript:;" id="log" class="btn white">立即登录</a></div>
    </div>
    <div class="lf login_rf gray">
        <span class="msg">还没有帐号?</span>
        <div class="btn_common btn14 hreg">
            <span class="b_lf"></span>
            <a href="javascript:;" title="人才注册" class="btn">人才注册</a></div>
        <div class="btn_common btn14 ereg">
            <a href="javascript:;" title="猎头注册" class="btn">猎头注册</a>
        </div>
        <div class="btn_common btn14 creg">
            <span class="b_rf"></span>
            <a href="javascript:;" title="企业注册" class="btn">企业注册</a>
        </div>
    </div>
</div>
<div class="cards_cover_login hidden"></div>