<?php
/**
 * Template display content banner
 */
?>
<?php
$agrs = array(
    'post_type' => 'banner',
    'post_status' => 'publish',
    'orderby' => 'rand',
    'posts_per_page' => 5
);
$loop = new WP_Query( $agrs );
$results = $loop->get_posts();
if ( !empty($results) ) :
?>
    <?php wp_nav_menu( array('theme_location' => 'banner', 'menu_class' => 'list-fund', 'container' => '') ) ?>
	<div id="project-home" class="slideshow">
		<ul class="preview">
			<?php foreach ($results as $item): ?>
			<li>
				<div class="title"><span><?php echo $item->post_title ?></span></div>
				<?php  $image = get_the_post_thumbnail($item->ID,'image_1024_572'); ?>
				<?php echo $image?>
            </li>
			<?php endforeach;?>
		</ul>            
		<?php wp_reset_postdata() ?>
    </div>
<?php endif ?>
