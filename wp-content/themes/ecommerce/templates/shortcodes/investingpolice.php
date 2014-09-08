<?php
if(!empty($data['investing'])):
  foreach($data['investing'] as $item):
  ?>
<div class="block-red">
          <div class="thumbs-icon"><a href="#" title="<?php echo $item->post_title?>" class="thumb thumb-hide-icon">
              <?php $image = get_the_post_thumbnail($item->ID, 'image_34_33');
  echo $image;
  ?><span>Investing policy</span></a>
          </div>
          <div class="list-thumb">
            <h2><?php echo $item->post_title?></h2>
            <div class="contents"><p><?php echo $item->post_content?></p></div>
          </div>
        </div>
    
    <?php
  endforeach;
endif;
?>
