<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($title); ?></title>
<link href="/Public/Css/tqd0707.css" rel="stylesheet" type="text/css" />
<script src="/Public/Js/jquery.js" type="text/javascript"></script>
<script src="/Public/Js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	jQuery.validator.addMethod("userName", function(value, element) {  
		var name = /^[\a-\z\A-\Z0-9\@\._\-\u4E00-\u9FA5]{3,15}$/;
		return this.optional(element) || (name.test(value));
	}, "用户名格式不符");
	jQuery.validator.addMethod("comPany", function(value, element) {  
		var name = /^[\a-\z\A-\Z0-9\u4E00-\u9FA5\@\._\-]{1,60}$/;
		return this.optional(element) || (name.test(value));
	}, "企业格式不符");
	jQuery.validator.addMethod("pwdCheck", function(value, element) {  
		var tel = /^[A-Za-z0-9!@#$%^&*_]{3,60}$/;
		return this.optional(element) || (tel.test(value));
	}, "密码格式不符");
	
	jQuery.validator.addMethod("email", function(value, element) {  
		var tel = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]{3,60}$/;
		return this.optional(element) || (tel.test(value));
	}, "邮箱格式不符");

	$('#register_form').validate({
		errorPlacement: function(error, element){
			$('#'+($(element).attr('name'))+'_err').append(error);
		},
		onkeyup : false,
		rules : {
			username : {
				required : true,
				userName : true
			},
			company : {
				required : false,
				comPany : true
			},
			password : {
				required : true,
				pwdCheck : true
			},
			password_confirm : {
				required : true,
				equalTo : '#password'
			},
			email : {
				required : true,
				email : true,
				maxlength : 60
			}
		},
		messages : {
			username : {
				required : '请输入用户名称',
				userName : '支持3-15位中文、英文、数字、下划线.-,'
			},
			company : {
				comPany : '支持0-60位中文、英文、数字、下划线.-,'
			},
			password  : {
				required : '请输入您的密码',
				pwdCheck : '支持3-60位数字、字母或字符组成的密码'
			},
			password_confirm : {
				required : '请再次确认密码',
				equalTo : '两次输入的密码不一致'
			},
			email : {
				required : '请输入您的邮箱',
				email   : '请输入有效邮箱',
				maxlength : '邮箱长度不得超过60个字符'
			}
		}
	});
});
</script>
</head>

<body>
<!--top--><!--top--><!--top-->
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

<!--top--><!--top--><!--top-->

<div class="ht_login">
    <h3>注册</h3>
    	<table width="570" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="470" height="55" valign="top"><p>如果已经注册过,请直接登录</p></td>
		<td width="100" height="55" valign="top"><a href="<?php echo U('Home/Index/login');?>" class="l1">直接登录</a>
		</td>
	</tr>

</table>
	
	<form id='register_form'  action='<?php echo U("Home/Index/register");?>'   method='post'>
	<table width="570" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="75" height="55" valign="top"><span>*&nbsp;用户名</span></td>
		<td width="495" height="55" valign="top"><input name="username" id='username' type="text" placeholder="请输入用户名" />
		<div class="htinput_err" id='username_err'></div>
		</td>
	</tr>
	<tr>
		<td width="75" height="55" valign="top"><span>*&nbsp;您的密码</span></td>
		<td width="495" height="55" valign="top"><input name="password" id='password' type="password" placeholder="请输入您的密码" />
		<div class="htinput_err" id='password_err'></div>
		</td>
	</tr>
	<tr>
		<td width="75" height="55" valign="top"><span>*&nbsp;确认密码</span></td>
		<td width="495" height="55" valign="top"><input name="repassword" id='password_confirm' type="password" placeholder="请输入您的密码" />
		<div class="htinput_err" id='password_confirm_err'></div>
		</td>
	</tr>
	<tr>
		<td width="75" height="55"></td>
		<td width="495" height="55"><input type='submit' value='注册'>	</tr>
</table></form>
		
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









<!--浮动按钮-->

<div class="right_fix" style="margin-left:615px;">
	<ul class="right_fix_lists">
		
		<li class="l7">
			<a class="right_f_bt" id="right_f_bt" href="javascript:vodi(0)" title="返回顶部"></a>
		</li>
				
		<!--{if $store.im_qq}-->
		<li class="l2">
			<a class="right_f_qq" title="" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=&site=qq&menu=yes"></a>
		</li>
		<!--{/if}-->
		
				
				<li class="l4"><a class="right_f_qq" title="" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=&site=qq&menu=yes"></a></li>
				<li class="l5"></li>
				<li class="l6"></li>
				
				
				
				<li class="l3" id="right_fix_lists_l3">
			<a href="javascript:void(0);"></a>
			<div class="right_f_history">
				<div class="right_f_history_c" id="right_f_history_c">X</div>
				<ul>

				</ul>
				<div class="right_f_historybgbox"></div>
			</div>
		</li>
				
	</ul>
</div>

<!--浮动按钮-->






</body>
</html>