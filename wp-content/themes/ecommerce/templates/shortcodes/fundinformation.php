<?php
?>
<ul class="fund-down">
  <?php for($i=0;$i<count($data['file']['name']);$i++):
    if($data['file']['name'][$i]!='' && $data['file']['id'][$i]!=''):
    ?>
  <li><span><?php echo $data['file']['name'][$i]?></span><a href="<?php echo "?file_id=" . $data['file']['id'][$i]?>" title="download" class="img"><span class="ico icon-download"></span></a></li>
  <?php
  endif;
  ?>
  <?php endfor;?>
  <li><span><?php echo __('FAQs', THEMENAME)?></span><a href="undefined" title="undefined" class="img"><span class="ico icon-undefined"></span></a>
  </li>
</ul>
<div class="fund-request">
          <ul class="quest-fund">
            <?php if(!empty($data['faq'])):
              $count = 1;
    foreach($data['faq'] as $item):
    ?>
            <li><a class="<?php echo ($count==1?"active":"")?>" href="<?php echo '?ajax=1&type=faq&id=' . $item->ID?>" title="<?php echo $item->post_title?>"><?php echo($count<10?"0" . $count . '. ' .$item->post_title :$count . '. ' .$item->post_title) ?></a>
  </li>
      <?php
      $count++;
    endforeach;
    
  endif; ?>
  
</ul>
<div class="replies"><span class="line-top"></span>
            <div class="scroll-container">
              <div class="scroll-cont-wrap">
                <div class="scroll-cont">
                <p class="replies-list"><?php 
                $content = $data['faq'][0]->post_content;
                $content = str_replace('<p>', '', $content);
                $content = str_replace('</p>', '', $content);
                
                echo $content?></p>
                </div>
              </div>
              <div class="scroll-bar"><a href="javascript:void(0);" title="Up" class="btn-scroll btn-up">Up</a><a href="javascript:void(0);" title="" class="dragger v-dragger"></a><a href="javascript:void(0);" title="Down" class="btn-scroll btn-down">Down</a>
              </div>
            </div>
          </div>
  </div>