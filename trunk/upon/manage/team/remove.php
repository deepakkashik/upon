<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
$id = abs(intval($_GET['id']));
$team = Table::Fetch('team', $id);
$order = Table::Fetch('order', $id, 'team_id');
if ( $order ) {
	Session::Set('notice', MANAGE_TEAM_REMOVE_DETFAIL_ID);
} else {
	Table::Delete('team', $id);
	Session::Set('notice', MANAGE_TEAM_REMOVE_DETSUCCESS_ID);
}
Utility::Redirect(udecode($_GET['r']));
