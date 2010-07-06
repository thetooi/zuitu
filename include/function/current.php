<?php
function current_frontend() {
	global $INI;
	$a = array(
			'/index.php' => '今日团购',
			'/team/index.php' => '往期团购',
			'/help/tour.php' => '玩转' . $INI['system']['abbreviation'],
			'/subscribe.php' => '邮件订阅',
			);
	if (abs(intval($INI['system']['forum']))) {
		unset($a['/subscribe.php']);
		$a['/forum/index.php'] = '讨论区';
	}
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#/team#',$r)) $l = '/team/index.php';
	elseif (preg_match('#/help#',$r)) $l = '/help/tour.php';
	elseif (preg_match('#/subscribe#',$r)) $l = '/subscribe.php';
	else $l = '/index.php';
	return current_link(null, $a);
}

function current_backend() {
	global $INI;
	$a = array(
			'/manage/misc/index.php' => '首页',
			'/manage/team/index.php' => '团购',
			'/manage/order/index.php' => '订单',
			'/manage/coupon/index.php' => $INI['system']['couponname'],
			'/manage/user/index.php' => '用户',
			'/manage/partner/index.php' => '商户',
			'/manage/market/index.php' => '营销',
			'/manage/category/index.php' => '类别',
			'/manage/system/index.php' => '设置',
			);
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#/manage/(\w+)/#',$r, $m)) {
		$l = "/manage/{$m[1]}/index.php";
	} else $l = '/manage/misc/index.php';
	return current_link($l, $a);
}

function current_biz() {
	global $INI;
	$a = array(
			'/biz/index.php' => '首页',
			'/biz/settings.php' => '商户资料',
			'/biz/coupon.php' => $INI['system']['couponname'] . '列表',
			);
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#/biz/coupon#',$r)) $l = '/biz/coupon.php';
	elseif (preg_match('#/biz/settings#',$r)) $l = '/biz/settings.php';
	else $l = '/biz/index.php';
	return current_link($l, $a);
}

function current_forum($selector='index') {
	global $city;
	$a = array(
			'/forum/index.php' => '所有',
			'/forum/city.php' => "{$city['name']}讨论区",
			'/forum/public.php' => '公共讨论区',
			);
	if (!$city) unset($a['/forum/city.php']);
	$l = "/forum/{$selector}.php";
	return current_link($l, $a, true);
}

function current_city($cename, $citys) {
	$link = "/city.php?ename={$cename}";
	$links = array();
	foreach($citys AS $city) {
		$links["/city.php?ename={$city['ename']}"] = $city['name'];
	}
	return current_link($link, $links);
}

function current_coupon_sub($selector='index') {
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/coupon/index.php' => '未使用',
		'/coupon/consume.php' => '已使用',
		'/coupon/expire.php' => '已过期',
	);
	$l = "/coupon/{$selector}.php";
	return current_link($l, $a);
}

function current_account($selector='/account/settings.php') {
	global $INI;
	$a = array(
		'/order/index.php' => '我的订单',
		'/coupon/index.php' => '我的' . $INI['system']['couponname'],
		'/credit/index.php' => '账户余额',
		'/account/settings.php' => '账户设置',
	);
	return current_link($selector, $a, true);
}

function current_about($selector='us') {
	global $INI;
	$a = array(
		'/about/us.php' => '关于' . $INI['system']['abbreviation'],
		'/about/contact.php' => '联系方式',
		'/about/job.php' => '工作机会',
		'/about/privacy.php' => '隐私申明',
		'/about/terms.php' => '服务条款',
	);
	$l = "/about/{$selector}.php";
	return current_link($l, $a, true);
}

function current_help($selector='faqs') {
	global $INI;
	$a = array(
		'/help/tour.php' => '玩转' . $INI['system']['abbreviation'],
		'/help/faqs.php' => '常见问题',
		'/help/zuitu.php' => $INI['system']['abbreviation'] . '是什么',
	);
	$l = "/help/{$selector}.php";
	return current_link($l, $a, true);
}

function current_order_index($selector='index') {
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/order/index.php?s=index' => '全部',
		'/order/index.php?s=unpay' => '未付款',
		'/order/index.php?s=pay' => '已付款',
	);
	$l = "/order/index.php?s={$selector}";
	return current_link($l, $a);
}

function current_link($link, $links, $span=false) {
	$html = '';
	$span = $span ? '<span></span>' : '';
	foreach($links AS $l=>$n) {
		if (trim($l,'/')==trim($link,'/')) {
			$html .= "<li class=\"current\"><a href=\"{$l}\">{$n}</a>{$span}</li>";
		}
		else $html .= "<li><a href=\"{$l}\">{$n}</a>{$span}</li>";
	}
	return $html;
}

