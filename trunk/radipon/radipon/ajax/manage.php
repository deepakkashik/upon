<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_manager();

$action = strval($_GET['action']);
$id = abs(intval($_GET['id']));

if ( 'orderrefund' == $action) {
	$order = Table::Fetch('order', $id);
	$rid = strtolower(strval($_GET['rid']));
	if ( $rid == 'credit' ) {
		ZFlow::CreateFromRefund($order);
	} else {
		Table::UpdateCache('order', $id, array('state' => 'unpay'));
	}
	/* team -- */
	$team = Table::Fetch('team', $order['team_id']);
	team_state($team);
	if ( $team['state'] != 'failure' ) {
		$minus = $team['conduser'] == 'Y' ? 1 : $order['quantity'];
		Table::UpdateCache('team', $team['id'], array(
					'now_number' => array( "now_number - {$minus}", ),
		));
	}
	/* card refund */
	if ( $order['card_id'] ) {
		Table::UpdateCache('card', $order['card_id'], array(
			'consume' => 'N',
			'team_id' => 0,
			'order_id' => 0,
		));
	}
	/* coupons */
	if ( in_array($team['delivery'], array('coupon', 'pickup') )) {
		$coupons = Table::Fetch('coupon', array($order['id']), 'order_id');
		foreach($coupons AS $one) Table::Delete('coupon', $one['id']);
	}

	/* order update */
	Table::UpdateCache('order', $id, array(
				'card' => 0, 
				'card_id' => '',
				'express_id' => 0,
				'express_no' => '',
				));
	Session::Set('notice', AJAX_MANAGE_MONEY_BACK_SUCCESS);
	json(null, 'refresh');
}
elseif ( 'orderremove' == $action) {
	$order = Table::Fetch('order', $id);
	if ( $order['state'] != 'unpay' ) {
		json(AJAX_MANAGE_PAYMENT_ORDER_CANNOT_DELETED, 'alert');
	}
	/* card refund */
	if ( $order['card_id'] ) {
		Table::UpdateCache('card', $order['card_id'], array(
			'consume' => 'N',
			'team_id' => 0,
			'order_id' => 0,
		));
	}
	Table::Delete('order', $order['id']);
	Session::Set('notice', sprintf(AJAX_MANAGE_DELETED_ORDER_ORDER_ID_SUCCESS,$order['id']));
	json(null, 'refresh');
}
else if ( 'ordercash' == $action ) {
	$order = Table::Fetch('order', $id);
	ZOrder::CashIt($order);
	$user = Table::Fetch('user', $order['user_id']);
	Session::Set('notice', sprintf(AJAX_MANAGE_CASH_PAYMENT_SUCCESS_PURCHASING_CUSTOM_USER_EMAIL,$user['email']));
	json(null, 'refresh');
}
else if ( 'teamdetail' == $action) {
	$team = Table::Fetch('team', $id);
	$partner = Table::Fetch('partner', $team['partner_id']);

	$paycount = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	));
	$buycount = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'quantity');
	$onlinepay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'money');
	$creditpay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'credit');
	$cardpay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'card');
	$couponcount = Table::Count('coupon', array(
		'team_id' => $id,
	));
	$team['state'] = team_state($team);
	$subcount = Table::Count('subscribe', array( 
				'city_id' => $team['city_id'],
				));

	/* send team subscribe mail */	
	$team['noticesubscribe'] = ($team['close_time']==0&&is_manager());
	/* send success coupon */
	$team['noticesms'] = ($team['delivery']!='express')&&(in_array($team['state'], array('success', 'soldout')))&&is_manager();
	/* teamcoupon */
	$team['teamcoupon'] = ($team['noticesms']&&$buycount>$couponcount);
	$team['needline'] = ($team['noticesms']||$team['noticesubscribe']||$team['teamcoupon']);

	$html = render('manage_ajax_dialog_teamdetail');
	json($html, 'dialog');
}
else if ( 'teamremove' == $action) {
	$team = Table::Fetch('team', $id);
	$order_count = Table::Count('order', array(
		'team_id' => $id,
		'state' => 'pay',
	));
	if ( $order_count > 0 ) {
		json(AJAX_MANAGE_GROUP_PURCHASE_PAYMENT_ORDER_CANNOT_DELETED, 'alert');
	}
	ZTeam::DeleteTeam($id);

	/* remove coupon */
	$coupons = Table::Fetch('coupon', array($id), 'team_id');
	foreach($coupons AS $one) Table::Delete('coupon', $one['id']);
	/* remove order */
	$orders = Table::Fetch('order', array($id), 'team_id');
	foreach($orders AS $one) Table::Delete('order', $one['id']);
	/* end */
	Session::Set('notice', sprintf(AJAX_MANAGE_GROUP_PURCHASE_ID_CANNOT_DELETED,$id));
	json(null, 'refresh');
}
else if ( 'cardremove' == $action) {
	$id = strval($_GET['id']);
	$card = Table::Fetch('card', $id);
	if (!$card) json(AJAX_MANAGE_NO_RELATED_CASH_COUPON, 'alert');
	if ($card['consume']=='Y') { json(AJAX_MANAGE_CASH_COUPON_USED_CANNOT_DELETED, 'alert'); }
	Table::Delete('card', $id);
	Session::Set('notice', sprintf(AJAX_MANAGE_CASH_COUPON_ID_DELETED_SUCCESS, $id));
	json(null, 'refresh');
}
else if ( 'userview' == $action) {
	$user = Table::Fetch('user', $id);
	$html = render('manage_ajax_dialog_user');
	json($html, 'dialog');
}
else if ( 'usermoney' == $action) {
	$user = Table::Fetch('user', $id);
	$money = intval($_GET['money']);
	if ( ZFlow::CreateFromStore($id, $money) ) {
		$action = ($money>0) ? AJAX_MANAGE_BELOW_THE_LINE_RECHARGE : AJAX_MANAGE_USER_WITHDRAW_DEPOSIT;
		$money = abs($money);
		json(array(
					array('data' => "{$action}{$money}元成功", 'type'=>'alert'),
					array('data' => null, 'type'=>'refresh'),
				  ), 'mix');
	}
	json(AJAX_MANAGE_RECHARGE_FAILED, 'alert'); 
}
else if ( 'orderexpress' == $action ) {
	$express_id = abs(intval($_GET['eid']));
	$express_no = strval($_GET['nid']);
	if (!$express_id) $express_no = null;
	Table::UpdateCache('order', $id, array(
		'express_id' => $express_id,
		'express_no' => $express_no,
	));
	json(array(
				array('data' => AJAX_MANAGE_ALTER_EXPRESSAGE_MESSAGE_SUCCESS, 'type'=>'alert'),
				array('data' => null, 'type'=>'refresh'),
			  ), 'mix');
}
else if ( 'orderview' == $action) {
	$order = Table::Fetch('order', $id);
	$user = Table::Fetch('user', $order['user_id']);
	$team = Table::Fetch('team', $order['team_id']);
	if ($team['delivery'] == 'express') {
		$option_express = option_category('express');
	}
	$payservice = array(
		'alipay' => AJAX_MANAGE_ALIPAY,
		'tenpay' => AJAX_MANAGE_TENPAY,
		'chinabank' => AJAX_MANAGE_CHINABANK_PAYMENT,
		'credit' => AJAX_MANAGE_BALANCE_PAYMENT,
		'cash' => AJAX_MANAGE_BELOW_THE_LINE_PAY,
	);
	$paystate = array(
		'unpay' => AJAX_MANAGE_GREEN_NON_PAYMENT,
		'pay' => AJAX_MANAGE_RED_PAID,
	);
	$option_refund = array(
		'credit' => AJAX_MANAGE_REFUND_ACCOUNT_BALANCE,
		'online' => AJAX_MANAGE_OTHER_WAYS_REFUNDED,
	);
	$html = render('manage_ajax_dialog_orderview');
	json($html, 'dialog');
}
else if ( 'inviteok' == $action ) {
	need_auth('admin');
	$invite = Table::Fetch('invite', $id);
	if (!$invite || $invite['pay']!='N') {
		json(AJAX_MANAGE_ILLEGAL_OPERATION, 'alert');
	}
	if(!$invite['team_id']) {
		json(AJAX_MANAGE_NOTHING_HAPPENED_PURCHASING_BEHAVIOR_CANNOT_EXECUTE_REBATE, 'alert');
	}
	$team = Table::Fetch('team', $invite['team_id']);
	$team_state = team_state($team);
	if (!in_array($team_state, array('success', 'soldout'))) {
		json(AJAX_MANAGE_SUCCESSFUL_GROUP_PURCHASE_CAN_EXECTUE_INVITE_REBATE, 'alert');
	}
	Table::UpdateCache('invite', $id, array(
				'pay' => 'Y', 
				'admin_id'=>$login_user_id,
				));
	$invite = Table::FetchForce('invite', $id);
	ZFlow::CreateFromInvite($invite);
	Session::Set('notice', AJAX_MANAGE_INVITE_REBATE_SUCCESSFUL_OPERATION);
	json(null, 'refresh');
}
else if ( 'inviteremove' == $action ) {
	need_auth('admin');
	Table::Delete('invite', $id);
	Session::Set('notice', AJAX_MANAGE_WRONFUL_INVITE_RECORD_DELETED_SUCCESS);
	json(null, 'refresh');
}
else if ( 'subscriberemove' == $action ) {
	$subscribe = Table::Fetch('subscribe', $id);
	if ($subscribe) {
		ZSubscribe::Unsubscribe($subscribe);
		Session::Set('notice', sprintf(AJAX_MANAGE_EMAIL_EMAIL_UNSUBSCRIPTION_SUCCESS,$subscribe['email']));
	}
	json(null, 'refresh');
}
else if ( 'partnerremove' == $action ) {
	$partner = Table::Fetch('partner', $id);
	$count = Table::Count('team', array('partner_id' => $id) );
	if ($partner && $count==0) {
		Table::Delete('partner', $id);
		Session::Set('notice', sprintf(AJAX_MANAGE_MERCHANT_ID_DELETE_SUCCEED,$id));
		json(null, 'refresh');
	}
	if ( $count > 0 ) {
		json(AJAX_MANAGE_MERCHANT_HAVE_GROUP_PURCHASE_ITEM_DELETE_FAILED, 'alert'); 
	}
	json(AJAX_MANAGE_DELETE_MERCHANT_FAILED, 'alert'); 
}
else if ( 'noticesms' == $action ) {
	$nid = abs(intval($_GET['nid']));
	$now = time();
	$team = Table::Fetch('team', $id);
	$condition = array( 'team_id' => $id, );
	$coups = DB::LimitQuery('coupon', array(
				'condition' => $condition,
				'order' => 'ORDER BY id ASC',
				'offset' => $nid,
				'size' => 1,
				));
	if ( $coups ) {
		foreach($coups AS $one) {
			$nid++;		
			// 2010/8/10 update start by wang
			try {
				ob_start();
				mail_coupon($one);
				$v = ob_get_clean();
				if ($v) throw new Exception($v);
			}catch(Exception $e) { 
				json(array(
							array('data' => $e->getMessage(), 'type'=>'alert'),
							array('data' => "X.misc.noticesms({$id},{$nid});", 'eval'),
						  ), 'mix');
			}
			$cost = time() - $now;
			if ( $cost >= 20 ) {
				json("X.misc.noticesms({$id},{$nid});", 'eval');
			}
			// 2010/8/10 update end by wang
		}
		json("X.misc.noticesms({$id},{$nid});", 'eval');
	} else {
		json($INI['system']['couponname'].AJAX_MANAGE_SENT_SUCCEED, 'alert');
	}
}
else if ( 'noticesubscribe' == $action ) {
	$nid = abs(intval($_GET['nid']));
	$now = time();
	$team = Table::Fetch('team', $id);
	$partner = Table::Fetch('partner', $team['partner_id']);
	$city = Table::Fetch('category', $team['city_id']);
	$condition = array( 'city_id' => $team['city_id'], );
	$subs = DB::LimitQuery('subscribe', array(
				'condition' => $condition,
				'order' => 'ORDER BY id ASC',
				'offset' => $nid,
				'size' => 1,
				));
	if ( $subs ) {
		foreach($subs AS $one) {
			$nid++;
			try {
				ob_start();
				mail_subscribe($city, $team, $partner, $one);
				$v = ob_get_clean();
				if ($v) throw new Exception($v);
			}catch(Exception $e) { 
				json(array(
							array('data' => $e->getMessage(), 'type'=>'alert'),
							array('data' => "X.misc.noticenext({$id},{$nid});", 'eval'),
						  ), 'mix');
			}
			$cost = time() - $now;
			if ( $cost >= 20 ) {
				json("X.misc.noticenext({$id},{$nid});", 'eval');
			}
		}
		json("X.misc.noticenext({$id},{$nid});", 'eval');
	} else {
		json(AJAX_MANAGE_SUBSCRIBE_MAIL_SENT_SUCCEED, 'alert');
	}
}
elseif ( 'categoryedit' == $action ) {
	if ($id) {
		$category = Table::Fetch('category', $id);
		if (!$category) json(AJAX_MANAGE_NO_DATA, 'alert');
		$zone = $category['zone'];
	} else {
		$zone = strval($_GET['zone']);
	}
	if ( !$zone ) json(AJAX_MANAGE_PLEASE_MAKE_SURE_CATEGORY, 'alert');
	$zone = get_zones($zone);

	$html = render('manage_ajax_dialog_categoryedit');
	json($html, 'dialog');
}
elseif ( 'categoryremove' == $action ) {
	$category = Table::Fetch('category', $id);
	if (!$category) json(AJAX_MANAGE_NO_SUCH_CATEGORY, 'alert');
	if ($category['zone'] == 'city') {
		$tcount = Table::Count('team', array('city_id' => $id));
		if ($tcount ) json(AJAX_MANAGE_GROUP_PURCHASE_ITEM_EXISTS_UNDER_THIS_CATEGORY, 'alert');
	}
	elseif ($category['zone'] == 'group') {
		$tcount = Table::Count('team', array('group_id' => $id));
		if ($tcount ) json(AJAX_MANAGE_GROUP_PURCHASE_ITEM_EXISTS_UNDER_THIS_CATEGORY, 'alert');
	}
	elseif ($category['zone'] == 'express') {
		$tcount = Table::Count('order', array('express_id' => $id));
		if ($tcount ) json(AJAX_MANAGE_ORDER_ITEM_EXISTS_UNDER_THIS_CATEGORY, 'alert');
	}
	elseif ($category['zone'] == 'public') {
		$tcount = Table::Count('topic', array('public_id' => $id));
		if ($tcount ) json(AJAX_MANAGE_DISCUSSION_TOPIC_EXISTS_UNDER_THIS_CATEGORY, 'alert');
	}
	Table::Delete('category', $id);
	option_category($category['zone']);
	Session::Set('notice', AJAX_MANAGE_DELETE_CATEGORY_SUCCEED);
	json(null, 'refresh');
}
else if ( 'teamcoupon' == $action ) {
	$team = Table::Fetch('team', $id);
	team_state($team);
	if (!$team['close_time'] || $team['now_number']<$team['min_number'])
		json(AJAX_MANAGE_GROUP_PURCHASE_NOT_CLOSED_OR_NOT_MEET_MINIMUM_NUMBER_PEOPLE_INTO_GROUP, 'alert');
	$orders = DB::LimitQuery('order', array(
				'condition' => array(
					'team_id' => $id,
					'state' => 'pay',
					),
				));
	foreach($orders AS $order) {
		ZCoupon::Create($order);
	}
	json(AJAX_MANAGE_DELIVER_COUPON_SUCCEED,  'alert');
}
