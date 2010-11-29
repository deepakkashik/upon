<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
	$god = $_GET['id'];
	$cod = $_GET['cod'];
	die(include template('order_pay_success'));

