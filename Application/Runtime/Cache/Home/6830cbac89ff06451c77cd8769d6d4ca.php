<?php if (!defined('THINK_PATH')) exit();?><!--引入头部html-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=10;IE=9;IE=8;IE=7;" />
<meta charset="utf-8">
<title>逗你玩</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
	content="组间好友匿名发微博及评论">
<meta name="author" content="逗你玩Team">

<!-- The styles -->
<link id="bs-css" href="/Public/Css/bootstrap-classic.css" rel="stylesheet">
<style type="text/css">
{literal}
@media (min-width: 768px) and (max-width: 979px) {
	body {
		padding-top: 100px;
		padding-bottom: 40px;
	}	
}
@media (min-width: 979px){
	body {
		padding-top: 80px;
		padding-bottom: 40px;
	}
}

.sidebar-nav {
	padding: 9px 0;
}
{/literal}
</style>
<link href="/Public/Css/widget_all.css" rel="stylesheet">
<link href="/Public/Css/jquery-ui-1.8.21.custom.css" rel="stylesheet">

<link href='/Public/Css/fullcalendar.css' rel='stylesheet'>
<link href="/Public/Css/bootstrap-responsive.css" rel="stylesheet">
<link href="/Public/Css/charisma-app.css" rel="stylesheet">
<link href="/Public/Css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
<link href='/Public/Css/chosen.css' rel='stylesheet'>
<link href='/Public/Css/uniform.default.css' rel='stylesheet'>
<link href='/Public/Css/colorbox.css' rel='stylesheet'>
<link href='/Public/Css/jquery.noty.css' rel='stylesheet'>
<link href='/Public/Css/noty_theme_default.css' rel='stylesheet'>
<link href='/Public/Css/jquery.iphone.toggle.css' rel='stylesheet'>
<link href='/Public/Css/opa-icons.css' rel='stylesheet'>
<link href='/Public/Css/datetimepicker.css' rel='stylesheet'>

<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	  <script src="http:/html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
<!-- jQuery -->
<script src="/Public/Js/jquery-1.7.2.min.js?{$app_version}"></script>
</head>
<style type="text/css">
.row{
	margin-left:10px;
	margin-right:10px;
}
body{
	padding-top:0px;
}
</style>
<body>
<script type="text/javascript">
    function getComment(id){
        var pid =id;
        var url ='<?=U("User/getComment");?>';
        $('#postcomment'+pid).toggle();
        $.ajax({
            url:url,
            type:'POST',
            dataType:'JSON',
            data:{'pid':pid},
            async:false,
            success:function(msg){
                var commentData;
                for(var i=0;i<msg.length;i++){
                    commentData = msg[i];
                if(msg!=null){
                    //if('undefined' == typeof(dataNow.error) ){
                        var html = '<div class="WB_info" >'+commentData.vuser+'</div><div class="WB_text feed_list_content">'+commentData.content+'</div><div class="WB_text feed_list_content">'+commentData.ctime+'</div>';
                        var div= document.createElement("li");
                        div.innerHTML=html;
                        $('#postcomment'+pid).append(div);
                }
            }
            }
        });
    }
    function postComment(id){
        var pid = id;
        var content = $("#comment_content"+pid).val();
        var url ='<?=U("User/postComment");?>';
        $.ajax({
            url:url,
            type:'POST',
            dataType:'JSON',
            data:{'pid':pid,'content':content},
            async:false,
            success:function(msg){
                var commentData = msg;
                if(msg!=null){
                    var html = '<div class="WB_info" >'+commentData.vuser+'</div><div class="WB_text feed_list_content">'+commentData.content+'</div><div class="WB_text feed_list_content">'+commentData.ctime+'</div>';
                    var div= document.createElement("li");
                    div.innerHTML=html;
                    $('#postcomment'+pid).append(div);
                }
            }
        });
    }



