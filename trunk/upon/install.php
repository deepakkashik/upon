<?php
require_once( dirname(__FILE__) . '/include/application.php');
header('Content-Type: text/html; charset=UTF-8;'); 
Session::Init();

if (is_get() ) {
	$db = array(
		'host' => 'localhost',
		'user' => 'root',
		'pass' => '',
		'name' => 'upon_db',
		'email' => '',
		'password' => '',
	);
	if (!is_writable(DIR_COMPILED)) {
		die( INSTALL_DIRECTORY_WRITABLE);
	}
	die(include template('install_step'));
}
$db = $_POST['db'];
$m = mysql_connect($db['host'], $db['user'], $db['pass']);

if (!is_writable(dirname(__FILE__) . '/include/configure/') ) {
	Session::Set('error', INSTALL_CONFIGURE_NOT_WRITE);
	Utility::Redirect('install.php');
}

if (!is_writable(dirname(__FILE__) . '/include/data/') ) {
	Session::Set('error', INSTALL_DATA_NOT_WRITE);
	Utility::Redirect('install.php');
}

if (!is_writable(dirname(__FILE__) . '/static/team/') ) {
	Session::Set('error', INSTALL_TEAM_NOT_WRITE);
	Utility::Redirect('install.php');
}

if (!is_writable(dirname(__FILE__) . '/static/user/') ) {
	Session::Set('error', INSTALL_USER_NOT_WRITE);
	Utility::Redirect('install.php');
}

if ( !$m ) {
	Session::Set('error', INSTALL_DATABASE_NOT);
	Utility::Redirect('install.php');
}

if ( !mysql_select_db($db['name'], $m) 
		&& !mysql_query("CREATE database `{$db['name']}`;", $m) ) {
	Session::Set('error', sprintf(INSTALL_DATABASE_NOT_EXISTS,$db['name']));
	Utility::Redirect('install.php');
}
mysql_select_db($db['name'], $m);

$dir = dirname(__FILE__);
$sql = '';
$f = file('./include/configure/db.sql');
foreach($f AS $l) {
	if ( strpos(trim($l), '--')===0 || strpos(trim($l), '/*') === 0 || !trim($l)) {
		continue;
	}
	$sql .= $l;
}

mysql_query("SET names UTF8;");
$sqls = explode(';', $sql);

foreach($sqls AS $sql) {
	mysql_query($sql, $m);
}

$db['password'] = ZPartner::GenPassword($db['password']);

mysql_query("INSERT INTO user(id,email,password,manager,login_from ) VALUES('1','{$db['email']}','{$db['password']}','Y','SELF')");

$PHP = array(
	'db' => $db,
);

if ( write_php_file($PHP, SYS_PHPFILE) ) {
	Session::Set('notice', INSTALL_SUCCESSFUL_INSTALLATION);
}

Utility::Redirect('index.php');
