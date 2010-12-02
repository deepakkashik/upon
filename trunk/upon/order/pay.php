<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();

if($_POST)
{
	$order_id = $_POST['order_id'];

	if(!$order_id || !($order = Table::Fetch('order', $order_id))) {
		Utility::Redirect( WEB_ROOT. '/index.php');
	}
	
	$amount = $_POST['amount'];
	$member_id = $login_user['email'];

	$gp = new GmoPayment();
	
	$output = $gp->execTranByMemberId($order_id, $amount, $member_id);
	
	if($output === false)
	{
		Session::Set('error', $gp->getErrorMessage());
		Utility::Redirect( WEB_ROOT. '/order/gmopay.php');
	}

	//payed order
	if ( $order['state'] == 'pay' ) {
		die(include template('order_pay_success'));
	}
	
	Table::UpdateCache('order', $order_id, array(
				'service' => 'credit',
				'money' => 0,
				'state' => 'pay',
				'credit' => $order['origin'],
				));
	$order = Table::FetchForce('order', $order_id);
	ZTeam::BuyOne($order);
	
	die(include template('order_pay_success'));	
}
else 
{
	Utility::Redirect( WEB_ROOT. '/index.php');	
}
