<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();

$gid = abs(intval($_GET['gid']));
$rst = abs(intval($_GET['rst']));
$ap = strval($_GET['ap']);
$ec = strval($_GET['ec']);
$god = abs(intval($_GET['god']));
$cod = abs(intval($_GET['cod']));
$am = abs(intval($_GET['am']));
$tx = abs(intval($_GET['tx']));
$sf = abs(intval($_GET['sf']));
$ta = abs(intval($_GET['ta']));
	
if ($_GET) {		
	need_login(true);	
	Table::UpdateCache('order', $cod, array(
				'service' => 'credit',
				'money' => 0,
				'state' => 'pay',
				'credit' => $order['origin'],
				));
	$order = Table::FetchForce('order', $cod);
	ZTeam::BuyOne($order);	
	
	$table = new Table('jpayment', $_POST);			///
	
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
		Utility::Redirect( WEB_ROOT. '/order/success.php');
		//die(include template('order_pay_success'));			////
	}
}else{
	Utility::Redirect( WEB_ROOT. '/order/success.php');
	//die(include template('order_pay_success'));
}