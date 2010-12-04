<?php
class GmoPayment
{
	const CARD_CHK_NUM 	= '9';
	const JOB_CHECK 	= 'CHECK';		//CHECK:有効性チェック
	const JOB_AUTH 		= 'AUTH';		//AUTH:仮売上
	const JOB_CAPTURE 	= 'CAPTURE';	//CAPTURE:即時売上
	const JOB_SALES		= 'SALES';		//実売上
	
	const ORDER_PRE		= '168';		//order prefix
	
	const SEQMODE_LOGIC  = '0';			//カード連番モード論理
	const SEQMODE_PHYSICS = '1';		//カード連番モード物理
	
	
	private $_error_message;

	var $_message_map = null;
	
	function GmoPayment(){
		$this->_message_map = array(
			'E00000000'=>'特になし',
			'E01010001'=>'ショップIDが指定されていません。',
			'E01020001'=>'ショップパスワードが指定されていません。',
			'E01030002'=>'指定されたIDとパスワードのショップが存在しません。',
			'E01040001'=>'オーダーIDが指定されていません。',
			'E01040003'=>'オーダーIDが最大文字数を超えています。',
			'E01040010'=>'既にオーダーIDが存在しています。',
			'E01040013'=>'オーダーIDに不正な文字が存在します。',
			'E01050001'=>'処理区分が指定されていません。',
			'E01050002'=>'指定された処理区分は定義されていません。',
			'E01050004'=>'指定した処理区分の処理は実行出来ません。',
			'E01060001'=>'利用金額が指定されていません。',
			'E01060005'=>'利用金額が最大桁数を超えています。',
			'E01060006'=>'利用金額に数字以外の文字が含まれています。',
			'E01070005'=>'税送料が最大桁数を超えています。',
			'E01070006'=>'税送料に数字以外の文字が含まれています。',
			'E01080007'=>'3Dセキュア使用フラグに0,1以外の値が指定されています。',
			'E01090001'=>'取引IDが指定されていません。',
			'E01100001'=>'取引パスワードが指定されていません。',
			'E01110002'=>'指定されたIDとパスワードの取引が存在しません。',
			'E01120008'=>'カード種別の書式が誤っています。',
			'E01130002'=>'指定されたカード略称が存在しません。',
			'E01140007'=>'対応支払方法に0,1以外の値が指定されています。',
			'E01140003'=>'対応支払方法が最大文字数を超えています。',
			'E01150007'=>'対応分割回数に0,1以外の値が指定されています。',
			'E01160007'=>'対応ボーナス分割回数に0,1以外の値が指定されています。',
			'E01170001'=>'カード番号が指定されていません。',
			'E01170003'=>'カード番号が最大文字数を超えています。',
			'E01170006'=>'カード番号に数字以外の文字が含まれています。',
			'E01170011'=>'カード番号が10桁～16桁の範囲ではありません。',
			'E01180001'=>'有効期限が指定されていません。',
			'E01180003'=>'有効期限が4桁ではありません。',
			'E01180006'=>'有効期限に数字以外の文字が含まれています。',
			'E01190001'=>'サイトIDが指定されていません。',
			'E01200001'=>'サイトパスワードが指定されていません。',
			'E01210002'=>'指定されたIDとパスワードのサイトが存在しません。',
			'E01220001'=>'会員IDが指定されていません。',
			'E01230001'=>'カード登録連番が指定されていません。',
			'E01230006'=>'カード登録連番に数字以外の文字が含まれています。',
			'E01230009'=>'カード登録連番が最大登録可能数を超えています。',
			'E01240002'=>'指定されたサイトIDと会員ID、カード連番のカードが存在しません。',
			'E01250010'=>'カードパスワードが一致しません。',
			'E01260001'=>'支払方法が指定されていません。',
			'E01250002'=>'指定された支払方法が存在しません。',
			'E01260010'=>'指定された支払方法はご利用できません。',
			'E01270001'=>'支払回数が指定されていません。',
			'E01270005'=>'支払回数が1～2桁ではありません。',
			'E01270006'=>'支払回数の数字以外の文字が含まれています。',
			'E01270010'=>'指定された支払回数はご利用できません。',
			'E01280012'=>'加盟店URLの値が最大バイト数を超えています。',
			'E01290001'=>'HTTP_ACCEPTが指定されていません。',
			'E01300001'=>'HTTP_USER_AGENTが指定されていません。',
			'E01310001'=>'使用端末が指定されていません。',
			'E01310007'=>'使用端末に0,1以外の値が指定されています。',
			'E01320012'=>'加盟店自由項目1の値が最大バイト数を超えています。',
			'E01330012'=>'加盟店自由項目2の値が最大バイト数を超えています。',
			'E01340012'=>'加盟店自由項目3の値が最大バイト数を超えています。',
			'E01350001'=>'MDが指定されていません。',
			'E01360001'=>'PaREsが指定されていません。',
			'E01370012'=>'3Dセキュア表示店舗名の値が最大バイト数を超えています。',
			'E01380007'=>'決済方法フラグに0,1以外の値が指定されています。',
			'E01390002'=>'指定されたサイトIDと会員IDの組み合わせが存在しません。',
			'E01390010'=>'指定されたサイトIDと会員IDの組み合わせは既に存在しています。',
			'E11010001'=>'この取引は既に決済が終了しています。',
			'E11010002'=>'この取引は決済が終了していませんので、変更する事が出来ません。',
			'E11010003'=>'この取引は指定処理区分処理を行う事が出来ません。',
			'E21010001'=>'3Dセキュア認証に失敗しました。もう一度、購入画面からやり直して下さい。',
			'E21020001'=>'3Dセキュア認証に失敗しました。もう一度、購入画面からやり直して下さい。',
			'E21020002'=>'3Dセキュア認証がキャンセルされました。もう一度、購入画面からやり直して下さい。',
			'E41170002'=>'入力されたカードの会社には対応していません。別のカード番号を入力して下さい。',
			'E41170099'=>'カード番号に誤りがあります。再度確認して入力して下さい。',
			'E61010001'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'E61010002'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'E61010003'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'E90010001'=>'現在処理を行っているのでもうしばらくお待ち下さい。',
			'E91019999'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'E91029999'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'E91099999'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C010000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C030000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C120000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C130000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C140000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C150000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C500000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C510000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C530000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C540000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C550000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C560000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C570000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C580000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C600000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C700000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C710000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C720000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C730000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C740000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C750000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C760000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C770000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42C780000'=>'決済処理に失敗しました。申し訳ございませんが、しばらくした後にもう一度購入画面からやり直してください。',
			'42G020000'=>'カード残高が不足しているために、決済が完了できませんでした。',
			'42G030000'=>'カード限度額を超えているために、決済が完了できませんでした。',
			'42G040000'=>'カード残高が不足しているために、決済が完了できませんでした。',
			'42G050000'=>'カード限度額を超えているために、決済が完了できませんでした。',
			'42G120000'=>'このカードでは取引をする事が出来ません。',
			'42G220000'=>'このカードでは取引をする事が出来ません。',
			'42G300000'=> '',
			'42G420000'=>'暗証番号が誤っていた為に、決済を完了する事が出来ませんでした。',
			'42G540000'=>'このカードでは取引をする事が出来ません。',
			'42G550000'=>'カード限度額を超えているために、決済が完了できませんでした。',
			'42G560000'=>'',
			'42G600000'=>'このカードでは取引をする事が出来ません。',
			'42G610000'=>'このカードでは取引をする事が出来ません。',
			'42G650000'=>'カード番号に誤りがあるために、決済を完了できませんでした。',
			'42G670000'=>'商品コードに誤りがあるために、決済を完了できませんでした。',
			'42G680000'=>'金額に誤りがあるために、決済を完了できませんでした。',
			'42G690000'=>'税送料に誤りがあるために、決済を完了できませんでした。',
			'42G700000'=>'ボーナス回数に誤りがあるために、決済を完了できませんでした。',
			'42G710000'=>'ボーナス月に誤りがあるために、決済を完了できませんでした。',
			'42G720000'=>'ボーナス額に誤りがあるために、決済を完了できませんでした。',
			'42G730000'=>'支払開始月に誤りがあるために、決済を完了できませんでした。',
			'42G740000'=>'分割回数に誤りがあるために、決済を完了できませんでした。',
			'42G750000'=>'分割金額に誤りがあるために、決済を完了できませんでした。',
			'42G760000'=>'初回金額に誤りがあるために、決済を完了できませんでした。',
			'42G770000'=>'業務区分に誤りがあるために、決済を完了できませんでした。',
			'42G780000'=>'支払区分に誤りがあるために、決済を完了できませんでした。',
			'42G790000'=>'照会区分に誤りがあるために、決済を完了できませんでした。',
			'42G800000'=>'取消区分に誤りがあるために、決済を完了できませんでした。',
			'42G810000'=>'取消取扱区分に誤りがあるために、決済を完了できませんでした。',
			'42G830000'=>'有効期限に誤りがあるために、決済を完了できませんでした。',
			'42G950000'=>'',
			'42G960000'=>'このカードでは取引をする事が出来ません。',
			'42G970000'=>'このカードでは取引をする事が出来ません。',
			'42G980000'=>'このカードでは取引をする事が出来ません。',
			'42G990000'=>'このカードでは取引をする事が出来ません。'	,
			'E01250008'=>'カードパスワードの書式が正しくありません。',
		);
	}
	
