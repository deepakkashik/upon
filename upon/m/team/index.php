<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$daytime = time();
$condition = array(
		'city_id' => array(0, abs(intval($city['id']))),
		"begin_time < {$daytime}",
		'OR' => array(
			"now_number >= min_number",
			"end_time > {$daytime}",
			),
		);

		
$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring_m($count, 5);
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
foreach($teams AS $id=>$one){
	team_state($one);
	if ($one['state']=='none') $one['picclass'] = '/static/css/i/bg-special-price.png';
	else if ($one['state']=='soldout') $one['picclass'] = '/static/css/i/bg-discontinued.png';
	else $one['picclass'] = '/static/css/i/bg-upon-discontinued.png';
	$teams[$id] = $one;
}

$discount_price = $one['market_price'] - $one['team_price'];
$discount_rate = 1 - $one['team_price']/$one['market_price'];

$pagetitle = TEAM_INDEX_UPON;
include template('team_index');
