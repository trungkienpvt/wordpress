<?php
/**
 * Template Name: Contact
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
get_header(); ?>
<div class="contact-page">
    <?php while ( have_posts() ) : the_post() ?>
    <ul class="breadcrumb">
            <li class="active"><a href="" title="<?php echo __('CONTACT US', THEMENAME)?>"><?php echo __('CONTACT US', THEMENAME)?></a>
            </li>
          </ul>
        <?php the_content() ?>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>