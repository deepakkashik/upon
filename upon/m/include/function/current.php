<?php
/**
 * @name: current.php
 * @desc: 此文件定义菜单项目。
 */

/**
 * @desc: 前台菜单 
 */
function current_frontend() {
	global $INI;
	$a = array(
			'/team/index.php' => INCLUDE_FUNCTION_CURRENT_REVIEW_TUANGOU,
			'/subscribe.php' => INCLUDE_FUNCTION_CURRENT_EMAIL_SUBSCRIBE,
			);
	if (abs(intval($INI['system']['forum']))) {
		unset($a['/subscribe.php']);
		$a['/forum/index.php'] = INCLUDE_FUNCTION_CURRENT_BBS;
	}
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#/team#',$r)) $l = '/team/index.php';
	elseif (preg_match('#/subscribe#',$r)) $l = '/subscribe.php';
	else $l = '/index.php';
	return current_mobile_link_nolist(null, $a);
}

/**
 * @desc: 管理页面菜单
 */
function current_backend() {
	global $INI;
	$a = array(
			'/manage/misc/index.php' => INCLUDE_FUNCTION_CURRENT_INDEX,
			'/manage/team/index.php' => INCLUDE_FUNCTION_CURRENT_TUANGOU,
			'/manage/order/index.php' => INCLUDE_FUNCTION_CURRENT_ORDER,
			'/manage/coupon/index.php' => $INI['system']['couponname'],
			'/manage/user/index.php' => INCLUDE_FUNCTION_CURRENT_USER,
			'/manage/partner/index.php' => INCLUDE_FUNCTION_CURRENT_SELLER,
			// '/manage/market/index.php' => INCLUDE_FUNCTION_CURRENT_MARKETING,
			'/manage/category/index.php' => INCLUDE_FUNCTION_CURRENT_CATEGORY,
			'/manage/system/index.php' => INCLUDE_FUNCTION_CURRENT_INSTALL,
			);
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#/manage/(\w+)/#',$r, $m)) {
		$l = "/manage/{$m[1]}/index.php";
	} else $l = '/manage/misc/index.php';
	return current_link($l, $a);
}

/**
 * @desc: 商家页面菜单
 */
function current_biz() {
	global $INI;
	$a = array(
			'/biz/index.php' => INCLUDE_FUNCTION_CURRENT_INDEX,
			'/biz/settings.php' => INCLUDE_FUNCTION_CURRENT_SELLER_DATA,
			'/biz/coupon.php' => $INI['system']['couponname'] . INCLUDE_FUNCTION_CURRENT_LIST,
			);
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#/biz/coupon#',$r)) $l = '/biz/coupon.php';
	elseif (preg_match('#/biz/settings#',$r)) $l = '/biz/settings.php';
	else $l = '/biz/index.php';
	return current_link($l, $a);
}

/**
 * @desc: 论坛菜单
 * @param $selector
 */
function current_forum($selector='index') {
	global $city;
	$a = array(
			'/forum/index.php' => INCLUDE_FUNCTION_CURRENT_ALL,
			'/forum/city.php' => sprintf(INCLUDE_FUNCTION_CURRENT_BBS_NAME,$city['name']),
			'/forum/public.php' => INCLUDE_FUNCTION_CURRENT_PUBLIC_BBS,
			);
	if (!$city) unset($a['/forum/city.php']);
	$l = "/forum/{$selector}.php";
	return current_m_link($l, $a, true);
}

function current_loginin($selector='index') {
	$a = array(
		'/account/signup.php' => INCLUDE_FUNCTION_ACCOUNT_SIGNUP,
		'/account/repass.php' => INCLUDE_FUNCTION_ACCOUNT_REPASS,
	);
	$l = "/forum/{$selector}.php";
	return current_m_link($l, $a, true);
}

/**
 * @desc: 城市菜单
 * @param $cename
 * @param $citys
 */
