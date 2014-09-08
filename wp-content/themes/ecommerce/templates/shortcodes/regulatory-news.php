<div class="outer">
  <div id="content">
    <?php
    //load report data
    foreach($arr_taxonomy as $t):
      if($t->slug!='media-coverage'):
      //get term image
      $images = get_option('taxonomy_image_plugin');
      $term_image = wp_get_attachment_image( $images[$t->term_taxonomy_id], 'image_54_47' );
      ?>
  <div class="block-red">
    <div class="thumbs-icon">
      <a href="#" title="<?php echo $t->name?>" class="thumb">
        <?php echo $term_image?><span><?php echo $t->name?></span></a>
    </div>
  <div class="list-thumb"> 
    <ul> 
      <?php $count = 0;?>
      <?php foreach($arr_data as $item): ?>
      <?php if( $item['category'] == $t->slug ): ?>
      <?php if( $count < POST_PER_PAGE_1 ):?>  
      <?php $count ++;?>
      <?php if(isset($item['file'][0])):
                $path = pathinfo(get_attached_file( $item['file'][0]));
                $file_size = round(filesize( get_attached_file( $item['file'][0]))/(1024),2);
                  ?>
                  <li class="thumbs-line">
                    <div class="thumbs-line-content">
                    <p class="date"><?php echo __('Releases date ', THEMENAME) . date(DATE_FORMAT, strtotime($item['release_date']))?></p><a href="?file_id=<?php echo $item['file'][0]?>" title="VNL divestment of Vina Properties Pte  [PDF, 144kb]" class="link-red"><span class="ico icon-list-arrow"></span><span><?php echo $item['title']?>[<?php echo strtoupper($path['extension'])?>, <?php echo $file_size?>kb]</span></a>
                    </div><a href="?file_id=<?php echo $item['file'][0]?>" title="icon download" class="img"><span class="ico icon-download"></span></a>
                  </li>
                  <?php elseif( $item['post_type'] == 'rss'):?>
                  <?php $link_rss = get_post_meta($item['ID'],'link_value')?>
                  <li class="thumbs-line">
                    <div class="thumbs-line-content">
                    <p class="date"><?php echo __('Releases date ', THEMENAME) . date(DATE_FORMAT, strtotime($item['release_date']))?></p><a href="<?php echo $link_rss[0]?>" title="<?php echo $item['title']?>" class="show-popup link-red"><span class="ico icon-list-arrow"></span><span><?php echo $item['title']?></span></a>
                    <p class="content"><?php echo $item['content']?></p>
                    </div>
                  </li>
                  
                  <?php else:?>
                  <li class="thumbs-line">
                    <div class="thumbs-line-content">
                    <p class="date"><?php echo __('Releases date ', THEMENAME) . date(DATE_FORMAT, strtotime($item['release_date']))?></p><a href="?ajax=1&type=detail_news&id=<?php echo $item['ID']?>" title="<?php echo $item['title']?>" class="show-popup link-red"><span class="ico icon-list-arrow"></span><span><?php echo $item['title']?></span></a>
                    <p class="content"><?php // echo $item['content']?></p>
                    </div>
                  </li>
                    <?php
                  endif;
              ?>
                  <?php else:continue;?>
                  <?php endif?>
                  <?php endif ?>
              <?php endforeach;?>
    </ul>
    <a href="?ajax=1&type=news&term=<?php echo $t->slug?>" title="Read More" class="btn"><span>Read More</span><span class="ico icon-next"></span></a>
  </div>
</div>    
        <?php
        endif;
    endforeach;
    ?>
  </div>
  <div id="content-more"></div>
</div>
  
