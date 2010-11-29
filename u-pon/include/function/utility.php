<?php
/**
 * @name: utility.php
 * @desc: 此文件定义应用函数及@opton_xxxx公共变量。
 */

/**
 * @desc: 根据ip取得所在的城市。
 * @param $ip
 */
function get_city($ip=null) {
	global $INI;
	$cities = option_category('city');
	$ip = ($ip) ? $ip : Utility::GetRemoteIP();
	$ip = "58.5.235.98";
	$url = "http://ip.uic.jp/{$ip}";
	//$url = "http://open.baidu.com/ipsearch/s?wd={$ip}&tn=baiduip";
	$res = mb_convert_encoding(Utility::HttpRequest($url), 'UTF-8', 'GBK');
	if ( preg_match(INCLUDE_FUNCTION_UTILITY_FROM, $res, $m) ) {
		foreach( $cities AS $cid=>$cname) {
			if ( FALSE !== strpos($m[1], $cname) ) {
				return Table::Fetch('category', $cid);
			}
		}
	}
	return array();
}

/**
 * @desc: 格式化邮件地址
 * @param $email
 */
function mail_zd($email) {
	global $option_mail;
	if ( ! Utility::ValidEmail($email) ) return false;
	preg_match('#@(.+)$#', $email, $m);
	$suffix = strtolower($m[1]);
	return $option_mail[$suffix];
}

function option_card_year($expire_date)
{
	$year = '20' . substr($expire_date,0,2);
	$option_years = array (
			'2010','2011','2012','2013','2014','2015','2016','2017','2018','2019','2020',
		);
	$option = '<option value="">年を選択して下さい</option>';
	
	foreach( $option_years as $option_year)
	{
		if( $option_year == $year)
		{
			$option .= "<option value=\"${option_year}\" selected>${option_year}年</option>";			
		}else
		{
			$option .= "<option value=\"${option_year}\">${option_year}年</option>";			
		}
	}
	return $option;
}

function option_card_month($expire_date)
{
	$month = substr($expire_date,2,2);
	$option_months = array (
		'01','02','03','04','05','06','07','08','09','10','11','12',
	);
	
	$option = '<option value="">月を選択して下さい</option>';
	
	foreach( $option_months as $option_month)
	{
		if( (int)$option_month == (int)$month)
		{
			$option .= "<option value=\"${option_month}\" selected>${option_month}月</option>";			
		}else
		{
			$option .= "<option value=\"${option_month}\">${option_month}月</option>";			
		}
	}
	return $option;	
}

global $option_gender;
$option_gender = array(
		'M' => INCLUDE_FUNCTION_UTILITY_MALE,
		'F' => INCLUDE_FUNCTION_UTILITY_FEMALE,
		);
global $option_pay;
$option_pay = array(
		'pay' => INCLUDE_FUNCTION_UTILITY_PAID,
		'unpay' => INCLUDE_FUNCTION_UTILITY_UNPAID,
		);
global $option_service;
$option_service = array(
		'alipay' => INCLUDE_FUNCTION_UTILITY_ALIPAY,
		'tenpay' => INCLUDE_FUNCTION_UTILITY_TENPAY,
		'chinabank' => INCLUDE_FUNCTION_UTILITY_CHINABANK,
		'cash' => INCLUDE_FUNCTION_UTILITY_CASH,
		'credit' => INCLUDE_FUNCTION_UTILITY_CREDIT_CARD,
		'other' => INCLUDE_FUNCTION_UTILITY_OTHER,
		);
global $option_delivery;
$option_delivery = array(
		'express' => INCLUDE_FUNCTION_UTILITY_EXPRESS_DELIVERY,
		'coupon' => INCLUDE_FUNCTION_UTILITY_COUPON,
		'pickup' => INCLUDE_FUNCTION_UTILITY_SELF_PICK,
		);
global $option_flow;
$option_flow = array(
		'buy' => INCLUDE_FUNCTION_UTILITY_BUY,
		'invite' => INCLUDE_FUNCTION_UTILITY_INVITE,
		'store' => INCLUDE_FUNCTION_UTILITY_RECHARGE,
		'withdraw' => INCLUDE_FUNCTION_UTILITY_WITHDRAW,
		'coupon' => INCLUDE_FUNCTION_UTILITY_REBATE,
		'refund' => INCLUDE_FUNCTION_UTILITY_REFUND,
		'register' => INCLUDE_FUNCTION_UTILITY_REGISTER,
		'charge' => INCLUDE_FUNCTION_UTILITY_RECHARGE,
		);
global $option_mail;
$option_mail = array(
		'gmail.com' => 'https://mail.google.com/',
		'163.com' => 'http://mail.163.com/',
		'126.com' => 'http://mail.126.com/',
		'qq.com' => 'http://mail.qq.com/',
		'sina.com' => 'http://mail.sina.com/',
		'sohu.com' => 'http://mail.sohu.com/',
		'yahoo.com.cn' => 'http://mail.yahoo.com.cn/',
		'yahoo.com' => 'http://mail.yahoo.com/',
		);
global $option_cond;
$option_cond= array(
		'Y' => INCLUDE_FUNCTION_UTILITY_NUMBER_OF_PEOPLE,
		'N' => INCLUDE_FUNCTION_UTILITY_QUANTITY,
		);
