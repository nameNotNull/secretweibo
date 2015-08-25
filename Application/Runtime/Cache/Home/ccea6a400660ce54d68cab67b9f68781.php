<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($title); ?></title>
<link href='/Public/Css/tqd0707.css' rel="stylesheet" type="text/css" />
<script src="/Public/Js/jquery.js" type="text/javascript"></script>
<script src="/Public/Js/jquery.validate.js" type="text/javascript"></script>
<!-- <script type="text/javascript">
	var  username;
	var password;
	function CheckForm(form)
	{
	
		username=$("#username").val();
		password=$("#password").val();
	    
		if(username.length>60)
		{
		$("#username_err").text("用户名字符不能超过60个"); 
		return false;
		}
		if(username.length<3)
		{
		$("#username_err").text("用户名字符不能小于3个"); 
		return false;
		}
		if(password.length>60)
		{
		$("#password_err").text("密码字符不能超过60个"); 
		return false;
		}
		if(!checkNull("username"))
		{
		$("#username_err").text("请输入用户名"); 
		return false;
		}
		if(!checkNull("password"))
		{
		$("#password_err").text("请输入密码");
		return false;
		 }
		 if(!islegal(username))
		{
		$("#username_err").text("请输入正确的用户名格式");
		return false;
		 }
		if(!islegal(password))
		{
		$("#password_err").text("含非法字符，请输入正确的密码");
		return false;
		 }

		
        $("#username_err").text(" ");	
		$("#password_err").text(" ");		
		return true;
		}	
	//判断字符是否合法，只能是英文字符、中文字符、@、.、-以及_
	function islegal(str) {
		if (str.search(/^[\a-\z\A-\Z0-9\u4E00-\u9FA5\@\._\-]+$/g) !== -1)
		{
			return true;
		}
		else
		{
			return false;
		}			
	}   

	//验证不能为空
	function checkNull(obj){
		if($("#"+obj).val()==null||$("#"+obj).val()==''||$("#"+obj).val().replace(/(^\s*)|(\s*$)/g,"")=="")
		{
			return false;
		}
		else
		{
		    return true;
		} 
	}
    
	//验证是否是Email
	function isEmail(strEmail) {
		if (strEmail.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) !== -1)
		{
			return true;
		}
		else
		{
			return false;
		}			
	}        

	
</script> -->
<script type="text/javascript">
$(function(){
	jQuery.validator.addMethod("userName", function(value, element) {  
		var name = /^[\a-\z\A-\Z0-9\@\._\-\u4E00-\u9FA5]{3,15}$/;
		return this.optional(element) || (name.test(value));
	}, "用户名格式不符");
	jQuery.validator.addMethod("pwdCheck", function(value, element) {  
		var tel = /^[A-Za-z0-9!@#$%^&*_]{3,60}$/;
		return this.optional(element) || (tel.test(value));
	}, "密码格式不符");
	$('#login_form').validate({
		errorPlacement: function(error, element){
			$('#'+($(element).attr('name'))+'_err').append(error);
		},
		onkeyup : false,
		rules : {
			username : {
				required : true,
				userName : true
			},
			password : {
				required : true,
				pwdCheck : true
			},
		},
		messages : {
			username : {
				required : '请输入用户名称',
				userName : '支持3-15位中文、英文、数字、下划线.-,'
			},	
			password  : {
				required : '请输入您的密码',
				pwdCheck : '支持3-60位数字、字母或字符组成的密码'
			},
		}
	});
});
</script>
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



<div class="ht_login">
	<h3>登录<a href='<?php echo U("Home/Index/register");?>' class="r1">注册</a></h3>
		<p>请直接登录</p>
	<form id='login_form' action='<?php echo U("Home/Index/login");?>' method='post'>
	<table width="570" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="75" height="55" valign="top"><span>*&nbsp;用户名</span></td>
		<td width="495" height="55"><input name="username" id="username" type="text" placeholder="请输入用户名称" />
		<div class="htinput_err" id='username_err'></div>
		
		</td>
	</tr>
	<tr>
		<td width="75" height="55" valign="top"><span>*&nbsp;您的密码</span></td>
		<td width="495" height="55"><input name="password" id="password" type="password" placeholder="请输入您的密码" />
		<div class="htinput_err" id='password_err'></div>
		</td>
	</tr>
	<tr>
		<td width="75" height="55"></td>
		<td width="495" height="55"><input type='submit' value='登录'><a href="javascript:void(0);" class="ht_logina1">错误按钮</a><a href='<?php echo U("Home/Member/findpw");?>' class="l1">忘记密码</a></td>
	</tr>
</table>
</form>
		
		
		
</div>
		
		
		
		



<div class="clear"></div> 






<!--main--><!--main--><!--main-->

<div class="clear"></div>

<!--piture--><!--piture--><!--piture-->
<div class="tqdtupian"></div>
<!--piture--><!--piture--><!--piture-->



<!--end--><!--end--><!--end-->
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

<!--end--><!--end--><!--end-->













</body>
</html>