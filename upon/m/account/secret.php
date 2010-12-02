<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$action = strval($_GET['action']);
$cid = strval($_REQUEST['id']);
$sec = strval($_REQUEST['secret']);
$query = strval($_POST['query']);
$consume = strval($_POST['consume']);

if($query){
	$coupon = Table::FetchForce('coupon', $cid);
	$partner = Table::Fetch('partner', $coupon['partner_id']);
	$team = Table::Fetch('team', $coupon['team_id']);
	$e = date('Y-m-d', $team['expire_time']);

	if (!$coupon) { 
		$v[] = sprintf(AJAX_COUPON_INVALIDATE_CID,$cid);
	} else if ( $coupon['consume'] == 'Y' ) {
		$v[] = $INI['system']['couponname'] . AJAX_COUPON_INVALIDATE;
		$v[] = AJAX_COUPON_CONSUME . date('Y-m-d H:i:s', $coupon['consume_time']);
	} else if ( $coupon['expire_time'] < strtotime(date('Y-m-d')) ) {
		$v[] = sprintf(AJAX_COUPON_EXPIRED_CID,$cid);  //AJAX_COUPON_HAVE_EXPIRED_CID;
		$v[] = AJAX_COUPON_EXPIRATION_DATE . date('Y-m-d', $coupon['consume_time']);
	} else {
		$v[] = sprintf(AJAX_COUPON_VALID_CID,$cid);
		$v[] = "{$team['title']}";
		$v[] = sprintf(AJAX_COUPON_DATE_EXPIRY_E,$e);
	}
	$v = join('<br/>', $v);
	$d = array(
			'html' => $v,
			'id' => 'coupon-dialog-display-id',
			);
	//json($d, 'updater');
}else if($consume){
	$coupon = Table::FetchForce('coupon', $cid);
	$partner = Table::Fetch('partner', $coupon['partner_id']);
	$team = Table::Fetch('team', $coupon['team_id']);

	if (!$coupon) {
		$v[] = sprintf(AJAX_COUPON_INVALIDATE_CID,$cid);
		$v[] = AJAX_COUPON_CONSUMER_FAILED;
	}
	else if ($coupon['secret']!=$sec) {
		$v[] = $INI['system']['couponname'] . AJAX_COUPON_NO_PASSWORD_INCORRECT;
		$v[] = AJAX_COUPON_CONSUMER_FAILED;
	} else if ( $coupon['expire_time'] < strtotime(date('Y-m-d')) ) {
		$v[] = sprintf(AJAX_COUPON_EXPIRED_CID,$cid);
		$v[] = AJAX_COUPON_EXPIRATION_TIME . date('Y-m-d', $coupon['consume_time']);
		$v[] = AJAX_COUPON_CONSUMER_FAILED;
	} else if ( $coupon['consume'] == 'Y' ) {
		$v[] = sprintf(AJAX_COUPON_CONSUMED_CID,$cid);
		$v[] = AJAX_COUPON_CONSUME . date('Y-m-d H:i:s', $coupon['consume_time']);
		$v[] = AJAX_COUPON_CONSUMER_FAILED;
	} else {
		ZCoupon::Consume($coupon);
		//credit to user'money'
		$tip = ($coupon['credit']>0) ? AJAX_COUPON_REBATE_COUPON_CREDIT_YUAN : '';
		$v[] = $INI['system']['couponname'] . AJAX_COUPON_VALID;
		$v[] = AJAX_COUPON_CONSUMPTION_TIME . date('Y-m-d H:i:s', time());
		$v[] = AJAX_COUPON_CONSUMER_SUCCESS . $tip;
	}
	$v = join('<br/>', $v);
	$d = array(
			'html' => $v,
			'id' => 'coupon-dialog-display-id',
			);
	//json($d, 'updater');	
}else if($action=='sms'){
	$coupon = Table::Fetch('coupon', $cid);
	/**if ( $coupon['sms']>=5 && !is_manager() ) { //zuiduofasong5ci
		json(AJAX_COUPON_SMS_SEND_5_TIMES_COUPON, 'alert'); 
	}*/
	if (!$coupon||!is_login()||($coupon['user_id']!= ZLogin::GetLoginId()&&!is_manager())) {//feifaxiazai
		//json(AJAX_COUPON_ILLEGALLY_DOWNLOADING, 'alert');
	}
	//$flag = sms_coupon($coupon);
	$flag = mail_coupon($coupon);////////////////////////////////////
	if ( $flag === true ) {
		//json(AJAX_COUPON_SEND_SMS_SUCCESS_CHECK_TIME, 'alert');
	} else if ( is_string($flag) ) {
		//json($flag, 'alert');
	}
	//json(AJAX_COUPON_SEND_SMS_FAILED_ERROR_CODE_CODE, 'alert');	
	
}else{
	//$html = render('ajax_dialog_coupon');
	//json($html, 'dialog');	
}

include template('ajax_dialog_coupon');

