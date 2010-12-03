<div id="footer" style="background-color: #514c46;">
	<div style="text-align: center;">
		<div style="background-color: #e1e1c9; padding: 5px 5px; border-bottom: 1px #000000 solid;border-top: 1px #000000 solid;">
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
	<div>
		<div></div>
	</div>
	</div>
	<div style="background-color: #555553; padding: 5px;">
		<table style="width: 100%;">
			<tr>
				<td style="color: #ffffff;font-size: 12px;">メール友達に送信 <a name="share" href="mailto:?subject=<?php echo $INI['system']['abbreviation']; ?>&amp;body=https://<?php echo $_SERVER['SERVER_NAME']; ?>"  style="text-decoration: none;">
				<img src="/static/css/i/logo_email.gif" alt="mail" title=""	width="16" height="16" border="0" /></a>
				</td>
				<td align='right'>	
				<a href="/index.php" style="font-size: 12px;"><span
				style="color: #ffffff;">TOP</span></a>
				</td>
			</tr>
		</table>
	</div>
	<table style="width: 100%; font-size: 12px; margin-left: 3px;">
		<tr>
			<td style="width: 35%">
			<div style="font-size: 12px;"><a href="/help/faqs.php"><span
				style="color: #ffffff;">よくあるご質問</span></a></div>
			</td>
			<td style="width: 30%">
			<div style="font-size: 12px;"><a href="/about/contact.php"><span
				style="color: #ffffff;">お問い合わせ</span></a></div>
			</td>
	
			<td style="width: 30%">
			<div style="font-size: 12px;"><a href="/about/job.php"><span
				style="color: #ffffff;">会社概要</span></a></div>
			</td>
		</tr>
		<tr>
			<td style="width: 35%">
			<div style="font-size: 12px;"><a href="/about/tokuteisyou.php"><span
				style="color: #ffffff;">特定商取引法に基づく表記</span></a></div>
			</td>
			<td style="width: 30%">
			<div style="font-size: 12px;"><a href="/about/corporate.php"><span
				style="color: #ffffff;">法人の皆様へ</span></a></div>
			</td>
			<td style="width: 30%">
			<div style="font-size: 12px;"><a href="/about/terms.php"><span
				style="color: #ffffff;">利用規約</span></a></div>
			</td>
		</tr>
		<tr>
			<td style="width: 35%">
			<div style="font-size: 12px;"><a href="/about/member.php"><span
				style="color: #ffffff;">会員規約</span></a></div>
			</td>
			<td style="width: 30%">
			<div style="font-size: 12px;"><a href="/about/privacy.php"><span
				style="color: #ffffff;">プライバシーポリシー</span></a></div>
			</td>
			<td style="width: 30%">
			<div style="font-size: 12px;"><a href="/account/secret.php"><span
				style="color: #ffffff;">ユーポン確認システム</span></a></div>
			</td>
		</tr>
	</table>
</div>
<?php include template("html_footer");?>