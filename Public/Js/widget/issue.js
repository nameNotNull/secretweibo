/**
 * 提案相关操作的封装 
 */

var treeModal = function(d){
	this.treeData = [], //组织结构树数据
	this.checkable = false,
	this.eleId = '',
	this.valId = '',
	this.nameId = '',
	this.callback = function(treeNode){ return true; },
	this.setTxtCallback = false,
	this.zTreeSetting = {		
		showLine : true,
		isSimpleData : true,
		treeNodeKey : "id",
		treeNodeParentKey : "pId",
		callback : {
			beforeExpand : function(treeId, treeNode) {
				that.zTreeSinglePath(treeNode);
			},
			beforeClick : function(treeId, treeNode) {
				if(that.callback(treeNode) === true){
					that.setTxt(treeNode);
					$("#modal_"+that.eleId).modal('hide');
					return false;
				}
			}
		}
	},
	this.zTree = false,
	this.init = function(d){
		//eid, name_id, title, curt_id, data, callback
		if(typeof(d.eid) == 'undefined' || typeof(d.data) == 'undefined') return false;
		if(typeof(d.callback) == 'function') this.callback = d.callback;
		if(typeof(d.setTxtCallback) == 'function') this.setTxtCallback = d.setTxtCallback;
		
		this.treeData = d.data;
		this.eleId = "IW_s_"+d.eid;
		this.valId = d.eid;
		this.nameId = d.name_id;
		if (typeof(d.checkable) != 'undefined' && d.checkable === true) {
			this.checkable = d.checkable;
			this.zTreeSetting.checkable=this.checkable;
			if (typeof(d.curt_id) != 'undefined'){
				var cAry = d.curt_id.split(",");
				$.each(this.treeData, function(k,node){
					$.each(cAry, function(tk, tv){
						if(node.id == tv){
							node.checked = true;
						}
					});
				});
			}
			
		}
		$('body').append('<div class="modal hide'+($.browser.msie && $.browser.version == '10.0' ? "" : " fade")+'" id="modal_'+this.eleId+'"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">×</button><h3>选择'+d.title+'</h3></div><div class="modal-body"><div class="span12"><ul class="tree" id="'+this.eleId+'"></ul></div><!--/span--></div><div class="modal-footer">'+(this.checkable == true ? '<a href="javascript:void(0);" onclick="'+d.objName+'.setTxt();" class="btn btn-primary" data-dismiss="modal">确定</a>' : '')+'<a href="#" class="btn" data-dismiss="modal">取消</a></div></div>');
		
		this.zTree = $("#" + this.eleId).zTree(this.zTreeSetting,this.treeData);

		if (typeof(d.curt_id) != 'undefined') {
			if(this.checkable === false){
				var nd = this.zTree.getNodeByParam("id", d.curt_id);
				this.zTree.selectNode(nd);	
				this.setTxt(nd);
			}else{
				this.setTxt();
			}
			
		}
		
	},
	this.showModal = function(){
		$("#modal_"+this.eleId).modal('show');
	},
	this.zTreeSinglePath = function(currNode) {
		var treeObj = this.zTree, expandedNodes = treeObj.getNodesByParam(
				"open", true, treeObj.getNodeByParam("id", currNode.pId));
		$.each(expandedNodes, function(k, node) {
			if (currNode.id != node.id && node.level == currNode.level) {
				treeObj.expandNode(node, false);
			}
		});
	},
	this.getParentNode = function(treeNode, stopLv){
		if(typeof(treeNode.parentNode) == "undefined" || treeNode.level == stopLv){
			return "";
		}
		if(typeof(stopLv) == "undefined" || treeNode.parentNode.level == stopLv){
			return treeNode.parentNode.name;
		}else{
			var tmp = this.getParentNode(treeNode.parentNode, stopLv);
			return tmp == "" ?  treeNode.parentNode.name : tmp+"/"+ treeNode.parentNode.name;
		}
	},
	this.setTxt = function(treeNode){
		if(that.checkable === true){
			var nodes = that.zTree.getCheckedNodes(),
				values = [],
				names = [],
				count = 0;
			$.each(nodes, function(k,v){
				if(v.check_True_Full === true && v.nodes.length == 0){
					values[count] = v.id.replace("p_", "");
					var tmp = that.getParentNode(v, 1);
					names[count] = tmp == "" ? v.name : tmp +"/"+v.name;	
					count ++;
				}						
			});
			$("#"+that.valId).val(values.join(','));
			$("#"+that.nameId).val(names.join("\n"));
		}else{
			$("#"+that.valId).val(treeNode.id.replace("p_", ""));
			var tmp = that.getParentNode(treeNode, 1);
			$("#"+that.nameId).val(tmp == "" ? treeNode.name : tmp +"/"+treeNode.name);
		}
		if(that.setTxtCallback){
			that.setTxtCallback(that);
		}
	};
	var that = this;
	// 初始化操作
	this.init(d);
	
	return this;
};
	//选择部门列表，浮层展示
