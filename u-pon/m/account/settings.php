<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();
if ( $_POST ) {
	$update = array(
		'email' => $_POST['email'],
		'username' => $_POST['username'],
		'realname' => $_POST['realname'], 
		'zipcode' => $_POST['zipcode'],
		'address' => $_POST['address'],
		'mobile' => $_POST['mobile'], 
		'gender' => $_POST['gender'], 
		'city_id' => $_POST['city_id'],
		'qq' => $_POST['qq'],
		'city_id' => $_POST['city_id'],
	);
	$errMsg = null;
	//ユーザ名
	if($_POST['username'])
	{
		if(!Utility::ValidStrlen($_POST['username'],4,16))
		{
			$errMsg = $errMsg.ACCUONT_SETTINGS_USERNAME_LENGTH_INVALID."</br>";
		}
	}
	//パスワードのチェック
	if($_POST['password']!=$_POST['password2'])
	{
		$errMsg = $errMsg.ACCUONT_SETTINGS_PASSWORDS_DIFFERENT."</br>";
	}
	else
	{
		if($_POST['password'])
		{
			if(!Utility::ValidStrlen($_POST['password'],4,16))
			{
				$errMsg = $errMsg.ACCUONT_SETTINGS_PASSWORD_LENGTH_INVALID."</br>";
			}	
		}
	}
	//名前
	if($_POST['realname'])
	{
		if(!Utility::ValidStrlen($_POST['realname'],2,32))
		{
			$errMsg = $errMsg.ACCUONT_SETTINGS_REALNAME_LENGTH_INVALID."</br>";
		}
/*		if(Utility::IsJpCharactor($_POST['realname']))
		{
			$errMsg = $errMsg.ACCUONT_SETTINGS_REALNAME_INVALID."</br>";
		}
*/	}
	//郵便番号
	if($_POST['zipcode'])
	{
		if(Utility::IsZipcode($update['zipcode']))
		{
			$errMsg = $errMsg.ACCUONT_SETTINGS_ZIPCODE_INVALID."</br>";
		}
	}
	//電話番号のチッェク
	if($update['mobile'])
	{
		if(!Utility::IsMobile($update['mobile']))
		{
			$errMsg = $errMsg.ACCUONT_SETTINGS_MOBILE_INVALID."</br>";
		}
	}
	$avatar = upload_image('upload_image',$login_user['avatar'],'user');
	$update['avatar'] = $avatar;
	
	if(!isset($errMsg))
	{
		if ( $_POST['password'] == $_POST['password2']
				&& $_POST['password'] ) {
			$update['password'] = $_POST['password'];
		}
	
		if ( ZUser::Modify($login_user['id'], $update) ) {
			Session::Set('notice', ACCUONT_SETTINGS_SETTINGS_SUCCESS);
			Utility::Redirect( WEB_ROOT . '/account/settings.php');
		} else {
			Session::Set('error', ACCUONT_SETTINGS_SETTINGS_FAILED);
			Session::Set('notice', "FAILED");
		}
	}
	else
	{
		Session::Set('error', $errMsg);
	}
}

$readonly['email'] = defined('UC_API') ? '' : 'readonly';
$readonly['username'] = defined('UC_API') ? 'readonly' : '';

include template('account_settings');
