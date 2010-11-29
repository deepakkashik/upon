<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
require_once(dirname(__FILE__) . "/twitteroauth.php");

$bCli = (PHP_SAPI == "cli");
// 下面这行填上你 Consumer key 和 Consumer secret
$oOAuth = new TwitterOAuth("SNXfP4kQnnpqnHdERnNlQ", "LLEg23vxqFQ0c6YL6tkeAUwczLdLd8k8nZLtKQ");
//$oOAuth = new TwitterOAuth("ZgcoSVX5iEc9TA1uNuvw", "2HwjaD5aehseuEo9B0BmlOUUft7hRkOIpz7Y6DpU"); //teiHk

$oOAuth->setRelease();
//$oOAuth->setDebug(); // 设定这行可以看到整个 HTTP 交互过程


// 代理示例，二选一
// $oOAuth->setProxy("192.168.0.151:7780", CURLPROXY_SOCKS5);
// $oOAuth->setProxy("192.168.0.151:7780", CURLPROXY_HTTP);
