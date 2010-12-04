<?php

// Net_IPv4を読み込む
require_once 'Net/IPv4.php';

// IPアドレスからキャリアを判別する
function mobile_ip_carrier()
{
	// IPを設定する配列を準備する
	$ip_table = array();

	// DoCoMoのIP帯域を配列に格納
	$ip_table['docomo'] = array();
	$ip_table['docomo'][] = '210.153.84.0/24';
	$ip_table['docomo'][] = '210.136.161.0/24';
	$ip_table['docomo'][] = '210.153.86.0/24';
	$ip_table['docomo'][] = '124.146.174.0/24';
	$ip_table['docomo'][] = '124.146.175.0/24';
	// DoCoMoのIP帯域2010年7月予定
	$ip_table['docomo'][] = '202.229.176.0/24';
	$ip_table['docomo'][] = '202.229.177.0/24';
	$ip_table['docomo'][] = '202.229.178.0/24';
	// DoCoMoのIP帯域2011年2月予定
	$ip_table['docomo'][] = '202.229.179.0/24';
	$ip_table['docomo'][] = '111.89.188.0/24';
	// DoCoMoのIP帯域2011年7月予定
	$ip_table['docomo'][] = '111.89.189.0/24';
	$ip_table['docomo'][] = '111.89.190.0/24';
	$ip_table['docomo'][] = '111.89.191.0/24';
	
	// 以下略

	// auのIP帯域を配列に格納
	$ip_table['au'] = array();
	$ip_table['au'][] = '210.230.128.224/28';
	$ip_table['au'][] = '121.111.227.160/27';
	$ip_table['au'][] = '61.117.1.0/28';
	$ip_table['au'][] = '219.108.158.0/27';
	$ip_table['au'][] = '219.125.146.0/28';
	$ip_table['au'][] = '61.117.2.32/29';
	$ip_table['au'][] = '61.117.2.40/29';
	$ip_table['au'][] = '219.108.158.40/29';
	$ip_table['au'][] = '219.125.148.0/25';
	$ip_table['au'][] = '222.5.63.0/25';
	$ip_table['au'][] = '222.5.63.128/25';
	$ip_table['au'][] = '222.5.62.128/25';
	$ip_table['au'][] = '59.135.38.128/25';
	$ip_table['au'][] = '219.108.157.0/25';
	$ip_table['au'][] = '219.125.145.0/25';
	$ip_table['au'][] = '121.111.231.0/25';
	$ip_table['au'][] = '121.111.227.0/25';
	$ip_table['au'][] = '118.152.214.192/25';
	$ip_table['au'][] = '118.159.131.0/25';
	$ip_table['au'][] = '118.159.133.0/25';
	//auのIP帯域を追加
	$ip_table['au'][] = '118.159.132.160/27';
	$ip_table['au'][] = '111.86.142.0/26';
	$ip_table['au'][] = '111.86.141.64/26';
	$ip_table['au'][] = '111.86.141.128/26';
	$ip_table['au'][] = '111.86.141.192/26';
	$ip_table['au'][] = '118.159.133.192/26';
	$ip_table['au'][] = '111.86.143.192/27';
	$ip_table['au'][] = '111.86.143.224/27';
	$ip_table['au'][] = '111.86.147.0/27';
	$ip_table['au'][] = '111.86.142.128/26';
	$ip_table['au'][] = '111.86.142.192/26';
	$ip_table['au'][] = '111.86.143.0/26';

	// SoftBankのIP帯域を配列に格納
	$ip_table['softbank'] = array();
	$ip_table['softbank'][] = '123.108.236.0/24';
	$ip_table['softbank'][] = '123.108.237.0/27';
	$ip_table['softbank'][] = '202.179.204.0/24';
	$ip_table['softbank'][] = '202.253.96.224/27';
	//　softBankのIP帯域を追加
	$ip_table['softbank'][] = '210.146.7.192/26';
	$ip_table['softbank'][] = '210.175.1.128/25';
	// 以下略

	// IPのキャリアを決定する
	$ip_carrier = '';

	// IPアドレスからキャリアを判断する
	if (empty($ip_carrier)) {
		foreach ($ip_table as $ip_table_carrier => $ip_table_value) {
			foreach ($ip_table_value as $value) {
				$value = trim($value);
				if (strcmp($_SERVER["REMOTE_ADDR"], $value) == 0 || Net_IPv4::ipInNetwork($_SERVER["REMOTE_ADDR"], $value)) {
					$ip_carrier = $ip_table_carrier;
					break 2;
				}
			}
		}
	}

	// 携帯のキャリアIPアドレスでない場合はPCからのアクセスとみなす
	if (empty($ip_carrier)) {
		$ip_carrier = 'モバイルでアクセスしてください。';
	}

	return $ip_carrier;
}

?>