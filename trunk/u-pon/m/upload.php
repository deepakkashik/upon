<?php
require_once(dirname(__FILE__) . '/app.php');

/*!
 * upload demo for php
 * @requires xhEditor
 * 
 * @author Yanis.Wang<yanis.wang@gmail.com>
 * @site http://pirate9.com/
 * @licence LGPL(http://www.opensource.org/licenses/lgpl-license.php)
 * 
 * @Version: 0.9.2 build 100225
 * 
 * 注：本程序仅为演示用，请您根据自己需求进行相应修改，或者重开发。
 */
header('Content-Type: text/html; charset=UTF-8');

function uploadfile($inputname)
{
	global $INI;
	$immediate=isset($_GET['immediate'])?$_GET['immediate']:0;
	$attachdir='upload';//上传文件保存路径，结尾不要带/
	$dirtype=1;//1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
	$maxattachsize=2097152;//最大上传大小，默认是2M
	$upext='txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mid';//上传扩展名
	$msgtype=2;//返回上传参数的格式：1，只返回url，2，返回参数数组
	
	$err = "";
	$msg = "";
	if(!isset($_FILES[$inputname]))return array('err'=>UPLOAD_DOCUMENT_NAME_ERROR,'msg'=>$msg);
	$upfile=$_FILES[$inputname];
	if(!empty($upfile['error']))
	{
		switch($upfile['error'])
		{
			case '1':
				$err = UPLOAD_UPLOAD_MAX_FILESIZE;
				break;
			case '2':
				$err = UPLOAD_MAX_FILE_SIZE;
				break;
			case '3':
				$err = UPLOAD_FILE_UPLOAD_INCOMPLETE;
				break;
			case '4':
				$err = UPLOAD_NO_FILE_UPLOAD;
				break;
			case '6':
				$err = UPLOAD_MISSING_A_TEMPORARY_FOLDER;
				break;
			case '7':
				$err = UPLOAD_FAILED_TO_WRITE_FILE;
				break;
			case '8':
				$err = UPLOAD_INTERRUPT;
				break;
			case '999':
			default:
				$err = UPLOAD_NO_VALID_ERROR_CODE;
		}
	}
	elseif(empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none')$err = UPLOAD_NO_FILE_UPLOAD;
	else
	{
		$temppath=$upfile['tmp_name'];
		$fileinfo=pathinfo($upfile['name']);
		$extension=strtolower($fileinfo['extension']);
		if(preg_match('/'.str_replace(',','|',$upext).'/i',$extension))
		{
			$filesize=filesize($temppath);
			if($filesize > $maxattachsize)$err=UPLOAD_FILE_SIZE.$maxattachsize.UPLOAD_BYTE;
			else
			{
				$year = date('Y');
				$day = date('md');
				$n = time().rand(1000,9999).'.jpg';
				$attach_dir = IMG_ROOT . "/team/{$year}/{$day}";
				RecursiveMkdir( IMG_ROOT . "/team/{$year}/{$day}" );
				$fname= time().rand(1000,9999).'.'.$extension;
				$target = $attach_dir.'/'.$fname;
				move_uploaded_file($upfile['tmp_name'],$target);
				$target = $INI['system']['imgprefix']."/static/team/{$year}/{$day}/{$fname}";
				if($immediate=='1')$target='!'.$target;
				if($msgtype==1)$msg=$target;
				else $msg=array('url'=>$target,'localname'=>$upfile['name'],'id'=>'1');//id参数固定不变，仅供演示，实际项目中可以是数据库ID
			}
		}
		else $err=UPLOAD_UPLOAD_FILE.$upext;

		@unlink($temppath);
	}
	return array('err'=>$err,'msg'=>$msg);
}

$state=uploadfile('filedata');
echo json_encode($state);
