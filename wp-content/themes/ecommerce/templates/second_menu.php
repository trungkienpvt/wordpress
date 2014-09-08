<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<ul class="breadcrumb">
  <li><a href="#"><?php echo $current_root_menu_title?></a></li>
  <?php if(!empty($arr_second_menu)):
    foreach($arr_second_menu as $item):
    ?>
      <li class="<?php echo $item['active_link']?>"><a href="<?php echo $item['data']->url?>" title="<?php echo $item['data']->title?>"><?php echo $item['data']->title?></a>
      <?php
    endforeach;
  endif;
?>
</ul>
