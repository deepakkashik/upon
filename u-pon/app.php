<?php
require_once(dirname(__FILE__). '/langs/lang.php');
require_once(dirname(__FILE__). '/include/application.php');

/* process currefer URL处理*/
$currefer = uencode(strval($_SERVER['REQUEST_URI']));

/* session,cache,configure,webroot register */
Session::Init(); 			//初始化Session
$INI = ZSystem::GetINI(); 	//读取系统配置文件

//根据请求类型，输出不同的Header
$AJAX = ('XMLHttpRequest' == @$_SERVER['HTTP_X_REQUESTED_WITH']);
if (false==$AJAX) { 
    header('Content-Type: text/html; charset=UTF-8;'); 
} else {
    header("Cache-Control: no-store, no-cache, must-revalidate");
}
/* end */

/* biz logic 商业逻辑处理 */
$currency = $INI['system']['currency'];	//货币符
$login_user_id = ZLogin::GetLoginId();	//取得登录用户id
$login_user = Table::Fetch('user', $login_user_id);	//取得登录用户信息
$city = cookie_city(null);				//取得当前城市
$hotcities = Table::Fetch('category', $INI['hotcity']);	//取得所有城市信息
$cities = ZCategory::AreaCoupon();
$cities = Utility::AssColumn($cities, 'czone', 'ename','flag');

/* not allow access app.php */
if($_SERVER['SCRIPT_FILENAME']==__FILE__){
	Utility::Redirect( WEB_ROOT . '/index.php');
}
/* end */
