<?php
set_time_limit(0);
/*
 * Insert data rss to database
 */
global $wpdb;
$key_run_cron = $_REQUEST['key'];
if($key_run_cron != KEY_RUN_CRON) {
  wp_redirect('/');
  exit;
}
ini_set('display_errors',0);
error_reporting(E_ALL);
//$link_cron = get_post_meta(get_the_ID(),'link_cronjob',true);
$link_cron = 'http://f24.com.vn/';

//get category data

$link = 'http://f24.com.vn/';
$dom = new DOMDocument('1.0','utf-8');
$dom->loadHTMLFile(trim($link));
$xpath = new DOMXPath($dom);
$list = $xpath->query('.//div [@id="mainNav"]/ul/div/li');
//print_r($list);exit;
$arr_data = array();
$data = array();

foreach($list as $item) {
	
	$category_name = $xpath->query('.//a', $item)->item(0)->nodeValue;
	$cate_link = $xpath->query('.//a/@href', $item)->item(0)->nodeValue;
	$dom2 = new DOMDocument('1.0','utf-8');
	$dom2->loadHTMLFile(trim($cate_link));
	$xpath2 = new DOMXPath($dom2);
	$list2 = $xpath2->query('.//div [@class="box-pr-nav"]/ul/li');
	
	foreach( $list2 as $item2 ) {
		$link3 = $xpath2->query('.//a/@href', $item2)->item(0)->nodeValue;
		$dom3 = new DOMDocument('1.0','utf-8');
		$dom3->loadHTMLFile(trim($link3));
		$xpath3 = new DOMXPath($dom3);
		$data['category'] = $category_name;
		$data['name'] = $xpath3->query('.//div [@id="boxDetail-left"]/div/div/div/span [@class="info-nameN"]')->item(0)->nodeValue;
		$data['code'] = $xpath3->query('.//div [@id="boxDetail-left"]/div/div/div/span [@class="info-code"]')->item(0)->nodeValue;
		$data['price'] = $xpath3->query('.//div [@id="boxDetail-left"]/div/div/div/div/span [@class="info-namePrice"]')->item(0)->nodeValue;
		$data['image'] = $xpath3->query(".//*[@id='img_big']/a/@href")->item(0)->nodeValue;
		$data['content'] = $xpath3->query('.//div [@id="boxDetail-left"]/div [@class="nav-boxDetail"]/div [@class="tab_container"]/div [@class="tab_content"]')->item(0)->nodeValue;
 		$arr_data[] = $data;
// 		print_r($arr_data);exit;
	}
}
print("<pre>");
print_r($arr_data);
exit;

?>
