<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_manager();

$action = strval($_GET['action']);
$id = $topic_id = abs(intval($_GET['id']));
$topic = Table::Fetch('topic', $id);
$pid = abs(intval($topic['parent_id']));

if (!$topic || !$id) {
	json(AJAX_TOPIC_TOPIC_NOT_EXIST, 'alert');
}
elseif ( $action == 'topicremove') {
	if ( $pid==0 ) {
		Table::Delete('topic', $id);
		Table::Delete('topic', $id, 'parent_id');
	} else {
		Table::Delete('topic', $id);
		Table::UpdateCache('topic', $pid, array(
			'reply_number' => Table::Count('topic', array('parent_id' => $pid) ),
		));
	}
	Session::Set('notice', AJAX_TOPIC_DELETE_TOPIC_SUCCEED);
	json(null, 'refresh');
}
elseif ( $action == 'topichead' ) {
	if ( $topic['parent_id']>0 ) {
		json(AJAX_TOPIC_ONLY_PRIMARY_TOPIC_CAN_TOP, 'alert');
	}
	$head = ($topic['head']==0) ? time() : 0;
	Table::UpdateCache('topic', $id, array( 'head' => $head,));
	$tip = $head ? AJAX_TOPIC_SET_TOPIC_ISTOP_SUCCEED : AJAX_TOPIC_CANCLE_TOPIC_ISTOP_SUCCEED;
	Session::Set('notice', $tip);
	json(null, 'refresh');
}
