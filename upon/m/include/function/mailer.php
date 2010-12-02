<?php
/**
 * @name: mailer.php
 * @desc: 此文件定义邮件函数。
 */

/**
 * @desc: 给多个客户发送邮件。
 * @param unknown_type $emails
 * @param unknown_type $subject
 * @param unknown_type $message
 */
function mail_custom($emails=array(), $subject, $message) {
	global $INI;
	settype($emails, 'array');

	$options = array(
		'contentType' => 'text/html',
		'encoding' => 'GBK',
	);

	$from = $INI['mail']['from'];
	$to = array_shift($emails);
	if ($INI['mail']['mail']=='mail') {
		Mailer::SendMail($from, $to, $subject, $message, $options, $emails);
	} else {
		Mailer::SmtpMail($from, $to, $subject, $message, $options, $emails);
	}
}

/**
 * @desc: 给用户发注册邮件
 * @param unknown_type $user
 */
function mail_sign($user) {
	global $INI;
	if ( empty($user) ) return true;
	$from = $INI['mail']['from'];
	$to = $user['email'];

	$vars = array( 'user' => $user,);
	$message = render('mail_sign_verify', $vars);
	$subject = INCLUDE_FUNCTION_MAILER_THANKS_REGISTER.$INI['system']['sitename'].INCLUDE_FUNCTION_MAILER_VERIFICATION_EMAIL;

	$options = array(
		'contentType' => 'text/html',
		'encoding' => 'GBK',
	);
	if ($INI['mail']['mail']=='mail') {
		Mailer::SendMail($from, $to, $subject, $message, $options);
	} else {
		Mailer::SmtpMail($from, $to, $subject, $message, $options);
	}
}

/**
 * @desc: 通过id给指定用户发注册邮件。
 * @param $id
 */
function mail_sign_id($id) {
	$user = Table::Fetch('user', $id);
	mail_sign($user);
}

function mail_sign_email($email) {
	$user = Table::Fetch('user', $email, 'email');
	mail_sign($user);
}

/**
 * @desc: 发送重设密码邮件
 * @param unknown_type $user
 */
function mail_repass($user) {
	global $INI;
	if ( empty($user) ) return true;
	$from = $INI['mail']['from'];
	$to = $user['email'];

	$vars = array( 'user' => $user,);
	$message = render('mail_repass', $vars);
	$subject = $INI['system']['sitename'] . INCLUDE_FUNCTION_MAILER_RESET_PASSWORD;

	$options = array(
		'contentType' => 'text/html',
		'encoding' => 'GBK',
	);
	if ($INI['mail']['mail']=='mail') {
		Mailer::SendMail($from, $to, $subject, $message, $options);
	} else {
		Mailer::SmtpMail($from, $to, $subject, $message, $options);
	}
}

/**
 * @desc: 给定购邮件用户发送团购信息邮件。
 * @param unknown_type $city
 * @param unknown_type $team
 * @param unknown_type $partner
 * @param unknown_type $subscribe
 */
function mail_subscribe($city, $team, $partner, $subscribe) 
{
	global $INI;
	$week = array(INCLUDE_FUNCTION_MAILER_SUNDAY,INCLUDE_FUNCTION_MAILER_MONDAY,INCLUDE_FUNCTION_MAILER_TUESDAY,INCLUDE_FUNCTION_MAILER_WEDNESDAY,INCLUDE_FUNCTION_MAILER_THURSDAY,INCLUDE_FUNCTION_MAILER_FRIDAY,INCLUDE_FUNCTION_MAILER_SATURDAY);
	$today = date(INCLUDE_FUNCTION_MAILER_YMD) . $week[date('w')];
	$vars = array(
		'today' => $today,
		'team' => $team,
		'city' => $city,
		'subscribe' => $subscribe,
		'partner' => $partner,
		'help_email' => $INI['subscribe']['helpemail'],
		'help_mobile' => $INI['subscribe']['helpphone'],
		'notice_email' => $INI['mail']['reply'],
	);
	$message = render('mail_subscribe_team', $vars);
	$mesasge = mb_convert_encoding($mesage, 'Shift-JIS', 'UTF-8');
	$options = array(
		'contentType' => 'text/html',
		'encoding' => 'Shift-JIS',
	);
	$from = $INI['mail']['from'];
	$to = $subscribe['email'];
	$subject = $INI['system']['sitename'] . sprintf(INCLUDE_FUNCTION_MAILER_TODAY_GROUP_BUY,$team['title']);

	if ($INI['mail']['mail']=='mail') {
		Mailer::SendMail($from, $to, $subject, $message, $options);
	} else {
		Mailer::SmtpMail($from, $to, $subject, $message, $options);
	}
}
