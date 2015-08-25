//初始化删除提示
function bindingRemove(ids,type){
	$("[id^="+ids+"]").mouseup(function(){
		var id = $(this).attr("id");
		$(this).confirm({
			'title'  : '删除确认',
			'message': '确认删除该记录吗？'	,
			'action' : function(){
				ajaxSetCommonWidget(id,'del',type);
			}
		});
	}); 
}
//置顶功能绑定
function bindingStick(ids,type){
	$("[id^="+ids+"]").click(function(){
		var id = $(this).attr("id");
		ajaxSetCommonWidget(id,'stick',type);
	}); 
}
//操作add,del,stick
function ajaxSetCommonWidget(treeNode,act,_type){
	if(act=='' || _type=='')return false;
	if(act=='upd'){//add
		var v_project_id   = treeNode.id.replace("p_","");
		var v_project_name = treeNode.name;
		var struct_id	   = treeNode.parentNode.id.replace("s_","");
		var struct_name    = treeNode.parentNode.name;
		//1.wrap post data
		var data = {
			project_id   : v_project_id,
			project_name : v_project_name,
			struct_name  : struct_name,
			struct_id    : struct_id,
			type         : _type,
			action       : act
		};
	}else{//remove or stick
		var v_project_id = treeNode.match(/(-?\d+)/)[1];		
		//1.wrap post data
		var data = {
			project_id : v_project_id,
			type       : _type,
			action     : act
		};
	}
	//2. post data with ajax
	$.post(
			//
		'/aj/commonwidget?__a=run',
		data,
		function(d){
			if(d.code != '0'){
				comNoty.error(d.msg);
			}else{
				var url = window.location.href;//window.location.host
				url = url.replace("#",'');
				url = url+"?type="+_type;
				BigPipe.ajaxPipeLoader({url:url, pl:{pid:'pl_widget_common'+_type+'s'}});
				comNoty.success(d.msg);
			}
		}
	);
}
