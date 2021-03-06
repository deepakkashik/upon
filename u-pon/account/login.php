<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

//dialog画面の表示するフラク
$carrierflg = Session::Get('carrierflg', true);
$facebookusername = Session::Get('facebook_username');
$facebookemail = Session::Get('facebook_email');

if ( $_POST ) {
	$login_user = ZUser::GetLogin($_POST['email'], $_POST['password']);
	if ( !$login_user ) {
		Session::Set('error', ACCUONT_LOGIN_LOGIN_FAILED);
		Utility::Redirect(WEB_ROOT . '/account/login.php');
	} else if ($INI['system']['emailverify'] 
			&& $login_user['enable']=='N'
			&& $login_user['secret']
			) {
		Session::Set('unemail', $_POST['email']);
		Utility::Redirect(WEB_ROOT .'/account/verify.php');
	} else {
		Session::Set('user_id', $login_user['id']);
		ZLogin::Remember($login_user);
		ZUser::SynLogin($_POST['email'], $_POST['password']);
		Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
	}
}
$currefer = strval($_GET['r']);
if ($currefer) { Session::Set('loginpage', udecode($currefer)); }
include template('account_login');