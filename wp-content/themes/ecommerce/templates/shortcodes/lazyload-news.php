
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
                    <p class="content"><?php echo $item['content']?></p>
                    </div>
                  </li>
                  <?php endif;?>
              <?php endforeach;?>
              <?php if( $next_page!=0 ):?>
              <a href="<?php echo home_url()?>/regulatory-news-press-release/?ajax=1&type=lazyload_news&term=<?php echo $category?>&pages=<?php echo $next_page?>" title="ajax" class="next-page hidden"></a>
              <?php endif;?>
