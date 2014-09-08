<div class="contact-us">

  <?php $count = 0;?>
  <?php if(!empty($arr_data)):?>
  <?php
  for($i=0;$i<count($arr_data)-1;$i++) {
    for($j=$i+1;$j<count($arr_data);$j++) {
      $ordering_1 = get_post_meta($arr_data[$i]->ID,'ordering_value',true);
      $ordering_2 = get_post_meta($arr_data[$j]->ID,'ordering_value',true);
      if($ordering_1>$ordering_2) {
        $tmp = $arr_data[$i];
        $arr_data[$i] = $arr_data[$j];
        $arr_data[$j] = $tmp;
      }
    }
  }
  ?>
<?php foreach($arr_data as $item):  ?>
<?php 
$id = $item->ID;
$day= get_post_meta($id,'create_date');
$month = get_post_meta($id,'create_month');
$address = get_post_meta($id,'address');
$code = get_post_meta($id,'city_value');
$title = $item->post_title;
?>  
  <?php if($count==count($arr_data)-1):?>
  <?php $content = str_replace('<p>', '', $item->post_content);
        $content = str_replace('</p>', '', $content);
        $content = str_replace('<ul>', '', $content);
        $content = str_replace('</ul>', '', $content)
      ?>
  <?php echo $content?>
  <?php else:?>
  <li>
    <div class="adds-contact"><span><?php echo (isset($code[0]) && $code[0]!=''?ucfirst($code[0]):ucfirst(cutString($title,20,' ','')))?></span><span class="city">city</span></div>
              <div class="detail-contact">
                <h2 class="title"><?php echo $title?></h2>
                <div class="inner">
                  <?php echo $item->post_content?>
                </div>
              </div>
  </li>
  <?php endif?>
  <?php $count++;?>
  
        <?php   endforeach; ?>
<?php endif?>  
  
  <?php?>
</div>