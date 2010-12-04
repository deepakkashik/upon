<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

 //機種番号
$obj = new MobileCheck();
$env = $obj->CheckUA($_SERVER['HTTP_USER_AGENT']);
$mobileCD = '';
$mobileFlg = 'none';
if($env !== 'pc' && $env !== 'other'){
	$obj->GetZone($env);
	$result = $obj->CheckIP($obj->zone);
	if($result === FALSE){
		// 偽装の時はPCへ振り分け
		$env = 'pc';
	}else{
		list($ser,$icc,$dgd,$srn,$sud,$ezn) = $obj->GetSub($env);
	}
	
	//mobileCD設定
	if ($env === 'docomo') {
		$mobileCD = $ser;
	}elseif ($env === 'softbank') {
		$mobileCD = $srn;
	}elseif ($env === 'au') {
		$mobileCD = $ezn;
	}
}
//データベースからmobileCD存在を確認
if ($mobileCD) {
	$replies = DB::LimitQuery('user', array(
	'condition' => array( 'uid' => $mobileCD, ),
	));
	if ($replies) {
		$mobileFlg = 'show';
	}else {
		$mobileFlg = 'check';
	}
}

if ( $_POST ) {
	if ($_POST['loginType'] === 'emailLogin') {
		$login_user = ZUser::GetLogin($_POST['email'], $_POST['password']);
	}elseif($_POST['loginType'] === 'mobileUidLogin'){
		$login_user = ZUser::GetUserFromUid($mobileCD);
	}
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
		if ($_POST['loginType'] === 'emailLogin'&&$_POST['mobileChk']) {
			Table::UpdateCache('user', $login_user['id'], array(
			'uid' => $_POST['mobileChk'],
			));
		}
		Session::Set('user_id', $login_user['id']);
		ZLogin::Remember($login_user);
		ZUser::SynLogin($_POST['email'], $_POST['password']);
		Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
	}
}
$currefer = strval($_GET['r']);
if ($currefer) { Session::Set('loginpage', udecode($currefer)); }
include template('account_login');