	private function _getErrorMessage( $errorInfo ){
		if( array_key_exists( $errorInfo , $this->_message_map )){
			return $this->_message_map[ $errorInfo ];
		}
		return 'エラーコード表をご確認ください。';
	}
	
	public function getErrorMessage()
	{
		return $this->_error_message;
	}
	
	public function saveCard($member_id, $card, $card_seq='0', $seq_mode='0')
	{
		require_once( 'com/gmo_pg/client/input/SaveCardInput.php');
		require_once( 'com/gmo_pg/client/tran/SaveCard.php');

	
		//入力パラメータクラスをインスタンス化します
		$input = new SaveCardInput();/* @var $input SaveCardInput */

		$config = Config::Instance('php');
		$input->setSiteId( $config['GMO']['PGCARD_SITE_ID'] );
		$input->setSitePass( $config['GMO']['PGCARD_SITE_PASS'] );
		
		//会員IDは必須です
		$input->setMemberId( $member_id );
		
		//登録カード連番
		$input->setCardSeq( $card_seq );
		$input->setSeqMode( $seq_mode );	
				
		$input->setCardNo( $card['CardNo'] );
		$input->setCardPass( $card['CardPass'] );
		$input->setExpire( $card['Expire'] );
		$input->setHolderName( $card['HolderName']);
		//$input->setCardName( $card['CardName']);
		//$input->setDefaultFlag( $card['DefaultFlag']);
		
		//API通信クラスをインスタンス化します
		$exe = new SaveCard();/* @var $exec SearchCard */
		
		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec( $input );/* @var $output SaveCardOutput */
	
		//var_dump($card);
		//実行後、その結果を確認します。
		return($this->_isSuccess($exe, $output));
		
	}
	
