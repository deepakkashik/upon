<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();

if ( $_POST ) {
	$gender = $_POST['gender'];
	$newbie = $_POST['newbie'];
	$city_id = $_POST['city_id'];
	if (!$city_id || !$newbie || !$gender) die('-ERR ERR_CHECK');

	$condition = array(
		'gender' => $gender,
		'newbie' => $newbie,
		'city_id' => $city_id,
	);

	$users = DB::LimitQuery('user', array(
		'condition' => $condition,
		'user' => 'ORDER BY id DESC',
	));

	if (!$users) die('-ERR ERR_NO_DATA');

	$name = 'user_'.date('Ymd');
	$kn = array(
		'id' => 'ID',
		'email' => MANAGE_MARKET_DOWNUSER_EMAIL,
		'username' => MANAGE_MARKET_DOWNORDER_USERNAME,
		'realname' => MANAGE_MARKET_DOWNORDER_REALNAME,
		'gender' => MANAGE_MARKET_DOWNORDER_GENDER,
		'qq' => MANAGE_MARKET_DOWNORDER_QQ,
		'mobile' => MANAGE_MARKET_DOWNORDER_MOBILE,
		'zipcode' => MANAGE_MARKET_DOWNORDER_ZIPCODE,
		'address' => MANAGE_MARKET_DOWNORDER_ADDRESS,
		'newbie' => MANAGE_MARKET_DOWNORDER_NEWBIE,
		);

	$gender = array(
		'M' => MANAGE_MARKET_DOWNUSER_M,
		'F' => MANAGE_MARKET_DOWNORDER_F,
	);
	$newbie = array(
		'Y' => MANAGE_MARKET_DOWNUSER_N,
		'N' => MANAGE_MARKET_DOWNORDER_Y,
	);

	$eusers = array();
	foreach( $users AS $one ) {
		$one['gender'] = $gender[$one['gender']];
		$one['newbie'] = $newbie[$one['newbie']];
		$eusers[] = $one;
	}
	down_xls($eusers, $kn, $name);
}

include template('manage_market_downuser');
