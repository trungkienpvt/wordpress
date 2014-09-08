<ul class="events-travel">    
<?php foreach($arr_data as $item):  ?>
<?php 
$id = $item->ID;
$day= get_post_meta($id,'create_date');
$month = get_post_meta($id,'create_month');
$address = get_post_meta($id,'address');
$title = $item->post_title;
?>  

            <li>
              <div class="date-ev"><span class="ev-day"><?php echo $day[0]?></span><span class="ev-mon">/<?php echo $month[0]?></span></div>
              <div class="detail-ev">
                <p class="ev-title"><?php echo $title?></p>
                <p class="team-name"><?php echo $address[0]?></p>
              </div>
            </li>
        <?php   endforeach; ?>

          </ul>