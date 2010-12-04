<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

// 機種番号取得サンプル
//$obj = new MobileCheck();
//$env = $obj->CheckUA($_SERVER['HTTP_USER_AGENT']);
//if($env !== 'pc' && $env !== 'other'){
//	$obj->GetZone($env);
//	$result = $obj->CheckIP($obj->zone);
//	if($result === FALSE){
//		// 偽装の時はPCへ振り分け
//		$env = 'pc';
//	}else{
//		list($ser,$icc,$dgd,$srn,$sud,$ezn) = $obj->GetSub($env);
//	}
//}

$page = Table::Fetch('page', 'help_faqs');
include template('help_faqs');
