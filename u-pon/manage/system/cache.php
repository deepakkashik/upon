<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager(true);

$system = Table::Fetch('system', 1);

if ($_POST) {
	unset($_POST['commit']);
	$INI = Config::MergeINI($INI, $_POST);
	if ( !save_config('php') ) {
		Session::Set('notice', MANAGE_SYSTEM_CACHE_SAVEFAIL.SYS_PHPFILE.MANAGE_SYSTEM_CACHE_NOWTITE);
	} else {
		$INI = ZSystem::GetUnsetINI($INI);
		$value = Utility::ExtraEncode($INI);
		$table = new Table('system', array('value'=>$value));
		if ( $system ) $table->SetPK('id', 1);
		$flag = $table->update(array( 'value'));
		Session::Set('notice', MANAGE_SYSTEM_CACHE_NOTICESUCCESS);
	}
	Utility::Redirect( WEB_ROOT . '/manage/system/cache.php');	
}

include template('manage_system_cache');
