
<?php echo '<?xml version="1.0" encoding="shift_jis"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="<?php echo $INI['sn']['sn']; ?>">
<head>
	<meta http-equiv=content-type content="text/html; charset=UTF-8">
	<title><?php echo $INI['system']['sitename']; ?> - <?php echo $INI['system']['sitetitle']; ?>|<?php echo $city['name']; ?>買物|<?php echo $city['name']; ?>共同購入|<?php echo $city['name']; ?>ディスカウント</title>
	<meta name="description" content="<?php echo $INI['system']['sitetitle']; ?>|<?php echo $city['name']; ?>買物|<?php echo $city['name']; ?>共同購入|<?php echo $city['name']; ?>ディスカウント" />
	<meta name="keywords" content="<?php echo $INI['system']['sitename']; ?>, <?php echo $city['name']; ?>, <?php echo $city['name']; ?><?php echo $INI['system']['sitename']; ?>，<?php echo $city['name']; ?>買物，<?php echo $city['name']; ?>共同購入，<?php echo $city['name']; ?>ディスカウント，共同購入，ディスカウント，クーポン，購物ガイド，消費ガイド" />
	<?php echo Session::Get('script',true);; ?>
</head>
<body text="#000000" bgcolor="#fbf3cf" link="#e62d66" vlink="#e62d66">
<div id="pagemasker"></div><div id="dialog"></div>
<div id="wrapper" style="width: 100%; font-family: arial, sans-serif; font-size: 12px;">