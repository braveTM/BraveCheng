<!--热点职位搜索-->   
<div class="job_search">
    <div class="se_box">
        <div class="kws">
            <input type="text" class="gray lf" rel="" value="<if condition="empty($pre_condition[word])">请输入您要找的职位<else/>{$pre_condition[word]}</if>" id="keywords" />
        </div>
        <a class="se_btn white lf" id="search" href="javascript:;"></a>                            
        <if condition="empty($pre_condition[salary]) && empty($pre_condition[pub_date]) && empty($pre_condition[require_place])">
            <a href="javascript:;" class="lf blue  m" id="se_advance"><em>+</em>高级搜索</a>
            <else/><a href="javascript:;" class="lf blue" id="se_advance"><em>-</em>高级搜索</a>
        </if>                            
        <div class="clr"></div>
    </div>
    <div class="hot_words" id="hotwords">
        <span class="gray">热门关键词：</span>
        <foreach name="hot_keyword" item="vo">
            <a href="javascript:;">{$vo[keyword]}</a>
        </foreach>                            
    </div>    
        <ul class="se_more hidden"  id="advance">        
                <li><span class="gray">要求地区：</span>
                    <input id="place" type="text" class="mselect" value="不限" />
                    <input id="pid" type="hidden" value="{$pre_condition[require_place]}" />
                </li>
                <li class="salary">
                    <span class="gray">薪资待遇：</span>                               
                    <a href="javascript:;" rel="0" class="sel">全部</a>
                    <a href="javascript:;" rel="1">0-3万</a>
                    <a href="javascript:;" rel="2">3-5万</a>
                    <a href="javascript:;" rel="3">5-15万</a>
                    <a href="javascript:;" rel="4">15-30万</a>
                    <a href="javascript:;" rel="5">30-100万</a>
                    <a href="javascript:;" rel="6">100万+</a>
                    <a href="javascript:;" rel="7">面议</a>
                </li>
                <li class="pub_date">
                    <span class="gray">发布时间：</span>
                    <a href="javascript:;" class="sel" rel="0">全部</a>
                    <a href="javascript:;" rel="1">1周内</a>
                    <a href="javascript:;" rel="2">半月内</a>
                    <a href="javascript:;" rel="3">1月内</a>
                    <a href="javascript:;" rel="4">6个月内</a>
                    <a href="javascript:;" rel="5">1年内</a>
                </li>
            </ul>
            <div class="clr"></div>
            </div>
            <div class="clr"></div>
            <div class="se_result">
                <div class="header" id="pos_list">
                    <span class="gray lf">排序方式:</span>                                   
                    <a class="sel" href="javascript:;" rel="0">默认</a>
                    <a class="count_gray count" href="javascript:;">浏览数<em  class="down cdw" rel="1"></em></a>
                    <a href="javascript:;">薪资待遇<em class="up" rel="3"></em><em class="down" rel="2"></em></a>
                    <a href="javascript:;">发布时间<em class="up" rel="5"></em><em class="down" rel="4"></em></a>
                    <span id="authuser" <if condition="$pre_condition[is_real_auth] eq 2 || empty($pre_condition[is_real_auth])">class="auth cancel lf"<else/>class="auth lf"</if>><em></em>认证用户</span>
                    <span id="cert" <if condition="$pre_condition[cert_type] eq 2 || empty($pre_condition[cert_type])">class="auth cancel lf"<else/>class="auth lf"</if>><em></em>资质证书</span>            
                    <switch name="search_page_count" >
                    <case value="0"></case>
                    <case value="1"></case>
                    <default  />
                        <a href="javascript:;" class="rf" id="next">></a>
                        <a href="javascript:;" class="rf gray" id="prev"><</a>      
                        <span class="pages rf">1/{$search_page_count}</span>
                    </switch>
                    <div class="clr"></div>
                </div>                     
                <div class="se_list">
                    <ul id="findjoblist" class="hgstemp mlist">
                        <li class="loading"><p class="gray">职位加载中请稍等...</p></li>
                    </ul>                                    
                    <div id="pagination" class="pages"></div>
                    <div class="clr"></div>
                </div>                            
            </div>