<?php
/**
 * Template Name: Media Coverage
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
<div class="media-page">
    <?php while ( have_posts() ) : the_post() ?>
    <?php do_action('wp_load_sub_menu')?>
        <?php the_content() ?>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>