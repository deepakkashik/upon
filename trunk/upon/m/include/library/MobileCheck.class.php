<?php
class MobileCheck{
	var $zone;

	function GetSub($env){
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if($env === 'docomo'){
			if(preg_match("/^.+ser([0-9a-zA-Z]+).*$/",$ua, $dprg)){
				if(strlen($dprg[1]) === 11){
					$ser = $dprg[1];
				}elseif(strlen($dprg[1]) === 15){
					$ser = $dprg[1];
					if(preg_match("/^.+icc([a-zA-Z0-9]+).*$/",$ua, $dpeg)){
						if(strlen($dpeg[1]) === 20){
							$icc = $dpeg[1];
						}
					}
				}
			}
			$dgd = $_SERVER['HTTP_X_DCMGUID'];
		}elseif($env === 'softbank'){
			//if(preg_match("/\/SN([a-zA-Z0-9]+)\//",$ua,$vprg)){
			if (preg_match("/^.+\/SN([0-9a-zA-Z]+).*$/", $ua, $vprg)){
				$srn = $vprg[1];
			}
			$sud = $_SERVER['HTTP_X_JPHONE_UID'];
		}elseif($env === 'au'){
			$ezn = $_SERVER['HTTP_X_UP_SUBNO'];
		}

		return array($ser,$icc,$dgd,$srn,$sud,$ezn);
	
	}//func-GetSub

