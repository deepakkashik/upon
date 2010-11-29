<?php
class ZCategory
{
	static public function GenCoupon($order_id) {
	}
	static public function AreaCoupon() {
		$today = strtotime(date('Y-m-d H:i'));
		$sql="SELECT *,(
			select count(*) from team where begin_time <= $today and
			end_time > $today and city_id = t1.id) 
			as flag 
			from (SELECT * FROM `category` WHERE `zone` = 'city' order by id) t1 ";
		$areas = DB::GetQueryResult($sql,false);
		return $areas;
	}
}