function current_city($cename, $citys) {
	$link = "/city.php?ename={$cename}";
	$links = array();
	foreach($citys AS $city) {
		$links["/city.php?ename={$city['ename']}"] = $city['name'];
	}
	return current_link($link, $links);
}
/**
 * @desc: 城市菜单
 * @param $cename
 * @param $citys
 */
function current_city_select_list($cename, $citys) {
	$html = '';

	foreach($citys AS $city) {
		if ($city['ename']==$cename) {
			$html .= "<option selected='true' value=\"{$city['ename']}\">{$city['name']}</option>";
		}
		else $html .= "<option value=\"{$city['ename']}\">{$city['name']}</option>";
	}
	return $html;
}
function current_quantity_select_list($max) {
	$html = '';
	if($max == 0)
	{
		$max = 10;
	}
	for ($i = 1; $i <= $max; $i++) {
		if($i == 1)
		{
			$html .= "<option selected='true' value=\"{$i}\">{$i}</option>";	
		}
		else
		{
			$html .= "<option value=\"{$i}\">{$i}</option>";
		}
	}
	return $html;
}
function current_coupon_sub($selector='index') {
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/coupon/index.php' => INCLUDE_FUNCTION_CURRENT_NOT_USE,
		'/coupon/consume.php' => INCLUDE_FUNCTION_CURRENT_ALREAD_USE,
		'/coupon/expire.php' => INCLUDE_FUNCTION_CURRENT_EXPIRE,
	);
	$l = "/coupon/{$selector}.php";
	return current_link($l, $a);
}

function current_account($selector='/account/settings.php') {
	global $INI;
	$a = array(
		'/order/index.php' => INCLUDE_FUNCTION_CURRENT_MY_ORDER,
		'/coupon/index.php' => INCLUDE_FUNCTION_CURRENT_MY . $INI['system']['couponname'],
		//'/credit/index.php' => INCLUDE_FUNCTION_CURRENT_ACCOUNT_BALANCE,
		'/account/settings.php' => INCLUDE_FUNCTION_CURRENT_ACCOUNT_SET,
	);
	return current_mobile_link($selector, $a, true);
}

function current_setting($selector='index') {
	global $INI;
	$a = array(
		'/order/index.php' => INCLUDE_FUNCTION_CURRENT_MY_ORDER,
		'/coupon/index.php' => INCLUDE_FUNCTION_CURRENT_MY . $INI['system']['couponname'],
		//'/credit/index.php' => INCLUDE_FUNCTION_CURRENT_ACCOUNT_BALANCE,
	);
	$l = "/forum/{$selector}.php";
	return current_m_link($l, $a, true);
}

function current_credit($selector='index') {
	global $INI;
	$a = array(
		'/order/index.php' => INCLUDE_FUNCTION_CURRENT_MY_ORDER,
		'/coupon/index.php' => INCLUDE_FUNCTION_CURRENT_MY . $INI['system']['couponname'],
		'/account/settings.php' => INCLUDE_FUNCTION_CURRENT_ACCOUNT_SET,
	);
	$l = "/forum/{$selector}.php";
	return current_m_link($l, $a, true);
}

function current_order($selector='index') {
	global $INI;
	$a = array(
		'/coupon/index.php' => INCLUDE_FUNCTION_CURRENT_MY . $INI['system']['couponname'],
		//'/credit/index.php' => INCLUDE_FUNCTION_CURRENT_ACCOUNT_BALANCE,
		'/account/settings.php' => INCLUDE_FUNCTION_CURRENT_ACCOUNT_SET,
	);
	$l = "/forum/{$selector}.php";
	return current_m_link($l, $a, true);
}

function current_MyPage1($selector='index') {
	global $INI;
	$a = array(
		'/order/index.php' => INCLUDE_FUNCTION_CURRENT_MY_ORDER,
		'/coupon/index.php' => INCLUDE_FUNCTION_CURRENT_MY . $INI['system']['couponname'],	
	);
	$l = "/forum/{$selector}.php";
	return current_m_link($l, $a, true);
}