	function GetZone($env){
		/* IP帯域の設定 */
		if($env === 'docomo'){
			//i-mode(NTT DoCoMo)のIPアドレス帯域を設定
			//更新日時:2010-06-24
			//http://www.nttdocomo.co.jp/service/imode/make/content/ip/index.html

			$this->zone[0] = '210.153.84.0/24';
			$this->zone[1] = '210.136.161.0/24';
			$this->zone[2] = '210.153.86.0/24';
			$this->zone[3] = '124.146.174.0/24';
			$this->zone[4] = '124.146.175.0/24';
			$this->zone[5] = '202.229.176.0/24';
			$this->zone[6] = '202.229.177.0/24';
			$this->zone[7] = '202.229.178.0/24';
			$this->zone[8] = '127.0.0.0/24'; //テスト用
			
			//$this->zone[8] = '111.89.188.0/24'; // (2011年2月に追加予定）
			//$this->zone[9] = '111.89.189.0/24'; // (2011年7月に追加予定）
			//$this->zone[10] = '111.89.190.0/24'; // (2011年7月に追加予定）
			//$this->zone[11] = '111.89.191.0/24'; // (2011年7月に追加予定）
			
		}elseif($env === 'au'){
			//EZWeb(au)のIPアドレス帯域を設定
			//更新日時:2010-06-24
			//http://www.au.kddi.com/ezfactory/tec/spec/ezsava_ip.html
			
			$this->zone[0] = '210.230.128.224/28';
			$this->zone[1] = '121.111.227.160/27';
			$this->zone[2] = '61.117.1.0/28';
			$this->zone[3] = '219.108.158.0/27';
			$this->zone[4] = '219.125.146.0/28';
			$this->zone[5] = '61.117.2.32/29';
			$this->zone[6] = '61.117.2.40/29';
			$this->zone[7] = '219.108.158.40/29';
			$this->zone[8] = '219.125.148.0/25';
			$this->zone[9] = '222.5.63.0/25';
			$this->zone[10] = '222.5.63.128/25';
			$this->zone[11] = '222.5.62.128/25';
			$this->zone[12] = '59.135.38.128/25';
			$this->zone[13] = '219.108.157.0/25';
			$this->zone[14] = '219.125.145.0/25';
			$this->zone[15] = '121.111.231.0/25';
			$this->zone[16] = '121.111.227.0/25';
			$this->zone[17] = '118.152.214.192/26';
			$this->zone[18] = '118.159.131.0/25';
			$this->zone[19] = '118.159.133.0/25';
			$this->zone[20] = '118.159.132.160/27';
			$this->zone[21] = '111.86.142.0/26';
			$this->zone[22] = '111.86.141.64/26';
			$this->zone[23] = '111.86.141.128/26';
			$this->zone[24] = '111.86.141.192/26';
			$this->zone[25] = '118.159.133.192/26';
			$this->zone[26] = '111.86.143.192/27'; //2010年10月予定
			$this->zone[27] = '111.86.143.224/27'; //2010年10月予定
			$this->zone[28] = '111.86.147.0/27';   //2010年10月予定
			$this->zone[29] = '111.86.142.128/26'; //2010年10月予定
			$this->zone[30] = '111.86.142.192/26'; //2010年10月予定
			$this->zone[31] = '111.86.143.0/26';   //2010年10月予定
			$this->zone[32] = '127.0.0.0/24'; //テスト用
			
		}elseif($env === 'softbank'){
			//Yahoo!ケータイ(SoftBank)のIPアドレス帯域を設定
			//更新日時:2010-06-24
			//http://creation.mb.softbank.jp/web/web_ip.html
			
			$this->zone[0] = '123.108.237.0/27';
			$this->zone[1] = '202.253.96.224/27';
			$this->zone[2] = '210.146.7.192/26';
			$this->zone[3] = '210.175.1.128/25';
			$this->zone[4] = '127.0.0.0/24'; //テスト用
			
		}elseif($env === 'willcom'){
			//AIR-EDGE PHONE(WILLCOM)のIPアドレス帯域を設定
			//更新日時:2010-06-24
			//http://www.willcom-inc.com/ja/service/contents_service/club_air_edge/for_phone/ip/
			
			$this->zone[0] = '61.198.128.0/24';
			$this->zone[1] = '61.198.129.0/24';
			$this->zone[2] = '61.198.130.0/24';
			$this->zone[3] = '61.198.131.0/24';
			$this->zone[4] = '61.198.132.0/24';
			$this->zone[5] = '61.198.133.0/24';
			$this->zone[6] = '61.198.134.0/24';
			$this->zone[7] = '61.198.135.0/24';
			$this->zone[8] = '61.198.136.0/24';
			$this->zone[9] = '61.198.137.0/24';
			$this->zone[10] = '61.198.138.100/32';
			$this->zone[11] = '61.198.138.101/32';
			$this->zone[12] = '61.198.138.102/32';
			$this->zone[13] = '61.198.138.103/32';
			$this->zone[14] = '61.198.139.0/29';
			$this->zone[15] = '61.198.139.128/27';
			$this->zone[16] = '61.198.139.160/28';
			$this->zone[17] = '61.198.140.0/24';
			$this->zone[18] = '61.198.141.0/24';
			$this->zone[19] = '61.198.142.0/24';
			$this->zone[20] = '61.198.143.0/24';
			$this->zone[21] = '61.198.160.0/24';
			$this->zone[22] = '61.198.161.0/24';
			$this->zone[23] = '61.198.162.0/24';
			$this->zone[24] = '61.198.163.0/24';
			$this->zone[25] = '61.198.164.0/24';
			$this->zone[26] = '61.198.165.0/24';
			$this->zone[27] = '61.198.166.0/24';
			$this->zone[28] = '61.198.168.0/24';
			$this->zone[29] = '61.198.169.0/24';
			$this->zone[30] = '61.198.170.0/24';
			$this->zone[31] = '61.198.171.0/24';
			$this->zone[32] = '61.198.172.0/24';
			$this->zone[33] = '61.198.173.0/24';
			$this->zone[34] = '61.198.174.0/24';
			$this->zone[35] = '61.198.175.0/24';
			$this->zone[36] = '61.198.248.0/24';
			$this->zone[37] = '61.198.249.0/24';
			$this->zone[38] = '61.198.250.0/24';
			$this->zone[39] = '61.198.251.0/24';
			$this->zone[40] = '61.198.252.0/24';
			$this->zone[41] = '61.198.253.0/24';
			$this->zone[42] = '61.198.254.0/24';
			$this->zone[43] = '61.198.255.0/24';
			$this->zone[44] = '61.204.0.0/24';
			$this->zone[45] = '61.204.2.0/24';
			$this->zone[46] = '61.204.3.0/25';
			$this->zone[47] = '61.204.3.128/25';
			$this->zone[48] = '61.204.4.0/24';
			$this->zone[49] = '61.204.5.0/24';
			$this->zone[50] = '61.204.6.0/25';
			$this->zone[51] = '61.204.6.128/25';
			$this->zone[52] = '61.204.7.0/25';
			$this->zone[53] = '61.204.92.0/24';
			$this->zone[54] = '61.204.93.0/24';
			$this->zone[55] = '61.204.94.0/24';
			$this->zone[56] = '61.204.95.0/24';
			$this->zone[57] = '114.20.49.0/24';
			$this->zone[58] = '114.20.50.0/24';
			$this->zone[59] = '114.20.51.0/24';
			$this->zone[60] = '114.20.52.0/24';
			$this->zone[61] = '114.20.53.0/24';
			$this->zone[62] = '114.20.54.0/24';
			$this->zone[63] = '114.20.55.0/24';
			$this->zone[64] = '114.20.56.0/24';
			$this->zone[65] = '114.20.57.0/24';
			$this->zone[66] = '114.20.58.0/24';
			$this->zone[67] = '114.20.59.0/24';
			$this->zone[68] = '114.20.60.0/24';
			$this->zone[69] = '114.20.61.0/24';
			$this->zone[70] = '114.20.62.0/24';
			$this->zone[71] = '114.20.63.0/24';
			$this->zone[72] = '114.20.64.0/24';
			$this->zone[73] = '114.20.65.0/24';
			$this->zone[74] = '114.20.66.0/24';
			$this->zone[75] = '114.20.67.0/24';
			$this->zone[76] = '114.21.255.0/27';
			$this->zone[77] = '125.28.0.0/24';
			$this->zone[78] = '125.28.1.0/24';
			$this->zone[79] = '125.28.15.0/24';
			$this->zone[80] = '125.28.16.0/24';
			$this->zone[81] = '125.28.17.0/24';
			$this->zone[82] = '125.28.2.0/24';
			$this->zone[83] = '125.28.3.0/24';
			$this->zone[84] = '125.28.4.0/24';
			$this->zone[85] = '125.28.5.0/24';
			$this->zone[86] = '125.28.8.0/24';
			$this->zone[87] = '210.168.246.0/24';
			$this->zone[88] = '210.168.247.0/24';
			$this->zone[89] = '210.169.92.0/24';
			$this->zone[90] = '210.169.93.0/24';
			$this->zone[91] = '210.169.94.0/24';
			$this->zone[92] = '210.169.95.0/24';
			$this->zone[93] = '210.169.96.0/24';
			$this->zone[94] = '210.169.97.0/24';
			$this->zone[95] = '210.169.98.0/24';
			$this->zone[96] = '210.169.99.0/24';
			$this->zone[97] = '211.126.192.128/25';
			$this->zone[98] = '211.18.232.0/24';
			$this->zone[99] = '211.18.233.0/24';
			$this->zone[100] = '211.18.234.0/24';
			$this->zone[101] = '211.18.235.0/24';
			$this->zone[102] = '211.18.236.0/24';
			$this->zone[103] = '211.18.237.0/24';
			$this->zone[104] = '219.108.10.0/24';
			$this->zone[105] = '219.108.11.0/24';
			$this->zone[106] = '219.108.12.0/24';
			$this->zone[107] = '219.108.13.0/24';
			$this->zone[108] = '219.108.14.0/24';
			$this->zone[109] = '219.108.15.0/24';
			$this->zone[110] = '219.108.7.0/24';
			$this->zone[111] = '219.108.8.0/24';
			$this->zone[112] = '219.108.9.0/24';
			$this->zone[113] = '221.119.0.0/24';
			$this->zone[114] = '221.119.1.0/24';
			$this->zone[115] = '221.119.2.0/24';
			$this->zone[116] = '221.119.3.0/24';
			$this->zone[117] = '221.119.4.0/24';
			$this->zone[118] = '221.119.6.0/24';
			$this->zone[119] = '221.119.7.0/24';
			$this->zone[120] = '221.119.8.0/24';
			$this->zone[121] = '221.119.9.0/24';
			$this->zone[122] = '127.0.0.0/24'; //テスト用
			
		}
	}//func-GetZone

