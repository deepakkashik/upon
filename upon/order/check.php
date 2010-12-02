<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
need_login(true);

$order_id = abs(intval($_GET['id']));
$order = Table::Fetch('order', $order_id);
if (!$order) {
	Session::Set('error',ORDER_CHECK_ERROR);
	Utility::Redirect( WEB_ROOT . '/index.php' );
}
$team = Table::Fetch('team', $order['team_id']);
$team['state'] = team_state($team);

if ( $team['close_time'] ) {
	Utility::Redirect( WEB_ROOT . "/team.php?id={$order['team_id']}");
}

if ( $order['state'] == 'unpay' ) {
	$gp = new GmoPayment();		
	$member_id = $login_user['email'];

	$credit_card = $gp->getCard($member_id);
	
	if($credit_card === false)
	{
		Utility::Redirect(WEB_ROOT."/order/gmopay.php?id={$order_id}");			
	}		
	
	if($INI['alipay']['mid'] && $order['service']=='alipay') {
		$ordercheck['alipay'] = 'checked';
	}
	else if($INI['chinabank']['mid'] && $order['service']=='chinabank') {
		$ordercheck['chinabank'] = 'checked';
	}
	else if($INI['tenpay']['mid'] && $order['service']=='tenpay') {
		$ordercheck['tenpay'] = 'checked';
	}
	else if($INI['alipay']['mid']) {
		$ordercheck['alipay'] = 'checked';
	}
	else if($INI['tenpay']['mid']) {
		$ordercheck['tenpay'] = 'checked';
	}
	else if($INI['chinabank']['mid']) {
		$ordercheck['chinabank'] = 'checked';
	}

	die(include template('order_check'));
}

Utility::Redirect( WEB_ROOT . "/order/view.php?id={$id}");
