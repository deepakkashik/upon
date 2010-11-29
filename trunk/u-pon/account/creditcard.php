<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();

$gp = new GmoPayment();

$member_id = $login_user['email'];

if ( $_POST ) 
{
	if( !$gp->existMember($member_id) )
	{
		if($gp->addMember($member_id)===false)
		{
			Session::Set('error',$gp->getErrorMessage());
		}
	}
	
	$card_post['HolderName'] = trim($_POST['HolderName']);
	$card_post['CardNo'] = trim($_POST['CardNo']);
	$card_post['CardPass'] = trim($_POST['CardPass']);
	$card_post['Expire'] = substr($_POST['ExpireYear'],2,2) . $_POST['ExpireMonth'];
	
	
	$card = $gp->getCard($member_id);
	
	if( $card === false )
	{
		if($gp->addNewCard($member_id, $card_post)===false)
		{
			Session::Set('error', $gp->getErrorMessage());
		}
	}
	else 
	{
		if($gp->saveCard($member_id, $card_post)===false)
		{
			Session::Set('error', $gp->getErrorMessage());
		}
	}
	
	Session::Set('info', 'クレジットカードを保存しました。');
	$card = $card_post;
} 
else 
{
	$card = $gp->getCard($member_id);
/*	if( $card === false )
	{
		Session::Set('error', $gp->getErrorMessage());
	}*/
}

include template('account_creditcard');
