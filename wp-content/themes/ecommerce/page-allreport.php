<?php
/**
 * Template Name: All Report
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
    <?php while ( have_posts() ) : the_post() ?>
<div class="aboutfund-page">
    <?php do_action('wp_load_sub_menu')?>
        <?php the_content() ?>
</div>
    <?php endwhile; ?>
<?php get_footer(); ?>