function current_MyPage2($selector='index') {
	global $INI;
	$a = array(
		//'/credit/index.php' => INCLUDE_FUNCTION_CURRENT_ACCOUNT_BALANCE,
		'/account/settings.php' => INCLUDE_FUNCTION_CURRENT_ACCOUNT_SET,
	);
	$l = "/forum/{$selector}.php";
	return current_m_link($l, $a, true);
}

function current_about($selector='us') {
	global $INI;
	$a = array(
		'/about/us.php' => $INI['system']['abbreviation'],
		'/about/contact.php' => INCLUDE_FUNCTION_CURRENT_CONTACT_CONTACT,
		'/about/job.php' => INCLUDE_FUNCTION_CURRENT_WORK_CHANCE,
		'/about/tokuteisyou.php' => INCLUDE_FUNCTION_CURRENT_TOKUTEISYOU,
		'/about/privacy.php' => INCLUDE_FUNCTION_CURRENT_PRIVACY_POLICY,
		'/about/terms.php' => INCLUDE_FUNCTION_CURRENT_SERVICE_CLAUSE,
		'/about/member.php' => INCLUDE_FUNCTION_CURRENT_MEMBER_RULE,
	);
	$l = "/about/{$selector}.php";
	return current_link($l, $a, true);
}

function current_help($selector='faqs') {
	global $INI;
	$a = array(
		'/help/tour.php' =>  $INI['system']['abbreviation'] . INCLUDE_FUNCTION_CURRENT_PLAY,
		'/help/faqs.php' => INCLUDE_FUNCTION_CURRENT_common_question,
		//'/help/zuitu.php' => $INI['system']['abbreviation'] . INCLUDE_FUNCTION_CURRENT_WHAT_IS,
	);
	$l = "/help/{$selector}.php";
	return current_link($l, $a, true);
}

function current_order_index($selector='index') {
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/order/index.php?s=index' => INCLUDE_FUNCTION_CURRENT_ALL2,
		'/order/index.php?s=unpay' => INCLUDE_FUNCTION_CURRENT_NOT_PAYMENT,
		'/order/index.php?s=pay' => INCLUDE_FUNCTION_CURRENT_ALREAD_PAYMENT,
	);
	$l = "/order/index.php?s={$selector}";
	return current_link($l, $a);
}

function current_link($link, $links, $span=false) {
	$html = '';
	$span = $span ? '<span></span>' : '';
	foreach($links AS $l=>$n) {
		if (trim($l,'/')==trim($link,'/')) {
			$html .= "<li class=\"current\"><a href=\"{$l}\">{$n}</a>{$span}</li>";
		}
		else $html .= "<li><a href=\"{$l}\">{$n}</a>{$span}</li>";
	}
	return $html;
}


function current_m_link($link, $links, $span=false) {
	$html = '';
	$span = $span ? '<span></span>' : '';
	foreach($links AS $l=>$n) {
			$html .= "<td><a href=\"{$l}\">{$n}</a>{$span}</td>";
	}
	return $html;
}

function current_mobile_link($link, $links, $span=false) {
	$html = '';
	$span = $span ? '<span></span>' : '';
	foreach($links AS $l=>$n) {
		if (trim($l,'/')==trim($link,'/')) {
			$html .= "<span>{$n}</span><br> </br>";
		}
		else $html .= "<a href=\"{$l}\">{$n}</a><br> </br>";
	}
	return $html;
}
function current_mobile_link_nolist($link, $links, $span=false) {
	$html = '';
	$span = $span ? '<br/>' : '';
	foreach($links AS $l=>$n) {
		if (trim($l,'/')==trim($link,'/')) {
			$html .="
				<td style='width:50%;background-color:#44abaf;text-align: center;'>
				<a style='color: #FFFFFF;font-weight:bold;padding-left:5px;text-decoration: 
				none;font-size: 12px;line-height: 24px' href=\"{$l}\">{$n}</a>
				</td>";	
		}
		else $html .="<td style='width:50%;background-color:#44abaf;text-align: center;'>
				<a style='color: #FFFFFF;font-weight:bold;padding-left:5px;text-decoration: 
				none;font-size: 12px;line-height: 24px' href=\"{$l}\">{$n}</a>
				</td>";
	}
	return $html;
}

