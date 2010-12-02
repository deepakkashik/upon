<?php
//feedback/seller.php
define(FEEDBACK_SELLER_COMPLETE_FORM_SUBMIT,'请完成表单后再提交');
//feedback/success.php
//feedback/suggest.php
define(FEEDBACK_SUGGEST_COMPLETE_FORM_SUBMIT,'请完成表单后再提交');
//forum/topic.php
define(FORUM_TOPIC_PUBLISH_REPLY_SUCCEED,'发表回复成功');
define(FORUM_TOPIC_ESPACEFORUM_TITLE,"{$topic['title']} 讨论区");
//include/classes/ZCard.class.php
define(INCLUDE_CLASSES_ZCARD.CLASS_NOT_EXIST_VOUCHER,'代金券不存在');
define(INCLUDE_CLASSES_ZCARD.CLASS_NOT_USES_VOUCHER_BILL,'代金券不可用与本单');
define(INCLUDE_CLASSES_ZCARD.CLASS_VOUCHER_DENOMINATION_RESTRICTED,'代金券面额受限');
define(INCLUDE_CLASSES_ZCARD.CLASS_NOTIN_VALIDITY,'不在有效期内');
define(INCLUDE_CLASSES_ZCARD.CLASS_VOUCHER_ALREADY_USED,'代金券已被使用');
define(INCLUDE_CLASSES_ZCARD.CLASS_ONEBILL_USES_ONEVOUCHER,'每单只能用一张代金券');
define(INCLUDE_CLASSES_ZCARD.CLASS_UNKNOWN_ERROR,'未知错误');
//include/classes/ZSystem.class.php
define(INCLUDE_CLASSES_ZSYSTEM.CLASS_ZUITUWANG,'最土网');
define(INCLUDE_CLASSES_ZSYSTEM.CLASS_GIFTWARE_TUANGOU_EVERYDAY,'精品团购每一天');
define(INCLUDE_CLASSES_ZSYSTEM.CLASS_ZUITU,'最土');
define(INCLUDE_CLASSES_ZSYSTEM.CLASS_COUPON,'优惠券');
//include/compiled/about_contact.php
define(INCLUDE_COMPILED_ABOUT_CONTACT_CONTACT,'联系方式');
//include/compiled/aoubt_job.php
define(INCLUDE_COMPILED_ABOUT_JOB_JOIN_US,'加入我们');
//include/compiled/aoubt_privacy.php
define(INCLUDE_COMPILED_ABOUT_PRIVACY_PRIVACY_POLICY,'隐私声明');	
//include/compiled/aoubt_terms.php
define(INCLUDE_COMPILED_ABOUT_TERMS_USER_AGREEMENT,'用户协议');
//include/compiled/aoubt_us.php
define(INCLUDE_COMPILED_ABOUT_US_ABOUT,'关于');
//ajax/topic.php
define(AJAX_TOPIC_TOPIC_NOT_EXIST,'话题不存在');
define(AJAX_TOPIC_DELETE_TOPIC_SUCCEED,'删除帖子成功');
define(AJAX_TOPIC_ONLY_PRIMARY_TOPIC_CAN_TOP,'只有主话题才能置顶');
define(AJAX_TOPIC_SET_TOPIC_ISTOP_SUCCEED,'设置话题置顶成功');
define(AJAX_TOPIC_CANCLE_TOPIC_ISTOP_SUCCEED,'取消话题置顶成功');

//ajax/order.php
define(AJAX_ORDER_ORDER_HISTORY_NOT_EXIST,'订单记录不存在');
define(AJAX_ORDER_COUPON_USE_SUCCEED,'代金券使用成功');

//biz/down.php
define(BIZ_DOWN_NAME_TEL_ADDRESS,'姓名\t电话\t地址');
define(BIZ_DOWN_USER_EMAIL,'用户Email');
define(BIZ_DOWN_MOBILE_NUMBER,'手机号码');
define(BIZ_DOWN_IDENTIFIER,'编号');
define(BIZ_DOWN_CONSUME_PASSWORD,'消费密码');

//biz/setting.php
define(BIZ_SETTING_MODIFY_MERCHANT_INFO_SUCCEED,'修改商户信息成功');
define(BIZ_SETTING_MODIFY_MERCHANT_INFO_FAILED,'修改商户信息失败');

//coupon/print.php
define(COUPON_PRINT_SYSTEM_COUPONNAME_NOT_EXIST,"{$INI['system']['couponname']}不存在");
define(COUPON_PRINT_BILL_SYSTEM_COUPONNAME_NOT_BELONGS_YOU,"本单{$INI['system']['couponname']}不属于你");
// include/library/AlipayNotify.class.php
define(INCLUDE_LIARBRY_ALIPAYNOTIFY_NOTICE, 'DSA 签名方法待后续开发，请先使用MD5签名方式');
define(INCLUDE_LIARBRY_ALIPAYNOTIFY_NOT_SUPPORT, '支付宝暂不支持');
define(INCLUDE_LIARBRY_ALIPAYNOTIFY_SIGNATURE_TYPE, '类型的签名方式');

// include/library/AlipayService.class.php
define(INCLUDE_LIARBRY_ALIPAYNOTIFY_NOTICE, 'DSA 签名方法待后续开发，请先使用MD5签名方式');
define(INCLUDE_LIARBRY_ALIPAYNOTIFY_NOT_SUPPORT, '支付宝暂不支持');
define(INCLUDE_LIARBRY_ALIPAYNOTIFY_SIGNATURE_TYPE, '类型的签名方式');

