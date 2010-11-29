<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();
need_auth(abs(intval($INI['system']['forum']))>0);

$condition = array( 
		'city_id' => $city['id'],
		'team_id' => 0,
		'parent_id' => 0,
		);

$count = Table::Count('topic', $condition);
list($pagesize, $offset, $pagestring) = pagestring_m($count, 5);
$topics = DB::LimitQuery('topic', array(
			'condition' => $condition,
			'order' => 'ORDER BY head DESC, last_time DESC',
			'size' => $pagesize,
			'offset' => $offset,
			));
$user_ids = Utility::GetColumn($topics, 'user_id');
$users = Table::Fetch('user', $user_ids);

include template('forum_city');
