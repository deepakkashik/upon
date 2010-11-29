<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

if ( $_POST ) {
	$u = array();
	$u['username'] = strval($_POST['username']);
	$u['password'] = strval($_POST['password']);
	$u['email'] = strval($_POST['email']);
	$u['city_id'] = abs(intval($_POST['city_id']));
	$u['mobile'] = strval($_POST['mobile']);
	$u['login_from'] = strval('SELF');

	if ( $_POST['subscribe'] ) { 
		ZSubscribe::Create($u['email'], abs(intval($u['city_id']))); 
	}
	//メールアドレスを最少と最大の長さを判断
	if (!Utility::ValidStrlen($u['email'], '0', '128')) {
		if ( ! Utility::ValidEmail($u['email'], true) ) {
			$errMsg = Utility::AddStr($errMsg, ACCUONT_SIGNUP_EMAIL_INVALID_ADDRESS);
		}
	} else {
	 	$errMsg = Utility::AddStr($errMsg, ACCUONT_SIGNUP_EMAIL_LEN_ERROR);
	 }
	
	//ユーザネームを最少と最大の長さを判断
	if (Utility::ValidStrlen($u['username'], '4', '16')) {
		$errMsg = Utility::AddStr($errMsg, ACCUONT_SIGNUP_USERNAME_LEN_ERROR);
	}
	
	//携帯番号のformatの判断
	if ($u['mobile']) {
		if(!Utility::IsMobile($u['mobile'])) {
			$errMsg = Utility::AddStr($errMsg, ACCUONT_SIGNUP_MOBILE_ERROR);
		}
	}
	
	//会員規約とプライバシーポリシーに同意の判断
	if (!isset($_POST['subscribe1'])) {
		$errMsg = Utility::AddStr($errMsg, ACCUONT_SIGNUP_MENBER_CHECK_ERROR);
	}
	if (!$errMsg) {
		//パスワードを最少と最大の長さを判断
		if (!Utility::ValidStrlen($u['password'], '4', '16')) {
			if ($_POST['password2']==$_POST['password'] && $_POST['password']) {
				if ( $INI['system']['emailverify'] ) { 
					$u['enable'] = 'N'; 
				}
				if ( $user_id = ZUser::Create($u) ) {
					if ( $INI['system']['emailverify'] ) {
						mail_sign_id($user_id);
						Session::Set('unemail', $_POST['email']);
						Utility::Redirect( WEB_ROOT . '/account/signuped.php');
					} else {
						ZLogin::Login($user_id);
						Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
					}
				} else {
					$au = Table::Fetch('user', $_POST['email'], 'email');
					if ( $au ) {
						Session::Set('error', ACCUONT_SIGNUP_EMAIL_USE);
					} else {
						Session::Set('error', ACCUONT_SIGNUP_USER_USE);
					}
				}
			} else {
				$errMsg = Utility::AddStr($errMsg, ACCUONT_SIGNUP_PASSWORD_ERROR);
			}
		} else {
			$errMsg = Utility::AddStr($errMsg, ACCUONT_SIGNUP_PASSWORD_LEN_ERROR);
		}
	}
	if ($errMsg) {
		Session::Set('error', $errMsg);
	}
}

include template('account_signup');
