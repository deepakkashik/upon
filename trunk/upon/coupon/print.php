<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();

$id = strval($_GET['id']);
$coupon = Table::Fetch('coupon', $id);

if (!$coupon) {
	Session::Set('error', COUPON_PRINT_SYSTEM_COUPONNAME_NOT_EXIST);
	Utility::Redirect(WEB_ROOT . '/coupon/index.php');
}

if ($coupon['user_id'] != $login_user_id) { 
	Session::Set('error', COUPON_PRINT_BILL_SYSTEM_COUPONNAME_NOT_BELONGS_YOU);
	Utility::Redirect(WEB_ROOT . '/coupon/index.php');
}

$partner = Table::Fetch('partner', $coupon['partner_id']);
$team = Table::Fetch('team', $coupon['team_id']);

include template('coupon_print');