// include/library/Pager.class.php
define(INCLUDE_LIARBRY_PAGER_FIRSTPAGE, '首页');
define(INCLUDE_LIARBRY_PAGER_LASTPAGE, '上一页');
define(INCLUDE_LIARBRY_PAGER_NEXTPAGE, '下一页');

// include/library/Utility.class.php
define(INCLUDE_LIARBRY_UTILITY_DAYTIME, '%Y-%m-%d 周%a %H:%M');
define(INCLUDE_LIARBRY_UTILITY_DAYS_AGO, '${number}天前');
define(INCLUDE_LIARBRY_UTILITY_HOURS_AGO, '${number}小时前');
define(INCLUDE_LIARBRY_UTILITY_MININUTES_AGO, '${number}分钟前');
define(INCLUDE_LIARBRY_UTILITY_JUST_NOW, '就在刚才');
define(INCLUDE_LIARBRY_UTILITY_SECONDS_AGO, '${interval}秒前');
define(INCLUDE_LIARBRY_UTILITY_SUNDAY, '日');
define(INCLUDE_LIARBRY_UTILITY_MONDAY, '一');
define(INCLUDE_LIARBRY_UTILITY_TUESDAY, '二');
define(INCLUDE_LIARBRY_UTILITY_WENSDAY, '三');
define(INCLUDE_LIARBRY_UTILITY_THURSDAY, '四');
define(INCLUDE_LIARBRY_UTILITY_FRIDAY, '五');
define(INCLUDE_LIARBRY_UTILITY_SATURDAY, '六');
define(INCLUDE_LIARBRY_UTILITY_LONGDATE, 'Y年m月d日');
define(INCLUDE_LIARBRY_UTILITY_WEEKDAY, '星期');
//feed.php
define(FEED_GROUP_BUY_TODAY,"{$INI['system']['sitename']} 今日团购");
define(FEED_GROUP_BUY_ONCE_A_DAY,"{$INI['system']['sitename']} 每天团购一次");
//install.php
define(INSTALL_DIRECTORY_WRITABLE,'include/compiled/  - 目录必须设置为可写！');
define(INSTALL_CONFIGURE_NOT_WRITE,'include/configure/ 不可写');
define(INSTALL_DATA_NOT_WRITE,'include/data/ 不可写');
define(INSTALL_TEAM_NOT_WRITE,'static/team/ 不可写');
define(INSTALL_USER_NOT_WRITE,'static/user/ 不可写');
define(INSTALL_DATABASE_NOT,'错误的数据库配置');
define(INSTALL_DATABASE_NOT_EXISTS,"选择数据库 {$db['name']} 错误，可能不存在？");
define(INSTALL_SUCCESSFUL_INSTALLATION,'最土软件安装成功，请及时删除 install.php！');
//team.php
define(TEAM_WHOLE,'全部');
//unsubscribe.php
define(UNSUBSCRIBE_UNSUBSCRIBE_IS_SUCCESSFUL,'退订成功，您不会收到每日团购信息了');
//upload.php
define(UPLOAD_DOCUMENT_NAME_ERROR,'文件域的name错误或者没选择文件');
define(UPLOAD_UPLOAD_MAX_FILESIZE,'文件大小超过了php.ini定义的upload_max_filesize值');
define(UPLOAD_MAX_FILE_SIZE,'文件大小超过了HTML定义的MAX_FILE_SIZE值');
define(UPLOAD_FILE_UPLOAD_INCOMPLETE ,'文件上传不完全');
define(UPLOAD_NO_FILE_UPLOAD ,'无文件上传');
define(UPLOAD_MISSING_A_TEMPORARY_FOLDER ,'缺少临时文件夹');
define(UPLOAD_FAILED_TO_WRITE_FILE ,'写文件失败');
define(UPLOAD_INTERRUPT ,'上传被其它扩展中断');
define(UPLOAD_NO_VALID_ERROR_CODE ,'无有效错误代码');
define(UPLOAD_FILE_SIZE ,'文件大小超过');
define(UPLOAD_BYTE ,'字节');
define(UPLOAD_UPLOAD_FILE ,'上传文件扩展名必需为：');


