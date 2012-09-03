<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC  "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>错误页 - {$title}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="{$voc_root}/imgs/system/favicon.ico"/>  
        <meta name='keywords' content='{$kwds}'>
        <meta name='description' content='{$desc}'>
        <style>
            body,html{
                background-color:#FCF6E8;
                width:100%;
                height:100%;
                font-size:13px;
                margin:0px;
                position:relative;
                z-index:-10;
            }
            a{
                color:#9c6;
                text-decoration:none;
            }
            a:hover{
                color:#000;
            }
            .logo ,.img404, .img1, .img2 ,.bg{
                background-image:url(./zhixun/Theme/default/vocat/imgs/system/404.png);
            }
            #main{
                position:relative;
                z-index:-111;
                height:100%;
            }
            .page404{
                margin:0 auto;
                width:960px;
                padding-top:20px;
                _text-align: center;
            }
            .info404{
                height:160px;
                width:670px;
                position:absolute;
                top:50%;
                left:50%;
                margin-left:-335px;	
                margin-top:-80px;
                _text-align:left;
            }
            .info404 div{
                float:left;
            }
            .logo{
                background-repeat:no-repeat;
                width:115px;
                height:38px;
            }
            .img404{
                background-color:#fff;
                width:169px;
                height:130px;
                background-repeat:no-repeat;
                background-position:-165px 0px;

            }
            .msg404{
                width:410px;
                height:100px;
                margin-left:90px;
                color:#666;	
            }
            .msg404 p{
                line-height: 30px;
            }
            .msg404 font{
                font-family:Arial, Helvetica, sans-serif;
                color:#6cc;
                padding:0 5px;
            }
            h1{
                color:#9c3;
                font-family:Arial, Helvetica, sans-serif;
                font-weight:100;
            }
            .footer{
                width:100%;
                float:left;
                position:absolute;	
                bottom:0px;
                z-index:-1;
                clear:both;
                _text-align: center;
            }
            .footer .img{
                margin:0 auto;
                width:960px;
                height:200px;
            }
            .footer .img1{
                background-position:0 -38px;
                height:98px;
                width:157px;
                float:left;
                position:relative;
                top:117px;
            }
            .footer .img2{
                background-position:0 -138px;
                height:198px;
                width:290px;
                float:right;
                position:relative;
                top:15px;
            }
            .footer .bg{
                height:20px;
                background-repeat:repeat-x;
                background-position:0 -350px;
            }
            .copyright{
                text-align:center;
                padding-top:5px;
                line-height:30px;
            }
        </style>
    </head>
    <body onload="h()">
        <div id="main">
            <div class="page404">
                <div class="logo"></div>
                <div class="info404">
                    <div class="img404"></div>
                    <div class="msg404">
                        <h1>Error 404</h1>
                        <p>
                            亲爱的用户：<br />
                            你访问的页面已经删除或丢失,<font id="timer">5</font>秒之后将自动跳转到首页!&nbsp;&nbsp;<a href="{$web_root}/">回到首页</a>
                        </p>
                    </div>	
                </div>
            </div>
            <div class="footer">
                <div class="img">
                    <div class="img1"></div>
                    <div class="img2"></div>
                </div>
                <div class="bg"></div>
                <div class="copyright">
                    &copy; 2012 职讯 <a href="{$web_root}/about/">职讯简介</a> <a href="{$web_root}/contactus/">联系我们</a> <a href="{$web_root}/joinus/">招贤纳士</a> <a href="{$web_root}/feedback/">建议反馈</a></div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        function h(){
            var ie=navigator.appVersion;
            var ie6 = ie.search(/MSIE 6/i);
            var h=screen.availHeight-125;
            var main=document.getElementById("main");	
            if(ie6!=-1)
                main.style.height=h+"px";
            else
                main.style.minHeight=550+"px";
            t();
        }
        function t(){
            var t=5;
            setInterval(function(){
                if(t>0){
                    t=t-1;
                    document.getElementById("timer").innerHTML=t;
                }
            },1000);
            setTimeout(function(){
                location.href="{$web_root}";
            },5000);
        }
    </script>
</html>
