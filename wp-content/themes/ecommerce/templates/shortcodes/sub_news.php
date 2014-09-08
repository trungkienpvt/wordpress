<?php 

$images = get_option('taxonomy_image_plugin');
$term_data = wp_get_post_terms($arr_data[0]['ID'], 'newstype', array('fields' => 'all'));
$term_image = wp_get_attachment_image( $images[$term_data[0]->term_taxonomy_id], 'medium' );
?>
<div class="block-red">
<div class="thumbs-icon">
      <a href="#" title="<?php echo $term_data[0]->name?>" class="thumb"><?php echo $term_image?><span><?php echo $term_data[0]->name?></span></a>
          </div>
          <div class="list-thumb"> 
            <ul> 
              <?php foreach($arr_data as $item):?>
                  <?php if(isset($item['file'][0])):
                $path = pathinfo(get_attached_file( $item['file'][0]));
                $file_size = round(filesize( get_attached_file( $item['file'][0]))/(1024),2);
                  ?>
                  <li class="thumbs-line">
                    <div class="thumbs-line-content">
                    <p class="date"><?php echo __('Releases date ', THEMENAME) . date(DATE_FORMAT, strtotime($item['release_date']))?></p><a href="?file_id=<?php echo $item['file'][0]?>" title="VNL divestment of Vina Properties Pte  [PDF, 144kb]" class="link-red"><span class="ico icon-list-arrow"></span><span><?php echo $item['title']?>[<?php echo strtoupper($path['extension'])?>, <?php echo $file_size?>kb]</span></a>
                    </div><a href="?file_id=<?php echo $item['file'][0]?>" title="icon download" class="img"><span class="ico icon-download"></span></a>
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
              <?php endforeach;?>
              <?php if( $next_page!=0):?>
              <a href="<?php echo home_url()?>/regulatory-news-press-release/?ajax=1&type=lazyload_news&term=<?php echo $term_data[0]->slug?>&pages=<?php echo $next_page?>" title="ajax" class="next-page hidden"></a>
              <?php endif;?>    
            </ul>
            <a href="<?php echo get_bloginfo('url')?>/regulatory-news-press-release/" title="Read More" class="btn"><span><?php echo __( 'Back', THEMENAME )?></span><span class="ico icon-back"></span></a>
          </div>
</div>