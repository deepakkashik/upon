<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
$id = abs(intval($_GET['id']));

$partner = Table::Fetch('partner', $id);

if ( $_POST && $id==$_POST['id'] ) {
	$table = new Table('partner', $_POST);
	$table->SetStrip('location', 'other');
	$up_array = array(
			'username', 'title', 'bank_name', 'bank_user', 'bank_no',
			'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
			'address',
			);

	if ($table->password ) {
		$table->password = ZPartner::GenPassword($table->password);
		$up_array[] = 'password';
	}
	$flag = $table->update( $up_array );
	if ( $flag ) {
		Session::Set('notice', MANAGE_PARTNER_EDIT_NOTICESUCCESS);
		Utility::Redirect( WEB_ROOT . "/manage/partner/edit.php?id={$id}");
	}
	Session::Set('error', MANAGE_PARTNER_EDIT_ERROR);
	$partner = $_POST;
}

include template('manage_partner_edit');
