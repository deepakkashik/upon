<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$action = strval($_GET['action']);
$cid = strval($_GET['id']);
$sec = strval($_GET['secret']);

if ($action == 'dialog') {
	$html = render('ajax_dialog_coupon');
	json($html, 'dialog');
}
else if($action == 'query') {
	$coupon = Table::FetchForce('coupon', $cid);
	$partner = Table::Fetch('partner', $coupon['partner_id']);
	$team = Table::Fetch('team', $coupon['team_id']);
	$e = date('Y-m-d', $team['expire_time']);

	if (!$coupon) { 
		$v[] = AJAX_COUPON_INVALIDATE_CID;
	} else if ( $coupon['consume'] == 'Y' ) {
		$v[] = $INI['system']['couponname'] . AJAX_COUPON_INVALIDATE;
		$v[] = AJAX_COUPON_CONSUME . date('Y-m-d H:i:s', $coupon['consume_time']);
	} else if ( $coupon['expire_time'] < strtotime(date('Y-m-d')) ) {
		$v[] = AJAX_COUPON_HAVE_EXPIRED_CID;
		$v[] = AJAX_COUPON_EXPIRATION_DATE . date('Y-m-d', $coupon['consume_time']);
	} else {
		$v[] = sprintf(AJAX_COUPON_VALID_CID,$cid);;
		$v[] = "{$team['title']}";
		$v[] = AJAX_COUPON_DATE_EXPIRY_E;
	}
	$v = join('<br/>', $v);
	$d = array(
			'html' => $v,
			'id' => 'coupon-dialog-display-id',
			);
	json($d, 'updater');
}

else if($action == 'consume') {
	$coupon = Table::FetchForce('coupon', $cid);
	$partner = Table::Fetch('partner', $coupon['partner_id']);
	$team = Table::Fetch('team', $coupon['team_id']);

	if (!$coupon) {
		$v[] = sprintf(AJAX_COUPON_INVALIDATE_CID,$cid);
		$v[] = AJAX_COUPON_THE_CONSUMER_FAILED;
	}
	else if ($coupon['secret']!=$sec) {
		$v[] = $INI['system']['couponname'] . AJAX_COUPON_NO_PASSWORD_INCORRECT;
		$v[] = AJAX_COUPON_THE_CONSUMER_FAILED;
	} else if ( $coupon['expire_time'] < strtotime(date('Y-m-d')) ) {
		$v[] = sprintf(AJAX_COUPON_EXPIRED_CID,$cid);
		$v[] = AJAX_COUPON_EXPIRATION_TIME . date('Y-m-d', $coupon['consume_time']);
		$v[] = AJAX_COUPON_THE_CONSUMER_FAILED;
	} else if ( $coupon['consume'] == 'Y' ) {
		$v[] = sprintf(AJAX_COUPON_CONSUMED_CID,$cid);
		$v[] = AJAX_COUPON_CONSUME . date('Y-m-d H:i:s', $coupon['consume_time']);
		$v[] = AJAX_COUPON_CONSUMER_FAILED;
	} else {
		ZCoupon::Consume($coupon);
		//credit to user'money'
		$tip = ($coupon['credit']>0) ? sprintf(AJAX_COUPON_REBATE_COUPON_CREDIT_YUAN,$coupon['credit']) : '';
		$v[] = $INI['system']['couponname'] . AJAX_COUPON_VALID;
		$v[] = AJAX_COUPON_CONSUMPTION_TIME . date('Y-m-d H:i:s', time());
		$v[] = AJAX_COUPON_CONSUMER_SUCCESS . $tip;
	}
	$v = join('<br/>', $v);
	$d = array(
			'html' => $v,
			'id' => 'coupon-dialog-display-id',
			);
	json($d, 'updater');
}
else if ($action == 'sms') {
	$coupon = Table::Fetch('coupon', $cid);
	if ( $coupon['sms']>=5 && !is_manager() ) { 
		json(AJAX_COUPON_SMS_SEND_5_TIMES_COUPON, 'alert'); 
	}
	if (!$coupon||!is_login()||($coupon['user_id']!= ZLogin::GetLoginId()&&!is_manager())) {
		json(AJAX_COUPON_ILLEGALLY_DOWNLOADING, 'alert');
	}
	$flag = sms_coupon($coupon);
	if ( $flag === true ) {
		json(AJAX_COUPON_SEND_SMS_SUCCESS_CHECK_TIME, 'alert');
	} else if ( is_string($flag) ) {
		json($flag, 'alert');
	}
	json(sprintf(AJAX_COUPON_SEND_SMS_FAILED_ERROR_CODE_CODE,$code), 'alert');
}
