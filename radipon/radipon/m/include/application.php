<?php
/* for rewrite or iis rewrite */
if (isset($_SERVER['HTTP_X_ORIGINAL_URL'])) {
	$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
} else if (isset($_SERVER['HTTP_X_REWRITE_URL'])) {
	$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
}
/* end */

error_reporting(E_ALL^E_WARNING^E_NOTICE);
define('SYS_VERSION', 'V1.5');
define('SYS_TIMESTART', microtime(true));
define('SYS_REQUEST', isset($_SERVER['REQUEST_URI']));
define('DIR_SEPERATOR', strstr(strtoupper(PHP_OS), 'WIN')?'\\':'/');
define('DIR_ROOT', str_replace('\\','/',dirname(__FILE__)));
define('WWW_ROOT', rtrim(dirname(DIR_ROOT),'/'));
define('DIR_LIBARAY', DIR_ROOT . '/library');
define('DIR_CLASSES', DIR_ROOT . '/classes');
define('DIR_COMPILED', DIR_ROOT . '/compiled');
define('DIR_TEMPLATE', DIR_ROOT . '/template');
define('DIR_FUNCTION', DIR_ROOT . '/function');
define('DIR_CONFIGURE', DIR_ROOT . '/configure');
define('IMG_ROOT', dirname(DIR_ROOT) . '/static');

define('WWW_ROOT_PC', rtrim(dirname(dirname(DIR_ROOT)),'/'));
define('DIR_CLASSES_PC', WWW_ROOT_PC . '/include/classes');
define('DIR_LIBARAY_PC', WWW_ROOT_PC . '/include/library');
define('DIR_CLASSES_PC', WWW_ROOT_PC . '/include/classes');
define('DIR_COMPILED_PC', WWW_ROOT_PC . '/include/compiled');
define('DIR_TEMPLATE_PC', WWW_ROOT_PC . '/include/template');
define('DIR_FUNCTION_PC', WWW_ROOT_PC . '/include/function');
define('DIR_CONFIGURE_PC', WWW_ROOT_PC . '/include/configure');
define('SYS_PHPFILE', WWW_ROOT_PC . '/include/configure/system.php');

/* setup include path */
$gpay_client_path = DIR_LIBARAY_PC . '/gpay_client/src/';
set_include_path(get_include_path() . PATH_SEPARATOR . $gpay_client_path);


/* important function */

/**
 * @desc:定义类加载规则
 */
function __autoload($class_name) {
	$file_name = trim(str_replace('_','/',$class_name),'/').'.class.php';
	
	$file_path = DIR_LIBARAY. '/' . $file_name;
	if ( file_exists( $file_path ) ) {
		return require_once( $file_path );
	}
	$file_path = DIR_CLASSES. '/' . $file_name;
	if ( file_exists( $file_path ) ) {
		return require_once( $file_path );
	}
	
	$file_path = DIR_LIBARAY_PC. '/' . $file_name;
	if ( file_exists( $file_path ) ) {
		return require_once( $file_path );
	}
	$file_path = DIR_CLASSES_PC. '/' . $file_name;
	if ( file_exists( $file_path ) ) {
		return require_once( $file_path );
	}
	return false;
}

/**
 * @desc: 定义引用函数规则
 */
function import($funcpre) {
	$file_path = DIR_FUNCTION. '/' . $funcpre . '.php'; 
	if (file_exists($file_path) ) {
		return require_once( $file_path );
	}
	
	$file_path = DIR_FUNCTION_PC. '/' . $funcpre . '.php'; 
	if (file_exists($file_path) ) {
		return require_once( $file_path );
	}
	
}

/* json */
//定义json_encode函数和json_decode函数
if (!function_exists('json_encode')){function json_encode($v){$js = new JsonService(); return $js->encode($v);}}
if (!function_exists('json_decode')){function json_decode($v,$t){$js = new JsonService($t?16:0); return $js->decode($v);}}
/* end json */

/* date_zone */
//定义时区函数
if(function_exists('date_default_timezone_set')) { date_default_timezone_set('Asia/Tokyo'); }
/* end date_zone */

/* ob_handler */
if(SYS_REQUEST){ ob_start(); }
/* end ob */

/* import */
import('template');
import('common');