/* manage current */
function mcurrent_misc($selector=null) {
	$a = array(
		'/manage/misc/index.php' => INCLUDE_FUNCTION_CURRENT_INDEX,
		'/manage/misc/ask.php' => INCLUDE_FUNCTION_CURRENT_TANGOU_ANSWER,
		'/manage/misc/feedback.php' => INCLUDE_FUNCTION_CURRENT_FEEDBACK_IDEA,
		'/manage/misc/subscribe.php' => INCLUDE_FUNCTION_CURRENT_EMAIL_SUBSCRIBE,
		'/manage/misc/invite.php' => INCLUDE_FUNCTION_CURRENT_INVITATION_RETURN,
		'/manage/misc/money.php' => INCLUDE_FUNCTION_CURRENT_FINANCE_RECORD,
	);
	$l = "/manage/misc/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_misc_money($selector=null){
	$selector = $selector ? $selector : 'store';
	$a = array(
		'/manage/misc/money.php?s=store' => INCLUDE_FUNCTION_CURRENT_UNDERLIEN_CHARGE,
		'/manage/misc/money.php?s=charge' => INCLUDE_FUNCTION_CURRENT_ONLINE_CHARGE,
		'/manage/misc/money.php?s=withdraw' => INCLUDE_FUNCTION_CURRENT_PAYPAL_RECORD,
		'/manage/misc/money.php?s=cash' => INCLUDE_FUNCTION_CURRENT_CASH_PAYMENT,
		'/manage/misc/money.php?s=refund' => INCLUDE_FUNCTION_CURRENT_REFUND_RECORD,
	);
	$l = "/manage/misc/money.php?s={$selector}";
	return current_link($l, $a);
}

