/**
 * 统计图表相关封装
 */

var rtChart=function(settings){
		this.chart_type       = '',//图表类型
		this.chart_title      = '',//图表标题
		this.aver_time		  = '',//部门工作效率均值个人修改e = '',//图表类型标题
		this.seriesData       = [],//图表数据
		this.categories       = [],//图表x轴数据
		this.yAxis_name       = '',//图表y轴名称
		this.container        = '',//图表渲染容器
		this.is_zoom_out      = false,//是否放大图片
		this.downloadable     = true,//图表是否可下载
		this.exportXcategories = [],//导出的数据，为保证下载时显示父级和百分比
		this.exportSdata       = [],//导出的数据，为保证下载时显示父级和百分比
		this.report_key        = -1,
		this.plotOps           = {pie: {dataLabels: {enabled: true,color: '#000000',connectorColor: '#000000',format: '{point.name}:{point.percentage:.1f}%'}}};
		this.init = function(settings){
			if(typeof(settings) != 'undefined'){
				if(typeof(settings.chart_type)       != 'undefined'){
					that.chart_type       = settings.chart_type;//图表类型
				} 
				if(typeof(settings.chart_title)      != 'undefined'){
					that.chart_title      = settings.chart_title;//图表标题
				} 
				if(typeof(settings.aver_time)      != 'undefined'){
					that.aver_time        = settings.aver_time;//部门工作效率均值个人修改
				}
				if(typeof(settings.chart_type_title) != 'undefined'){
					that.chart_type_title = settings.chart_type_title;//图表类型标题
				} 
				if(typeof(settings.seriesData)       != 'undefined'){
					that.seriesData       = settings.seriesData;//图表数据
				}
				if(typeof(settings.yAxis_name)       != 'undefined' && that.chart_type!='pie'){
					that.yAxis_name       = settings.yAxis_name;//图表y轴名称
				} 
				if(typeof(settings.container)        != 'undefined'){
					that.container        = settings.container;//图表渲染容器
				} 
				if(typeof(settings.is_zoom_out)      != 'undefined'){
					that.is_zoom_out      = settings.is_zoom_out;//是否放大图片
				}
				if(typeof(settings.downloadable)     != 'undefined'){
					that.downloadable     = settings.downloadable;//图表是否可下载
				}
				if(typeof(settings.report_key)     != 'undefined'){
					that.report_key       = settings.report_key;//图表ID
				}
			}
			
			that.options.title.text        = that.chart_title;
			that.options.chart.renderTo    = that.container;
			that.options.chart.type        = that.chart_type;
			that.options.exporting.enabled = that.downloadable;
			that.options.subtitle.text     = that.chart_type_title;
			//统计图均值，封装里面直接修改不好，后期若上采用值传递
			if (that.aver_time != "") {
				that.options.subtitle.text     = that.chart_type_title + '<br/>' + '[均值' + that.aver_time+'小时]';
			} else {
				that.options.subtitle.text     = that.chart_type_title;
			}
			that.options.series[0].data    = that.format_series_data(that.seriesData);
			
			//动态渲染图表高度
			this.dataLength = that.options.series[0].data.length;
			if(this.dataLength>15 && that.chart_type=='bar'){
				$("#"+that.container).height((this.dataLength / 10) * 450+"px");
			}else{
				$("#"+that.container).height('');//非条形图时恢复默认
			}
			that.switch_chart(that.chart_type);
		},
		this.rtExport = function(ex_type){
			/**
			 * 大图的时候，不必重复渲染，可直接下载
			 * 或者不存在父级时，但这是若是饼图要追加百分比
			 */
			if(that.is_zoom_out===true || that.exportSdata.length==0){
				 var chart = $('#'+that.container).highcharts();
				 chart.options.exporting.type=ex_type;
				 if(chart.options.chart.type=='pie' && that.is_zoom_out!==true){
					 chart.exportChart(null,{
						 plotOptions:that.plotOps
					 });
				 }else{
					 chart.exportChart();
				 }
			}else{
				var ex_ops = $('#'+that.container).highcharts().options;//获取当前图表的options
				ex_ops.chart.renderTo="hidden_container";
				ex_ops.exporting.type = ex_type;
				if(ex_ops.chart.type=='pie'){
					ex_ops.series[0].data     = that.exportSdata;
					ex_ops.tooltip.pointFormat='<b>{point.percentage:.1f}%</b>';
					ex_ops.plotOptions= that.plotOps;
				}else{
					ex_ops.xAxis[0].categories  = that.exportXcategories;
					if(ex_ops.chart.type=='bar'){
						ex_ops.xAxis[0].labels.rotation = 0;
					}
				}
				var ex_chart = new Highcharts.Chart(ex_ops);
				//Enable this block to view SVG
				/*var svg = ex_chart.getSVG().replace(/</g, '\n&lt;') // make it slightly more readable
	            .replace(/>/g, '&gt;');
				document.body.innerHTML = '<pre>'+ svg +'</pre>';*/
				ex_chart.exportChart();
				ex_chart.destroy();
		        return true;
			}
		},
		//default settings of chart
		this.options = {
			chart: {
				type:'',
			    renderTo:'',
			    plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false
			},
		   	credits: {
		   		href: 'http://rt.intra.sina.com.cn',
		   		text: 'rt.intra.sina.com.cn'
		   	},
		   	exporting:{
		   		enabled:true,
		   		filename:'sina_rt_chart',
		   		url:"/aj/downloadchart?__a=download",
		   		buttons: {
	                contextButton: {
	                	menuItems: [{
	                        text: '打印图表',
	                        onclick: function () {
	        					this.print();
	        				}
	                    },{
	                        text: '下载JPEG图片',
	                        onclick: function() {
	                        	that.rtExport('image/jpeg')
	                        }
	                    }, {
	                        text: '下载PNG图片',
	                        onclick: function() {
	                        	that.rtExport('image/png')
	                        }
	                    }, {
	                        text: '下载SVG矢量图',
	                        onclick: function() {
	                        	that.rtExport('image/svg+xml')
	                        }
	                    }, {
	                        text: '下载PDF文档',
	                        onclick: function() {
	                        	that.rtExport('application/pdf')
	                        }
	                    }]
	                }
	            }
		   	},
		    title: {
		        text: '',
		        x: -20 //center
		    },
		    subtitle: {                                                        
		        text: '',
		        aligh:'right',
		        floating:true,
		        x: 120,
		        y: 20
		    },  
		    tooltip: {
		  	  pointFormat: '<b>{point.percentage:.1f}%</b>'
		  	},
		  	legend:{
			        enabled:false//不显示图例
			},
			plotOptions:{
				
			},
		  	series:[{
		  		data:[],
		  		cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                        	if(this.options.url){
                        		 location.href = this.options.url;
                        	}
                        }
                    }
                }

		  	}]
		},
		//format data of chart
		this.format_series_data=function(seriesData){
			var seriesArr = new Array();
			if(seriesData){
				  $.each(seriesData, function(i,item) {
					  var d = new Object();
					  if(that.is_zoom_out==true && item['remark_name']){//大图时，展示父级，以便保存
						  d.name = item['remark_name'];
						  that.categories.push(item['remark_name']);
					  }else{
						  d.remark_name = item['remark_name'];
						  d.name = item['name'];
						  that.categories.push(item['name']);
					  }
					  d.y = item['y'];
					  if(item['url'] != 'undefined' && item['url']!=null){//点击图表某个部分时跳转的Url
						  d.url = item['url'];
					  }
					  
					  if(item['remark_name']){//为带有父级的图表导出准备资源
						  that.exportXcategories.push(item['remark_name']);
						  that.exportSdata.push({'name':item['remark_name'],'y':item['y']});
					  }
					  seriesArr.push(d);
			      });
			}
			return seriesArr;
		},
		
		//切换图标个性配置
		this.switch_chart = function (chart_type){
			if(chart_type!='pie'){//set chart options except pie
				that.options.tooltip = {
			            shared: true,
			            useHTML: true,
			            headerFormat: '<table>',
			            pointFormat: '<tr><td><small>{point.remark_name}</small></td></tr><tr><td ><b>{point.name}</b><br/><b>{point.y:.0f}</b></td></tr>',
			            footerFormat: '</table>',
			            valueDecimals: 2
			        };
				that.options.yAxis={
			            min: 0,
			            title: {
			                text: that.yAxis_name,
			            }
			     };
				if(chart_type=='bar' || chart_type=='column' || chart_type=='line'){
					that.set_bar_or_column();
				}
			}else{//set pie chart options
				that.options.tooltip = {
			            shared: true,
			            useHTML: true,
			            headerFormat: '<table>',
			            pointFormat: '<tr><td><small>{point.remark_name}</small></td></tr><tr><td ><b>{point.name}</b><br/><b>{point.percentage:.1f}%</b></td></tr>',
			            footerFormat: '</table>',
			            valueDecimals: 2
			        };
				if(that.is_zoom_out==true){//大图时，饼图dataLabel加入百分比
					that.options.plotOptions= {
			            pie: {
			                allowPointSelect: true,
			                cursor: 'pointer',
			                dataLabels: {
			                    enabled: true,
			                    color: '#000000',
			                    connectorColor: '#000000',
			                    format: '{point.name}:{point.percentage:.1f}%'
			                }
			            }
			        };
				}
			}
		},
		
		this.set_bar_or_column = function(){
			that.options.plotOptions= {//开启柱图上显示数据
		        bar: {
		            dataLabels: {
		                enabled: true
		            }
		        },
		        column: {
		            dataLabels: {
		                enabled: true
		            }
		        }
		    };
			that.options.xAxis= {categories: that.categories};
			if(that.is_zoom_out==false || that.chart_type=='column'){
				that.options.xAxis.labels= {
	                rotation: -45,
	                align: 'right',
	                style: {
	                    fontSize: '12px',
	                }
		        };
			}
			that.options.series.dataLabels={//设置柱图上显示数据
		        enabled: true,
		        rotation: -90,
		        color: '#FFFFFF',
		        align: 'right',
		        x: 4,
		        y: 0,
		        style: {
		            fontSize: '12px',
		            textShadow: '0 0 3px black'
		        }
		    };
		}
		var that = this;
		this.init(settings);
		return new Highcharts.Chart(this.options);
};