//account/invite.php
define(ACCUONT_INVITE_INVITED_TO_AWARDS,'邀请有奖');
//account/login.php
define(ACCUONT_LOGIN_LOGIN_FAILED,'登录失败');
//account/repass.php
define(ACCUONT_REPASS_EMAIL_NOT_REGISTRATION,'你的Email没有在本站注册');
//account/reset.php
define(ACCUONT_RESET_RESET_PASSORD_ERROR,'重设密码的链接无效');
define(ACCUONT_RESET_PASSORD_ERROR,'两次输入的密码不匹配，请重新设置');
//account/settings.php
define(ACCUONT_SETTINGS_SETTINGS_SUCCESS,'修改账户设置成功');
define(ACCUONT_SETTINGS_SETTINGS_FAILED,'修改账户设置失败');
//account/signup.php
define(ACCUONT_SIGNUP_EMAIL_INVALID_ADDRESS,'Email地址为无效地址');
define(ACCUONT_SIGNUP_USER_USE,'注册失败，用户名已被使用');
define(ACCUONT_SIGNUP_PASSWORD_ERROR,'注册失败，密码设置有问题');
//account/verify.php
define(ACCUONT_VERIFY_EMAIL_VALIDATION_SUCCESS,'恭喜！你的帐户已经通过Email验证');
//ajax/coupon.php
define(AJAX_COUPON_INVALIDATE_CID,"#{$cid}&nbsp;无效");
define(AJAX_COUPON_INVALIDATE,'无效');
define(AJAX_COUPON_CONSUME,'消费于：');
define(AJAX_COUPON_EXPIRED_CID,"#{$cid}&nbsp;已过期");
define(AJAX_COUPON_EXPIRATION_DATE,'过期日期：');
define(AJAX_COUPON_VALID_CID,"#{$cid}&nbsp;有效");
define(AJAX_COUPON_DATE_EXPIRY_E,"有效期至&nbsp;{$e}");
define(AJAX_COUPON_CONSUMER_FAILED,'本次消费失败');
define(AJAX_COUPON_NO_PASSWORD_INCORRECT,'编号密码不正确');
define(AJAX_COUPON_EXPIRATION_TIME,'过期时间：');
define(AJAX_COUPON_CONSUMED_CID,"#{$cid}&nbsp;已消费");
define(AJAX_COUPON_REBATE_COUPON_CREDIT_YUAN," 返利{$coupon['credit']}元");
define(AJAX_COUPON_VALID,'有效');
define(AJAX_COUPON_CONSUMPTION_TIME,'消费时间：');
define(AJAX_COUPON_CONSUMER_SUCCESS,'本次消费成功');
define(AJAX_COUPON_SMS_SEND_5_TIMES_COUPON,'短信发送优惠券最多5次');
define(AJAX_COUPON_ILLEGALLY_DOWNLOADING,'非法下载');
define(AJAX_COUPON_SEND_SMS_SUCCESS_CHECK_TIME,'手机短信发送成功，请及时查收');
define(AJAX_COUPON_SEND_SMS_FAILED_ERROR_CODE_CODE,"手机短信发送失败，错误码：{$code}");

//ajax/manage.php
define(AJAX_MANAGE_MONEY_BACK_SUCCESS,'退款成功');
define(AJAX_MANAGE_PAYMENT_ORDER_CANNOT_DELETED,'付款订单不能删除');
define(AJAX_MANAGE_DELETED_ORDER_ORDER_ID_SUCCESS,"删除订单 {$order['id']} 成功");
define(AJAX_MANAGE_CASH_PAYMENT_SUCCESS_PURCHASING_CUSTOM_USER_EMAIL,"现金付款成功，购买用户：{$user['email']}");
define(AJAX_MANAGE_GROUP_PURCHASE_PAYMENT_ORDER_CANNOT_DELETED,'本团购包含付款订单，不能删除');
define(AJAX_MANAGE_GROUP_PURCHASE_ID_CANNOT_DELETED,'本团购包含付款订单，"团购 {$id} 删除成功！"');
define(AJAX_MANAGE_NO_RELATED_CASH_COUPON,'没有相关代金券');
define(AJAX_MANAGE_CASH_COUPON_USED_CANNOT_DELETED,'代金券已经被使用，不能删除');
define(AJAX_MANAGE_CASH_COUPON_ID_DELETED_SUCCESS,"代金券 {$id} 删除成功！");
define(AJAX_MANAGE_BELOW_THE_LINE_RECHARGE,'线下充值');
define(AJAX_MANAGE_USER_WITHDRAW_DEPOSIT,'用户提现');
define(AJAX_MANAGE_RECHARGE_FAILED,'充值失败');
define(AJAX_MANAGE_ALTER_EXPRESSAGE_MESSAGE_SUCCESS,"修改快递信息成功");
define(AJAX_MANAGE_ALIPAY,'支付宝');
define(AJAX_MANAGE_TENPAY,'财付通');
define(AJAX_MANAGE_CHINABANK_PAYMENT,'网银在线');
define(AJAX_MANAGE_BALANCE_PAYMENT,'余额付款');
define(AJAX_MANAGE_BELOW_THE_LINE_PAY,'线下支付');
define(AJAX_MANAGE_GREEN_NON_PAYMENT,'<font color="green">未付款</font>');
define(AJAX_MANAGE_RED_PAID,'<font color="red">已付款</font>');
define(AJAX_MANAGE_REFUND_ACCOUNT_BALANCE,'退款到账户余额');
define(AJAX_MANAGE_OTHER_WAYS_REFUNDED,'其他途径已退款');
define(AJAX_MANAGE_ILLEGAL_OPERATION,'非法操作');
define(AJAX_MANAGE_NOTHING_HAPPENED_PURCHASING_BEHAVIOR_CANNOT_EXECUTE_REBATE,'没有发生购买行为，不能执行返利');
define(AJAX_MANAGE_SUCCESSFUL_GROUP_PURCHASE_CAN_EXECTUE_INVITE_REBATE,'只有成功的团购才可以执行邀请返利');
define(AJAX_MANAGE_INVITE_REBATE_SUCCESSFUL_OPERATION,'邀请返利操作成功');
define(AJAX_MANAGE_WRONFUL_INVITE_RECORD_DELETED_SUCCESS,'不合法邀请记录删除成功！');
define(AJAX_MANAGE_EMAIL_EMAIL_UNSUBSCRIPTION_SUCCESS,"邮件地址：{$subscribe['email']}退订成功");
define(AJAX_MANAGE_MERCHANT_ID_DELETE_SUCCEED,'商户：{$id} 删除成功');
define(AJAX_MANAGE_MERCHANT_HAVE_GROUP_PURCHASE_ITEM_DELETE_FAILED,'商户有团购项目，删除失败');
define(AJAX_MANAGE_DELETE_MERCHANT_FAILED,'商户删除失败');
define(AJAX_MANAGE_SENT_SUCCEED,'发送完毕');
define(AJAX_MANAGE_SUBSCRIBE_MAIL_SENT_SUCCEED,'订阅邮件发送完毕');
define(AJAX_MANAGE_NO_DATA,'无数据');
define(AJAX_MANAGE_PLEASE_MAKE_SURE_CATEGORY,'请确定分类');
define(AJAX_MANAGE_NO_SUCH_CATEGORY,'无此分类');
define(AJAX_MANAGE_GROUP_PURCHASE_ITEM_EXISTS_UNDER_THIS_CATEGORY,'本类下存在团购项目');
define(AJAX_MANAGE_ORDER_ITEM_EXISTS_UNDER_THIS_CATEGORY,'本类下存在订单项目');
define(AJAX_MANAGE_DISCUSSION_TOPIC_EXISTS_UNDER_THIS_CATEGORY,'本类下存在讨论区话题');
define(AJAX_MANAGE_DELETE_CATEGORY_SUCCEED,'删除分类成功');
define(AJAX_MANAGE_GROUP_PURCHASE_NOT_CLOSED_OR_NOT_MEET_MINIMUM_NUMBER_PEOPLE_INTO_GROUP,'团购未结束或未达到最低成团人数');
define(AJAX_MANAGE_DELIVER_COUPON_SUCCEED,'发券成功');
//manage/market/down.php
define(MANAGE_MARKET_DOWN_USEREMAIL,'用户Email');
define(MANAGE_MARKET_DOWN_REALNAME,'真实姓名');
define(MANAGE_MARKET_DOWN_MOBILE,'手机号码');


