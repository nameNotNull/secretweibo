$(function(){
	//左侧高度
	var lheight = $('#left').height()
	var height  = document.documentElement.clientHeight - $('.head').height()
	if(height > lheight){
		$('#left').height(height)
	}
	//右侧宽度
	var width   = document.documentElement.clientWidth - 180
	$('#right').width(width)
	$('#right').height(height - 40)
	//菜单初始化
	$('#index-Index p').slideDown();
	$('#menu-Index-index').addClass('on')
	//菜单按钮点击
	$('#left p').click(function(){
		$('#left p').removeClass();
		$(this).addClass('on')
		var url = $(this).find('a').attr('href')
		$('#right').attr('src',url)
		return false;
	})
	
})
//菜单折叠
function menu(str){
	$('#left .menu p').slideUp();
	if($('#'+str+' p').is(":visible")==false){
		$('#'+str+' p').slideDown();
	}
}