	private function _isSuccess($exe, $output)
	{
		if( $exe->isExceptionOccured() ){//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
	
			//サンプルでは、例外メッセージを表示して終了します。
			$exception = $exe->getException();	
			$this->_error_message = $exception->getMessage();
			return false;			
		}else{
			
			//例外が発生していない場合、出力パラメータオブジェクトが戻ります。
			
			if( $output->isErrorOccurred() ){//出力パラメータにエラーコードが含まれていないか、チェックしています。
				
				$errorList = $output->getErrList();
				
				$errMsg = "";
				foreach( $errorList as  $errorInfo ){/* @var $errorInfo ErrHolder */			
					$errMsg .= '<li>'
						. $errorInfo->getErrCode()
						. ':' . $errorInfo->getErrInfo()
						. ':' . $this->_getErrorMessage($errorInfo->getErrInfo())
						.'</li>';
				}
				$this->_error_message = $errMsg;
				return false;
			}
	
			//例外発生せず、エラーの戻りもないので、正常とみなします。
			//このif文を抜けて、結果を表示します。
			$this->_error_message = "";
			return true;
		}
	}
	
	public function getCard($member_id, $card_seq='0', $seq_mode='0')
	{
		require_once( 'com/gmo_pg/client/input/SearchCardInput.php');
		require_once( 'com/gmo_pg/client/tran/SearchCard.php');
		
		//入力パラメータクラスをインスタンス化します
		$input = new SearchCardInput();/* @var $input SearchCardInput */
		
		//このサンプルでは、サイトID・パスワードはコンフィグファイルで
		//定数defineしています。
		$config = Config::Instance('php');
		$input->setSiteId( $config['GMO']['PGCARD_SITE_ID'] );
		$input->setSitePass( $config['GMO']['PGCARD_SITE_PASS'] );
		
		//会員IDは必須です
		$input->setMemberId( $member_id );
		
		//登録カード連番
		$input->setCardSeq( $card_seq );
		$input->setSeqMode( $seq_mode );	
				
		//API通信クラスをインスタンス化します
		$exe = new SearchCard();/* @var $exec SearchCard */
		
		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec( $input );/* @var $output SearchCardOutput */

		
		
		//実行後、その結果を確認します。
		if($this->_isSuccess($exe, $output) === false)
		{
			return false;
		}
		
		$cardList = $output->getCardList();

		foreach( $cardList as $card )
		{
			if( $card['CardSeq'] === $card_seq)
			{
				return $card;
			}
		}
		
		$this->_error_message = "CardSeqが「$card_seq」のカードが存在しません";
		
		return false;
	}
	
