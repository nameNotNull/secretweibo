<?php
// +----------------------------------------------------------------------
// | YZCMS <XueHen CMS>
// +----------------------------------------------------------------------
// | Copyright (c) http://www.xuehen.org
// +----------------------------------------------------------------------
// | Author XueHen <490860758@qq.com>
// +----------------------------------------------------------------------

if(file_exists(APP_PATH.'Common/Conf/db.php')){
	$dbconfig = require APP_PATH.'Common/Conf/db.php';
}else{
	$dbconfig = array();
}
$config = array(

	'SITE_URL'		=> 'http://test.ruanqudao.com',	// 站点网址

	/*模块管理*/
	'DEFAULT_MODULE'       =>    'Home',
	//'SHOW_PAGE_TRACE'      => 'true',
	//'URL_MODEL'          => '3', //URL模式
	/*模板设置*/
	'TMPL_PARSE_STRING'	=>	array(
   		'__CSS__'     => __ROOT__.'/Public/Css',
		'__JS__'     => __ROOT__.'/Public/Js',
		'__PLUGIN__' => __ROOT__.'/Public/Plugin',
		'__IMAGE__' => __ROOT__.'/Public/Image'),

	'__CSS__'     => __ROOT__.'/Public/Css',
		'__JS__'     => __ROOT__.'/Public/Js',
		'__PLUGIN__' => __ROOT__.'/Public/Plugin',
		'__IMAGE__' => __ROOT__.'/Public/Image',
	/*视图配置*/
	'TMPL_FILE_DEPR'     => '/',
	'TMPL_L_DELIM'       => '<{',
	'TMPL_R_DELIM'       => '}>',

	/*是否检查文件的大小写*/
	'APP_FILE_CASE'      =>  true,
	// 'VIEW_PATH'          => './Tpl/',
	
	//默认错误跳转对应的模板文件
	'TMPL_ACTION_ERROR' => 'Home@Public:dispatch_jump',
	
	//默认成功跳转对应的模板文件
	'TMPL_ACTION_SUCCESS' => 'Home@Public:dispatch_jump',);

return array_merge($config,$dbconfig);