	function CheckUA($agent){
		/* UserAgentからキャリアを返す */
		if(strpos($agent,"DoCoMo") !== FALSE){
			return('docomo');
		}elseif(strpos($agent,"SoftBank") !== FALSE || strpos($agent,"Vodafone") !== FALSE || strpos($agent,"J-PHONE") !== FALSE || strpos($agent,"MOT-") !== FALSE){
			return('softbank');
		}elseif(strpos($agent,"KDDI-") !== FALSE || strpos($agent,"UP.Browser/") !== FALSE){
			return('au');
		}elseif(strpos($agent,"WILLCOM") !== FALSE || strpos($agent,"DDIPOCKET") !== FALSE){
			return('willcom');
		}elseif(strpos($agent,"L-MODE") !== FALSE || strpos($agent,"Nintendo Wii;") !== FALSE || strpos($agent,"PlayStation Portable") !== FALSE || strpos($agent,"EGBROWSER") !== FALSE || strpos($agent,"AveFront") !== FALSE || strpos($agent,"PLAYSTATION 3;") !== FALSE || strpos($agent,"ASTEL") !== FALSE || strpos($agent,"PDXGW") !== FALSE){
			return('other');
		}else{
			return('pc');
		}
	}//func-CheckUA

	function CheckIP($area){
		/* IPアドレス帯域($zone)に含まれているか検査 */
		$addr = $_SERVER['REMOTE_ADDR'];

		$i = 0;
		$count = count($area);
		$flag = FALSE;

		while($i <$count){
			/* ネットワークアドレスの算出 */
			//範囲の特定
			list($ip,$sub) = explode('/',$area[$i]);
			list($mask,$plus) = $this->switchtomask($sub);
			if($mask === FALSE && $plus === FALSE) die('範囲がおかしいです(0-32まで)');

			//IP,サブネットマスクの論理積を求める
			$ip = explode('.',$ip);
			$mask = explode('.',$mask);

			//それぞれの論理積を求める
			$network[0] = bindec(decbin($ip[0]) & decbin($mask[0]));
			$network[1] = bindec(decbin($ip[1]) & decbin($mask[1]));
			$network[2] = bindec(decbin($ip[2]) & decbin($mask[2]));
			$network[3] = bindec(decbin($ip[3]) & decbin($mask[3]));

			//ロングIPアドレスへ
			$naddr = sprintf("%u", ip2long(implode('.',$network)));
			$baddr = $naddr + $plus -1;

			/* $addrが範囲内にあるか */
			//$addrをロングIPアドレス化する
			$addr = sprintf("%u", ip2long($addr));

			if($naddr <$addr && $addr <$baddr){
				$flag = TRUE;
				break;
			}

			$i++;
		}

		return $flag;

	}//func-CheckIP

