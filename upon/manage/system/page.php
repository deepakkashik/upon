<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager(true);
$pages = array(
	'help_tour' => $INI['system']['abbreviation'] . MANAGE_SYSTEM_PAGE_PLAY,
	'help_faqs' => MANAGE_SYSTEM_PAGE_FAQ,
//	'help_zuitu' => $INI['system']['abbreviation'] . MANAGE_SYSTEM_PAGE_WHAT,
//	'help_api' => MANAGE_SYSTEM_PAGE_API,
	'about_contact' => MANAGE_SYSTEM_PAGE_CONTACT,
	'about_us' => $INI['system']['abbreviation'] . MANAGE_SYSTEM_PAGE_ABOUT,
	'about_job' => MANAGE_SYSTEM_PAGE_JOB,
	'about_terms' => MANAGE_SYSTEM_PAGE_TERMS,
	'about_member' => MANAGE_SYSTEM_PAGE_MEMBER,
	'about_privacy' => MANAGE_SYSTEM_PAGE_PRIVACY,

);

$id = strval($_GET['id']);
if ( $id && !in_array($id, array_keys($pages))) { 
	Utility::Redirect( WEB_ROOT . "/manage/system/page.php");
}
$n = Table::Fetch('page', $id);

if ( $_POST ) {
	$table = new Table('page', $_POST);
	$table->SetStrip('value');
	if ( $n ) {
		$table->SetPk('id', $id);
		$table->update( array('id', 'value') );
	} else {
		$table->insert( array('id', 'value') );
	}
	Session::Set('notice', sprintf(MANAGE_SYSTEM_PAGE_EDITSUCCESS_PAGESID,$pages[$id]));
	Utility::Redirect( WEB_ROOT . "/manage/system/page.php?id={$id}");
}

$value = $n['value'];
include template('manage_system_page');
