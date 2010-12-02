<?php
require_once(dirname(__FILE__) . '/app.php');

$code = strval($_GET['code']);
$subscribe = Table::Fetch('subscribe', $code, 'secret');
if ($subscribe) {
	ZSubscribe::Unsubscribe($subscribe);
	Session::Set('notice', UNSUBSCRIBE_UNSUBSCRIBE_IS_SUCCESSFUL);
}
Utility::Redirect( WEB_ROOT  . '/subscribe.php');
