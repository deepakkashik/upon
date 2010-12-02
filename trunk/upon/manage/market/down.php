<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();

if ( $_POST ) {
	$city_id = $_POST['city_id'];
	$users = DB::LimitQuery('user', array(
				'condition' => array(
					'city_id' => $city_id,
					'mobile > 0',
					),
				'select' => 'email, realname, mobile',
				));
	if ( $users ) {
		$kn = array(
				'email' => MANAGE_MARKET_DOWN_USEREMAIL,
				'realname' => MANAGE_MARKET_DOWN_REALNAME,
				'mobile' => MANAGE_MARKET_DOWN_MOBILE,
				);
		$name = "mobile_".date('Ymd');
		down_xls($users, $kn, $name);
	}
	die('-ERR ERR_NO_DATA');
}

include template('manage_market_downsms');