//manage/market/downcoupon.php
define(MANAGE_MARKET_DOWNCOUPON_ID,'编号');
define(MANAGE_MARKET_DOWNCOUPON_DATE,'密码');
define(MANAGE_MARKET_DOWNCOUPON_CONSUME,'状态');

define(MANAGE_MARKET_DOWNCOUPON_Y,'已消费');
define(MANAGE_MARKET_DOWNCOUPON_N,'未消费');


//manage/market/downorder.php
define(MANAGE_MARKET_DOWNORDER_ID,'订单号');
define(MANAGE_MARKET_DOWNORDER_PAYID,'支付号');
define(MANAGE_MARKET_DOWNORDER_SERVICE,'支付方式');
define(MANAGE_MARKET_DOWNORDER_PRICE,'单价');
define(MANAGE_MARKET_DOWNORDER_QUANTITY,'数量');
define(MANAGE_MARKET_DOWNORDER_FARE,'运费');
define(MANAGE_MARKET_DOWNORDER_ORIGIN,'总金额');
define(MANAGE_MARKET_DOWNORDER_MONEY,'支付款');
define(MANAGE_MARKET_DOWNORDER_CREDIT,'余额付款');
define(MANAGE_MARKET_DOWNORDER_STATE,'支付状态');

define(MANAGE_MARKET_DOWNORDER_REALANEM,'收件人');
define(MANAGE_MARKET_DOWNORDER_MOBILE,'手机号码');
define(MANAGE_MARKET_DOWNORDER_ZIPCODE,'邮政编码');
define(MANAGE_MARKET_DOWNORDER_ADDRESS,'送货地址');

define(MANAGE_MARKET_DOWNORDER_ALIPAY,'支付宝');
define(MANAGE_MARKET_DOWNORDER_TENPAY,'财付通');
define(MANAGE_MARKET_DOWNORDER_CHINABANK,'网银在线');
define(MANAGE_MARKET_DOWNORDER_CREDIT,'余额付款');
define(MANAGE_MARKET_DOWNORDER_CASH,'现金支付');
define(MANAGE_MARKET_DOWNORDER_OTHER,'其他');

define(MANAGE_MARKET_DOWNORDER_UNPAY,'未支付');
define(MANAGE_MARKET_DOWNORDER_PAY,'已支付');


//manage/market/downuser.php
define(MANAGE_MARKET_DOWNUSER_EMAIL,'邮件');
define(MANAGE_MARKET_DOWNORDER_USERNAME,'用户名');
define(MANAGE_MARKET_DOWNORDER_REALNAME,'真实姓名');
define(MANAGE_MARKET_DOWNORDER_GENDER,'性别');
define(MANAGE_MARKET_DOWNORDER_QQ,'QQ号码');
define(MANAGE_MARKET_DOWNORDER_MOBILE,'手机号码');
define(MANAGE_MARKET_DOWNORDER_ZIPCODE,'邮编');
define(MANAGE_MARKET_DOWNORDER_ADDRESS,'地址');
define(MANAGE_MARKET_DOWNORDER_NEWBIE,'购买');

define(MANAGE_MARKET_DOWNUSER_M,'男');
define(MANAGE_MARKET_DOWNORDER_F,'女');

define(MANAGE_MARKET_DOWNUSER_N,'否');
define(MANAGE_MARKET_DOWNORDER_Y,'是');


