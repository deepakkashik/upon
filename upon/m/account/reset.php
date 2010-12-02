<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

if(isset($_SESSION['user_id'])) {
	unset($_SESSION['user_id']);
	ZLogin::NoRemember();
	$login_user = $login_user_id = $login_manager = $login_leader = null;
}

$code = strval($_GET['code']);
if ( $code == 'ok' && is_get()) {
	die(include template('account_reset_ok'));
}

$user = Table::Fetch('user', $code, 'recode');
if (!$user) {
	Session::Set('error', ACCUONT_RESET_RESET_PASSORD_ERROR);
	Utility::Redirect( WEB_ROOT . '/index.php');
}

if (is_post()) {
	if ($_POST['password'] == $_POST['password2']) {
		$password = ZUser::GenPassword($_POST['password']);
		Table::UpdateCache('user', $user['id'], array(
			'password' => $password,
			'recode' => '',
		));
		Utility::Redirect( WEB_ROOT . '/account/reset.php?code=ok');
	}
	Session::Set('error', ACCUONT_RESET_PASSORD_ERROR);
}

include template('account_reset');
