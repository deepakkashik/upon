<?php
/**
 * @name: common.php
 * @desc: 此文件用于定义公共函数。
 */
/* import other */
import('current'); 	//引入菜单函数
import('utility'); 	//引入应用函数
import('mailer');	//引入邮件函数
import('sms');		//引入短信功能函数
import('upgrade');	//引入最土程序更新函数
import('uc');		//引入UCenter SNS系统接口

/**
 * @desc: 应用指定模板
 * @param unknown_type $tFile： 模板文件名
 */
function template($tFile) {
	global $INI;
	if ( 0===strpos($tFile, 'manage') ) {
		return __template($tFile);
	}
	if ($INI['skin']['template_m']) {
		$templatedir = DIR_TEMPLATE. '/' . $INI['skin']['template_m'];
		$checkfile = $templatedir . '/html_header.html';
		if ( file_exists($checkfile) ) {
			return __template($INI['skin']['template_m'].'/'.$tFile);
		}
	}
	return __template($tFile);
}

/**
 * @desc: 显示指定模板
 * @param unknown_type $tFile
 * @param unknown_type $vs
 */
function render($tFile, $vs=array()) {
    ob_start();	//打开输入缓冲
    foreach($GLOBALS AS $_k=>$_v) {
        ${$_k} = $_v;
    }
	foreach($vs AS $_k=>$_v) {
		${$_k} = $_v;
	}
	include template($tFile);
    return render_hook(ob_get_clean());
}

/**
 * @desc: 替换所有钩子
 * @param unknown_type $c
 */
function render_hook($c) {
	global $INI;
	
	$c = preg_replace('#href="/#i', 'href="'.WEB_ROOT.'/', $c);
	$c = preg_replace('#src="/#i', 'src="'.WEB_ROOT.'/', $c);
	$c = preg_replace('#action="/#i', 'action="'.WEB_ROOT.'/', $c);

	/* theme */
	$page = strval($_SERVER['REQUEST_URI']);
	if($INI['skin']['theme_m'] && !preg_match('#/manage/#i',$page)) {
		$themedir = WWW_ROOT. '/static/theme/' . $INI['skin']['theme_m'];
		$checkfile = $themedir. '/css/index.css';
		if ( file_exists($checkfile) ) {
			$c = preg_replace('#/static/css/#', "/static/theme/{$INI['skin']['theme_m']}/css/", $c);
			$c = preg_replace('#/static/img/#', "/static/theme/{$INI['skin']['theme_m']}/img/", $c);
		}
	}
	return $c;
}

function output_hook($c) {
	global $INI;
	if ( 0==abs(intval($INI['system']['gzip'])))  return($c);
	$HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"]; 
	if( strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false ) 
		$encoding = 'x-gzip'; 
	else if( strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false ) 
		$encoding = 'gzip'; 
	else $encoding == false;
	if (function_exists('gzencode')&&$encoding) {
		$c = gzencode($c);
		header("Content-Encoding: {$encoding}"); 
	}
	$length = strlen($c);
	header("Content-Length: {$length}");
	return($c);
}

$lang_properties = array();
function I($key) { 
    global $lang_properties, $LC;
    if (!$lang_properties) {
        $ini = DIR_ROOT . '/i18n/' . $LC. '/properties.ini';
        $lang_properties = Config::Instance($ini);
    }
    return isset($lang_properties[$key]) ?
        $lang_properties[$key] : $key;
}

function json($data, $type='eval') {
    $type = strtolower($type);
    $allow = array('eval','alert','updater','dialog','mix', 'refresh');
    if (false==in_array($type, $allow))
        return false;
    Output::Json(array( 'data' => $data, 'type' => $type,));
}

/**
 * 重定向链接
 * @param unknown_type $url
 */
function redirect($url=null) {
    header("Location: {$url}");
    exit;
}

/**
 * 输出php文件
 * @param unknown_type $array
 * @param unknown_type $filename
 */
function write_php_file($array, $filename=null){
	$v = "<?php\r\n\$INI = ";
	$v .= var_export($array, true);
	$v .=";\r\n?>";
	return file_put_contents($filename, $v);
}

/**
 * @desc: 写入ini文件
 * @param unknown_type $array
 * @param unknown_type $filename
 */
function write_ini_file($array, $filename=null){   
	$ok = null;   
	if ($filename) {
		$s =  ";;;;;;;;;;;;;;;;;;\r\n";
		$s .= ";; SYS_INIFILE\r\n";
		$s .= ";;;;;;;;;;;;;;;;;;\r\n";
	}
	foreach($array as $k=>$v) {   
		if(is_array($v))   { 
			if($k != $ok) {   
				$s  .=  "\r\n[{$k}]\r\n";
				$ok = $k;   
			} 
			$s .= write_ini_file($v);
		}else   {   
			if(trim($v) != $v || strstr($v,"["))
				$v = "\"{$v}\"";   
			$s .=  "$k = \"{$v}\"\r\n";
		} 
	}

	if(!$filename) return $s;   
	return file_put_contents($filename, $s);
}   

