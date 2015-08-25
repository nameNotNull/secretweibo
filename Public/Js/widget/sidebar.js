var SideBarWidget = {
	menuEleId : "",
	menuData : [],
	zTree : false,
	zTreeSetting : {
		showLine : true,
		isSimpleData : true,
		treeNodeKey : "id",
		treeNodeParentKey : "pId",
		callback : {
			beforeExpand : function(treeId, treeNode) {
				SideBarWidget.zTreeSinglePath(treeNode);
			},
			expand : function(event, treeId, treeNode){
				$("#"+treeId).scrollLeft(1000);
			}
		}
	},
	init : function(eId, mData, curtId) {
		this.menuEleId = eId;
		this.menuData = mData;
		// 设置显示的样式树状/列表
		this.setMenuStyle();

		this.zTree = $("#" + this.menuEleId).zTree(this.zTreeSetting,
				this.menuData);

		if (curtId != '') {
			this.zTree.selectNode(this.zTree.getNodeByParam("id", curtId));
			this.selectNode(curtId);
		} else {
			this.initMenuHtml();
		}
	},
	initMenuHtml : function() {
		var that = this, html = '';
		$.each(that.menuData, function(k, node) {
			if (node.pId == null) {
				html += that.getNodeHtml(node, false);
				$.each(node.nodes, function(k, node1) {
					html += that.getNodeHtml(node1, true);
				});
			}
		});
		$("#_" + this.menuEleId).html(html);
		$("#__" + this.menuEleId).html(html);
	},
	getNodeHtml : function(node, forword, isHead) {
		if (node.pId == null) {
			return '<li class="nav-header" data-menu-id="' + node.id
					+ '"><i class="icon-folder-open hidden-tablet"></i> '
					+ node.name + '</li>';
		} else {
			return typeof (node.nodes) != 'undefined' && node.nodes.length != 0
					&& forword == true ? '<li><a href="javascript:void(0);" class="menu-forward" onclick="SideBarWidget.forward(\''
					+ node.id
					+ '\');">&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-folder-close hidden-tablet"></i> <span>'
					+ node.name + '</span></a></li>'
					: (typeof (isHead) != 'undefined' && isHead == true ? '<li data-menu-id="'
							+ node.id
							+ '"><a href="'
							+ node.url
							+ '" target="'
							+ node.target
							+ '"><i class="icon-folder-open hidden-tablet"></i> <span><b>'
							+ node.name + '</b></span></a></li>'
							: '<li data-menu-id="'
									+ node.id
									+ '"><a href="'
									+ node.url
									+ '" target="'
									+ node.target
									+ '">&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-file hidden-tablet"></i> <span>'
									+ node.name + '</span></a></li>');

		}
	},
	getNode : function(id, nodes) {
		var that = this, ret = [];
		$.each(nodes, function(k, node) {
			if (node.id == id) {
				ret = node;
				return false;
			}
			if (node.nodes.length != 0) {
				ret = that.getNode(id, node.nodes);
			}
			if (ret.length != 0)
				return false;
		});
		return ret;
	},
	forward : function(mid) {
		var that = this, html = '', node = that.getNode(mid, that.menuData);
		if (node.length == 0)
			return false;
		if (node.pId != null) {
			html += '<li><a href="javascript:void(0);" onclick="SideBarWidget.back(\''
					+ node.pId
					+ '\');"><i class="icon-backward hidden-tablet"></i> <span>返回上一级</span></a></li>';
		}
		html += that.getNodeHtml(node, false, true);
		$.each(node.nodes, function(k, node1) {
			html += that.getNodeHtml(node1, true);
		});

		$("#_" + this.menuEleId).html(html);
		$("#__" + this.menuEleId).html(html);
	},
	back : function(pid) {
		var that = this, html = '', node = that.getNode(pid, that.menuData);
		if (node.length == 0)
			return false;
		if (node.pId == null) {
			that.initMenuHtml();
		} else {
			that.forward(pid);
		}
	},
	selectNode : function(curtId) {
		var that = this, node = that.getNode(curtId, that.menuData);
		if (node.length == 0)
			return false;
		if (node.pId == null) {
			that.initMenuHtml();
		} else {
			node.nodes.length == 0 ? that.forward(node.pId) : that
					.forward(curtId);
		}
		$("#_" + that.menuEleId + " li[data-menu-id=\"" + curtId + "\"]")
				.addClass("active");
		$("#__" + that.menuEleId + " li[data-menu-id=\"" + curtId + "\"]")
				.addClass("active");
	},
	setMenuStyle : function() {
		var that = this, style = $.cookie("mStyle_" + that.menuEleId);
		if (typeof (style) != 'undefined' && style == '_') {
			$("#_" + that.menuEleId).show();
			$("#" + that.menuEleId).hide();
		} else {
			$("#" + that.menuEleId).show();
			$("#_" + that.menuEleId).hide();
		}
	},
	changeMenuStyle : function() {
		var that = this;
		if ($(".changeMStyle").attr("checked") == "checked") {
			$.cookie("mStyle_" + that.menuEleId, "", {
				expires : 365,
				path : '/'
			});
		} else {
			$.cookie("mStyle_" + that.menuEleId, "_", {
				expires : 365,
				path : '/'
			});
		}
		that.setMenuStyle();
	},
	zTreeSinglePath : function(currNode) {
		var treeObj = this.zTree, expandedNodes = treeObj.getNodesByParam(
				"open", true, treeObj.getNodeByParam("id", currNode.pId));
		$.each(expandedNodes, function(k, node) {
			if (currNode.id != node.id && node.level == currNode.level) {
				treeObj.expandNode(node, false);
			}
		});
	}
};