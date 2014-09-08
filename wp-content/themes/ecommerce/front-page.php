<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage demo
 * @since demo 1.0
 */
do_action('download_file');
do_action('wp_ajax_load');
get_header(); ?>
<?php
//get five latest news
$args = array(
  'post_type' => 'news',
  'post_status' => 'publish',
//  'orderby'=>'date',
//  'order'=>'DESC',
  'posts_per_page'=>5,
  'paged'=>1
);
$query = new WP_Query($args);
$list_news = $query->get_posts();
$args = array(
  'post_type'=>'document',
  'post_status'=>'publish',
  'orderby'=>'date',
  'order'=>'DESC',
  'posts_per_page'=>5,
  'paged'=>1
);
$query = new WP_Query($args);
$list_document = $query->get_posts();
$args = array(
  'post_type'=>'rss',
  'post_status'=>'publish',
  'orderby'=>'date',
  'order'=>'DESC',
  'posts_per_page'=>5,
  'paged'=>1
);
$query = new WP_Query($args);
$list_rss = $query->get_posts();
$list = array_merge($list_news, $list_document, $list_rss);
for( $i= 0 ;$i<count($list)-1;$i++ ) {
  for($j = $i + 1;$j<count($list);$j++) {
    $post_date_1 = strtotime($list[$i]->post_date);
    $post_date_2 = strtotime($list[$j]->post_date);
    if($post_date_1 < $post_date_2) {
      $tmp = $list[$i];
      $list[$i] = $list[$j];
      $list[$j] = $tmp;
    }
  }
}
$lastest_news = array_slice($list, 0, 4);
$arr_news = array();
foreach($lastest_news as $item) {
    $data['ID'] = $item->ID;
    $data['post_type'] = $item->post_type;
    $data['post_date'] = $item->post_date;
    if($item->post_type== 'document') {
      $data['file']= get_post_meta($item->ID,'document_file');
      $data['title'] = $item->post_title;
    }elseif($item->post_type=='news' || $item->post_type =='rss') {
      $data['title'] = $item->post_title;
      $data['content'] = $item->post_content;
    }
    $arr_news[] = $data;
}
//get summary data
$args = array(
  'post_type'=>'summary',
  'post_status'=>'publish',
  
);
$query = new WP_Query($args);
$list_summary = $query->get_posts();
for($i=0;$i<count($list_summary) -1;$i++) {
  for($j=$i+1;$j<count($list_summary);$j++) {
      $ordering_1 = get_post_meta($list_summary[$i]->ID,'summary_ordering');
      $ordering_2 = get_post_meta($list_summary[$j]->ID,'summary_ordering');
      if($ordering_1>$ordering_2) {
        $tmp = $list_summary[$i];
        $list_summary[$i] = $list_summary[$j];
        $list_summary[$j] = $tmp;
      }
//    $ordering = get_post_meta($item->ID,'summary_ordering');
//    $link = get_post_meta($item->ID,'summary_link');
    
  }
}
$list_summary = array_slice($list_summary, 0, 4);

//for($list_summary as $item):
//endforeach;



?>
<div class="home-page">
<div class="hightlight-1">
  <?php if(!empty($list_summary)):?>
  <?php foreach($list_summary as $item):?>
  <?php
    $link_summary = get_post_meta($item->ID,'summary_link');
    $image_summary = get_the_post_thumbnail($item->ID, 'image_72_73');
  ?>
  <div class="intro-block">
              <div class="outer">
                <h2><?php echo $item->post_title?></h2>
                <div class="inner">
                  <div class="image"><?php echo $image_summary?>
                  </div>
                  <?php echo $item->post_content?>
                </div>
              </div><a href="<?php echo get_bloginfo('url')?>/<?php echo $link_summary[0]?>" title="Read More" class="btn"><span><?php echo __('Read More', THEMENAME)?></span><span class="ico icon-readmore"></span></a>
  </div>
  <?php endforeach?>
  <?php endif?>
            
</div>
<div class="hightlight-2">
    <div class="inner">
        <?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-2' ); ?>
        <?php endif; ?>
        <div class="event-travel">
            <h2><?php echo __('events and travel schedule', THEMENAME)?></h2>
            <a href="<?php echo get_bloginfo('url')?>/events" title="<?php echo __('EVents and Travel Schedule', THEMENAME)?>"><?php echo __('EVents and Travel
                Schedule', THEMENAME)?></a>
        </div>
        <div class="compay-news">
            <h2><?php echo __('company news', THEMENAME)?></h2>
            <ul>
              <?php if(!empty($arr_news)):?>
              <?php foreach($arr_news as $n):?>
              <?php if($n['post_type'] == 'news'):?>
              <li><a href="?ajax=1&type=detail_news&id=<?php echo $n['ID']?>" class="show-popup" title=""><?php echo $n['title']?>
                  <span  class="date"><?php echo date('d/m/Y',  strtotime($n['post_date']))?></span>
                </a>
              </li>
              <?php elseif($n['post_type'] == 'document'):?>
              <?php
              $path = pathinfo(get_attached_file( $n['file'][0]));
              $file_size = round(filesize( get_attached_file( $n['file'][0]))/(1024),2);
              ?>          
              <li><a href="?file_id=<?php echo $n['file'][0]?>" title=""><?php echo $n['title']?>
                  <span  class="date"><?php echo date('d/m/Y',  strtotime($n['post_date']))?></span>
                </a>
              </li>
              <?php elseif($n['post_type'] == 'rss'):?>
              <?php $link_rss = get_post_meta($n['ID'],'link_value', true)?>
              <li><a href="<?php echo $link_rss?>" title=""><?php echo $n['title']?>
                  <span  class="date"><?php echo date('d/m/Y',  strtotime($n['post_date']))?></span>
                </a>
              </li>
              
              <?php endif?>
              
              <?php endforeach;?>
              <?php endif;?>
            </ul>
        </div>
    </div>
    <span class="line-shadow"></span>
</div>
</div>  
<?php get_footer(); ?>