/**
 * @desc: 保存配置文件
 * @param unknown_type $type
 */
function save_config($type='ini') {
	global $INI; $q = ZSystem::GetSaveINI($INI);
	if ( strtoupper($type) == 'INI' ) {
		if (!is_writeable(SYS_INIFILE)) return false;
		return write_ini_file($q, SYS_INIFILE);
	} 
	if ( strtoupper($type) == 'PHP' ) {
		if (!is_writeable(SYS_PHPFILE)) return false;
		return write_php_file($q, SYS_PHPFILE);
	} 
	return false;
}

/**
 * @desc: 保存系统配置
 * @param $ini
 */
function save_system($ini) {
	$system = Table::Fetch('system', 1);
	$ini = ZSystem::GetUnsetINI($ini);
	$value = Utility::ExtraEncode($ini);
	$table = new Table('system', array('value'=>$value));
	if ( $system ) $table->SetPK('id', 1);
	return $table->update(array( 'value'));
}

/* user relative */
function need_login($force=false) {
	if ( isset($_SESSION['user_id']) ) {
		if (is_post()) {
			unset($_SESSION['loginpage']);
			unset($_SESSION['loginpagepost']);
		}
		return $_SESSION['user_id'];
	}
	if ( is_get() ) {
		Session::Set('loginpage', $_SERVER['REQUEST_URI']);
	} else {
		Session::Set('loginpage', $_SERVER['HTTP_REFERER']);
		Session::Set('loginpagepost', json_encode($_POST));
	}
	return redirect(WEB_ROOT . '/account/login.php');	
}
function need_post() {
	return is_post() ? true : redirect(WEB_ROOT . '/index.php');
}
function need_manager($super=false) {
	if ( ! is_manager() ) {
		redirect( WEB_ROOT . '/account/login.php' );
	}
	if ( ! $super ) return true;
	if ( abs(intval($_SESSION['user_id'])) == 1 ) return true;
	return redirect( WEB_ROOT . '/manage/misc/index.php');
}
function need_partner() {
	return is_partner() ? true : redirect( WEB_ROOT . '/biz/login.php');
}

function need_auth($b=true) {
	global $AJAX, $INI, $login_user;
	if (is_string($b)) {
		$auths = $INI['authorization'][$login_user['id']];
		$b = is_manager(true)||in_array($b, $auths);
	}
	if (true===$b) {
		return true;
	}
	if ($AJAX) json(INCLUDE_FUNCTION_COMMON_IMPUISSANCE, 'alert');
	Session::Set('error', INCLUDE_FUNCTION_COMMON_IMPUISSANCE);
	redirect( WEB_ROOT . '/account/login.php');
}

function is_manager($super=false) {
	global $login_user;
	if ( ! $super ) return ($login_user['manager'] == 'Y');
	return $login_user['id'] == 1;
}
function is_partner() {
	return ($_SESSION['partner_id']>0);
}

function is_newbie(){ return (cookieget('newbie')!='N'); }
function is_get() { return ! is_post(); }
function is_post() {
	return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
}

function is_login() {
	return isset($_SESSION['user_id']);
}

function get_loginpage($default=null) {
	$loginpage = Session::Get('loginpage', true);
	if ($loginpage)  return $loginpage;
	if ($default) return $default;
	return WEB_ROOT . '/index.php';
}

function cookie_city($city) {
	global $INI;
	if($city) { 
		cookieset('city', $city['id']);
		return $city;
	} 
	$city_id = cookieget('city');

	if (!$city_id) {
		$city = get_city();
		if (!$city) {
			$city = Table::Fetch('category', $INI['hotcity'][0]);
		}
		if ($city) cookie_city($city);
		return $city;
	} else {
		if (in_array($city_id, $INI['hotcity'])) {
			return Table::Fetch('category', $city_id);
		}
		$city = Table::Fetch('category', $INI['hotcity'][0]);
	}
	return $city;
}

function cookieset($k, $v, $expire=0) {
	$pre = substr(md5($_SERVER['HTTP_HOST']),0,4);
	$k = "{$pre}_{$k}";
	if ($expire==0) {
		$expire = time() + 365 * 86400;
	} else {
		$expire += time();
	}
	setCookie($k, $v, $expire, '/');
}

function cookieget($k) {
	$pre = substr(md5($_SERVER['HTTP_HOST']),0,4);
	$k = "{$pre}_{$k}";
	return strval($_COOKIE[$k]);
}