	public function existMember($member_id)
	{
		require_once( 'com/gmo_pg/client/input/SearchMemberInput.php');
		require_once( 'com/gmo_pg/client/tran/SearchMember.php');
		
		//入力パラメータクラスをインスタンス化します
		$input = new SearchMemberInput();/* @var $input SearchMemberInput */
		
		//このサンプルでは、サイトID・パスワードはコンフィグファイルで
		//定数defineしています。
		$config = Config::Instance('php');
		$input->setSiteId( $config['GMO']['PGCARD_SITE_ID'] );
		$input->setSitePass( $config['GMO']['PGCARD_SITE_PASS'] );
		
		//会員IDは必須です
		$input->setMemberId( $member_id );
				
		//API通信クラスをインスタンス化します
		$exe = new SearchMember();/* @var $exec SearchMember */
		
		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec( $input );/* @var $output SearchMemberOutput */
	
		//実行後、その結果を確認します。
		return $this->_isSuccess($exe, $output);		
	}
	
	public function addMember($member_id, $member_name)
	{
		require_once( 'com/gmo_pg/client/input/SaveMemberInput.php');
		require_once( 'com/gmo_pg/client/tran/SaveMember.php');
		
		//入力パラメータクラスをインスタンス化します
		$input = new SaveMemberInput();/* @var $input SaveMemberInput */
		
		//このサンプルでは、サイトID・パスワードはコンフィグファイルで
		//定数defineしています。
		$config = Config::Instance('php');
		$input->setSiteId( $config['GMO']['PGCARD_SITE_ID'] );
		$input->setSitePass( $config['GMO']['PGCARD_SITE_PASS'] );
		
		//会員IDは必須です
		$input->setMemberId( $member_id );

		//会員名称は任意です。
		$input->setMemberName( mb_convert_encoding( $member_name , 'SJIS') );
		
		//API通信クラスをインスタンス化します
		$exe = new SaveMember();/* @var $exec SaveMember */
		
		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec( $input );/* @var $output SaveMemberOutput */
	
		//実行後、その結果を確認します。
		return $this->_isSuccess($exe, $output);
	}
	
	public function getGmoOrderId($order_id)
	{
		return GmoPayment::ORDER_PRE . $order_id;
	}
	
	
	// クーポンが成立したあと、この関数で決済有効状態に変更する。
	public function confirmTran($order_id)
	{
		$output = $this->seachTrande($order_id);
		
		if( $output=== false )
		{
			return false;
		}
		
		require_once( 'com/gmo_pg/client/input/AlterTranInput.php');
		require_once( 'com/gmo_pg/client/tran/AlterTran.php');
		
		//入力パラメータクラスをインスタンス化します
		$input = new AlterTranInput();/* @var $input AlterTranInput */
		
		//各種パラメータを設定します。
		$config = Config::Instance('php');
		
		$input->setShopId( $config['GMO']['PGCARD_SHOP_ID'] );
		$input->setShopPass( $config['GMO']['PGCARD_SHOP_PASS'] );
		
		$input->setAccessId( $output->getAccessID());
		$input->setAccessPass( $output->getAccessPass() );
		
		$input->setJobCd( GmoPayment::JOB_SALES );
		
		$input->setAmount( $output->getAmount());
		$input->setTax($output->getTax());
		
		//支払方法に応じて、支払回数のセット要否が異なります。
		$input->setMethod( '1' );
		//$input->setPayTimes('1');

		//API通信クラスをインスタンス化します
		$exe = new AlterTran();/* @var $exec AlterTran */
		
		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec( $input );/* @var $output AlterTranOutput */
	
		//実行後、その結果を確認します。
		return $output;
	}
	