	/* xxx.xxx.xxx.xxx/YYのYY→yyy.yyy.yyy.yyyへ */
	function switchtomask($sub){
		switch($sub){
			case 32 :
				$mask = '255.255.255.255';
				$plus = 1;
				break;
			case 31 :
				$mask = '255.255.255.254';
				$plus = 2;
				break;
			case 30 :
				$mask = '255.255.255.252';
				$plus = 4;
				break;
			case 29 :
				$mask = '255.255.255.248';
				$plus = 8;
				break;
			case 28 :
				$mask = '255.255.255.240';
				$plus = 16;
				break;
			case 27 :
				$mask = '255.255.255.224';
				$plus = 32;
				break;
			case 26 :
				$mask = '255.255.255.192';
				$plus = 64;
				break;
			case 25 :
				$mask = '255.255.255.128';
				$plus = 128;
				break;
			case 24 :
				$mask = '255.255.255.0';
				$plus = 256;
				break;
			case 23 :
				$mask = '255.255.254.0';
				$plus = 512;
				break;
			case 22 :
				$mask = '255.255.252.0';
				$plus = 1024;
				break;
			case 21 :
				$mask = '255.255.248.0';
				$plus = 2048;
				break;
			case 20 :
				$mask = '255.255.240.0';
				$plus = 4096;
				break;
			case 19 :
				$mask = '255.255.224.0';
				$plus = 8192;
				break;
			case 18 :
				$mask = '255.255.192.0';
				$plus = 16384;
				break;
			case 17 :
				$mask = '255.255.128.0';
				$plus = 32768;
				break;
			case 16 :
				$mask = '255.255.0.0';
				$plus = 65536;
				break;
			case 15 :
				$mask = '255.254.0.0';
				$plus = 131072;
				break;
			case 14 :
				$mask = '255.252.0.0';
				$plus = 262144;
				break;
			case 13 :
				$mask = '255.248.0.0';
				$plus = 524288;
				break;
			case 12 :
				$mask = '255.240.0.0';
				$plus = 1048576;
				break;
			case 11 :
				$mask = '255.224.0.0';
				$plus = 2097152;
				break;
			case 10 :
				$mask = '255.192.0.0';
				$plus = 4194304;
				break;
			case 9 :
				$mask = '255.128.0.0';
				$plus = 8388608;
				break;
			case 8 :
				$mask = '255.0.0.0';
				$plus = 16777216;
				break;
			case 7 :
				$mask = '254.0.0.0';
				$plus = 33554432;
				break;
			case 6 :
				$mask = '252.0.0.0';
				$plus = 67108864;
				break;
			case 5 :
				$mask = '248.0.0.0';
				$plus = 134217728;
				break;
			case 4 :
				$mask = '240.0.0.0';
				$plus = 268435456;
				break;
			case 3 :
				$mask = '224.0.0.0';
				$plus = 536870912;
				break;
			case 2 :
				$mask = '192.0.0.0';
				$plus = 1073741824;
				break;
			case 1 :
				$mask = '128.0.0.0';
				$plus = 2147483648;
				break;
			case 0 :
				$mask = '0.0.0.0';
				$plus = 4294967296;
				break;
			default :
				$mask = FALSE;
				$plus = FALSE;
				break;
		}
		return array($mask,$plus);
	}//func-switchtomask
}//class-MobileCheck
?>