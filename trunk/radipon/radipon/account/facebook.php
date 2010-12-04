<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

define('FACEBOOK_APP_ID', '144033315615787');
define('FACEBOOK_SECRET', '9d36f2dcd09f3406e56b4ea1b99b6dc5');

function get_facebook_cookie($app_id, $application_secret) {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . $application_secret) != $args['sig']) {
    return null;
  }
  return $args;
}

$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token='.$cookie['access_token']));

if( !$user )
{
	Utility::Redirect(get_loginpage(WEB_ROOT . '/account/login.php'));
}

	
Session::Set('facebook_username',strval($user->name));
Session::Set('facebook_email',strval($user->email));

$facebook_user = Table::Fetch('user', $user->email,'email');	//根据email查找用户    *****$user->email
if ($facebook_user) { 	//userが存在している
	
	$login_from = $facebook_user['login_from'];
	if(!(strpos($login_from, "FACEBOOK")===FALSE)){ //リンクが存在している場合
		ZLogin::Login($facebook_user['id']);	///仅仅是设置$_SESSION
		Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
	}else {		
		$_facebookmarking = "facebook_link_dlg";
		Session::Set('carrierflg',$_facebookmarking);
		Utility::Redirect(get_loginpage(WEB_ROOT . '/account/login.php'));
	}
}else {	
	//ユーザが存在していない場合は、ユーザを新規する
	$u = array();
	$u['username'] = strval($user->name);
	$u['email'] = strval($user->email);
	$u['login_from'] = strval("SELF,FACEBOOK");
	
	if(ZUser::FacebookInsertToDB($u)) 
	{
		$facebook_user = Table::Fetch('user', $user->email,'email');
		ZLogin::Login($facebook_user['id']);
	} else {
		Session::Set("error",AJAX_LINK_DB_UPDATE_ERROR);
	}
	Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
} 
