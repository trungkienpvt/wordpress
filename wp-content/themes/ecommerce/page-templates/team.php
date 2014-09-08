
<?php
if(!empty($resultTeam)):
  foreach($resultTeam as $item):
  ?>
  <div class="thumnail">
          <div class="figure"><?php $image = get_the_post_thumbnail($item->ID, 'thumbnail');
  echo $image;
  ?><span><?php echo $item->post_title?></span>
          </div>
          <div class="caption">
            <div class="inner">
              <h2><?php echo $item->post_title?></h2><span class="regency"><?php $arr = get_post_meta($item->ID,'position'); echo $arr[0]?></span>
              <p><?php echo $item->post_content?></p>
            </div>
          </div>
  </div>
    <?php
  endforeach;
endif;



?>
