<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();

if ( $_POST ) {
	$phones = preg_split('/[\s,]+/', $_POST['phones'], -1, PREG_SPLIT_NO_EMPTY);
	$content = trim(strval($_POST['content']));
	$phone_count = count($phones);
	$phones = implode(',', $phones);
	$ret = sms_send($phones, $content);
	if ( $ret===true ) {
		Session::Set('notice', sprintf(MANAGE_MARKET_SMS_SMSSUCCESS_PHONECOUNT,$phone_count));
		Utility::Redirect( WEB_ROOT + '/manage/market/sms.php' );
	}
	Session::Set('notice', sprintf(MANAGE_MARKET_SMS_SMSFAIL_RET,$ret));
}

include template('manage_market_sms');
