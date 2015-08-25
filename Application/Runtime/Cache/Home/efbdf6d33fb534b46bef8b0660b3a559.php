<?php if (!defined('THINK_PATH')) exit(); if(C('LAYOUT_ON')) { echo ''; } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>跳转提示</title>
<link href="/Public/Css/tqd0707.css" rel="stylesheet" type="text/css" />
<style type="text/css">
*{padding: 0; margin: 0; }
body{background:#fff; font-family: '微软雅黑'; color: #333; font-size:16px; }
.system-message{ padding: 24px 48px; text-align:center;}
.system-message .jump{ padding-top: 10px}
.system-message .jump a{ color: #333;}
.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px }
.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
</style>

</head>
<body>
<div class="tqdtop">
	<div class="tqdtopbox">
    	<div class="tqdtopboxdiv">
        	<a href="<?php echo F('SiteDomain');?>" class="tqdlogo"></a>
        	
            <div class="div">
            	<p><span>你好,</span><?php if($username): echo ($username); ?> , <a href="<?php echo U('/Member/index');?>" class="a1">会员中心</a>  , <a href="<?php echo U('Home/Member/logout');?>">退出</a><?php else: ?>游客</span><?php endif; ?> | &nbsp;&nbsp;&nbsp;<a href="">在线咨询</a></p>
                <p>服务热线：<span>4006-9191-01/05</span></p>
            </div>
            
        </div>
    </div>
</div>

<div class="system-message" id="message">
<?php if(isset($message)): ?><img src="/Public/Image/success.png" width="72" height="72" alt="√" />
<p class="success"><?php echo($message); ?></p>
<?php else: ?>
<img src="/Public/Image/error.png" width="72" height="72" alt="×" />
<p class="error"><?php echo($error); ?></p><?php endif; ?>
<p class="detail"></p>
<p class="jump">
页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
</p>
</div>
<script type="text/javascript">
(function(){
var height  = document.documentElement.clientHeight
var mheight = document.getElementById('message').offsetHeight
var mtop = Math.ceil((height - 2*mheight)/2)
if(mtop > 0){
	document.getElementById('message').style.marginTop = mtop+'px'
}
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
<!--piture--><!--piture--><!--piture-->
<div class="tqdtupian"></div>
<!--piture--><!--piture--><!--piture-->
<!--end--><!--end--><!--end-->
<div class="footer">
	<a href="http://www.henrongyi.com/">很容易软件商城</a> | <a href="http://www.csix.cn/itxuanxing/">产品选型</a> | <a href="http://www.csix.cn/itwangzhi/">企业黄页</a> | <a href="#">在线商城</a> | <a href="http://www.csix.cn/v5_gywm/wzdh.shtml">采购平台</a> | <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=4006919101&amp;site=qq&amp;menu=yes" target="_blank">产业园区</a> | <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=4006919101&amp;site=qq&amp;menu=yes" target="_blank">关于软交所</a> | <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=4006919101&amp;site=qq&amp;menu=yes" target="_blank">帮助中心</a>
    <div class="text">
		<p>版权所有北京软件和信息服务交易所 京ICP证120704号 京公网安备 11010802008614号</p>
		<p>Copyright&copy;2011 Beijing Software and Information Services Excharge co., Ltd All Rights Resrved Powered by Cmstop</p>
	</div>
</div>
<!--end--><!--end--><!--end-->




<!--<a href="/sitemap.html">网站地图</a>  <?php echo F('WebCountCode');?>--> 

</body>
</html>