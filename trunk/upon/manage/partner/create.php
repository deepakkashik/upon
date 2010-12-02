<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
if(Session::Get('partner')){
	$partner = Session::Get('partner');
}

if ( $_POST ) {
	$table = new Table('partner', $_POST);
	$table->SetStrip('location', 'other');
	$table->create_time = time();
	$table->user_id = $login_user_id;
	$table->password = ZPartner::GenPassword($table->password);
	//バグ対応 insertflg追加する
	$insertflg = $table->insert(array(
		'username', 'user_id', 'city_id', 'title',
		'bank_name', 'bank_user', 'bank_no', 'create_time',
		'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
		'password', 'address',
	));
	if($insertflg == FALSE){
		Session::Set('error', MANAGE_PARTNER_CREATE_ERROR);
		Session::Set('partner', $_POST);
		Utility::Redirect(WEB_ROOT . '/manage/partner/create.php');
	}
	Session::Set('partner', '');
	Utility::Redirect( WEB_ROOT . '/manage/partner/index.php');
}

include template('manage_partner_create');

if(Session::Get('partner')){
	Session::Set('partner', '');
}
