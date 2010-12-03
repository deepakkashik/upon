<?php include template("header");?>
<?php if($team['close_time']){?>
<div id="sysmsg-tip" class="sysmsg-tip-deal-close"><div class="sysmsg-tip-content">終了いたしました</div></div>
<?php }?>
<?php if($order){?>
<div id="sysmsg-tip" ><div class="sysmsg-tip-content">決済が完了していません<a href="/order/check.php?id=<?php echo $order['id']; ?>">オーダーを確認して決済を完了</a></div></div>
<?php }?>
<div id="content" style="width: 100%; font-family: arial, sans-serif;">
<div
	style="background-color: #44abaf; padding: 6px 10px; border-bottom: 2px #fbf3cf solid;">
<?php if($team['close_time']==0){?> 
<span style="margin: 0px; font-weight: bold; font-size: 20px;">本日のクーポン</span>
<?php } else { ?>
<span style="margin: 0px; font-weight: bold; font-size: 20px;"><?php echo $city['name']; ?>のクーポン</span>
<?php }?>

</div>

<div style="background-color: #a2def0; padding: 5px; font-weight: bold;">
<table style="width: 100%; font-size: 12px;">
	<tr>
		<td style="width: 40%">
		<div><img alt="<?php echo $team['title_m']; ?>"
			src="<?php echo team_image($team['image_m']); ?>" width="91" height="100"></div>
		</td>
		<td valign="top" style="width: 60%;">
		<div>
			<span style="margin: 0px;font-weight:bold;font-size: 20px;"><img
				src="/static/css/i/bg-special-price.png" alt="Upon"
				width="40" height="40" /><?php echo round($discount_rate*100); ?>%</span>
			</div>
		
		<div style="padding: 5px; font-size: 12px;"><?php echo $team['title_m']; ?></div>
		</td>
	</tr>
</table>
</div>
<?php if($team['close_time']){?>
<?php if($team['min_number']>0){?>
<div style="background-color: #e1e1c9; padding: 2px 10px; font-size: 12;">
<span>現在</span> <span style="font-size: 16px; color: #e62d66;"><?php echo $team['now_number']; ?></span>人購入。成立
</div>
<?php } else { ?>
<div style="background-color: #e1e1c9; padding: 2px 10px; font-size: 12;">
販売終了しました
</div>
<?php }?>
<?php } else { ?>
<div style="background-color: #e1e1c9; padding: 2px 10px; font-size: 12;">
<span>現在</span> <span style="font-size: 16px; color: #e62d66;"><?php echo $team['now_number']; ?></span>人購入。あと
<span style="font-size: 16px; color: #e62d66;"><?php echo $team['min_number']-$team['now_number']; ?></span>人で成立
</div>
<?php }?>
<div style="background-color: #a2def0; padding: 5px;">
<table style="width: 100%; font-size: 12px;">
	<tr>
		<td style="width: 60%; vertical-align: text-top">
		<div style="color: #000000; margin: 0px 2px; font-size: 12px;">通常価格:<?php echo number_format($team['market_price']); ?>円</div>
		<div style="color: #000000; margin: 0px 2px; font-size: 12px;">割引率:<?php echo round($discount_rate*100); ?>%</div>
		<div style="color: #000000; margin: 0px 2px; font-size: 12px;">割引額:<?php echo number_format($discount_price); ?>円</div>
		</td>
		<td style="width: 40%; vertical-align: text-top">
		<div style="width: 100%; font-size: 12px; text-align: center;">残り時間</div>
		<?php if($team['close_time']){?>
		<div
			style="background-color: #44abaf; color: #ffffff; paddingr 2px; text-align: center;">
		00:00:00</div>
		<?php } else { ?>
		<div
			style="background-color: #44abaf; color: #ffffff; paddingr 2px; text-align: center;">
		<?php if($left_day>0){?> <span><?php echo $left_day; ?></span>日<span><?php echo $left_hour; ?></span>時間<span><?php echo $left_minute; ?></span>分
		<?php } else { ?> <span><?php echo $left_hour; ?></span>時間<span><?php echo $left_minute; ?></span>分<span><?php echo $left_time; ?></span>秒
		<?php }?></div>
		<?php }?>
		</td>
	</tr>
