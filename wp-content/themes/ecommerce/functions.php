<?php
/**
 * ecommerce functions and definitions
 */

// define constants use in theme
define( 'THEMENAME', 'demo' );
define( 'THEMEDIR', get_template_directory() );
define( 'THEMEURL', get_template_directory_uri() );
define( 'POST_PER_PAGE_1',3);
define( 'POST_PER_PAGE_2',10);
define( 'DATE_FORMAT', 'd/m/Y' );
define( 'KEY_RUN_CRON', '1234561' );
define( 'GROUP_PER_PAGE', '10' );
// load functions support in theme
require_once THEMEDIR .'/inc/loader.php';
/**
 * Sets up theme defaults and registers the various WordPress features that
 */
function sm_theme_setup() {
    load_theme_textdomain( THEMENAME, get_template_directory() . '/languages' );

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menu( 'primary', __( 'Primary Menu', THEMENAME ) );
    register_nav_menu( 'banner', __( 'Banner Menu', THEMENAME ) );

    // This theme uses a custom image size for featured images, displayed on "standard" posts.
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
    add_image_size( 'image_34_33', 34, 33, true );
    add_image_size( 'image_73_72', 73, 72, true );
    add_image_size( 'image_1024_572', 1024, 572, true );
    add_image_size( 'image_54_47', 54, 47, true );
    add_image_size( 'image_112_112', 112, 112, true );
//    create_post_type();
}
add_action( 'after_setup_theme', 'sm_theme_setup' );

/**
 * Register scripts & styles use in theme
 */
function sm_theme_scripts_styles() {
    global $wp_styles;

    // Adds JavaScript for handling the navigation menu hide-and-show behavior.
    wp_enqueue_script( 'demo-navigation', THEMEURL . '/js/navigation.js', array(), '1.0', true );

    // Loads our main stylesheet.
    wp_enqueue_style( 'demo-style', get_stylesheet_uri() );
    // Loads the Internet Explorer specific stylesheet.
    wp_enqueue_style( 'demo-ie', THEMEURL . '/css/ie.css', array( 'demo-style' ), '20121010' );
    $wp_styles->add_data( 'demo-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'sm_theme_scripts_styles' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function sm_theme_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', THEMENAME ), max( $paged, $page ) );

    return $title;
}
add_filter( 'wp_title', 'sm_theme_wp_title', 10, 2 );

/**
 * Register two widget areas.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return void
 */

function demo_widgets_init() {
	register_sidebar( array(
		'name' => __( 'First Sidebar', 'demo' ),
		'id' => 'sidebar-1',
		'description' => __( 'Load first menu list', 'demo' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
  register_sidebar( array(
		'name' => __( 'Latest fund share prices', THEMENAME ),
		'id' => 'sidebar-2',
		'description' => __( 'Latest fund share prices', THEMENAME ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'demo_widgets_init' );
add_action('download_file','download_file');
add_action( 'wp_ajax_load', 'ajax_load' );

/**
 * Load second menu to FO
 * @global type $wpdb
 */
function load_sub_menu(){
  global $wpdb;
    $current_postid  = get_the_ID();
    $current_url = get_permalink( $current_postid );
    //get root menu
    $arr_menu = wp_get_nav_menu_items( 'Menu 1' );
    if( !empty($arr_menu) ) {
	    foreach($arr_menu as $item) {
	      if($item->url == $current_url) {
	        $_SESSION['current_menu'] = $item->ID;
	        if($item->menu_item_parent==0){
	          $_SESSION['parent_menu_id'] = $item->ID;
	          $_SESSION['root_menu'] = true;
	        }
	        else {
	          $_SESSION['root_menu'] = false;
	          $_SESSION['parent_menu_id'] = $item->menu_item_parent;
	
	        }
	      }
	    }
	    foreach($arr_menu as $item) {
	      if($item->ID == $_SESSION['parent_menu_id']) {
	        $_SESSION['parent_menu_title'] = $item->title;
	        break;
	      }
	    }
	    $current_root_menu = $_SESSION['parent_menu_id'];
	    $current_root_menu_title = $_SESSION['parent_menu_title'];
	    foreach($arr_menu as $item) {
	      if($item->menu_item_parent!=0 && $item->post_status=='publish' && $item->menu_item_parent==$current_root_menu){
	          $arr['data'] = $item;
	          if($_SESSION['current_menu'] == $item->ID)
	            $arr['active_link'] = 'active';
	          else
	            $arr['active_link'] = '';
	          $arr_second_menu[] = $arr;
	
	      }
	    }
    }
    if($_SESSION['root_menu']) {
      $arr_second_menu[0]['active_link'] = 'active';
      $_SESSION['current_post_url'] = $arr_second_menu[0]['data']->url;
    }else{
      $_SESSION['current_post_url'] = '';
    }
//    echo '<pre>';
//    print_R($arr_second_menu);
//    echo '</pre>';
//    exit;
    include_once 'templates/second_menu.php';
  
}

add_action( 'wp_load_sub_menu', 'load_sub_menu' );
add_theme_support('post-thumbnails');

/**
 * Remove view post button in custom post type
 * @global type $post_type
 */
function sm_admin_css() {
global $post_type;
if(get_post_type() != 'post') {
echo '<style type="text/css">#view-post-btn,
#post-preview,.updated p a{display: none;}.view{display:none;}</style>';
}
}
add_action('admin_head', 'sm_admin_css'); 
