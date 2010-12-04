<?php
/**
 * @name: Session会话类
 * @desc: singleton模式，定义全局唯一的session对象。
 * @author: shwdai@gmail.com
 */
class Session
{
	static private $_begin = 0;
	static private $_instance = null;
	static private $_debug = false;

	static public function Init($debug=false)
	{
		ini_set('session.use_cookies', 0);
		ini_set('session.use_only_cookies', 0);
		ini_set('session.use_trans_sid', 1);
		if ( function_exists('render_hook') ) {
			ob_start('render_hook');
		}
		if ( function_exists('output_hook') ) {
			ob_start('output_hook');
		}
		
		self::$_instance = new Session();
		self::$_debug = $debug;
		session_start();
	}

	static public function Set($name, $v) 
	{
		$_SESSION[$name] = $v;
	}

	static public function Get($name, $once=false)
	{
		$v = null;
		if ( isset($_SESSION[$name]) )
		{
			$v = $_SESSION[$name];
			if ( $once ) unset( $_SESSION[$name] );
		}
		return $v;
	}

	function __construct()
	{
		self::$_begin = microtime(true);
	}

	function __destruct()
	{
		global $AJAX, $INI;
		if (self::$_debug&&!$AJAX) { echo 'Generation Cost: '.(microtime(true)-self::$_begin).'s'; }
	}
}
?>