</table>
</div>
</div>
<?php if($team['close_time']){?>
<div
	style="background-color: #20b8d4; color: #ffffff; padding: 0px 10px; text-align: right; font-size: 12px; font-weight: bold; border-bottom: 2px #fbf3cf solid; line-height: 18px">
販売終了しました</div>
	<?php } else { ?>
<div
	style="background-color: #20b8d4; color: #ffffff; padding: 0px 10px; text-align: right; font-size: 12px; font-weight: bold; border-bottom: 2px #fbf3cf solid; line-height: 18px">
<?php echo number_format($team['team_price']); ?>円<a
	href="/team/buy.php?id=<?php echo $team['id']; ?>"
	style="font-weight: bold; font-size: 16px;">購入する</a></div>
<?php }?>
<div id="deal-stuff" class="cf">
<div class="clear box box-split">
<div class="box-top"></div>
<div class="box-content cf"><?php if(trim(strip_tags($team['detail_m']))){?>
<div
	style="background-color: #44abaf; padding: 10px 10px; border-bottom: 2px #fbf3cf solid;">
<span style="margin: 0px; font-weight: bold; font-size: 20px;">クーポン詳細情報</span>
</div>
<div
	style="background-color: #a2def0; padding: 5px; border-bottom: 2px #ffffff solid; font-size: 12px;">
<?php echo $team['detail_m']; ?></div>
<?php }?> <?php if(trim(strip_tags($team['notice_m']))){?>
<div
	style="background-color: #44abaf; padding: 10px 10px; border-bottom: 2px #fbf3cf solid;">
<span style="margin: 0px; font-weight: bold; font-size: 20px;">お店の紹介</span>
</div>
<div
	style="background-color: #a2def0; padding: 5px; border-bottom: 2px #fbf3cf solid; font-size: 12px;">
<?php echo $team['notice_m']; ?></div>
<?php }?>
<div
	style="background-color: #44abaf; padding: 10px 10px; border-bottom: 2px #fbf3cf solid;">
<span style="margin: 0px; font-weight: bold; font-size: 20px;">店舗情報</span>
</div>
<div
	style="background-color: #a2def0; padding: 5px; border-bottom: 2px #fbf3cf solid;">
<table style="width: 100%; font-size: 12px;">
	<tr>
		<td style="width: 40%; vertical-align: text-top">提供店舗名</td>
		<td valign="top"
			style="width: 60%; vertical-align: text-top; padding-left: 5px;"><?php echo $partner['title']; ?></td>
	</tr>
	<tr>
		<td style="width: 40%; vertical-align: text-top">住所</td>
		<td valign="top"
			style="width: 60%; vertical-align: text-top; padding-left: 5px;"><?php echo $partner['address']; ?></td>
	</tr>
	<tr>
		<td style="width: 40%; vertical-align: text-top">電話番号</td>
		<td valign="top"
			style="width: 60%; vertical-align: text-top; padding-left: 5px;"><?php echo $partner['phone']; ?></td>
	</tr>
	<tr>
		<td style="width: 40%; vertical-align: text-top">URL</td>
		<td valign="top"
			style="width: 60%; vertical-align: text-top; padding-left: 5px;">
		<a href="<?php echo $partner['homepage']; ?>" target="_blank"><?php echo domainit($partner['homepage']); ?></a></td>
	</tr>
	<tr>
		<td style="width: 40%; vertical-align: text-top">アクセス</td>
		<td valign="top"
			style="width: 60%; vertical-align: text-top; padding-left: 5px;"><?php echo $partner['location']; ?></td>
	</tr>
	<tr>
		<td style="width: 40%; vertical-align: text-top">営業情報</td>
		<td valign="top"
			style="width: 60%; vertical-align: text-top; padding-left: 5px;"><?php echo $partner['other']; ?></td>
	</tr>
</table>
</div>

<?php if(trim(strip_tags($team['systemreview_m']))){?>
<div
	style="background-color: #44abaf; padding: 10px 10px; border-bottom: 2px #fbf3cf solid;">
<span style="margin: 0px; font-weight: bold; font-size: 20px;"><?php echo $INI['system']['abbreviation']; ?>コメント</span>
</div>
<div
	style="background-color: #a2def0; padding: 5px; border-bottom: 2px #fbf3cf solid; font-size: 12px;">
<?php echo $team['systemreview_m']; ?></div>
<?php }?></div>
</div>
</div>

<?php if($team['close_time']){?>
<div
	style="background-color: #20b8d4; color: #ffffff; padding: 0px 10px; text-align: right; font-size: 12px; font-weight: bold; line-height: 18px">
販売終了しました</div>
	<?php } else { ?>
<div
	style="background-color: #20b8d4; color: #ffffff; padding: 0px 10px; text-align: right; font-size: 12px; font-weight: bold; line-height: 18px">
<?php echo number_format($team['team_price']); ?>円<a
	href="/team/buy.php?id=<?php echo $team['id']; ?>"
	style="font-weight: bold; font-size: 16px;">購入する</a></div>
<?php }?>


<!-- bdw end --> <?php include template("footer");?>