<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$login_from = Session::Get('login_from');
$facebookusername = Session::Get('facebook_username');
$facebookemail = Session::Get('facebook_email');

ZLogin::Remember($login_user);
ZUser::SynLogin($_POST['email'], $_POST['password']);

$login_user = Table::Fetch('user', $facebookemail,'email');
$update['login_from'] = $login_from . ',FACEBOOK';			////更改数据库login_from字段
echo $update['login_from'];
if ( ZUser::Modify($login_user['id'], $update) ) {
	ZLogin::Login($login_user['id']);
	Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
}