//manage/market/index.php
define(MANAGE_MARKET_INDEX_ERROR,'发送邮件错误：缺少合法的收件人邮件地址');
define(MANAGE_MARKET_INDEX_NOTICE_EMAILCOUNT,"发送邮件成功，数量：{$email_count}");
define(MANAGE_MARKET_INDEX_MERROR,'发送邮件错误：');


//manage/market/sms.php
define(MANAGE_MARKET_SMS_SMSSUCCESS_PHONECOUNT,"发送短信成功，发送量：{$phone_count}");
define(MANAGE_MARKET_SMS_SMSFAIL_RET,"发送短信失败，错误码：{$ret}");


//manage/misc/askremove.php
define(MANAGE_MISC_ASKREMOVE_NOTICESUCCESS_ID,"删除团购咨询({$id})记录成功");


//manage/misc/feedback.php
define(MANAGE_MISC_FEEDBACK_SUGGEST,'意见反馈');
define(MANAGE_MISC_FEEDBACK_SELLER,'商务合作');


//manage/partner/edit.php
define(MANAGE_PARTNER_EDIT_NOTICESUCCESS,'修改商户信息成功');
define(MANAGE_PARTNER_EDIT_ERROR,'修改商户信息失败');



//manage/system/bulletin.php
define(MANAGE_SYSTEM_BULLETIN_NOTICESUCCESS,'更新系统信息成功');



//manage/system/cache.php
define(MANAGE_SYSTEM_CACHE_NOTICESUCCESS,'更新系统信息成功');
define(MANAGE_SYSTEM_CACHE_NOWTITE,' 不可写');
define(MANAGE_SYSTEM_CACHE_SAVEFAIL,'保存失败，');



//manage/system/city.php
define(MANAGE_SYSTEM_CITY_NOTICESUCCESS,'更新系统信息成功');



//manage/system/email.php
define(MANAGE_SYSTEM_EMAIL_NOTICESUCCESS,'更新系统信息成功');



//manage/system/index.php
define(MANAGE_SYSTEM_INDEX_NOTICESUCCESS,'更新系统信息成功');



//manage/system/page.php
define(MANAGE_SYSTEM_PAGE_PLAY,'玩转');
define(MANAGE_SYSTEM_PAGE_FAQ,'常见问题');
define(MANAGE_SYSTEM_PAGE_API,'开发API');
define(MANAGE_SYSTEM_PAGE_WHAT,'什么是');
define(MANAGE_SYSTEM_PAGE_CONTACT,'联系方式');
define(MANAGE_SYSTEM_PAGE_ABOUT,'关于');
define(MANAGE_SYSTEM_PAGE_JOB,'工作机会');
define(MANAGE_SYSTEM_PAGE_TERMS,'用户协议');
define(MANAGE_SYSTEM_PAGE_PRIVACY,'隐私声明');

define(MANAGE_SYSTEM_PAGE_EDITSUCCESS_PAGESID,"页面：{$pages[$id]}编辑成功");



//manage/system/pay.php
define(MANAGE_SYSTEM_PAY_NOTICESUCCESS,'更新系统信息成功');




//manage/system/skin.php
define(MANAGE_SYSTEM_SKIN_NOTICESUCCESS,'更新系统信息成功');



//manage/system/sms.php
define(MANAGE_SYSTEM_SMS_NOTICESUCCESS,'更新系统信息成功');




//manage/system/template.php
define(MANAGE_SYSTEM_TEMPLATE_EDITSUC_TEMPLATE_ID,"模板 {$template_id} 修改成功");
define(MANAGE_SYSTEM_TEMPLATE_EDITFAI_TEMPLATE_ID,"模板 {$template_id} 修改失败");



//manage/system/upgrade.php
define(MANAGE_SYSTEM_UPGRADE_NEWVERSION,'数据库结构升级成功，数据库已经是最新版本');



//manage/team/down.php
define(MANAGE_TEAM_DOWN_NAME,'姓名');
define(MANAGE_TEAM_DOWN_MOBILE,'手机号码');
define(MANAGE_TEAM_DOWN_USER,'用户');
define(MANAGE_TEAM_DOWN_ADDRESS,'地址');
define(MANAGE_TEAM_DOWN_CODE_INI,"{$INI['system']['couponname']}编号");
define(MANAGE_TEAM_DOWN_PASSWORD_INI,"{$INI['system']['couponname']}密码");



//manage/team/edit.php
define(MANAGE_TEAM_EDIT_EDITSUCESS,'修改团信息成功');
define(MANAGE_TEAM_EDIT_EDITFAIL,'修改团信息失败，请检查系统环境？');



