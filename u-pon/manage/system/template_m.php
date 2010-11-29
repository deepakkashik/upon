<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager(true);
$template_id = trim(strval($_GET['id']));
$template_id = str_replace('\\', '_', $template_id);
$template_id = str_replace('/', '_', $template_id);

$dir_template = WWW_ROOT . '/m/include/template';

if ('default' != $INI['skin']['template_m']) {
	$dir_template = $dir_template . '/' . $INI['skin']['template_m'];
}

if ( $_POST ) {
	//$path = DIR_TEMPLATE .'/' . $template_id;
	$path = $dir_template .'/' . $template_id;
	
	if(is_writable($path) && !is_dir($path) && is_file($path)) {
		$flag = file_put_contents($path, stripslashes(trim($_POST['content'])));
	}
	if ( $flag ) {
		Session::Set('notice', sprintf(MANAGE_SYSTEM_TEMPLATE_EDITSUC_TEMPLATE_ID,$template_id));
	} else {
		Session::Set('error', sprintf(MANAGE_SYSTEM_TEMPLATE_EDITFAI_TEMPLATE_ID,$template_id));
	}
	Utility::Redirect(WEB_ROOT . "/manage/system/template_m.php?id={$template_id}");
}

$temps = scandir($dir_template);
$may = array();
foreach($temps AS $one) {
	if(is_dir($dir_template . '/' .$one)) continue;
	if(!is_writable($dir_template . '/' .$one)) continue;
	$may[] = $one;
}
$may = array_combine($may, $may);

if (file_exists($dir_template .'/' . $template_id)) {
	$content = trim(file_get_contents( $dir_template .'/'.$template_id ));
} else {
	$template_id = null;
}

include template('manage_system_template_m');
