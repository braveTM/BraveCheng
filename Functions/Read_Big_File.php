<?php

/**
 * 
 * @param type $filename
 * @param type $count
 * @param type $tag
 * @return type
 */
function readBigFile($filename, $count = 20, $tag = '\r\n') {
    $content = ''; //最终内容
    $_current = ''; //当前读取内容寄存
    $step = 1; //每次走多少字符
    $tagLen = strlen($tag);
    $start = 0; //起始位置
    $i = 0; //计数器
    $handle = fopen($filename, 'r+'); //读写模式打开文件，指针指向文件头
    while ($i < $count && !feof($handle)) {    //文件没有到结尾和小鱼需要读取得行数时
        fseek($handle, $start, SEEK_SET); //指针设置在文件开头
        $_current = fread($handle, $step); //读取文件
        $content .= $_current; //组合字符串
        $start += $step; //依据步长向前移动
        //依据分隔符的长度截取字符串最后免得几个字符
        $substrTag = substr($content, -$tagLen);
        if ($substrTag == $tag) {    //判断是否为判断是否是换行或其他分隔符
            $i++;
        }
    }
    //关闭文件
    fclose($handle);
    //返回结果
    return $content;
}

$filename = "D:/opt1.txt"; //需要读取的文件

$tag = "\r\n"; //行分隔符 注意这里必须用双引号

$count = 20000; //读取行数

$data = readBigFile($filename, $count, $tag);

function read_big_file($file) {
    $fp = fopen($file, "r");
    $line = 10;
    $pos = -2;
    $t = " ";
    $data = "";
    while ($line > 0) {
        while ($t != "\n") {
            fseek($fp, $pos, SEEK_END);
            $t = fgetc($fp);
            $pos--;
        }
        $t = " ";
        $data .= fgets($fp);
        $line--;
    }
    fclose($fp);
    return $data;
}

//echo read_big_file($filename);


set_time_limit(0);
echo '<h2>正在安装，请稍后...</h2>',
 '<div style="border:1px solid #000;width:500px;"><div id="progress_bar">loading...</div></div>';
for ($i = 1; $i <= 100; $i++) {
    $width = '500';
    $width = ceil(($i / 100) * $width);
    echo '<mce:script type="text/javascript"><!--',
    'var progress_bar = document.getElementById("progress_bar");',
    'progress_bar.style.background="#ff0000";',
    'progress_bar.style.width ="' . $width . 'px";',
    "progress_bar.innerHTML = '{$i}%';",
    '
// --></mce:script>';
    sleep(1);
    flush();
}
echo 'done';
