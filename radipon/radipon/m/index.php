<?php
/**
 * @name: index.php
 * @desc: 此文件首页。
 */
//执行应用程序模块
require_once(dirname(__FILE__) . '/app.php');

//如果没有系统安装，则执行安装模块
if(!$INI['db']['host']) Utility::Redirect( WEB_ROOT . '/install.php' );
$cities = DB::LimitQuery('category', array(
	'condition' => array( 'zone' => 'city') ,
	'order' => 'order by id',
));
$cities = Utility::AssColumn($cities, 'czone', 'ename');
$request_uri = 'index';
$team = current_team($city['id']);	//取得当前团购信息
if ($team) {
	$_GET['id'] = abs(intval($team['id']));
	die(require_once('team.php'));
}

//引入模板模块
include template('subscribe');
