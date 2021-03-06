<?php
require_once(dirname(__FILE__) . '/app.php');

$id = abs(intval($_GET['id']));
if (!$id || !$team = Table::FetchForce('team', $id) ) {
	Utility::Redirect( WEB_ROOT . '/team/index.php');
}

/* refer */
if (abs(intval($_GET['r']))) { 
	if($_rid) cookieset('_rid', abs(intval($_GET['r'])));
	Utility::Redirect( WEB_ROOT . "/team.php?id={$id}");
}
$city = Table::Fetch('category', $team['city_id']);
if(!$city) { $city = array('id' => 0, 'name' => TEAM_WHOLE, ); }

$pagetitle = $team['title'];

$discount_price = $team['market_price'] - $team['team_price'];
$discount_rate = 1 - $team['team_price']/$team['market_price'];

$left = array();
$now = time();
$diff_time = $left_time = $team['end_time']-$now;

$left_day = floor($diff_time/86400);
$left_time = $left_time % 86400;
$left_hour = floor($left_time/3600);
$left_time = $left_time % 3600;
$left_minute = floor($left_time/60);
$left_time = $left_time % 60;

/* progress bar size */
$bar_size = ceil(190*($team['now_number']/$team['min_number']));
$bar_offset = ceil(5*($team['now_number']/$team['min_number']));

$partner = Table::Fetch('partner', $team['partner_id']);

/* other teams */
if ( abs(intval($INI['system']['sideteam'])) ) {
	$oc = array( 
			'city_id' => $city['id'], 
			"id <> {$id}",
			"begin_time < {$now}",
			"end_time > {$now}",
			);
	$others = DB::LimitQuery('team', array(
				'condition' => $oc,
				'order' => 'ORDER BY id DESC',
				'size' => abs(intval($INI['system']['sideteam'])),
				));
}

$team['state'] = team_state($team);

/* your order */
if ($login_user_id && 0==$team['close_time']) {
	$order = DB::LimitQuery('order', array(
		'condition' => array(
			'team_id' => $id,
			'user_id' => $login_user_id,
			'state' => 'unpay',
		),
		'one' => true,
	));
}
/* end order */

include template('team_view');
