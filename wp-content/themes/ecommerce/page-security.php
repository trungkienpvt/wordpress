<?php
/**
 * Template Name: Security
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage demo
 * @since demo 1.0
 */
// download file when client request
do_action('download_file');
do_action('wp_ajax_load');
get_header(); ?>
<?php $post = get_post()?>
<div class="aim3-page">
  <?php do_action('wp_load_sub_menu')?>
  <div class="block-red">
            <div class="thumbs-icon"><a href="#" title="Financial Information" class="thumb thumb-hide-icon">
            <?php $image = get_the_post_thumbnail($post->ID, 'thumbnail');
            echo $image;
            ?>
            <span>Financial Information</span></a>
            </div>
            <div class="list-thumb">
              <h2><?php echo ($post->post_title)?></h2>
              <div class="contents">
                <?php echo ($post->post_content)?>
                </div>
            </div>
  </div>
</div>
<?php get_footer(); ?>