	// クーポンを購入するときに、この関数でしはらい
	public function execTranByMemberId($order_id, $amount, $member_id)
	{
		$output = $this->getTrande($order_id, $amount);
		if($output!==false)
		{
			return $output;
		}
		
		require_once( 'com/gmo_pg/client/input/ExecTranInput.php');
		require_once( 'com/gmo_pg/client/tran/ExecTran.php');
		
		//入力パラメータクラスをインスタンス化します
		$input = new ExecTranInput();/* @var $input ExecTranInput */
		
		//各種パラメータを設定します。
	
		//カード番号入力型・会員ID決済型に共通する値です。
		$input->setAccessId( $output->getAccessId() );
		$input->setAccessPass( $output->getAccessPass() );
		$input->setOrderId( $this->getGmoOrderId($order_id) );
		
		//支払方法に応じて、支払回数のセット要否が異なります。
		$input->setMethod( '1' );	//一括で
		
		//このサンプルでは、加盟店自由項目１～３を全て利用していますが、これらの項目は任意項目です。
		//利用しない場合、設定する必要はありません。
		//また、加盟店自由項目に２バイトコードを設定する場合、SJISに変換して設定してください。
		//$input->setClientField1( mb_convert_encoding( $_POST['ClientField1'] , 'SJIS' , PGCARD_SAMPLE_ENCODING ) );
		//$input->setClientField2( mb_convert_encoding( $_POST['ClientField2'] , 'SJIS' , PGCARD_SAMPLE_ENCODING ) );
		//$input->setClientField3( mb_convert_encoding( $_POST['ClientField3'] , 'SJIS' , PGCARD_SAMPLE_ENCODING ) );
		
				
		//ここでは、「画面で会員IDが入力されたか」を判断基準にして、
		//決済のタイプを判別しています。
		$memberId = $member_id;
		
		//サンプルでは、サイトID・サイトパスワードはコンスタント定義しています。
		$input->setSiteId( PGCARD_SITE_ID );
		$input->setSitePass( PGCARD_SITE_PASS );
			
		//会員IDは必須です。
		$input->setMemberId( $memberId );
		
		//登録カード連番は'0'です。		
		$input->setCardSeq( '0' );
		
			
		//API通信クラスをインスタンス化します
		$exe = new ExecTran();/* @var $exec ExecTran */
		
		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec( $input );/* @var $output ExecTranOutput */

		return $output;
	}
	
	public function getTrande($order_id, $amount, $jobcd = GmoPayment::JOB_AUTH )
	{
		$output = $this->seachTrande($order_id);
		if($output!==false)
		{
			return $output;
		}
		
		require_once( 'com/gmo_pg/client/input/EntryTranInput.php');
		require_once( 'com/gmo_pg/client/tran/EntryTran.php');
		
		//入力パラメータクラスをインスタンス化します
		$input = new EntryTranInput();/* @var $input EntryTranInput */
		
		//このサンプルでは、サイトID・パスワードはコンフィグファイルで
		//定数defineしています。
		$config = Config::Instance('php');
		$input->setShopId( $config['GMO']['PGCARD_SHOP_ID'] );
		$input->setShopPass( $config['GMO']['PGCARD_SHOP_PASS'] );
		
		//各種パラメータを設定しています。
		//実際には、処理区分や利用金額、オーダーIDといったパラメータをカード所有者が直接入力することは無く、
		//購買内容を元に加盟店様システムで生成した値が設定されるものと思います。
		$input->setJobCd( $jobcd );
		$input->setOrderId( $this->getGmoOrderId($order_id) );
		$input->setAmount($amount);
		
		//API通信クラスをインスタンス化します
		$exe = new EntryTran();/* @var $exec EntryTran */
		
		//パラメータオブジェクトを引数に、実行メソッドを呼び、結果を受け取ります。
		$output = $exe->exec( $input );/* @var $output EntryTranOutput */
	
		
		//実行後、その結果を確認します。		
		if( $this->_isSuccess($exe, $output) === false)
		{
			return false;
		}
		
		return $output;
	}
	
	public function seachTrande($order_id)
	{
		require_once( 'com/gmo_pg/client/input/SearchTradeInput.php');
		require_once( 'com/gmo_pg/client/tran/SearchTrade.php');
		
		//入力パラメータクラスをインスタンス化します
		$input = new SearchTradeInput();/* @var $input SearchTradeInput */
		
		//各種パラメータを設定します。
	
		//カード番号入力型・会員ID決済型に共通する値です。
		$config = Config::Instance('php');
		$input->setShopId( $config['GMO']['PGCARD_SHOP_ID'] );
		$input->setShopPass( $config['GMO']['PGCARD_SHOP_PASS'] );		
		$input->setOrderId( $this->getGmoOrderId($order_id) );
		
		//API通信クラスをインスタンス化します
		$exe = new SearchTrade();/* @var $exec SearchTrade */
		
		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec( $input );/* @var $output SearchTradeOutput */
		
		//実行後、その結果を確認します。		
		if( $this->_isSuccess($exe, $output) === false)
		{
			return false;
		}
		
		return $output;
	}
	
