<!--资讯右侧导航-->
<div class="m_na">
     <!--资讯右侧导航-->
     <div class="ad1">
        <!--     广告位1        -->
        <img src="{$voc_root}/imgs/temp/infodetailad2.png"  alt=""/>
     </div>
     <!--热门资讯-->     
     <div class="m_a m_c">         
          <h2 class="m_t">
             <a href="{$web_root}/articles/0/2" class="blue lf m_o t_x">热门资讯</a>
             <a class="blue rf more m_o cur_m" href="{$web_root}/articles/0/2">更多</a> 
         </h2>
         <p class="clr"></p>
          <ul>
             <foreach name="hotInfo" item="p1">
                    <li><a href="{$web_root}/article/0/{$p1.blog_id}"target="_blank"  class="gray" title="{$p1.title}">{$p1.title}</a></li>
              </foreach>
         </ul>
     </div>
     <!--推荐职场经验-->
     <div class="m_exp m_c">
         <h2 class="m_t">
             <a href="{$web_root}/articles/0/3" class="blue lf mp t_x">推荐职场经验</a>
             <a class="blue rf more mp"  href="{$web_root}/articles/0/3">更多</a> 
         </h2>
         <p class="clr"></p>
         <ul>
            <foreach name="recommendblog" item="p2">
                <li><a href="{$web_root}/article/1/{$p2.blog_id}"target="_blank"  class="gray" title="{$p2.title}">{$p2.title}</a></li>
            </foreach>
         </ul>
     </div>
     <div class="ad2">
        <!--     广告位2        -->
         <img src="{$voc_root}/imgs/temp/infodetailad1.png"  alt=""/>
     </div>
     <!--热门职场经验-->
     <div class="m_exp m_c">
         <h2 class="m_t">
             <a href="{$web_root}/articles/0/4" class="blue lf mh t_x">热门职场经验</a>
             <a class="blue rf more mh"  href="{$web_root}/articles/0/4">更多</a> 
         </h2>
         <p class="clr"></p>
         <ul>
            <foreach name="hotblog" item="p3">
                <li><a href="{$web_root}/article/1/{$p3.blog_id}"target="_blank"  class="gray" title="{$p3.title}">{$p3.title}</a></li>
            </foreach>
         </ul>
     </div>
     <!--猎头的职场经验-->
     <div class="m_exp m_c hidden">
         <h2 class="m_t">
             <a href="javascript:;" class="blue lf mag t_x">{$data.name}的职场经验</a>
             <a class="blue rf more mag"   href="javascript:;">更多</a> 
         </h2>
         <p class="clr"></p>
     </div>
<!--      公示公告
     <div class="m_a m_c">
          <h2 class="m_t">
             <a href="{$web_root}/articles/" title="公示公告" class="blue lf m_o t_x"  rel="8">公示公告</a>
             <a class="blue rf more m_o" href="{$web_root}/articles/">更多</a> 
         </h2>
         <p class="clr"></p>
          <ul>
             <foreach name="part2" item="p2">
                    <li><a href="{$web_root}/article/0/{$p2.blog_id}"target="_blank"  class="gray" title="{$p2.title}">{$p2.title}</a></li>
              </foreach>
         </ul>
     </div>
      文件通知
     <div class="m_n m_c">
          <h2 class="m_t">
             <a href="{$web_root}/articles/" title="文件通知" class="blue lf m_o t_x"  rel="9">文件通知</a>
             <a class="blue rf more m_o" href="{$web_root}/articles/">更多</a> 
         </h2>
         <p class="clr"></p>
          <ul>
              <foreach name="part3" item="p3">
                    <li><a href="{$web_root}/article/0/{$p3.blog_id}"target="_blank"  class="gray" title="{$p3.title}">{$p3.title}</a></li>
              </foreach>
         </ul>
     </div>
     政策法规
     <div class="m_p m_c">
          <h2 class="m_t">
             <a href="{$web_root}/articles/" title="政策法规" class="blue lf m_o t_x"  rel="10">政策法规</a>
             <a class="blue rf more m_o" href="{$web_root}/articles/">更多</a> 
         </h2>
         <p class="clr"></p>
          <ul>
            <foreach name="part4" item="p4">
                    <li><a href="{$web_root}/article/0/{$p4.blog_id}"target="_blank"  class="gray" title="{$p4.title}">{$p4.title}</a></li>
            </foreach>
         </ul>
     </div>  -->
</div>