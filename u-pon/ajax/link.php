<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$action = strval($_GET['action']);
$carrier = strval($_GET['carrier']);

//キャリア(facebook,twitterなど)のユーザID
$carrieruserid = Session::Get('carrieruserid');
//キャリア(facebook,twitterなど)のユーザ名
$carrierusername = Session::Get('carrierusername');
//キャリア(facebook,twitterなど)のemail
$email = Session::Get('email');


$action_query =strval($_POST['action_query']);

if ($action == 'dialog' && $carrier == 'facebook_link_dlg') {
	$html = render('ajax_link_facebook');
	json($html, 'dialog');
}
//ログイン画面からtwitterのemailのdialog画面を表示
if ($action == 'dialog' && $carrier == 'twitter_input_email') {
	$html = render('ajax_link_twitter');
	json($html, 'dialog');
}

//ログイン画面からtwitterのpaswordのdialog画面を表示
if($action == 'dialog' && $carrier == 'twitter_input_pass') {
	//dialogのパスワードの画面
	$html = render('ajax_link_twitterpw');
	json($html, 'dialog');
}

//twitterのemail画面送信処理
if($action_query == 'twitter_email_query') {
	//emailチェック
	if ( ! Utility::ValidEmail($_POST['email'], true) ) {
		Session::Set('link_error', AJAX_LINK_EMAIL_INVALID);
		Session::Set('carrierflg','twitter_input_email');
		Utility::Redirect(get_loginpage(WEB_ROOT . '/account/login.php'));
	} else {
		//emailがDBに存在するかを検索
		$au = Table::Fetch('user', $_POST['email'], 'email');
		//メールアドレスが存在している場合
		if ( $au['email']) {
			Session::Set('email', $au['email']);
			Session::Set('carrierflg', 'twitter_input_pass');
			Utility::Redirect(get_loginpage(WEB_ROOT . '/account/login.php'));
		} else {
			//新規ユーザをDBに保存
			$u['username'] = strval($carrierusername);
			$u['email'] = strval($_POST['email']);
			$u['login_from'] = 'SELF,' . strval($carrieruserid."@twitter");
			if(ZUser::FacebookInsertToDB($u))
			{
				$twitter_user = Table::Fetch('user', $u['email'],'email');
				ZLogin::Login($twitter_user['id']);				
			}else
			{
				Session::Set("error",AJAX_LINK_DB_INSERT_ERROR);
			}
			Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
		}
	}
}

//twitterのパスワードdialog画面送信処理
if($action_query == 'twitter_password_query') {
	$password = $_POST['twitter_password'];
	$login_user = ZUser::GetLogin($email, $password);
	//パスワードの認証
	if ( !$login_user ) {
		Session::Set('link_error', AJAX_LINK_PASSORD_INVALID);
		Session::Set('carrierflg', 'twitter_input_pass');
		Utility::Redirect(get_loginpage(WEB_ROOT . '/account/login.php'));
	} else {
		//DBにuserテーブルのlogin_from項目を更新
		$update['login_from'] = $login_user['login_from']. ',' . $carrieruserid.'@twitter';
		if ( ZUser::Modify($login_user['id'], $update) ) {
			Session::Set('user_id', $login_user['id']);
			ZLogin::Remember($login_user);
			ZUser::SynLogin($_POST['email'], $_POST['password']);
			Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
		}else
		{
			Session::Set("error",AJAX_LINK_DB_UPDATE_ERROR);
			Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
		}

	}
}

if($action_query == 'facebook_query') {

	$facebookusername = Session::Get('facebook_username');
	$facebookemail = Session::Get('facebook_email');

	$password = strval($_POST['facebook_password']);
	
	$login_user = ZUser::GetLogin($facebookemail, $password);

	if ( !$login_user ) {
		Session::Set('link_error', AJAX_LINK_PASSORD_INVALID);
		Session::Set('carrierflg','facebook_link_dlg');
		Utility::Redirect(get_loginpage(WEB_ROOT . '/account/login.php'));
	} else {
		// FACEBOOKにリンクする
		$update['login_from'] = $login_user['login_from'] .',FACEBOOK';
		if ( ZUser::Modify($login_user['id'], $update) ) {
			Session::Set('user_id', $login_user['id']);
			ZLogin::Remember($login_user);
			ZUser::SynLogin($_POST['email'], $_POST['password']);
			Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
		} else
		{
			Session::Set("error",AJAX_LINK_DB_UPDATE_ERROR);
			Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
		}
	}
}