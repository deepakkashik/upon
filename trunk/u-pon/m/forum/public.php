<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();
need_auth(abs(intval($INI['system']['forum']))>0);

$publics = option_category('public');

$show_public = DB::LimitQuery('category', array(
		'condition' => array( 'zone' => 'public', ),
	));

$id = abs(intval($_GET['id']));
$condition = array( 'parent_id' => 0, );

if ( $id && $public = Table::Fetch('category', $id) ){ 
	$condition['public_id'] = $id;
} else if ($id) {
	Utility::Redirect( WEB_ROOT . '/forum/public.php');	
} else {
	$condition[] = 'public_id > 0';
}

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
$public = Table::Fetch('category', $id);

include template('forum_public');
