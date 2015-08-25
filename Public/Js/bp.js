var BigPipe = (function() {
	var that = {};
	that = {
		/**
		 * check the id
		 * 
		 * @param {object}
		 *            json.pid
		 */
		argsCheck : function(json) {
			if (!json.pid) {
				throw 'nodeId is necessary';
				return;
			}
		},
		/**
		 * get node by id
		 * 
		 * @param {string}
		 *            id
		 * @return {html object} html node
		 */
		g : function(id) {
			if (typeof id === 'string') {
				return document.getElementById(id);
			} else {
				return id;
			}
		},
		/**
		 * check the type of broswer
		 */
		IE : function() {
			return /msie/i.test(navigator.userAgent);
		},
		getStyle : function(node, property) {
			var cssList;
			try {
				cssList = document.defaultView.getComputedStyle(node, null);
			} catch (e) {
				cssList = node.currentStyle;
			}
			return node.style[property] || cssList[property];
		},
		/**
		 * load css
		 * 
		 * @param {object}
		 *            css href, load_ID, oncomplete
		 * @param {string}
		 *            css href
		 * @param {string}
		 *            load_ID
		 * @param {function}
		 *            onCssComplete
		 */
		cssLoader : function(json) {
			// insert css
			var len = json.css.length;
			json.onCssComplete = json.onCssComplete ? json.onCssComplete
					: function() {
					};
			if (len < 1) {
				json.onCssComplete();
			} else {
				for ( var i = 0; i < len; i++) {
					var link = document.createElement('link');
					link.setAttribute('rel', 'stylesheet');
					link.setAttribute('type', 'text/css');
					link.setAttribute('charset', 'utf-8');
					link.setAttribute('href', json.css[i]);
					document.getElementsByTagName('head')[0].appendChild(link);

					var div = document.createElement("div");
					div.id = json.load_ID;
					div.style.display = "none";
					div.style.width = "40px";
					document.body.appendChild(div);
				}
				var timer = setInterval(function() {
					if (parseInt(BigPipe.getStyle(BigPipe.g(json.load_ID),
							"width")) == 40) {
						clearInterval(timer);
						json.onCssComplete();
						document.body.removeChild(div);
					}

				}, 50);
			}

		},
		/**
		 * load js
		 * 
		 * @param {string}
		 *            js
		 */
		jsLoader : function(json) {
			var len = json.js.length;
			json.onJsComplete = json.onJsComplete ? json.onJsComplete
					: function() {
					};

			if (len < 1) {
				json.onJsComplete();
			} else {
				for ( var i = 0; i < len; i++) {
					var script = document.createElement("script");
					script.setAttribute("charset", "utf-8");
					script.setAttribute("src", json.js[i]);
					document.getElementsByTagName("head")[0]
							.appendChild(script);

					if (i == len - 1) { // 判断最后一个js文件是否已经加载完
						if (BigPipe.IE) {
							script["onreadystatechange"] = function() {
								if (script.readyState.toLowerCase() == "loaded"
										|| script.readyState
												.toLowerCase() == "complete") {
									json.onJsComplete();
								}
							}	
						} else {
							script.onload = function() {
								json.onJsComplete();
							}
						}
					}
				}

			}
		},
		ajaxPipeLoader : function(pl_object) {
			if(typeof(pl_object.url) == "undefined"){
				return false;
			}
			
			var url = pl_object.url.replace(/#.*$/, "");
			if(url.indexOf("?") != -1) {
				url += "&__aj=1";
			} else {
				url += "?__aj=1";
			}
			/**
			 * 处理pl数组
			 * pl属性{pid:pl对应的id,did:pl填充的div，默认为pid,loading：pl加载时目标div是否增加加载状态，默认为true，或者传入loading所调用的function}
			 * 单个pl：直接传入pl对象
			 * 多个pl：多个pl对象的数组
			 */
			var pid_array 	= new Array();
			var did_array 	= new Array();
			var load_array	= new Array();
			
			if(pl_object.pl instanceof Array){
				for(var k in pl_object.pl){
					var tmp_pl = pl_object.pl[k];
					if(typeof(tmp_pl.pid) == "undefined"){
						return false;
					}
					if(typeof(tmp_pl.did) == "undefined"){
						tmp_pl.did = null;
					}
					if(typeof(tmp_pl.loading) == "function"){
						tmp_pl.loading;
					}else if(typeof(tmp_pl.loading) == "undefined" || !isNaN(tmp_pl.loading)){
						tmp_pl.loading = 1;
					}
					pid_array[k] = tmp_pl.pid;
					did_array[k] = tmp_pl.did;
					if(tmp_pl.loading == 1){
						if(tmp_pl.did == null){
							BigPipe.autoLoading(tmp_pl.pid);
						}else{
							BigPipe.autoLoading(tmp_pl.did);
						}
					}
				}
			}else if(typeof(pl_object.pl) == "object"){
				if(typeof(pl_object.pl.pid) == "undefined"){
					return false;
				}
				if(typeof(pl_object.pl.did) == "undefined"){
					pl_object.pl.did = null;
				}
				if(typeof(pl_object.pl.loading) == "function"){
					pl_object.pl.loading;
				}else if(typeof(pl_object.pl.loading) == "undefined" && typeof(pl_object.pl.callback) == "undefined"){
					pl_object.pl.loading = 1;
				}
				pid_array[0] = pl_object.pl.pid;
				did_array[0] = pl_object.pl.did;
				if(pl_object.pl.loading == 1){
					if(pl_object.pl.did == null){
						BigPipe.autoLoading(pl_object.pl.pid);
					}else{
						BigPipe.autoLoading(pl_object.pl.did);
					}
				}
			}else{
				return false;
			}
			
			if(pid_array.length == did_array.length){
				url += "&__pl="+encodeURIComponent(pid_array.join("|"));
				url += "&__d="+encodeURIComponent(did_array.join("|"));
			}
			
			if(typeof(pl_object.callback) != "undefined"){
				if(typeof(pl_object.callback) == "function"){
					url += "&__no_cb=1";
				}else{
					url += "&__cb="+encodeURIComponent(pl_object.callback);
				}
				
			}else{
				url += "&__cb=BigPipe.onPageletArrive";
			}
			url += "&__t=" + new Date().getTime();
			
			if(typeof(pl_object.callback) == "function"){
				$.getJSON(url, function( data ) {
					pl_object.callback(data);
				});
			}else{
				$.getScript(url);
			}
		},
		autoLoading: function(id, delay){
			var div = BigPipe.g(id),
				loadingTpl = '<div style="text-align: center;"><img src="/img/ajax-loaders/ajax-loader-6.gif" title="/img/ajax-loaders/ajax-loader-6.gif"></div>';
			if(div != null && typeof(div.innerHTML) != "undefined"){
				if(typeof(delay) == "undefined"){
					div.innerHTML = loadingTpl;
				}else{
					eval("BigPipe_loadingHandle_"+id+" = setTimeout(function(){div.innerHTML = loadingTpl;}, "+delay+");");
				}
			}
		},
		onPageletArrive : function(json) {
			var arriveTime = new Date().getTime();
			BigPipe.argsCheck(json);

			var cssJson = {
				css : json.css,
				load_ID : json.pid + "css",
				onCssComplete : function() {
					// load css first;
					if (typeof(json.content) != "undefined") {
						eval("typeof(BigPipe_loadingHandle_"+json.pid+") !='undefined' && clearTimeout(BigPipe_loadingHandle_"+json.pid+");");
						$("#"+json.pid).html(json.content);//@todo InnerHTML
					}
				}
			};
			BigPipe.cssLoader(cssJson);

			var jsJson = {
				js : json.js,
				onJsComplete : function() {
//					BigPipe.pageletLog(json.pid+':'+arriveTime);
				}
			};
			BigPipe.jsLoader(jsJson);
		},
		pageletLog : function(msg) {
			if (!/msie/i.test(navigator.userAgent)){
				console.log(msg + '-' +new Date().getTime() + '----complete');
			}
		}
	};
	return that;
})();