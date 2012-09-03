<!--猎头超级管理员左侧导航-->
<div class="module_1">
                    <div class="comlogo">
                        <img src="{$broker.photo}" alt="" />
                    </div>                    
                    <h3 class="comname">{$broker.name}</h3>
                    <div class="count lf">
                        <div class="sum">成员<span class="num">{$result.total_person}</span>人</div>
                        <div class="isline">
                            <ul>
                                <li class="on"><em></em><span class="num">{$result.is_online}</span>人在线</li>
                                <li class="off"><em></em><span class="num">{$result.off_line}</span>人离线</li>
                            </ul>
                        </div>
                    </div>
                    <div class="tc lf">
                        <h3 class="tcname">当前使用<span class="yellow">{$menu.title}</span>套餐</h3>
                        <ul>
                            <foreach name="menu.modules" item="mm">
                                <li><em class="gray lf">{$mm.name}</em>
                                     <if condition="$mm.s_count eq '-1'">
                                      <em class="c rf">不限
                                    <else /><em class="c rf">{$mm.s_count}个
                                   </if></em></li>
                            </foreach>
                        </ul>
                    </div>
                </div>