var chart = function(d){
	this.type = '',//图形类型，如“Lines,Bars,Steps,Pie”
	this.id = '',//当前div的id
	this.data = '',//数据
	this.updatetime = '',
	this.typestack = '',//线是否重叠
	this.backgroundColor = { colors: ["#fff", "#eee"] } ,//背景颜色
	this.showbutton=false,//是否显示按钮
	this.pie_data='',
	this.pie=false;//饼图特殊处理
	this.y = '',//y轴单位
	this.x= '',//x轴单位
	
	this.init = function(d){
		if(typeof(d.id) == 'undefined'||typeof(d.data.data) == 'undefined') return false;
		this.showbutton =  typeof(d.showbutton) == 'undefined' ? false : d.showbutton;
		this.click =  typeof(d.click) == 'undefined' ? false : d.click;
		//this.data = d.data.data;
		if(typeof(d.data) != 'undefined'){
			this.data = (typeof(d.data.data)) == 'function' ? d.data.data() : d.data.data;
			this.pie_data = (typeof(d.data.data)) == 'function' ? d.data.data() : d.data.data;
			this.type =  typeof(d.data.type) == 'undefined' ? 'Lines' : d.data.type;
			this.title  =  typeof(d.data.title) == 'undefined' ? 'null' : d.data.title;
			this.typestack = typeof(d.data.typestack) == 'undefined' ? 0 : d.data.typestack;
			this.backgroundColor = typeof(d.data.backgroundColor) == 'undefined' ? this.backgroundColor : d.data.backgroundColor;
			this.fill = typeof(d.data.fill) == 'undefined' ? false : d.data.fill;
			this.y = typeof(d.y) == 'undefined' ? '' :" &nbsp (Y轴单位："+d.y+")" ;
			this.x = typeof(d.x) == 'undefined' ? '' : "&nbsp ( X轴单位："+d.x+")";
		}
		
		
		if(typeof(d.callback) == 'function')
			{
				this.callback = d.callback;
				this.data =d.callback;
			}
		this.id = "#"+d.id;
	
		if(typeof(d.updatetime) == 'undefined')
		{
			this.updatetime = 0;
		}else{
			this.updatetime = d.updatetime;
		}
		//this.plotWithOptions = chart.plotWithOptions();
		width=$("."+d.id).parent().width();
		if(width=="undefined"){
			width=500;
		}
		$("."+d.id).html('<div id="'+d.id+'"  class="center" style="height:300px;width:'+width+'px;"></div><br><div id="button_'+d.id+'"></div>');
		if(this.showbutton){
			$("#button_"+d.id).html(
				'<div><p class="graphControls'+d.id+' graphControls center ">'+
					'<input class="btn btn-primary" type="button" value="饼图" v_id="Pie" >'+
					'<input class="btn btn-primary" type="button" value="柱图" v_id="Bars" >'+
					'<input class="btn btn-primary" type="button" value="线图" v_id="Lines">'+
//					'<input class="btn btn-primary" type="button" value="d" v_id="Steps" >'+
				'</p>'+
				'<p class="stackControls'+d.id+' stackControls center" style="display:none;">'+
					'<input class="btn" type="button" value="叠加" v_id="With stacking">'+
					'<input class="btn" type="button" value="不叠加" v_id="Without stacking" >'+
				'</p>'+
				'<p class="fillControls'+d.id+' stackControls center" style="display:none;">'+
					'<input class="btn" type="button" value="填充"  v_id="With fill" >'+
					'<input class="btn" type="button" value="不填充"  v_id="Without fill">'+
				'</p></div>');
		}
		this.update();
		
		//定义显示位置
		function showTooltip(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css( {
			position: 'absolute',
			display: 'none',
			top: y + 5,
			left: x + 5,
			border: '1px solid #fdd',
			padding: '2px',
			'background-color': '#dfeffc',
			opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
		//点击事件
		if(0){
		$(this.id).bind("plotclick", function () {
			that.data = that.click();
			var plot = that.plotWithOptions();
				
					
		});
		}
	var previousPoint = null;
	//s鼠标经过事件
		$(this.id).bind("plothover", function (event, pos, item) {
			 dataX=plot.getXAxes();
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
			if (item) {
				if (previousPoint != item.dataIndex) {
					//previousPoint = item.dataIndex;

					$("#tooltip").remove();
					var x =item.datapoint[0],
					//item.series.data[x]当前数据点
					labelX =item.series.data[x][0],
						y =item.datapoint[1];
					showTooltip(item.pageX, item.pageY,
								"【"+item.series.label+"】"+labelX + " : " + y);
				}
			}
			else {
				$("#tooltip").remove();
					previousPoint = null;
				}
		});
		//各个按钮事件
		$(".fillControls"+d.id+" input").click(function (e) {
			e.preventDefault();
			that.fill = $(this).attr("v_id") == "With fill" ? true : false;
			that.plotWithOptions();
		});
		$(".stackControls"+d.id+" input").click(function (e) {
		e.preventDefault();
		that.typestack = $(this).attr("v_id") == "With stacking" ? 'stack' : null;
		that.plotWithOptions();
	});
	$(".graphControls"+d.id+" input").click(function (e) {
		e.preventDefault();
		that.type = $(this).attr("v_id");
		that.type != 'Pie' ? $(".stackControls"+d.id).show() : $(".stackControls"+d.id).hide();
		that.type == 'Lines' ? $(".fillControls"+d.id).show() : $(".fillControls"+d.id).hide();
		that.plotWithOptions();
	});
	length = this.data[0].data.length;


	},
	
	
	
	
	
	this.plotWithOptions = function() {
		var bars=false,lines=false,points=false,steps=false,stack=0;
		switch(that.type){
		case "Bars":bars=true,that.pie=false;break;
		case "Lines":lines=true,points=true,that.pie=false;break;
		case "Steps":lines=true,points=true,steps=true,that.pie=false;break;
		case "Pie":that.pie=true;break;
		};
		switch(that.typestack){
		case "stack":stack=true;break;
		default:stack=null;break;
		};
		
		//圆的数据加工
		if(that.pie ){
			 for (var i = 0; i <that.pie_data.length; ++i) {
				 if(that.pie_data[i].data.length>1){
					 var sum=0;
				 for(var j=0; j< that.pie_data[i].data.length;++j){
					 sum =sum+ that.pie_data[i].data[j][1];
				 }
				
				 that.pie_data[i].data =sum;
				 }
			 }
		}
		//alert(d.id);
		if(that.pie)
			d = that.pie_data; 
		else 
			d =	that.data;
	plot = $.plot(that.id,d, {
			series: {
				stack: stack,
				lines: { show: lines, fill: that.fill, steps: steps },
				bars: { show: bars, barWidth: 0.6},
				points: {show:points},
				pie:{show:that.pie}
			},
			xaxis: {
				
				mode: "categories",
				tickLength: 5,
				
			},
			yaxis:{
//				tickFormatter: function(value, axis) {
//					return value.toFixed(axis.tickDecimals) +that.y;
//				}
			},
			 grid: { hoverable: !that.pie, clickable: true, backgroundColor: that.backgroundColor },
			 legend: {
					show: !that.pie
				}
		});
	length = that.data[0].data.length;
		that.max_width = 50;//parseInt( $(that.id+">.flot-text>.xAxis>.tickLabel").css("max-width"));
		that.width = $(that.id).width();
		that.maxs_width = that.max_width*(length+1);
		if(that.maxs_width>=that.width){
//		if(length>10){
			$(".xAxis>.tickLabel").addClass("newtickLabel");
		}
	// Append it to the placeholder that Flot already uses for positioning
	var placeholder = $(this.id);
	//placeholder.append("<div style='position:absolute;left: 34px;top:-10px;color:#666;font-size:smaller'>Y轴单位【"+that.title+"】</div>");
	placeholder.append("<div style='position:absolute;left: 34px;top:-10px;color:#666;font-size:smaller'>"+that.title+that.y+that.x+"</div>");
	return plot;
	
	},
	this.update=function(){
		var plot = that.plotWithOptions();
		if(that.updatetime != 0 && !that.pie){
			
			updatetime = that.updatetime;
		//	if(typeof(d.data.data) == 'function' && !that.pie)
		//	{
				that.data = d.data.data();
			
				plot.setData(that.data);
				// since the axes don't change, we don't need to call plot.setupGrid()
				plot.draw();
		//	}
			
			setTimeout(that.update,updatetime);
		}
	}
	
	var that = this;
	// 初始化操作
	this.init(d);
	return this;
};