//manage/team/remove.php
define(MANAGE_TEAM_REMOVE_DETFAIL_ID,"删除团购({$id})记录失败，存在订单记录");
define(MANAGE_TEAM_REMOVE_DETSUCCESS_ID,"删除团购({$id})记录成功");
//include/function/common.php
define(INCLUDE_FUNCTION_COMMON_IMPUISSANCE,'无权操作');
define(INCLUDE_FUNCTION_COMMON_LONG_SENTENCE_SYSTEM_SITENAME,"发现一好网站--{$INI['system']['sitename']}，他们每天组织一次团购，超值！");
define(INCLUDE_FUNCTION_COMMON_TODAY_TUANGOU_TITLE,"今天的团购是：{$team['title']}");
define(INCLUDE_FUNCTION_COMMON_THINK_INTEREST,"我想你会感兴趣的：");
define(INCLUDE_FUNCTION_COMMON_INTEREST_TITLE ,"有兴趣吗：{$team['title']}");
define(INCLUDE_FUNCTION_COMMON_PROCEED,'正在进行中');
define(INCLUDE_FUNCTION_COMMON_SELLOUT,'已售光');
define(INCLUDE_FUNCTION_COMMON_TUANGOU_FAIL,'团购失败');
define(INCLUDE_FUNCTION_COMMON_TUANGOU_SUCCESS,'团购成功');
define(INCLUDE_FUNCTION_COMMON_OVER,'已结束');
define(INCLUDE_FUNCTION_COMMON_CITY_LIST,'城市列表');
define(INCLUDE_FUNCTION_COMMON_TUANGOU_CATEGORY,'团购分类');
define(INCLUDE_FUNCTION_COMMON_BBS_LAYOUT,'论坛版面');
define(INCLUDE_FUNCTION_COMMON_USER_GRADE,'用户等级');
define(INCLUDE_FUNCTION_COMMON_EXPRESS_COMPANY,'快递公司');
define(INCLUDE_FUNCTION_COMMON_TAGGING, '标签');

//include/function/current.php
define(INCLUDE_FUNCTION_CURRENT_TODAY_TUANGOU,'今日团购');
define(INCLUDE_FUNCTION_CURRENT_REVIEW_TUANGOU,'往期团购');
define(INCLUDE_FUNCTION_CURRENT_PLAY,'玩转');
define(INCLUDE_FUNCTION_CURRENT_EMAIL_SUBSCRIBE,'邮件订阅');
define(INCLUDE_FUNCTION_CURRENT_TEST_QUERY_DB,'测试查询数据库');
define(INCLUDE_FUNCTION_CURRENT_BBS,'讨论区');
define(INCLUDE_FUNCTION_CURRENT_INDEX,'首页');
define(INCLUDE_FUNCTION_CURRENT_TUANGOU,'团购');
define(INCLUDE_FUNCTION_CURRENT_ORDER,'订单');
define(INCLUDE_FUNCTION_CURRENT_USER,'用户');
define(INCLUDE_FUNCTION_CURRENT_SELLER,'商户');
define(INCLUDE_FUNCTION_CURRENT_MARKETING,'营销');
define(INCLUDE_FUNCTION_CURRENT_CATEGORY,'类别');
define(INCLUDE_FUNCTION_CURRENT_INSTALL,'设置');
define(INCLUDE_FUNCTION_CURRENT_SELLER_DATA,'商户资料');
define(INCLUDE_FUNCTION_CURRENT_LIST,'列表');
define(INCLUDE_FUNCTION_CURRENT_ALL,'所有');
define(INCLUDE_FUNCTION_CURRENT_BBS_NAME,"{$city['name']}讨论区");
define(INCLUDE_FUNCTION_CURRENT_PUBLIC_BBS,'公共讨论区');
define(INCLUDE_FUNCTION_CURRENT_NOT_USE,'未使用');
define(INCLUDE_FUNCTION_CURRENT_ALREAD_USE,'已使用');
define(INCLUDE_FUNCTION_CURRENT_EXPIRE,'已过期');
define(INCLUDE_FUNCTION_CURRENT_MY_ORDER,'我的订单');
define(INCLUDE_FUNCTION_CURRENT_MY,'我的');
define(INCLUDE_FUNCTION_CURRENT_ACCOUNT_BALANCE,'账户余额');
define(INCLUDE_FUNCTION_CURRENT_ACCOUNT_SET,'账户设置');
define(INCLUDE_FUNCTION_CURRENT_ABOUT,'关于');
define(INCLUDE_FUNCTION_CURRENT_CONTACT_CONTACT,'联系方式');
define(INCLUDE_FUNCTION_CURRENT_WORK_CHANCE,'工作机会');
define(INCLUDE_FUNCTION_CURRENT_PRIVACY_POLICY,'隐私申明');
define(INCLUDE_FUNCTION_CURRENT_SERVICE_CLAUSE,'服务条款');
define(INCLUDE_FUNCTION_CURRENT_common_question,'常见问题');
define(INCLUDE_FUNCTION_CURRENT_WHAT_IS,'是什么');
define(INCLUDE_FUNCTION_CURRENT_ALL2,'全部');
define(INCLUDE_FUNCTION_CURRENT_NOT_PAYMENT,'未付款');
define(INCLUDE_FUNCTION_CURRENT_ALREAD_PAYMENT,'已付款');
define(INCLUDE_FUNCTION_CURRENT_TANGOU_ANSWER,'团购答疑');
define(INCLUDE_FUNCTION_CURRENT_FEEDBACK_IDEA,'反馈意见');