function moneyit($k) {
	return rtrim(rtrim(sprintf('%.2f',$k), '0'), '.');
}

function debug($v, $e=false) {
	global $login_user_id;
	if ($login_user_id==100000) {
		echo "<pre>";
		var_dump( $v);
		if($e) exit;
	}
}

function getparam($index=0, $default=0) {
	if (is_numeric($default)) {
		$v = abs(intval($_GET['param'][$index]));
	} else $v = strval($_GET['param'][$index]);
	return $v ? $v : $default;
}
function getpage() {
	$c = abs(intval($_GET['page']));
	return $c ? $c : 1;
}
function pagestring($count, $pagesize) {
	$p = new Pager($count, $pagesize, 'page');
	return array($pagesize, $p->offset, $p->genBasic());
}
function pagestring_m($count, $pagesize) {
	$p = new PagerM($count, $pagesize, 'page');
	return array($pagesize, $p->offset, $p->genBasic());
}

function uencode($u) {
	return base64_encode(urlEncode($u));
}
function udecode($u) {
	return urlDecode(base64_decode($u));
}

/* share link */
function share_renren($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'link' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
				);
	}
	else {
		$query = array(
				'link' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}

	$query = http_build_query($query);
	return 'http://share.renren.com/share/buttonshare.do?'.$query;
}

function share_kaixin($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'rurl' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'rtitle' => $team['title'],
				'rcontent' => strip_tags($team['summary']),
				);
	}
	else {
		$query = array(
				'rurl' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'rtitle' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				'rcontent' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}
	$query = http_build_query($query);
	return 'http://www.kaixin001.com/repaste/share.php?'.$query;
}

function share_douban($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
				);
	}
	else {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}
	$query = http_build_query($query);
	return 'http://www.douban.com/recommend/?'.$query;
}

function share_sina($team) {
	global $login_user_id;
	global $INI;
	if ($team)  {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}",
				'title' => $team['title'],
				);
	}
	else {
		$query = array(
				'url' => $INI['system']['wwwprefix'] . "/r.php?r={$login_user_id}",
				'title' => $INI['system']['sitename'] . '(' .$INI['system']['wwwprefix']. ')',
				);
	}
	$query = http_build_query($query);
	return 'http://v.t.sina.com.cn/share/share.php?'.$query;
}

function share_mail($team) {
	global $login_user_id;
	global $INI;
	if (!$team) {
		$team = array(
				'title' => $INI['system']['sitename'] . '(' . $INI['system']['wwwprefix'] . ')',
				);
	}
	$pre[] = sprintf(INCLUDE_FUNCTION_COMMON_LONG_SENTENCE_SYSTEM_SITENAME,$INI['system']['sitename']);
	if ( $team['id'] ) {
		$pre[] = sprintf(INCLUDE_FUNCTION_COMMON_TODAY_TUANGOU_TITLE,$team['title']);
		$pre[] = INCLUDE_FUNCTION_COMMON_THINK_INTEREST;
		$pre[] = $INI['system']['wwwprefix'] . "/team.php?id={$team['id']}&r={$login_user_id}";
		$pre = mb_convert_encoding(join("\n\n", $pre), 'GBK', 'UTF-8');
		$sub = sprintf(INCLUDE_FUNCTION_COMMON_INTEREST_TITLE,$team['title']);
	} else {
		$sub = $pre[] = $team['title'];
	}
	$sub = mb_convert_encoding($sub, 'GBK', 'UTF-8');
	$query = array( 'subject' => $sub, 'body' => $pre, );
	$query = http_build_query($query);
	return 'mailto:?'.$query;
}

function domainit($url) {
	if(strpos($url,'//')) { preg_match('#[//]([^/]+)#', $url, $m);
} else { preg_match('#[//]?([^/]+)#', $url, $m); }
return $m[1];
}

// that the recursive feature on mkdir() is broken with PHP 5.0.4 for
function RecursiveMkdir($path) {
	if (!file_exists($path)) {
		RecursiveMkdir(dirname($path));
		@mkdir($path, 0777);
	}
}

function upload_image($inputname, $image=null, $type='team', $width=440) {
	$year = date('Y'); $day = date('md'); $n = time().rand(1000,9999).'.jpg';
	$z = $_FILES[$inputname];
	if ($z && strpos($z['type'], 'image')===0 && $z['error']==0) {
		if (!$image) { 
			RecursiveMkdir( IMG_ROOT . '/' . "{$type}/{$year}/{$day}" );
			$image = "{$type}/{$year}/{$day}/{$n}";
			$path = IMG_ROOT . '/' . $image;
		} else {
			RecursiveMkdir( dirname(IMG_ROOT .'/' .$image) );
			$path = IMG_ROOT . '/' .$image;
		}
		if ($type=='user') {
			Image::Convert($z['tmp_name'], $path, 48, 48, Image::MODE_CUT);
		} 
		else if($type=='team') {
			move_uploaded_file($z['tmp_name'], $path);
		}
		return $image;
	} 
	return $image;
}