	public function addNewCard($member_id, $card)
	{
		require_once( 'com/gmo_pg/client/input/EntryTranInput.php');
		require_once( 'com/gmo_pg/client/tran/EntryTran.php');
		
		$order_id = GmoPayment::CARD_CHK_NUM . $card['CardNo'] . $card['Expire'] . substr(time(),-5);
		
		//入力パラメータクラスをインスタンス化します
		$input = new EntryTranInput();/* @var $input EntryTranInput */
		
		//このサンプルでは、サイトID・パスワードはコンフィグファイルで
		//定数defineしています。
		$config = Config::Instance('php');
		$input->setShopId( $config['GMO']['PGCARD_SHOP_ID'] );
		$input->setShopPass( $config['GMO']['PGCARD_SHOP_PASS'] );
		
		//各種パラメータを設定しています。
		//実際には、処理区分や利用金額、オーダーIDといったパラメータをカード所有者が直接入力することは無く、
		//購買内容を元に加盟店様システムで生成した値が設定されるものと思います。
		$input->setJobCd( GmoPayment::JOB_CHECK );
		$input->setOrderId( $order_id );
		
		//API通信クラスをインスタンス化します
		$exe = new EntryTran();/* @var $exec EntryTran */
		
		//パラメータオブジェクトを引数に、実行メソッドを呼び、結果を受け取ります。
		$output = $exe->exec( $input );/* @var $output EntryTranOutput */
	
		
		//実行後、その結果を確認します。		
		if( $this->_isSuccess($exe, $output) === false)
		{
			return false;
		}
		
		$access_id = $output->getAccessId();
		$access_pass = $output->getAccessPass();
		
		require_once( 'com/gmo_pg/client/input/ExecTranInput.php');
		require_once( 'com/gmo_pg/client/tran/ExecTran.php');
		
		//入力パラメータクラスをインスタンス化します
		$input = new ExecTranInput();/* @var $input ExecTranInput */
		
		//各種パラメータを設定します。
	
		//カード番号入力型・会員ID決済型に共通する値です。
		$input->setAccessId( $access_id );
		$input->setAccessPass( $access_pass );
		$input->setOrderId( $order_id );
		
		//カード番号・有効期限は必須です。
		$input->setCardNo( $card['CardNo'] );
		$input->setExpire( $card['Expire'] );
		
		//セキュリティコードは任意です。
		$input->setSecurityCode( $card['CardPass'] );
		
		//API通信クラスをインスタンス化します
		$exe = new ExecTran();/* @var $exec ExecTran */
		
		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec( $input );/* @var $output ExecTranOutput */
	
		//実行後、その結果を確認します。
		var_dump($input);
		var_dump($output);
		if( $this->_isSuccess($exe, $output) === false)
		{
			return false;
		}
		
		require_once( 'com/gmo_pg/client/input/TradedCardInput.php');
		require_once( 'com/gmo_pg/client/tran/TradedCard.php');
		
		//入力パラメータクラスをインスタンス化します
		$input = new TradedCardInput();/* @var $input TradedCardInput */
		
		//このサンプルでは、ショップID・サイトID・パスワードはコンフィグファイルで
		//定数defineしています。
		$input->setSiteId( $config['GMO']['PGCARD_SITE_ID'] );
		$input->setSitePass( $config['GMO']['PGCARD_SITE_PASS'] );
		$input->setShopId( $config['GMO']['PGCARD_SHOP_ID'] );
		$input->setShopPass( $config['GMO']['PGCARD_SHOP_PASS'] );
		
		
		//登録したい取引と、会員IDを指定します。
		$input->setMemberId( $member_id );
		$input->setOrderId( $order_id );
		$input->setSeqMode(GmoPayment::SEQMODE_LOGIC);
		$input->setHolderName($card['HolderName']);
		
		//API通信クラスをインスタンス化します
		$exe = new TradedCard();/* @var $exec TradedTran */
		
		//パラメータオブジェクトを引数に、実行メソッドを呼びます。
		//正常に終了した場合、結果オブジェクトが返るはずです。
		$output = $exe->exec( $input );/* @var $output TradedCardOutput */
		
		var_dump($input);
		var_dump($output);
		
		return ( $this->_isSuccess($exe, $output) );
	}	
}