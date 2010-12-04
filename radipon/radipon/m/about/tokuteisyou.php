<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$page = Table::Fetch('page', 'about_tokuteisyou');
include template('about_tokuteisyou');
