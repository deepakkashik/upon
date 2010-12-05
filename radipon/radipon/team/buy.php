<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

//前画面からクーポンIDより、クーポン情報を取得する
$id = abs(intval($_GET['id']));
$team = Table::Fetch('team', $id);

//クーポンありません　また　クーポン未開始
if ( !$team || $team['begin_time'] > time() ) {
	Session::Set('error', TEAM_BUY_ERRNOTEXIST);
	Utility::Redirect( WEB_ROOT . '/index.php' );
}

//オーダー情報を取得する
//	*検索条件：ユーザID　及び　クーポンID　
$ex_con = array(
	'user_id' => $login_user_id,
	'team_id' => $team['id'],
);
$order = DB::LimitQuery('order', array(
	'condition' => $ex_con,
	'one' => true,
));

//既にこのクーポンを購入される数量
$order_quantity = 0;
//既にこのクーポンを購入されている場合：
if ( $order )
{
	//購買数取得
	$order_quantity = $order['quantity'];
	if ( $order['state'] != 'unpay' && $order_quantity >= $team['per_number'] ) 
	{
		Session::Set('error', TEAM_BUY_ERRBUYONE);
		Utility::Redirect( WEB_ROOT . "/team.php?id={$id}");
	}
}

if ( $_POST ) {
	need_login(true);
	$table = new Table('order', $_POST);
	if ( $table->quantity == 0 ) {
		Session::Set('error', TEAM_BUY_ERRGT);
		Utility::Redirect( WEB_ROOT . "/team/buy.php?id={$team['id']}");
	}
	elseif ( $team['per_number'] > 0 && $table->quantity > ($team['per_number'] + $order_quantity) ) {
		Session::Set('error', TEAM_BUY_ERRRANGE);
		Utility::Redirect( WEB_ROOT . "/team/buy.php?id={$team['id']}");
	}

	if ($order && $order['state'] == 'unpay') {
		$table->id = $order['id'];
	}

	$table->user_id = $login_user_id;
	$table->team_id = $team['id'];
	$table->city_id = $team['city_id'];
	$table->express = ($team['delivery']=='express') ? 'Y' : 'N';
	$table->fare = $table->express=='Y' ? $team['fare'] : 0;
	$table->price = $team['team_price'];
	$table->service = 'gmo';
	$table->credit = 0;

	if ( $table->id ) {
		$eorder = Table::Fetch('order', $table->id);
		$table->origin = ($table->quantity * $team['team_price']) + ($team['delivery'] == 'express' ? $team['fare'] : 0) - $eorder['card'];
	} else {
		$table->create_time = time();
		$table->origin = ($table->quantity * $team['team_price']) + ($team['delivery'] == 'express' ? $team['fare'] : 0);
	}

	$insert = array(
			'user_id', 'team_id', 'city_id', 'state',
			'fare', 'express', 'origin', 'price',
			'address', 'zipcode', 'realname', 'mobile', 'quantity',
			'create_time', 'remark',
		);

	if ($flag = $table->update($insert)) {
		$order_id = abs(intval($table->id));
		Utility::Redirect(WEB_ROOT."/order/check.php?id={$order_id}");			
	}
}

//each user per day per buy
if (!$order) {
	$order = json_decode(Session::Get('loginpagepost'),true);
	settype($order, 'array');
	if ($order['mobile']) $login_user['mobile'] = $order['mobile'];
	if ($order['zipcode']) $login_user['zipcode'] = $order['zipcode'];
	if ($order['address']) $login_user['address'] = $order['address'];
	if ($order['realname']) $login_user['realname'] = $order['realname'];
	$order['quantity'] = 1;
}
//end;

$order['origin'] = ($order['quantity'] * $team['team_price']) + ($team['delivery']=='express' ? $team['fare'] : 0);

include template('team_buy');
