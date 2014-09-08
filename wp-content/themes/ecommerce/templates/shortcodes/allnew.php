<div id="all-news">
<div class="block-red">
    <div class="thumbs-icon">
      <a href="<?php echo get_bloginfo('url')?>/report" title="<?php echo __('Report', THEMENAME)?>" class="thumb"><img src="<?php echo get_template_directory_uri()?>/images/icon-report.png" alt="<?php echo __('Report', THEMENAME)?>" class="ico"/><span><?php echo __('Report', THEMENAME)?></span></a>
          </div>
    <div class="list-thumb">
            <ul>
              <?php
              foreach($list_report as $item):
                  if(isset($item['file'][0]))
                  $path = pathinfo(get_attached_file( $item['file'][0]));
                  $file_size = round(filesize( get_attached_file( $item['file'][0]))/(1024),2);
              ?>
              <li class="thumbs-line">
                <div class="thumbs-line-content">
                  <p class="date"><?php echo __('Releases date ', THEMENAME) . date(DATE_FORMAT, strtotime($item['release_date']))?></p><a href="?file_id=<?php echo $item['file'][0]?>" title="VNL divestment of Vina Properties Pte  [PDF, 144kb]" class="link-red"><span class="ico icon-list-arrow"></span><span><?php echo $item['title']?>[<?php echo strtoupper($path['extension'])?>, <?php echo $file_size?>kb]</span></a>
                </div><a href="?file_id=<?php echo $item['file'][0]?>" title="icon download" class="img"><span class="ico icon-download"></span></a>
              </li>
              <?php endforeach; ?>
            </ul>
            <a href="<?php echo get_bloginfo('url')?>/report" title="Read More" class="btn"><span>Read More</span><span class="ico icon-next"></span></a>
          </div>
</div>
<div class="block-red">
    <div class="thumbs-icon">
      <a href="<?php echo get_bloginfo('url')?>/regulatory-news-press-release/" title="<?php echo __('News', THEMENAME)?>" class="thumb"><img src="<?php echo get_template_directory_uri()?>/images/icon-news.png" alt="<?php echo __('News', THEMENAME)?>" class="ico"/><span><?php echo __('News', THEMENAME)?></span></a>
          </div>
    <div class="list-thumb">
            <ul>
              <?php
              if(!empty($list_news['news'])):
              $count = 0;  
              foreach($list_news['news'] as $item):
                  if($count<POST_PER_PAGE_1):
                  $count ++;
                  if(isset($item['file'][0])):
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
                    <p class="date"><?php echo __('Releases date ', THEMENAME) . date(DATE_FORMAT, strtotime($item['release_date']))?></p><a href="<?php echo $link_rss[0]?>" title="<?php echo $item['title']?>" class="link-red" target="_blank"><span class="ico icon-list-arrow"></span><span><?php echo $item['title']?></span></a>
                    <p class="content"><?php echo $item['content']?></p>
                    </div>
                  </li>
                  <?php else:?>
                  <li class="thumbs-line">
                    <div class="thumbs-line-content">
                    <p class="date"><?php echo __('Releases date ', THEMENAME) . date(DATE_FORMAT, strtotime($item['release_date']))?></p><a href="?ajax=1&type=detail_news&id=<?php echo $item['ID']?>" title="<?php echo $item['title']?>" class="show-popup link-red"><span class="ico icon-list-arrow"></span><span><?php echo $item['title']?></span></a>
                    <!--<p class="content"><?php echo $item['content']?></p>-->
                    </div>
                  </li>
                    <?php
                  endif;
                  else: continue;
                endif;
              ?>
              <?php
              endforeach;
              endif

?>
            </ul>
      <a href="<?php echo get_bloginfo('url')?>/regulatory-news-press-release/" title="Read More" class="btn"><span>Read More</span><span class="ico icon-next"></span></a>
          </div>
</div>
<div class="block-red">
          <div class="thumbs-icon">
      <a href="<?php echo get_bloginfo('url')?>/media-coverage/" title="<?php echo __('Media Coverage', THEMENAME)?>" class="thumb"><img src="<?php echo get_template_directory_uri()?>/images/icon-media.png" alt="<?php echo __('Media Coverage', THEMENAME)?>" class="ico"/><span><?php echo __('Media Coverage', THEMENAME)?></span></a>
          </div>
          <div class="list-thumb">
            <ul>
              <?php
              if(!empty($list_news['media'])):
                $count = 0;  
              foreach($list_news['media'] as $item):
                if($count<POST_PER_PAGE_1):
                  $count ++;
                  if(isset($item['file'][0])):
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
                    <p class="content"><?php echo $item['content']?></p>
                    </div>
                  </li>
                    <?php
                    endif;
                    else: continue;
                endif;
                  
                  
              ?>
              <?php
              endforeach;
            endif;
?>
            </ul>
            <a href="<?php echo get_bloginfo('url')?>/media-coverage/" title="Read More" class="btn"><span>Read More</span><span class="ico icon-next"></span></a>
          </div>
</div>
<div class="block-red">
          <div class="thumbs-icon">
      <a href="<?php echo get_bloginfo('url')?>/information-briefs" title="<?php echo __('Information Briefs', THEMENAME)?>" class="thumb"><img src="<?php echo get_template_directory_uri()?>/images/icon-information.png" alt="<?php echo __('Information Briefs', THEMENAME)?>" class="ico"/><span><?php echo __('Information Briefs', THEMENAME)?></span></a>
          </div>
          <div class="list-thumb">
            <ul>
              <?php
              if(!empty($list_information_brif)):
                $count = 0;  
              foreach( $list_information_brif as $item):
                if($count<POST_PER_PAGE_1):
                  $count ++;
                  if(isset($item['file'][0])):
                    
                    $path = pathinfo(get_attached_file( $item['file'][0]));
                  $file_size = round(filesize( get_attached_file( $item['file'][0]))/(1024),2);
                  ?>
                  <li class="thumbs-line">
                    <div class="thumbs-line-content">
                    <p class="date"><?php echo __('Releases date ', THEMENAME) . date(DATE_FORMAT, strtotime($item['release_date']))?></p><a href="?file_id=<?php echo $item['file'][0]?>" title="VNL divestment of Vina Properties Pte  [PDF, 144kb]" class="link-red"><span class="ico icon-list-arrow"></span><span><?php echo $item['title']?>[<?php echo strtoupper($path['extension'])?>, <?php echo $file_size?>kb]</span></a>
                    </div><a href="?file_id=<?php echo $item['file'][0]?>" title="icon download" class="img"><span class="ico icon-download"></span></a>
                  </li>
                    <?php
                  endif;
                  else: continue;
                endif;
              ?>
              <?php
              endforeach;
            endif;
?>
            </ul>
            <a href="<?php echo get_bloginfo('url')?>/information-briefs" title="Read More" class="btn"><span>Read More</span><span class="ico icon-next"></span></a>
          </div>

</div>
</div>