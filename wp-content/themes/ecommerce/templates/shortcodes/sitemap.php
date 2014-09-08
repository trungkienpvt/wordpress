
<?php
if(!empty($loop)):
  while($loop->have_posts()){
  $loop->the_post();
  $id = get_the_ID();
  $title = get_the_title();
  $content = get_the_content();
  $term_list = wp_get_post_terms($id, 'group', array("fields" => "slugs"));
  if(!empty($term_list))
    $category = $term_list[0];
  else
    $category = '';
  if($category == 'team'):
//  ?>
  <div class="thumnail">
    <div class="figure"><?php $image = get_the_post_thumbnail($id, 'thumbnail');
  echo $image;
  ?><span><?php echo $title?></span>
          </div>
          <div class="caption">
            <div class="inner">
              <h2><?php echo $title?></h2><span class="regency"><?php $arr = get_post_meta($id,'position'); echo $arr[0]?></span>
              <p><?php echo $content?></p>
            </div>
          </div>
  </div>
    <?php
endif;
  };
endif;



?>