function mcurrent_misc_invite($selector=null){
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/manage/misc/invite.php?s=index' => INCLUDE_FUNCTION_CURRENT_INVITATION_RECORD,
		'/manage/misc/invite.php?s=record' => INCLUDE_FUNCTION_CURRENT_RETURN_RECORD,
	);
	$l = "/manage/misc/invite.php?s={$selector}";
	return current_link($l, $a);
}
function mcurrent_order($selector=null) {
	$a = array(
		'/manage/order/index.php' => INCLUDE_FUNCTION_CURRENT_NOW_ORDER,
		'/manage/order/pay.php' => INCLUDE_FUNCTION_CURRENT_PAYMENT_ORDER,
		'/manage/order/unpay.php' => INCLUDE_FUNCTION_CURRENT_NOT_PAYMENT_ORDER,
	);
	$l = "/manage/order/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_user($selector=null) {
	$a = array(
		'/manage/user/index.php' => INCLUDE_FUNCTION_CURRENT_USER_LIST,
		'/manage/user/manager.php' => INCLUDE_FUNCTION_CURRENT_ADMIN_LIST,
	);
	$l = "/manage/user/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_team($selector=null) {
	$a = array(
		'/manage/team/index.php' => INCLUDE_FUNCTION_CURRENT_NOW_TUANGOU,
		'/manage/team/success.php' => INCLUDE_FUNCTION_CURRENT_SUCCESS_TUANGOU,
		'/manage/team/failure.php' => INCLUDE_FUNCTION_CURRENT_FAIL_TUANGOU,
		'/manage/team/create.php' => INCLUDE_FUNCTION_CURRENT_NEW_TUANGOU,
	);
	$l = "/manage/team/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_feedback($selector=null) {
	$a = array(
		'/manage/feedback/index.php' => INCLUDE_FUNCTION_CURRENT_SYNOPSIS,
	);
	$l = "/manage/feedback/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_coupon($selector=null) {
	$a = array(
		'/manage/coupon/index.php' => INCLUDE_FUNCTION_CURRENT_NOT_CONSUME,
		'/manage/coupon/consume.php' => INCLUDE_FUNCTION_CURRENT_ALREAD_CONSUME,
		'/manage/coupon/expire.php' => INCLUDE_FUNCTION_CURRENT_OVERDUE,
		// '/manage/coupon/card.php' => INCLUDE_FUNCTION_CURRENT_VOUCHER,
		// '/manage/coupon/cardcreate.php' => INCLUDE_FUNCTION_CURRENT_NEW_VOUCHER,
	);
	$l = "/manage/coupon/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_category($selector=null) {
	$zones = get_zones();
	$a = array();
	foreach( $zones AS $z=>$o ) {
		$a['/manage/category/index.php?zone='.$z] = $o;
	}
	$l = "/manage/category/index.php?zone={$selector}";
	return current_link($l,$a,true);
}
function mcurrent_partner($selector=null) {
	$a = array(
		'/manage/partner/index.php' => INCLUDE_FUNCTION_CURRENT_SELLER_LIST,
		'/manage/partner/create.php' => INCLUDE_FUNCTION_CURRENT_NOW_SELLER,
	);
	$l = "/manage/partner/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_market($selector=null) {
	$a = array(
		'/manage/market/index.php' => INCLUDE_FUNCTION_CURRENT_MAIL_MARKETING,
		'/manage/market/sms.php' => INCLUDE_FUNCTION_CURRENT_MESSAGE_FANOUT,
		'/manage/market/down.php' => INCLUDE_FUNCTION_CURRENT_DATA_DOWNLOAD,
	);
	$l = "/manage/market/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_market_down($selector=null) {
	$a = array(
		'/manage/market/down.php' => INCLUDE_FUNCTION_CURRENT_PHONE_NUMBER,
		'/manage/market/downemail.php' => INCLUDE_FUNCTION_CURRENT_EMAIL_ADDR,
		'/manage/market/downorder.php' => INCLUDE_FUNCTION_CURRENT_TUANGOU_ORDER,
		'/manage/market/downcoupon.php' => INCLUDE_FUNCTION_CURRENT_TUANGOU_COUPON,
		'/manage/market/downuser.php' => INCLUDE_FUNCTION_CURRENT_USER_INFO,
	);
	$l = "/manage/market/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_system($selector=null) {
	$a = array(
		'/manage/system/index.php' => INCLUDE_FUNCTION_CURRENT_BASIC,
		'/manage/system/bulletin.php' => INCLUDE_FUNCTION_CURRENT_BULLETIN,
		// '/manage/system/pay.php' => INCLUDE_FUNCTION_CURRENT_PAYMENT,
		'/manage/system/email.php' => INCLUDE_FUNCTION_CURRENT_MAIL,
		// '/manage/system/sms.php' => INCLUDE_FUNCTION_CURRENT_MESSAGE,
		'/manage/system/city.php' => INCLUDE_FUNCTION_CURRENT_CITY,
		'/manage/system/page.php' => INCLUDE_FUNCTION_CURRENT_PAGE,
		'/manage/system/cache.php' => INCLUDE_FUNCTION_CURRENT_CACHE,
		'/manage/system/skin.php' => INCLUDE_FUNCTION_CURRENT_SKIN,
		'/manage/system/template.php' => INCLUDE_FUNCTION_CURRENT_TEMPLATE,
		// '/manage/system/upgrade.php' => INCLUDE_FUNCTION_CURRENT_UPGRADE,
	);
	$l = "/manage/system/{$selector}.php";
	return current_link($l,$a,true);
}
