<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>邮箱注册成功 - {$title}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
    </head>
    <body style="margin: 0;font-size: 13px;color: #232323;line-height: 30px;
          padding:0;text-align: center;
          background: #ecedf1 url('{$file_root}zhixun/Theme/default/imgs/system/headerbg.png') no-repeat center top;">
        <div style="margin:166px auto 0 auto;
             background: url('{$file_root}zhixun/Theme/default/imgs/system/listshadow.png') repeat-y -2043px 0;
             width:826px;
             position: relative;">
            <a style="color:blue;display: block;position: absolute;top:-48px;right:10px;cursor: pointer;_top:-110px;" href="{$web_root}">返回首页</a>



           <div style="margin: -60px 60px 0 60px;padding: 0 0 40px 0;">
                <div style="font-size: 20px;color: #cc0000;
                     text-align: center;
                     line-height: 80px;">
                    恭喜你！邮箱已验证成功
                </div>
                <p style="line-height: 100px;"><span id="timer">5秒</span>之后将自动跳转至首页</p>
            </div>




        </div>
        <div style="background: url('{$file_root}zhixun/Theme/default/imgs/system/listshadow.png') no-repeat -2871px 0;
             margin:0 auto 40px auto;
             height:10px;
             width: 826px;">
        </div>
         <script type="text/javascript">
        var t=5;
        setInterval(function(){
            t=t-1;
            document.getElementById("timer").innerHTML=t;
        },1000);
        setTimeout(function(){
            location.href="{$file_root}";
        },5000);
    </script>
    </body>
</html>
