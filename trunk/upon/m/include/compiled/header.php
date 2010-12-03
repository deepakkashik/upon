<?php include template("html_header");?>

	<div id="header" style="background-color: #40bdab; border-bottom: 1px #000000 solid;">
		<img src="/static/css/i/mobile-logo.gif" alt="Upon" title="" width="100%" />
	</div>
	<div style="text-align: center;padding-top:0px">
		<?php if($login_user){?>
		<div style="background-color: #44abaf; width: 100%; border-bottom: 1px #000000 solid;padding-top:0px">
			<table style="width:100%;background-color:#44abaf;text-align: center;">
				<tr>					
					<td style="width:35%;background-color:#44abaf;text-align: center;">
						<a href="/account/logout.php" style="color: #FFFFFF;font-weight:bold;text-decoration: none;font-size: 12px;line-height: 24px">ログアウト</a>							
					</td>
					<td style="width:35%;background-color:#44abaf;text-align: center;">
						<a href="/order/index.php" style="color: #FFFFFF;font-weight:bold;text-decoration: none;font-size: 12px;line-height: 24px">マイページ</a>
					</td>
					<td style="width:30%;background-color:#44abaf;text-align: center;">
						<a href="#share" style="color: #FFFFFF;font-weight:bold;text-decoration: none;font-size: 12px;line-height: 24px">シェア</a>
					</td>
				</tr>
			</table>
		</div>
		<?php } else { ?>
		<div style="background-color: #44abaf; width: 100%; border-bottom: 1px #000000 solid;padding-top:0px">
			<table style="width:100%;background-color:#44abaf;text-align: center;">
				<tr>					
					<td style="width:35%;background-color:#44abaf;text-align: center;">
						<a href="/account/login.php" style="color: #FFFFFF;font-weight:bold;text-decoration: none;font-size: 12px;line-height: 24px">ログイン</a>							
					</td>
					<td style="width:35%;background-color:#44abaf;text-align: center;">
						<a href="/account/signup.php" style="color: #FFFFFF;font-weight:bold;text-decoration: none;font-size: 12px;line-height: 24px">新規登録</a>
					</td>
					<td style="width:30%;background-color:#44abaf;text-align: center;">
						<a href="#share" style="color: #FFFFFF;font-weight:bold;text-decoration: none;font-size: 12px;line-height: 24px">シェア</a>
					</td>
				</tr>
			</table>
		</div>
		<?php }?>
		<div style="background-color: #44abaf; width: 100%; border-bottom: 1px #000000 solid;">
			<table style="width:100%;background-color:#44abaf;text-align: center;">
				<tr>
					<?php echo current_frontend(); ?>
				</tr>
			</table>
		</div>
		<div style="background-color: #e1e1c9; padding: 5px 5px; border-bottom: 1px #000000 solid;">
			<form action="/city.php"  accept-charset="UTF-8;q=1, Shift_JIS;q=0.5" method="post" >
				<span style="font-size: small;" class="form-item" >
					<label for="edit-area-select">ご希望のエリア：</label>				
					<select name="ename" class="form-select" id="edit-area-select" >
						<?php echo current_city_select_list($city['ename'], $hotcities); ?>
					</select>
				</span>
				<input type="submit" name="commit" id="edit-submit-2" value="Go" /> 
			</form>
		</div>
	</div>
<?php if($session_notice=Session::Get('notice',true)){?>
<div id="sysmsg-success"><div><p><?php echo $session_notice; ?></p></div></div> 
<?php }?>
<?php if($session_notice=Session::Get('error',true)){?>
<div id="sysmsg-error"><div style="color: #FF0000; padding: 5px;"><p><?php echo $session_notice; ?></p></div></div> 
<?php }?>
