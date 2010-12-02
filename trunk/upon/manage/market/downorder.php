<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();

if ( $_POST ) {
	$team_id = abs(intval($_POST['team_id']));
	$service = $_POST['service'];
	$state = $_POST['state'];
	if (!$team_id || !$service || !$state) die('-ERR ERR_NO_DATA');
	
	$condition = array(
		'service' => $service,
		'state' => $state,
		'team_id' => $team_id,
	);
	$orders = DB::LimitQuery('order', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
	));

	if (!$orders) die('-ERR ERR_NO_DATA');
	$team = Table::Fetch('team', $team_id);
	$name = 'order_'.date('Ymd');
	$kn = array(
		'id' => MANAGE_MARKET_DOWNORDER_ID,
		'pay_id' => MANAGE_MARKET_DOWNORDER_PAYID,
		'service' => MANAGE_MARKET_DOWNORDER_SERVICE,
		'price' => MANAGE_MARKET_DOWNORDER_PRICE,
		'quantity' => MANAGE_MARKET_DOWNORDER_QUANTITY,
		'fare' => MANAGE_MARKET_DOWNORDER_FARE,
		'origin' => MANAGE_MARKET_DOWNORDER_ORIGIN,
		'money' => MANAGE_MARKET_DOWNORDER_MONEY,
		'credit' => MANAGE_MARKET_DOWNORDER_CREDIT,
		'state' => MANAGE_MARKET_DOWNORDER_STATE,
		);

	if ( $team['delivery'] == 'express' ) {
		$kn = array_merge($kn, array(
					'realanem' => MANAGE_MARKET_DOWNORDER_REALANEM,
					'mobile' => MANAGE_MARKET_DOWNORDER_MOBILE,
					'zipcode' => MANAGE_MARKET_DOWNORDER_ZIPCODE,
					'address' => MANAGE_MARKET_DOWNORDER_ADDRESS,
					));
	}
	$pay = array(
			'alipay' => MANAGE_MARKET_DOWNORDER_ALIPAY,
			'tenpay' => MANAGE_MARKET_DOWNORDER_TENPAY,
			'chinabank' => MANAGE_MARKET_DOWNORDER_CHINABANK,
			'credit' => MANAGE_MARKET_DOWNORDER_CREDIT,
			'cash' => MANAGE_MARKET_DOWNORDER_CASH,
			'' => MANAGE_MARKET_DOWNORDER_OTHER,
			);
	$state = array(
			'unpay' => MANAGE_MARKET_DOWNORDER_UNPAY,
			'pay' => MANAGE_MARKET_DOWNORDER_PAY,
			);
	$eorders = array();
	foreach( $orders AS $one ) {
		$one['fare'] = ($one['delivery'] == 'express') ? $one['fare'] : 0;
		$one['service'] = $pay[$one['service']];
		$one['price'] = $team['market_price'];
		$one['state'] = $state[$one['state']];
		$eorders[] = $one;
	}
	down_xls($eorders, $kn, $name);
}

include template('manage_market_downorder');
