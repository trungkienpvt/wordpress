<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage demo
 * @since demo 1.0
 */
// download file when client request
do_action('download_file');
do_action('wp_ajax_load');
global $wpdb;
$key_search = $_REQUEST['s'];
if(isset($_REQUEST['pages'])) {
  $paged = $_REQUEST['pages'];
  if($paged > LIMIT_NUM_PAGE) {
  }
}else {
  $paged = 1;
}
  


$args = array(
  'post_type' => 'news',
  'post_status'=>'publish',
  
);

$arr_results = array();
  $query_1 = "
        SELECT      *
        FROM        $wpdb->posts
        WHERE       $wpdb->posts.post_title LIKE '%$key_search%'
        AND         $wpdb->posts.post_type IN('news','report','document','rss') 
        AND         $wpdb->posts.post_status = 'publish'  
        ORDER BY    $wpdb->posts.post_title DESC LIMIT " . ($paged-1)*POST_PER_PAGE_2 . ',' . POST_PER_PAGE_2;
  $query_2 = "
        SELECT      count(*) as num_row
        FROM        $wpdb->posts
        WHERE       $wpdb->posts.post_title LIKE '%$key_search%'
        AND         $wpdb->posts.post_type IN('news','report','document','rss') 
        AND         $wpdb->posts.post_status = 'publish'  
        ORDER BY    $wpdb->posts.post_title DESC";
$arr_results = $wpdb->get_results($query_1);
$result_2 = $wpdb->get_row($query_2);
if(!empty($result_2))
  $total_items = $result_2->num_row;
else
  $total_items = 0;
if(!empty($total_items)) {
  $total_page = ceil($total_items/POST_PER_PAGE_2);
}
//get mime type by content type
$arr_mime_types = array(
  'application/pdf'=>'PDF/Adobe Acrobat',
  'application/msword'=>'DOC/MS Word',
  'application/vnd.ms-excel'=>'XLS/MS Excel',
  'application/vnd.ms-excel'=>'XLS/MS Excel',
  'application/vnd.ms-powerpoint'=>'PPT/MS Powerpoint',
  'application/vnd.ms-powerpoint'=>'PPT/MS Powerpoint',
  'video/mpeg'=>'MPEG/',
  'text/plain'=>'TXT/',
  'image/jpeg'=>'JPEG/',
    );

$total_group = ceil($total_page/GROUP_PER_PAGE);
for($i=0;$i<$total_group;$i++) {
  if($paged <= ($i+1)*GROUP_PER_PAGE && $paged>$i*GROUP_PER_PAGE) {
    $begin_poin = $i*GROUP_PER_PAGE + 1;
  }
}
if($end_poin==$total_page && $paged > $total_page - GROUP_PER_PAGE)
  $begin_poin = $total_page - GROUP_PER_PAGE;
if($total_page > $begin_poin + GROUP_PER_PAGE) {
    $end_poin = $begin_poin + GROUP_PER_PAGE - 1;
}else {
  $end_poin = $total_page;
}
get_header(); ?>
<div class="search-page">
  <header>
      <h1><?php echo __('Search', THEMENAME)?></h1>
  </header>
    <h2 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
    <ul class="search-result">
  <?php if(!empty($arr_results)):?>
  <?php foreach($arr_results as $item):?>
  <?php if($item->post_type == 'news'):?>
  <li>
      <div class="search-block">
          <a href="?ajax=1&type=detail_news&id=<?php echo $item->ID?>" class="show-popup"><h4><?php echo $item->post_title?></h4></a>
<!--        <div class="contents">
          <?php echo substr($item->post_content,0,100)?>
      </div>-->
    </li>
  <?php elseif($item->post_type == 'rss'):?>
    <?php $link_rss = get_post_meta($item->ID,'link_value',true)?>
  <li>
      <div class="search-block">
        <a class="" target="_blank" href="<?php echo $link_rss?>"<h4><?php echo $item->post_title?></h4></a>
        <div class="contents">
          <?php echo $item->post_content?>
      </div>
    </li>  
  <?php elseif($item->post_type == 'document' || $item->post_type == 'report'):?>
    <?php
    $file= get_post_meta($item->ID,'document_file',true);
    $path = pathinfo(get_attached_file( $file));
    $file_path = $path['dirname'] . '/' . $path['basename'];
    if(file_exists($file_path)):
    $mime_content = mime_content_type($file_path);
    if(isset($arr_mime_types[$mime_content]))
      $file_format = $arr_mime_types[$mime_content];
    else
      $file_format = 'Document';
    ?>
    <li>
      <div class="search-block">
        <h4><?php echo $item->post_title?></h4>
        <div class="contents"><p>File Format: <?php echo $file_format?></p></div>
      </div>
      <a href="?file_id=<?php echo $file?>" title="icon download" class="img"><span class="ico icon-download"></span></a>
    </li>
    <?php endif?>
  <?php endif?>
  <?php endforeach?>
  <?php endif?>
</ul>
    <?php if($total_page>1):
      ?>
    <div class="paging">
            <div class="outer">
              <a href="<?php echo get_bloginfo('url')?>?s=<?php echo $key_search?>&pages=<?php echo (($paged-1)>=1?($paged-1):$paged)?>" title="Prev" class="prev"><span>&lt;</span></a>
              <ul class="inner">
                <?php
                  
                ?>
                <?php if($begin_poin>1):?>
                <li>(...)</li>
                <?php endif?>
                <?php for($i = $begin_poin;$i<= $end_poin;$i++):?>
                <?php $active_class = ($i==$paged?'current-page':'')?>
                <li class="<?php echo $active_class?>"><a href="<?php echo get_bloginfo('url')?>?s=<?php echo $key_search?>&pages=<?php echo $i?>" title="page<?php echo $i?>"><?php echo $i?></a>
                <?php endfor?>
                <?php if($end_poin < $total_page):?>
                <li>(...)</li>
                <?php endif?>
              </ul>
              <a href="<?php echo get_bloginfo('url')?>?s=<?php echo $key_search?>&pages=<?php echo ($paged+1<=$total_page?($paged+1):$paged)?>" title="Next" class="next"><span>&gt;</span></a>
            </div>
          </div>
    <?php endif?>
</div>
<?php get_footer(); ?>