define(INCLUDE_FUNCTION_CURRENT_INVITATION_RETURN,'邀请返利');
define(INCLUDE_FUNCTION_CURRENT_FINANCE_RECORD,'财务记录');
define(INCLUDE_FUNCTION_CURRENT_UNDERLIEN_CHARGE,'线下充值');
define(INCLUDE_FUNCTION_CURRENT_ONLINE_CHARGE,'在线充值');
define(INCLUDE_FUNCTION_CURRENT_PAYPAL_RECORD,'提现记录');
define(INCLUDE_FUNCTION_CURRENT_CASH_PAYMENT,'现金支付');
define(INCLUDE_FUNCTION_CURRENT_REFUND_RECORD,'退款记录');
define(INCLUDE_FUNCTION_CURRENT_INVITATION_RECORD,'邀请记录');
define(INCLUDE_FUNCTION_CURRENT_RETURN_RECORD,'返利记录');
define(INCLUDE_FUNCTION_CURRENT_NOW_ORDER,'当期订单');
define(INCLUDE_FUNCTION_CURRENT_PAYMENT_ORDER,'付款订单');
define(INCLUDE_FUNCTION_CURRENT_NOT_PAYMENT_ORDER,'未付订单');
define(INCLUDE_FUNCTION_CURRENT_USER_LIST,'用户列表');
define(INCLUDE_FUNCTION_CURRENT_ADMIN_LIST,'管理员列表');
define(INCLUDE_FUNCTION_CURRENT_NOW_TUANGOU,'当前团购');
define(INCLUDE_FUNCTION_CURRENT_SUCCESS_TUANGOU,'成功团购');
define(INCLUDE_FUNCTION_CURRENT_FAIL_TUANGOU,'失败团购');
define(INCLUDE_FUNCTION_CURRENT_NEW_TUANGOU,'新建团购');
define(INCLUDE_FUNCTION_CURRENT_SYNOPSIS,'总览');
define(INCLUDE_FUNCTION_CURRENT_NOT_CONSUME,'未消费');
define(INCLUDE_FUNCTION_CURRENT_ALREAD_CONSUME,'已消费');
define(INCLUDE_FUNCTION_CURRENT_OVERDUE,'已过期');
define(INCLUDE_FUNCTION_CURRENT_VOUCHER,'代金券');
define(INCLUDE_FUNCTION_CURRENT_NEW_VOUCHER,'新建代金券');
define(INCLUDE_FUNCTION_CURRENT_SELLER_LIST,'商户列表');
define(INCLUDE_FUNCTION_CURRENT_NOW_SELLER,'新建商户');
define(INCLUDE_FUNCTION_CURRENT_MAIL_MARKETING,'邮件营销');
define(INCLUDE_FUNCTION_CURRENT_MESSAGE_FANOUT,'短信群发');
define(INCLUDE_FUNCTION_CURRENT_DATA_DOWNLOAD,'数据下载');
define(INCLUDE_FUNCTION_CURRENT_PHONE_NUMBER,'手机号码');
define(INCLUDE_FUNCTION_CURRENT_EMAIL_ADDR,'邮件地址');
define(INCLUDE_FUNCTION_CURRENT_TUANGOU_ORDER,'团购订单');
define(INCLUDE_FUNCTION_CURRENT_TUANGOU_COUPON,'团购优惠券');
define(INCLUDE_FUNCTION_CURRENT_USER_INFO,'用户信息');

define(INCLUDE_FUNCTION_CURRENT_BASIC,'基本');
define(INCLUDE_FUNCTION_CURRENT_BULLETIN,'公告');
define(INCLUDE_FUNCTION_CURRENT_PAYMENT,'支付');
define(INCLUDE_FUNCTION_CURRENT_MAIL,'邮件');
define(INCLUDE_FUNCTION_CURRENT_MESSAGE,'短信');
define(INCLUDE_FUNCTION_CURRENT_CITY,'城市');
define(INCLUDE_FUNCTION_CURRENT_PAGE,'页面');
define(INCLUDE_FUNCTION_CURRENT_CACHE,'缓存');
define(INCLUDE_FUNCTION_CURRENT_SKIN,'皮肤');
define(INCLUDE_FUNCTION_CURRENT_TEMPLATE,'模板');
define(INCLUDE_FUNCTION_CURRENT_UPGRADE,'升级');


//include/function/mailer.php
define(INCLUDE_FUNCTION_MAILER_THANKS_REGISTER,'感谢注册');
define(INCLUDE_FUNCTION_MAILER_VERIFICATION_EMAIL,'，请验证Email以获取更多服务');
define(INCLUDE_FUNCTION_MAILER_RESET_PASSWORD,'重设密码');
// START 以下の定数を翻訳する時、「曜日」が必須（サンプル：日曜日、月曜日、火曜日）
define(INCLUDE_FUNCTION_MAILER_SUNDAY,'日');
define(INCLUDE_FUNCTION_MAILER_MONDAY,'一');
define(INCLUDE_FUNCTION_MAILER_TUESDAY,'二');
define(INCLUDE_FUNCTION_MAILER_WEDNESDAY,'三');
define(INCLUDE_FUNCTION_MAILER_THURSDAY,'四');
define(INCLUDE_FUNCTION_MAILER_FRIDAY,'五');
define(INCLUDE_FUNCTION_MAILER_SATURDAY,'六');
// END

define(INCLUDE_FUNCTION_MAILER_YMD,'Y年n月j日 ');
define(INCLUDE_FUNCTION_MAILER_TODAY_GROUP_BUY,"今日团购：{$team['title']}");


//include/function/sms.php
define(INCLUDE_FUNCTION_SMS_SMS_LENGTH,'短信长度低于20汉字？长点吧～');
define(INCLUDE_FUNCTION_SMS_INVALID,'已失效');
define(INCLUDE_FUNCTION_SMS_SET_PHONE_NUMBER,'请设置合法的手机号码，以便接受短信');