/* manage current */
function mcurrent_misc($selector=null) {
	$a = array(
		'/manage/misc/index.php' => '首页',
		'/manage/misc/ask.php' => '团购答疑',
		'/manage/misc/feedback.php' => '反馈意见',
		'/manage/misc/subscribe.php' => '邮件订阅',
		'/manage/misc/invite.php' => '邀请返利',
		'/manage/misc/money.php' => '财务记录',
	);
	$l = "/manage/misc/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_misc_money($selector=null){
	$selector = $selector ? $selector : 'store';
	$a = array(
		'/manage/misc/money.php?s=store' => '线下充值',
		'/manage/misc/money.php?s=charge' => '在线充值',
		'/manage/misc/money.php?s=withdraw' => '提现记录',
		'/manage/misc/money.php?s=cash' => '现金支付',
		'/manage/misc/money.php?s=refund' => '退款记录',
	);
	$l = "/manage/misc/money.php?s={$selector}";
	return current_link($l, $a);
}

function mcurrent_misc_invite($selector=null){
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/manage/misc/invite.php?s=index' => '邀请记录',
		'/manage/misc/invite.php?s=record' => '返利记录',
	);
	$l = "/manage/misc/invite.php?s={$selector}";
	return current_link($l, $a);
}
function mcurrent_order($selector=null) {
	$a = array(
		'/manage/order/index.php' => '当期订单',
		'/manage/order/pay.php' => '付款订单',
		'/manage/order/unpay.php' => '未付订单',
	);
	$l = "/manage/order/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_user($selector=null) {
	$a = array(
		'/manage/user/index.php' => '用户列表',
		'/manage/user/manager.php' => '管理员列表',
	);
	$l = "/manage/user/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_team($selector=null) {
	$a = array(
		'/manage/team/index.php' => '当前团购',
		'/manage/team/success.php' => '成功团购',
		'/manage/team/failure.php' => '失败团购',
		'/manage/team/create.php' => '新建团购',
	);
	$l = "/manage/team/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_feedback($selector=null) {
	$a = array(
		'/manage/feedback/index.php' => '总览',
	);
	$l = "/manage/feedback/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_coupon($selector=null) {
	$a = array(
		'/manage/coupon/index.php' => '未消费',
		'/manage/coupon/consume.php' => '已消费',
		'/manage/coupon/expire.php' => '已过期',
		'/manage/coupon/card.php' => '代金券',
		'/manage/coupon/cardcreate.php' => '新建代金券',
	);
	$l = "/manage/coupon/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_category($selector=null) {
	$zones = get_zones();
	$a = array();
	foreach( $zones AS $z=>$o ) {
		$a['/manage/category/index.php?zone='.$z] = $o;
	}
	$l = "/manage/category/index.php?zone={$selector}";
	return current_link($l,$a,true);
}
function mcurrent_partner($selector=null) {
	$a = array(
		'/manage/partner/index.php' => '商户列表',
		'/manage/partner/create.php' => '新建商户',
	);
	$l = "/manage/partner/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_market($selector=null) {
	$a = array(
		'/manage/market/index.php' => '邮件营销',
		'/manage/market/sms.php' => '短信群发',
		'/manage/market/down.php' => '数据下载',
	);
	$l = "/manage/market/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_market_down($selector=null) {
	$a = array(
		'/manage/market/down.php' => '手机号码',
		'/manage/market/downemail.php' => '邮件地址',
		'/manage/market/downorder.php' => '团购订单',
		'/manage/market/downcoupon.php' => '团购优惠券',
		'/manage/market/downuser.php' => '用户信息',
	);
	$l = "/manage/market/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_system($selector=null) {
	$a = array(
		'/manage/system/index.php' => '基本',
		'/manage/system/bulletin.php' => '公告',
		'/manage/system/pay.php' => '支付',
		'/manage/system/email.php' => '邮件',
		'/manage/system/sms.php' => '短信',
		'/manage/system/city.php' => '城市',
		'/manage/system/page.php' => '页面',
		'/manage/system/cache.php' => '缓存',
		'/manage/system/skin.php' => '皮肤',
		'/manage/system/template.php' => '模板',
		'/manage/system/upgrade.php' => '升级',
	);
	$l = "/manage/system/{$selector}.php";
	return current_link($l,$a,true);
}
