<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager(true);
$id = abs(intval($_GET['id']));
if (!$id || !$team = Table::Fetch('team', $id)) {
	Utility::Redirect( WEB_ROOT . '/team/create.php');
}

if ($_POST) {
	$insert = array(
		'title', 'market_price', 'team_price', 'end_time', 'begin_time', 'expire_time', 'min_number', 'max_number', 'summary', 'notice', 'per_number',
		'product', 'image',  'detail', 'userreview', 'systemreview', 'image1', 'image2', 'flv', 'card', 'conduser',
		'delivery', 'mobile', 'address', 'fare', 'express', 'credit',
		'user_id', 'city_id', 'group_id', 'partner_id',
		'is_shown_m', 'title_m', 'summary_m', 'notice_m', 'image_m', 'detail_m', 'userreview_m', 'systemreview_m',
		);
	$table = new Table('team', $_POST);
	$table->SetStrip('detail', 'systemreview', 'notice');
	$table->begin_time = strtotime($_POST['begin_time']);
	$table->city_id = abs(intval($table->city_id));
	$table->end_time = strtotime($_POST['end_time']);
	$table->expire_time = strtotime($_POST['expire_time']);
	$table->image = upload_image('upload_image', $team['image'], 'team');
	$table->image1 = upload_image('upload_image1',$team['image1'],'team');
	$table->image2 = upload_image('upload_image2',$team['image2'],'team');
	$table->image_m = upload_image_m('upload_image_m',$team['image_m'],'team');

	$error_tip = array();
	if ( !$error_tip ) {
		if ( $table->update($insert) ) {

			$field = strtoupper($table->conduser)=='Y' ? null : 'quantity';
			$now_number = Table::Count('order', array(
						'team_id' => $table->id,
						'state' => 'pay',
						), $field);
			Table::UpdateCache('team', $table->id, array(
				'now_number' => $now_number,
			));

			Session::Set('notice', MANAGE_TEAM_EDIT_NOTICE);
			Utility::Redirect( WEB_ROOT. "/manage/team/edit.php?id={$team['id']}");
		} else {
			Session::Set('error', MANAGE_TEAM_EDIT_ERROR);
		}
	}
}

$groups = DB::LimitQuery('category', array(
			'condition' => array( 'zone' => 'group', ),
			));
$groups = Utility::OptionArray($groups, 'id', 'name');

$partners = DB::LimitQuery('partner', array(
			'order' => 'ORDER BY id DESC',
			));
$partners = Utility::OptionArray($partners, 'id', 'title');

$taggings = DB::LimitQuery('category', array(
	'condition' => array('zone' => 'tagging'),
));

$taggings = Utility::OptionArray($taggings, 'id', 'name');


include template('manage_team_edit');