</script>
<!--发微博模块-->
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2>有什么新鲜事想告诉大家？</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                <form id='login_form' action='<?php echo U("Home/User/publishMsg");?>' method='post'>
                    <div class="form-group">
                        <label for="weibo_content">微博</label>
                        <textarea class="form-control" name = "publish" id="weibo_content" placeholder="分享些什么"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pushToGroup">好友组</label>
                        <select id="pushToGroup" data-rel="chosen" placeholder="选择好友组">
                            <option value="-1" >请选择好友组</option>
                            {foreach from=$group item=v}
                            <option>{$v.gname}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="anonymousType">匿名分类</label>
                        <select id="anonymousType" name="vtypeselect" data-rel="chosen" placeholder="匿名分类">
                            <option value="-1" >请选择匿名类别</option>
                            <?php if(is_array($vUserType)): $i = 0; $__LIST__ = $vUserType;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option <?php if($v["vtype"] == '海贼王'): ?>selected<?php endif; ?>><?php echo ($v["vtype"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default">
                        发布
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--微博消息feed-->
<!--{if $feed_publish|@count > 0}
{foreach from=$feed_publish item=v}-->
<?php if(is_array($contentData)): $i = 0; $__LIST__ = $contentData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="WB_left">
                <div class="WB_photo"></div>
            </div>
            <div class="WB_right">
                <div class="WB_info" title="{v.vuser}"><?php echo ($list['vuser']); ?></div>
                <div class="WB_text feed_list_content"><?php echo ($list['content']); ?></div>
                <div class="WB_time"><?php echo (date('Y-m-d H:i:s',$list['ctime'])); ?></div>
            </div>
            <!--清除浮动-->
            <div class="clearfix"></div>
            <div class="WB_handle">
                <ul class="WB_row_line WB_row_r4 clearfix S_line2"  >
                    <li>
                        <a class="S_txt2" title="评论" id="comment<?php echo ($list['id']); ?>" style="cursor:pointer" herf="javascript:void(0);" attr="<?php echo ($list['id']); ?>" onclick="getComment(<?php echo ($list['id']); ?>);"type="fl_comment" >评论 {v.comm_num}</a><a class="S_txt2" title="点赞" type="fl_like" href="javascript:void(0);">点赞 {v.like_num}</a>
                    </li>
                    <li style="display:none" id="postcomment<?php echo ($list['id']); ?>" >   
                        <div class="form-group">
                        <label for="weibo_content">微博</label>
                        <textarea class="form-control" name = "publishcomment" id="comment_content<?php echo ($list['id']); ?>" placeholder="评论些什么"></textarea>
                        <a class="S_txt2" title="发表评论"style="cursor:pointer" herf='javascript:void(0);'attr="<?php echo ($list['id']); ?>" onclick="postComment(<?php echo ($list['id']); ?>);" herf="javascript:void(0);" "type="fl_comment" >发表评论</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>
<!--{/foreach}
{/if}-->
<!--引入尾部html-->
<hr>
<footer>
	<p class="pull-left">
		&copy; 2014 - 2015 All Rights Reserved 逗你玩团队 版权所有
	</p>
	<p class="pull-right">
		Powered by: <a href="http://rd.intra.sina.com.cn" target="_blank">Sina R&D</a>
	</p>
</footer>
<!-- external javascript
	================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- jQuery UI -->
<script src="/Public/Js/jquery-ui-1.8.21.custom.min.js"></script>
<!-- transition / effect library -->
<script src="/Public/Js/bootstrap-transition.js"></script>
<!-- alert enhancer library -->
<script src="/Public/Js/bootstrap-alert.js"></script>
<!-- modal / dialog library -->
<script src="/Public/Js/bootstrap-modal.js"></script>
<!-- confirm / extends modal -->
<script src="/Public/Js/bootstrap-confirm.js"></script>
<!-- custom dropdown library -->
<script src="/Public/Js/bootstrap-dropdown.js"></script>
<!-- scrolspy library -->
<script src="/Public/Js/bootstrap-scrollspy.js"></script>
<!-- library for creating tabs -->
<script src="/Public/Js/bootstrap-tab.js"></script>
<!-- library for advanced tooltip -->
<script src="/Public/Js/bootstrap-tooltip.js"></script>
<!-- popover effect library -->
<script src="/Public/Js/bootstrap-popover.js"></script>
<!-- button enhancer library -->
<script src="/Public/Js/bootstrap-button.js"></script>
<!-- accordion library (optional, not used in demo) -->
<script src="/Public/Js/bootstrap-collapse.js"></script>
<!-- carousel slideshow library (optional, not used in demo) -->
<script src="/Public/Js/bootstrap-carousel.js"></script>
<!-- autocomplete library -->
<script src="/Public/Js/bootstrap-typeahead.js"></script>
<!-- tour library -->
<script src="/Public/Js/bootstrap-tour.js"></script>
<!-- library for cookie management -->
<script src="/Public/Js/jquery.cookie.js"></script>
<!-- calander plugin -->
<script src='/Public/Js/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='/Public/Js/jquery.dataTables.min.js'></script>

<!-- chart libraries start -->
<script src="/Public/Js/excanvas.js"></script>
<script src="/Public/Js/jquery.flot.min.js"></script>
<script src="/Public/Js/jquery.flot.pie.min.js"></script>
<script src="/Public/Js/jquery.flot.stack.js"></script>
<script src="/Public/Js/jquery.flot.resize.min.js"></script>
<!-- chart libraries end -->

<!-- select or dropdown enhancer -->
<script src="/Public/Js/jquery.chosen.min.js"></script>
<!-- checkbox, radio, and file input styler -->
<script src="/Public/Js/jquery.uniform.min.js"></script>
<!-- plugin for gallery image view -->
<script src="/Public/Js/jquery.colorbox.min.js"></script>
<!-- rich text editor library -->
<script src="/Public/Js/jquery.cleditor.min.js"></script>
<!-- notification plugin -->
<script src="/Public/Js/jquery.noty.js"></script>
<!-- file manager library -->
<script src="/Public/Js/jquery.elfinder.min.js"></script>
<!-- star rating plugin -->
<script src="/Public/Js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="/Public/Js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="/Public/Js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="/Public/Js/jquery.uploadify.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="/Public/Js/jquery.history.js"></script>
<!-- datetimepicker widget -->
<script src="/Public/Js/datetimepicker.min.js"></script>
<!-- application script for Charisma demo -->
<script src="/Public/Js/charisma.js"></script>
<script src="/Public/Js/common.js"></script>
<script type="text/javascript" src="/Public/Js/jquery.ztree.js"></script>
<script type="text/javascript" src="/Public/Js/widget/issue.js"></script>
<script type="text/javascript" src="/Public/Js/widget/sidebar.js"></script>
<!-- <link href="/Public/Js/zTree/zTreeStyle.css" rel="stylesheet"> -->
<!-- {if $pagelet_scripts != ""}
{foreach from=$pagelet_scripts item=pl_js}
<script type="text/javascript" src="{$pl_js}"></script>
{/foreach}
{/if} -->

</body>
</html>