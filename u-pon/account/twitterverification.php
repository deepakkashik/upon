<?php
require_once(dirname(__FILE__)."/twittercommon.php");


$aParam = array(
	"oauth_token" => $_GET["oauth_token"],
	"oauth_verifier" => $_GET["oauth_verifier"],
);

$sURL = "http://api.twitter.com/oauth/access_token";

$sReturn = $oOAuth->send($aParam, $sURL);

parse_str($sReturn, $aReturn);

if (!$bCli) {
	$_SESSION["oauth_token"] = $aReturn["oauth_token"];
	$_SESSION["oauth_token_secret"] = $aReturn["oauth_token_secret"];
}
//Twitter登録してるかをチェック
if ($aReturn["user_id"]) {
//Twitter user idで認証
	$login_user = ZUser::GetLoginByTwitterId($aReturn["user_id"]);
	if($login_user){
		//既に登録した場合
		Session::Set('user_id', $login_user['id']);
		ZLogin::Remember($login_user);
		ZUser::SynLogin($_POST['email'], $_POST['password']);
		Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
	}else{
		Session::set('carrierusername', $aReturn["screen_name"]);
		Session::set('carrieruserid', $aReturn["user_id"]);
		$_carrierflg = 'twitter_input_email';
		Session::Set('carrierflg',$_carrierflg);
		Utility::Redirect(get_loginpage(WEB_ROOT . '/account/login.php'));
	}
} else {
	//ログイン画面へ遷移する
	Utility::Redirect( WEB_ROOT . '/account/login.php');
}