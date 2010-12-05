<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login(true);

$order_id = abs(intval($_GET['id']));
$order = Table::Fetch('order', $order_id);
if (!$order) {
	Session::Set('error',ORDER_CHECK_ERROR);
	Utility::Redirect( WEB_ROOT . '/index.php' );
}
$team = Table::Fetch('team', $order['team_id']);
$team['state'] = team_state($team);

if ( $team['close_time'] ) {
	Utility::Redirect( WEB_ROOT . "/team.php?id={$order['team_id']}");
}
$errMsg = null;
if ( $order['state'] == 'unpay' ) {

	$gp = new GmoPayment();
	$member_id = $login_user['email'];
	
	if( $_POST )
	{		
		$update = array(
			'realname' => $_POST['realname'], 
			'zipcode' => $_POST['zipcode'],
			'address' => $_POST['address'],
		);
		$card_post['HolderName'] = trim($_POST['HolderName']);
		$card_post['CardNo'] = trim($_POST['CardNo']);
		$card_post['CardPass'] = trim($_POST['CardPass']);
		$card_post['Expire'] = substr($_POST['ExpireYear'],2,2) . $_POST['ExpireMonth'];
		
		//名前
		if($_POST['realname'])
		{
			if(Utility::ValidStrlen($update['realname'],2,32))
			{
				$errMsg = $errMsg.ACCUONT_SETTINGS_REALNAME_LENGTH_INVALID."</br>";
			}
		}
		//郵便番号
		if($_POST['zipcode'])
		{
			if(!Utility::IsZipcode($update['zipcode']))
			{
				$errMsg = $errMsg.ACCUONT_SETTINGS_ZIPCODE_INVALID."</br>";
			}
		}
		
		//creditcard check
		if($card_post['CardNo'])
		{
			if(Utility::ValidStrlen($card_post['CardNo'],10,16))
			{
				$errMsg = $errMsg. ORDER_GMOPAY_INVALID_CREDITCARD_NO."</br>";
			}
		}
		if(!$errMsg)
		{
			if ( ZUser::Modify($login_user['id'], $update) ) {
				
				$order['realname'] = $_POST['realname'];
				$order['zipcode'] = $_POST['zipcode'];
				$order['address'] = $_POST['address'];				
				
				$table = new Table('order', $order);
				
				$update_fields = array(
						'address', 'zipcode', 'realname'
					);
				
				$table->Update($update_fields);
				
				if( !$gp->existMember($member_id) )
				{
					if($gp->addMember($member_id)===false)
					{
						$errMsg = $errMsg.$gp->getErrorMessage();
					}
				}
				
				$creditcard = $gp->getCard($member_id);
			
				if( $creditcard === false )
				{
					if($gp->addNewCard($member_id, $card_post)===false)
					{
						$errMsg = $errMsg.$gp->getErrorMessage();
					}
				}
				else 
				{
					if($gp->saveCard($member_id, $card_post)===false)
					{
						$errMsg = $errMsg. $gp->getErrorMessage();
					}
					else 
					{
						Utility::Redirect(WEB_ROOT."/order/check.php?id={$order_id}");
					}
				}				
			} else {
				$errMsg = ACCUONT_SETTINGS_SETTINGS_FAILED;
			}
		}
	} else 
	{
		$update = array(
			'realname' => $login_user['realname'], 
			'zipcode' => $login_user['zipcode'],
			'address' => $login_user['address'],
		);

		$creditcard = $gp->getCard($member_id);
		
	}
	
	if($errMsg)
	{
		Session::Set('error',$errMsg);
	}
	die(include template('order_gmopay'));
}
Utility::Redirect( WEB_ROOT . "/order/view.php?id={$order_id}");