//include/function/utility.php
define(INCLUDE_FUNCTION_UTILITY_FROM,'#来自：<b>(.+)</b>#Ui');
define(INCLUDE_FUNCTION_UTILITY_MALE,'男');
define(INCLUDE_FUNCTION_UTILITY_FEMALE,'女');
define(INCLUDE_FUNCTION_UTILITY_PAID,'已支付');
define(INCLUDE_FUNCTION_UTILITY_UNPAID,'未支付');
define(INCLUDE_FUNCTION_UTILITY_ALIPAY,'支付宝');
define(INCLUDE_FUNCTION_UTILITY_TENPAY,'付通');
define(INCLUDE_FUNCTION_UTILITY_CHINABANK,'中国银行');
define(INCLUDE_FUNCTION_UTILITY_CASH,'现金支付');
define(INCLUDE_FUNCTION_UTILITY_CREDIT_CARD,'信用卡');
define(INCLUDE_FUNCTION_UTILITY_OTHER,'其他');
define(INCLUDE_FUNCTION_UTILITY_EXPRESS_DELIVERY,'快递');
define(INCLUDE_FUNCTION_UTILITY_COUPON,'优惠券');
define(INCLUDE_FUNCTION_UTILITY_SELF_PICK,'自取');
define(INCLUDE_FUNCTION_UTILITY_BUY,'购买');
define(INCLUDE_FUNCTION_UTILITY_INVITE,'邀请');
define(INCLUDE_FUNCTION_UTILITY_RECHARGE,'充值');
define(INCLUDE_FUNCTION_UTILITY_WITHDRAW,'提邇ｰ');
define(INCLUDE_FUNCTION_UTILITY_REBATE,'返利');
define(INCLUDE_FUNCTION_UTILITY_REFUND,'退款');
define(INCLUDE_FUNCTION_UTILITY_REGISTER,'注册');
define(INCLUDE_FUNCTION_UTILITY_NUMBER_OF_PEOPLE,'以雍ｭ荵ｰ成功人数成蝗｢');
define(INCLUDE_FUNCTION_UTILITY_QUANTITY,'以莠ｧ品雍ｭ荵ｰ数量成蝗｢');
//manage/team/down.php

define(MANAGE_TEAM_DOWN_NAME,'姓名');

define(MANAGE_TEAM_DOWN_TEL,'手机号码');

define(MANAGE_TEAM_DOWN_ADDR,'地址');

define(MANAGE_TEAM_DOWN_USER,'用户');

define(MANAGE_TEAM_DOWN_MOB,'手机号码');

define(MANAGE_TEAM_DOWN_SERIAL_SYSTEM_COUPONNAME,"{$INI['system']['couponname']}编号");

define(MANAGE_TEAM_DOWN_PWD_SYSTEM_COUPONNAME,"{$INI['system']['couponname']}密码");


//manage/team/edit.php

define(MANAGE_TEAM_EDIT_NOTICE,'修改团信息成功');

define(MANAGE_TEAM_EDIT_ERROR,'修改团信息失败，请检查系统环境？');

//manage/team/failure.php

//manage/team/index.php

//manage/team/remove.php

define(MANAGE_TEAM_REMOVE_DETFAIL_ID,"删除团购({$id})记录失败，存在订单记录");

define(MANAGE_TEAM_REMOVE_DETSUCCESS_ID,"删除团购({$id})记录成功");

//manage/team/success.php

//manage/user/edit.php

define(MANAGE_USER_EDIT_NOTCANT,'你无权修改超级管理员信息');

define(MANAGE_USER_EDIT_NOTSUC, '修改用户信息成功');

define(MANAGE_USER_EDIT_NOTFAL,'修改用户信息失败');

//manage/user/index.php

//manage/user/manager.php

//message/inbox.php

//order/charge.php

define(ORDER_CHARGE_ERROR,'充值金额至少1元');

define(ORDER_CHARGE_CHG_EMAIL_SYSTEM_SITENAME,"{$login_user['email']}({$INI['system']['sitename']}充值{$total_money}元)");

//order/check.php

define(ORDER_CHECK_ERROR, '订单不存在');

//order/index.php

//order/pay.php

define(ORDER_PAY_ERROR, '无合适的支付方式或余额不足');

//order/view.php

//order/alipay/notify.php

define(ORDER_ALIPAY_NOTIFY_BANK, '支付宝');

//order/alipay/return.php

define(ORDER_ALIPAY_RETURN_FEE, "支付宝充值{$total_fee}元成功！");

define(ORDER_ALIPAY_RETURN_BANK, '支付宝');

//order/chinabank/notify.php

//order/chinabank/return.php

define(ORDER_CHINABANK_RETURN_BANKSUC_AMOUNT,  "网银在线充值{$v_amount}元成功！");

//order/tenpay/return.php

define(ORDER_TENPAY_RETURN_CAISUC_AMOUNT,  "财付通充值{$v_amount}元成功！");

define(ORDER_TENPAY_RETURN_BANK, '财付通');

//team/ask.php

define(TEAM_ASK_REPLY_SYSTEM_ABBREVIATION_TITLE,"{$INI['system']['abbreviation']}答疑 {$team['title']}");

//team/buy.php

define(TEAM_BUY_ERRNOTEXIST, '团购项目不存在');

define(TEAM_BUY_ERRBUYONE, '每人每单只能购买一次，你已经成功购买过！');

define(TEAM_BUY_ERRGT, '购买数量不能小于1份');

define(TEAM_BUY_ERRRANGE, '您本次购买本单产品已超出限额！');

//team/index.php

define(TEAM_INDEX_UPON, '近期团购');