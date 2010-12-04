<?php
class ZOrder {
	static public function CashIt($order) {
		global $login_user_id;
		if (! $order['state']=='pay' ) return 0;

		//update user money;
		$user = Table::Fetch('user', $order['user_id']);
		Table::UpdateCache('user', $order['user_id'], array(
			'money' => moneyit($user['money'] - $order['credit']),
		));

		//update order
		Table::UpdateCache('order', $order['id'], array(
			'state' => 'pay',
			'service' => 'cash',
			'admin_id' => $login_user_id,
			'money' => $order['origin'],
		));

		$order = Table::FetchForce('order', $order['id']);
		ZTeam::BuyOne($order);
	}

	static public function GetOrderJiesuan($table, $options=array()){
		$condition = isset($options['condition']) ? $options['condition'] : null;
		$one = isset($options['one']) ? $options['one'] : false;
		$offset = isset($options['offset']) ? abs(intval($options['offset'])) : 0;
		if ( $one ) {
			$size = 1;
		} else {
			$size = isset($options['size']) ? abs(intval($options['size'])) : null;
		}
		$select = isset($options['select']) ? $options['select'] : '*';
		$order = isset($options['order']) ? $options['order'] : null;
		$cache = isset($options['cache'])?abs(intval($options['cache'])):0;

		$condition = DB::BuildCondition( $condition );
		$condition = (null==$condition) ? null : "WHERE $condition";

		$limitation = $size ? "LIMIT $offset,$size" : null;

		$sql = "SELECT {$select} FROM $table $condition $order $limitation";		////`$table`改成了$table
		//echo $sql;
		//die();
		return DB::GetQueryResult( $sql, $one, $cache);
	} 
	static public function CreateFromCharge($money, $user_id, $time,$service) {
		if (!$money || !$user_id || !$time || !$service) return 0;
		$pay_id = "charge-{$user_id}-{$time}";
		$oarray = array(
			'user_id' => $user_id,
			'pay_id' => $pay_id,
			'service' => $service,
			'state' => 'pay',
			'money' => $money,
			'origin' => $money,
			'create_time' => $time,
		);
		return DB::Insert('order', $oarray);
	}
}
?>
