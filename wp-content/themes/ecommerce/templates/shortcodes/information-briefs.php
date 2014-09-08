
    <ul> 
      <?php foreach($arr_data as $item):  ?>
      <?php $path = pathinfo(get_attached_file( $item['file'][0]));
            $file_size = round(filesize( get_attached_file( $item['file'][0]))/(1024),2);
      ?>
      <li class="thumbs-line"> 
        <div class="thumbs-line-content">
          <p class="date"><?php echo __('Releases date ', THEMENAME) . date(DATE_FORMAT, strtotime($item['release_date']))?></p><a href="?file_id=<?php echo $item['file'][0]?>" title="VNL divestment of Vina Properties Pte  [PDF, 144kb]" class="link-red"><span class="ico icon-list-arrow"></span><span><?php echo $item['title']?>[<?php echo strtoupper($path['extension'])?>, <?php echo $file_size?>kb]</span></a>
        </div>
        <a href="?file_id=<?php echo $item['file'][0]?>" title="icon download" class="img"><span class="ico icon-download"></span></a>
      </li>
      <?php endforeach;?>
    </ul>
