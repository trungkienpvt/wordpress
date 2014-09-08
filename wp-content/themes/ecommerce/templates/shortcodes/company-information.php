    <?php foreach($arr_data as $item):  ?>
    <?php $image = get_the_post_thumbnail($item->ID, 'thumbnail');  ?>
  <div class="block-red">
    <div class="thumbs-icon">
      <a href="#" title="" class="thumb">
        <?php echo $image?>
      </a>
    </div>
    <div class="list-thumb">
              <h2><?php echo $item->post_title?></h2>
              <div class="contents">
                <?php 
                $content = str_replace('[base_url]', get_bloginfo('url'), $item->post_content);
                echo $content?>
              </div>
            </div>
  </div>
        <?php   endforeach; ?>

