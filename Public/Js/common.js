$(document).ready(function(){
	var isPlaceholderSupport = "placeholder" in document.createElement("input");
	if(!isPlaceholderSupport){
		$("input").each(
			function(){
				if($(this).val()=="" && $(this).attr("placeholder")!=""){
					$(this).val($(this).attr("placeholder"));
					$(this).focus(function(){
						if($(this).val()==$(this).attr("placeholder")) $(this).val("");
					});
					$(this).blur(function(){
						if($(this).val()=="") $(this).val($(this).attr("placeholder"));
					});
				}
		});
	}
	//顶导判断当前地址
	$('ul.top-nav-menu li a').each(function(){
		var r = $.inArray(window.location.pathname.split("/")[1], $(this).attr("active-path").split("|"));
		if(r != -1){
			$(this).parent().addClass('active');
		}
	});
	// 模板样式
	var current_theme = $.cookie('current_theme')==null ? 'classic' :$.cookie('current_theme');
	//switch_theme(current_theme);
	
	$('#themes a[data-value="'+current_theme+'"]').find('i').addClass('icon-ok');
				 
	$('#themes a').click(function(e){
		e.preventDefault();
		current_theme=$(this).attr('data-value');
		$.cookie('current_theme',current_theme,{expires:365, path: '/', domain:'.intra.sina.com.cn'});
		switch_theme(current_theme);
		$('#themes i').removeClass('icon-ok');
		$(this).find('i').addClass('icon-ok');
	});
	
	
	function switch_theme(theme_name)
	{
		$('#bs-css').attr('href','/css/bootstrap-'+theme_name+'.css');
	}
	
	// 左侧菜单选中状态
	$('ul.main-menu li a').each(function(){
		var href = String(window.location).split("?");
		//左导航包括问号时url的匹配
		if($($(this))[0].href.match(/info\?/)!=null){
			hrefinfo = String($($(this))[0].href).split("staff=");
			 hrefleft = String(window.location).split("staff=");
			if(hrefinfo[0]==  hrefleft[0])
				$(this).parent().addClass('active');
		}
		if($($(this))[0].href.match(/\?/)!=null){
			if($($(this))[0].href== window.location)
				$(this).parent().addClass('active');
		}
		if($($(this))[0].href== href[0])
			$(this).parent().addClass('active');
	});
	
	//全站通知
	comNoty = {
		success : function(txt){
			noty({"text":txt,layout:"top",type:"success",timeout:200});
		},	
		error : function(txt){
			noty({"text":txt,layout:"top",type:"error",timeout:3000});
		},
		info : function(txt){
			noty({"text":txt,layout:"top",type:"information",timeout:3000});
		},
		alert : function(txt){
			noty({"text":txt,layout:"top",type:"alert",timeout:3000});
		}
	};
	
	// 全局用户插件
	RtUser = {
		addUserGroupModal : function(){
			if($("#rt_uergroup_modal_container").length != 0){
				$("#rt_uergroup_modal_container").html("");
			}else{
				$(document.body).append('<div id="rt_uergroup_modal_container"></div>');
			}
			$.post(
				'/aj/user?__a=usergroupmodal',
				{},
				function(d){
					if(d.code != '0'){
						comNoty.error(d.msg);
					}else{
						$("#rt_uergroup_modal_container").html(d.data);
						$("#rt_uergroup_modal").modal("show");
					}
				}
			);
		}
	};
	
	// 附件图片列表
	//gallery controlls container animation
	$('ul.gallery li').hover(function(){
		$('img',this).fadeToggle(1000);		
	},function(){
		$('img',this).fadeToggle(1000);		
	});

	//gallery colorbox
	$('.showbox a').colorbox({rel:'showbox a', transition:"elastic", maxWidth:"95%", maxHeight:"95%"});

	//gallery fullscreen
	$('#toggle-fullscreen').button().click(function () {
		var button = $(this), root = document.documentElement;
		if (!button.hasClass('active')) {
			$('#thumbnails').addClass('modal-fullscreen');
			if (root.webkitRequestFullScreen) {
				root.webkitRequestFullScreen(
					window.Element.ALLOW_KEYBOARD_INPUT
				);
			} else if (root.mozRequestFullScreen) {
				root.mozRequestFullScreen();
			}
		} else {
			$('#thumbnails').removeClass('modal-fullscreen');
			(document.webkitCancelFullScreen ||
				document.mozCancelFullScreen ||
				$.noop).apply(document);
		}
	});
	//chosen - improves select
	$('[data-rel="chosen"],[rel="chosen"]').each(function(k, v){
		if($(this).hasClass("allowAddOpt")){
			$(this).chosen({no_results_text: "没有找到 <button type=\"button\" class=\"btn btn-primary ChosenAddOpt\" for-id=\""+$(this).attr("id")+"\">添加</buttion>"});
		}else{
			$(this).chosen({no_results_text: "没有找到"});
		}
	});
	$(".ChosenAddOpt").live("click", function(){
		if($(this).attr("for-id") != ''){
			var opt = $(this).children("span").html(),
				selId = $(this).attr("for-id"),
				prefixreg = /^[a-z]([a-z0-9]*[-_]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+([\.][a-z0-9]+)*$/i;
				staffreg = /^[a-z]([a-z0-9]*[-_]?[a-z0-9]+)*$/;
			if(!staffreg.test(opt) && !prefixreg.test(opt)){
				comNoty.error('请填写staff邮箱前缀或完整邮箱地址');
				return false;
			}
			addSelOpt(selId, {text:opt,value:opt});
			if(staffreg.test(opt)){
				$.post("/aj/user?__a=usercheckin",{staff:opt});
			}
		}
	});
	
});

var addSelOpt = function(selId, opt){
	if(typeof(opt.text) == 'undefined' || typeof(opt.value) == 'undefined') return false;
	if($("#"+selId).find('optgroup').size() > 0){
		var hasTmp = false;
		$("#"+selId).find('optgroup').each(function(k, v){
			if($(this).hasClass("tmp_optgroup")){
				hasTmp = true;
				$(this).prepend('<option value="'+opt.value+'" selected>'+opt.text+'</option>');
			}
		});
		if(hasTmp === false){
			$("#"+selId).prepend('<optgroup class="tmp_optgroup" label="临时选项"><option value="'+opt.value+'" selected>'+opt.text+'</option></optgroup>');
		}
	}else{
		$("#"+selId).prepend('<option value="'+opt.value+'" selected>'+opt.text+'</option>');
	}
	$("#"+selId).trigger("liszt:updated");
}
