<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ten thousand years too long</title>
</head>
<body>
<?php
function IsMobile()
{
    //如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if(isset($_SERVER['HTTP_X_WAP_PROFILE']))  return TRUE;
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if(isset($_SERVER['HTTP_VIA']))
    {
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    //判断手机发送的客户端标志,兼容性有待提高
    if(isset($_SERVER['HTTP_USER_AGENT']))
    {

        $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile');

        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if(preg_match('/('.implode('|', $clientkeywords).')/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return TRUE;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if(isset($_SERVER['HTTP_ACCEPT']))
    {
        //如果只支持wml并且不支持html那一定是移动设备
        //如果支持wml和html但是wml在html之前则是移动设备
        if((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false ||
                (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return TRUE;
        }
    }
    return FALSE;
}
if(IsMobile()){
?>
<img src="img/bg.jpg">
<div class="content">
    <div id="tishi"></div>
    <input id="pwd" size="6">
    <div class="in" onclick="check()">
        <div class="in-1"><div class="in-2"></div></div>
    </div>
</div>
<div class="select">
    <a href="birthday/index.php" id="birthday">birthday</a>
    <a href="album/index.html" id="album">album</a>
    <a href="superman/index.html" id="superman">superman</a>
</div>
<style>
    .select{
        display: none;
        width: 100%;
        z-index: 99;
        top: 30%;
        font-size: 5rem;
        color: white;
        text-align: center;
        position: absolute;
    }
    .select a{
        color: white;
        text-decoration: none;
        display: block;
        padding: 1rem;
        border: 1px solid white;
        margin: 4rem;
    }
    #tishi{
        height: 4rem;
        text-align: center;
        margin: 20px;
        font-size: 4rem;
        color: white;
    }
    .in .in-1{
        width: 100px;
        height: 20px;
        background: rgba(255,255,255,0.38);
        position: relative;
        margin: auto;
    }
    .in .in-2{
        border: 30px solid transparent;
        border-left: 40px solid rgba(255,255,255,0.38);;
        width: 0;
        height: 0px;
        position: absolute;
        right: 0;
        margin-right: -70px;
        margin-top: -20px;
        border-radius: 2px;
    }
    body img{
        width: 100%;
        height: 100%;
    }
    .content{
        position: absolute;
        top: 30%;
        z-index: 99;
        text-align: center;
        width: 100%;
    }
    .content input{
        width: 50%;
        background-color: transparent;
        height: 6rem;
        font-size: 5.5rem;
        text-align: center;
        color: white;
        letter-spacing: 1.8rem;
    }
    .content div{
        margin: 150px 0;
        font-size: 4.5rem;
    }
</style>
<script>
    eval(function(p,a,c,k,e,r){e=function(c){return c.toString(a)};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('d 9(){c a=1.3(\'e\').6;7(a==8){1.2(\'b\')[0].4.5=\'f\';1.2(\'g\')[0].4.5=\'h\'}i{1.3(\'j\').k="你还是不懂我"}}',21,21,'|document|getElementsByClassName|getElementById|style|display|value|if|290125|check||content|var|function|pwd|none|select|block|else|tishi|innerHTML'.split('|'),0,{}))
</script>
<?php
}else{
    ?>
    <style>
        body{background:#fff;}
    </style>
    <div style="width:600px;height:600px;background:url(img/code.png);margin:0 auto 0;"></div>
    <?php
}
?>
</body>
</html>
