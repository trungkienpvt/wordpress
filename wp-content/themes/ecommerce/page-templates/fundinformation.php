<p>
<?php
echo $data['post_content'];
?>
  
</p>

<ul>
  <?php for($i=0;$i<count($data['file']['name']);$i++):?>
  <?php echo '<li>' . $data['file']['name'][$i] .'</li>'?>
  <?php endfor;?>
</ul>
<h3>FAQ</h3>
<ul>
  <?php if(!empty($data['faq'])):
    foreach($data['faq'] as $item):
    ?>
      <li>
    <span><?php echo $item->post_title?></span>
    <p><?php echo $item->post_content?></p>
  </li>
      <?php
    endforeach;
    
  endif; ?>
  
  
</ul>
