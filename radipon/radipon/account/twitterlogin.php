<?php
require_once(dirname(__FILE__)."/twittercommon.php");
if (!$bCli) {
//	$_SESSION = array();
	session_destroy();
}

$host = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']), "/");
$extra = 'twitterverification.php';

$aParam = array(
	"oauth_callback" => 'http://'.$host.$uri.'/'.$extra,
);
$sURL = "http://api.twitter.com/oauth/request_token";

$sReturn = $oOAuth->send($aParam, $sURL);

parse_str($sReturn, $aReturn);

$sRedirect = "http://api.twitter.com/oauth/authenticate?oauth_token="
	.$aReturn["oauth_token"];

header("Location: ".$sRedirect);
