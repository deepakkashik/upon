<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();


	

	$gid = abs(intval($_GET['gid']));
	$rst = abs(intval($_GET['rst']));
	$ap = strval($_GET['ap']);
	$ec = strval($_GET['ec']);
	$god = abs(intval($_GET['god']));
	$cod = strval($_GET['cod']);
	$am = abs(intval($_GET['am']));
	$tx = abs(intval($_GET['tx']));
	$sf = abs(intval($_GET['sf']));
	$ta = abs(intval($_GET['ta']));
	
	
	$order_id = abs(intval($_POST['order_id']));
	$service = abs(intval($_POST['service']));
	
if (is_post()) {
	$order_id = abs(intval($_POST['order_id']));

} else {
	if ( $_GET['id'] == 'charge' ) {
		Utility::Redirect( WEB_ROOT. '/credit/index.php');
	}
	$order_id = $id = abs(intval($_GET['id']));
}
if(!$order_id || !($order = Table::Fetch('order', $order_id))) {
	Utility::Redirect( WEB_ROOT. '/index.php');
}

if (is_post()&&$_POST['paytype']) {
	$uarray = array( 'service' => strtolower($_POST['paytype']), );
	Table::UpdateCache('order', $order_id, $uarray);
	$order = Table::Fetch('order', $order_id);
	$order['service'] = strtolower($_POST['paytype']);
}

//payed order
if ( $order['state'] == 'pay' ) {
	if ( is_get() ) {
		$team = Table::Fetch('team', $order['team_id']);
		die(include template('order_pay_success'));
	} else {
		Utility::Redirect(WEB_ROOT  . "/order/pay.php?id={$order_id}");
	}
}

$team = Table::Fetch('team', $order['team_id']);
$randno = rand(1000,9999);
$total_money = moneyit($order['origin'] - $login_user['money']);
if ($total_money<0) { $total_money = 0; $order['service'] = 'credit'; }

/* credit pay */
if ( $_POST['action'] == 'redirect' ) {
	Utility::Redirect($_POST['reqUrl']);
}
elseif ( $_POST['service'] == 'credit' && $_GET['gid']== $gid ) {		///点击最终结算按钮()
	//if ( $order['origin'] > $login_user['money'] ) {
		//Table::Delete('order', $order_id);
		//Utility::Redirect( WEB_ROOT . '/order/index.php');
	//}
	//$gid = abs(intval($_POST['gid']));
	Table::UpdateCache('order', $order_id, array(
				'service' => 'credit',
				'money' => 0,
				'state' => 'pay',
				'credit' => $order['origin'],
				));
	$order = Table::FetchForce('order', $order_id);
	ZTeam::BuyOne($order);	////还需要改动
	
	/**
	 * 将结算公司返回值 插入到数据库中 start
	 */
	need_login(true);
	$table = new Table('jiesuan', $_POST);
	
	$table->gid = $gid;
	$table->rst = $rst;
	$table->ap = $ap;
	$table->ec = $ec;
	$table->god = $god;
	$table->cod = $cod;
	$table->am = $am;
	$table->tx = $tx;
	$table->sf = $sf;
	$table->ta = $ta;

	$insert = array(
			'gid', 'rst', 'ap', 'ec',
			'god', 'cod', 'am', 'tx',
			'sf', 'ta', 
		);
	if ($flag = $table->insert($insert)) {
		//$order_id = abs(intval($table->id));
		//Utility::Redirect(WEB_ROOT."/order/check.php?id={$order_id}");
	
		//Utility::Redirect( WEB_ROOT . "/order/pay.php?id={$order_id}");
		die(include template('order_pay_success'));
	}
	/**
	 * 将结算公司返回值 插入到数据库中 end
	 */
	
	//Utility::Redirect( WEB_ROOT . "/order/pay.php?id={$order_id}");
	die(include template('order_pay_success'));
}else if ( $order['service'] == 'credit' ) {
	$total_money = $order['origin'];
	die(include template('order_pay'));
}
else {
	Session::Set('error', ORDER_PAY_ERROR);
	Utility::Redirect( WEB_ROOT. "/team.php?id={$order_id}");
}
