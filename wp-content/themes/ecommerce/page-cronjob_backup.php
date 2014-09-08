<?php
/*
 * Insert data rss to database
 */
global $wpdb;
$key_run_cron = $_REQUEST['key'];
if($key_run_cron != KEY_RUN_CRON) {
  wp_redirect('/');
  exit;
}
//insert new data to temporary Tables
$post = get_post();
set_include_path(THEMEDIR . '/inc/');
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();
require_once 'Zend/Cache.php';
require_once 'Zend/Feed/Rss.php';
//delete old data in yesterday in temporary Tables
$current_date_1 = date('Y-m-d 00:00:00');
$current_date_2 = date('Y-m-d H:i:s');
$query = "DELETE FROM wp_rss WHERE post_date < STR_TO_DATE('" . $current_date_1 . "', '%Y-%m-%d %H:%i:%s')";
$wpdb->query($query);
$link_sport = get_post_meta($post->ID, 'sport',true);
$link_it = get_post_meta($post->ID, 'it',true);
$new_array = array();
$arr_url = array(
  'sport'=>$link_sport,
  'it'=>$link_it,
    );
foreach($arr_url as $key=>$value) {
  $url = trim($value);
  try {
    $rss = new Zend_Feed_Rss($url);
  }catch(Exception $e) {
    
  }
  if($key=='sport') {
    $term = 'sport';
  }
  if(!empty($rss)) {
    foreach ($rss as $entry) {
//      print("<pre>");
//      print_r($entry->summaryImg());
//      exit;          
      $post_obj = array(
        'post_type'=>'rss',
        'post_title'    => $entry->title(),
        'post_content'  => $entry->description(),
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_date'     =>$current_date_2,
        'post_link' => $entry->link(),
        'post_image'=> $entry->summaryImg()
      );
      //check to exist post in db
      $query = "SELECT * from wp_rss WHERE post_title='". $entry->title() ."' AND post_content='". $entry->description ."'";
      $results = $wpdb->get_results($query);
      if(empty($results)){
        $new_array[] = array('post_obj'=>$post_obj,'term'=>$term) ;
        $wpdb->insert('wp_rss', $post_obj);
      }
    }
  }
}

//insert data to wp_posts
foreach($new_array as $item) {
  $post_id = wp_insert_post( $item['post_obj']);
  if(!empty($post_id)){
    $post_data = get_post_meta($post_id, 'link_value', true);
    add_post_meta($post_id, 'link_value', $item['post_obj']['post_link']);    
    //get meta data
    $query = "SELECT * FROM $wpdb->postmeta WHERE $wpdb->postmeta.post_id = $post_id AND $wpdb->postmeta.meta_key = 'link_value'";
    $result = $wpdb->get_row($query);
    if(!empty($result)) {
        $meta_id = $result->meta_id;
        $cfs_obj = array(
        'field_id'=>9,
        'meta_id'=>$meta_id,
        'post_id'=>$post_id,
        'base_field_id'=>0,
        'hierarchy'=>0,
        'depth'=>0,
        'weight'=>0,
        'sub_weight'=>0
        ) ;
        $wpdb->insert('wp_cfs_values', $cfs_obj);
    }
    wp_set_object_terms($post_id, $item['term'], 'newstype');
  }
}


?>