function user_image($image=null) {
	global $INI;
	if (!$image) { 
		return $INI['system']['imgprefix'] . '/static/img/user-no-avatar.gif';
	}
	return $INI['system']['imgprefix'] . '/static/' .$image;
}

function team_image($image=null) {
	global $INI;
	if (!$image) return null;
	return $INI['system']['imgprefix'] . '/static/' .$image;
}

function userreview($content) {
	$line = preg_split("/[\n\r]+/", $content, -1, PREG_SPLIT_NO_EMPTY);
	$r = '<ul>';
	foreach($line AS $one) {
		$c = explode('|', htmlspecialchars($one));
		$c[2] = $c[2] ? $c[2] : '/';
		$r .= "<li>{$c[0]}<span>－－<a href=\"{$c[2]}\" target=\"_blank\">{$c[1]}</a>";
		$r .= ($c[3] ? "（{$c[3]}）":'') . "</span></li>\n";
	}
	return $r.'</ul>';
}

function team_state(&$team) {
	$team['close_time'] = 0;
	if ( $team['now_number'] >= $team['min_number'] ) {
		if ($team['max_number']>0) {
			if ( $team['now_number']>=$team['max_number'] ){
				if ($team['close_time']==0) {
					$team['close_time'] = $team['end_time'];
				}
				return $team['state'] = 'soldout';
			}
		}
		if ( $team['end_time'] <= time() ) {
			$team['close_time'] = $team['end_time'];
		}
		return $team['state'] = 'success';
	} else {
		if ( $team['end_time'] <= time() ) {
			$team['close_time'] = $team['end_time'];
			return $team['state'] = 'failure';
		}
	}
	return $team['state'] = 'none';
}

function current_team($city_id=0) {
	$today = strtotime(date('Y-m-d'));
	settype($city_id, 'array'); $city_id[] = 0;
	$cond = array(
			'city_id' => $city_id,
			"begin_time <= {$today}",
			"end_time > {$today}",
			);
	$team = DB::LimitQuery('team', array(
				'condition' => $cond,
				'one' => true,
				'order' => 'ORDER BY city_id DESC,begin_time DESC,id DESC',
				));
	return $team;
}

function state_explain($team, $error='false') {
	$state = team_state($team);
	$state = strtolower($state);
	switch($state) {
		case 'none': return INCLUDE_FUNCTION_COMMON_PROCEED;
		case 'soldout': return INCLUDE_FUNCTION_COMMON_SELLOUT;
		case 'failure': if($error) return INCLUDE_FUNCTION_COMMON_TUANGOU_FAIL;
		case 'success': return INCLUDE_FUNCTION_COMMON_TUANGOU_SUCCESS;
		default: return INCLUDE_FUNCTION_COMMON_OVER;
	}
}

function get_zones($zone=null) {
	$zones = array(
			'city' => INCLUDE_FUNCTION_COMMON_CITY_LIST,
			'group' => INCLUDE_FUNCTION_COMMON_TUANGOU_CATEGORY,
			'public' => INCLUDE_FUNCTION_COMMON_BBS_LAYOUT,
			'grade' => INCLUDE_FUNCTION_COMMON_USER_GRADE,
			'express' => INCLUDE_FUNCTION_COMMON_EXPRESS_COMPANY,
			);
	if ( !$zone ) return $zones;
	if (!in_array($zone, array_keys($zones))) {
		$zone = 'city';
	}
	return array($zone, $zones[$zone]);
}

function down_xls($data, $keynames, $name='dataxls') {
	$xls[] = "<html><meta http-equiv=content-type content=\"text/html; charset=UTF-8\"><body><table border='1'>";
	$xls[] = "<tr><td>ID</td><td>" . implode("</td><td>", array_values($keynames)) . '</td></tr>';
	foreach($data As $o) {
		$line = array(++$index);
		foreach($keynames AS $k=>$v) {
			$line[] = $o[$k];
		}
		$xls[] = '<tr><td>'. implode("</td><td>", $line) . '</td></tr>';
	}
	$xls[] = '</table></body></html>';
	$xls = join("\r\n", $xls);
	header('Content-Disposition: attachment; filename="'.$name.'.xls"');
	die(mb_convert_encoding($xls,'UTF-8','UTF-8'));
}

function option_category($zone='city', $force=false) {
	$cache = $force ? 0 : 86400*30;
	$cates = DB::LimitQuery('category', array(
		'condition' => array( 'zone' => $zone, ),
		'cache' => $cache,
	));
	return Utility::OptionArray($cates, 'id', 'name');
}
