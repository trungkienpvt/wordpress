<?php
/**
 * Define shortcode function
 */

/**
 * Register shortcode use in theme
 */
add_shortcode( 'display_posts', 'sm_theme_shortcode_display_posts' );

/**
 * function handle shortcode display_posts
 */
function sm_theme_shortcode_display_posts( $atts ) {
    // merge param option with default option
    if(isset($atts['type']) && $atts['type'] == 'page') {
      switch($atts['name']) {
        case "aboutus":
          $current_post_url = $_SESSION['current_post_url'];
          if(!empty($current_post_url))
            $id = url_to_postid( $current_post_url );
          else
            $id = get_the_ID();
          $post_data = get_post($id);
          $data['post_content'] = $post_data->post_content;
          $data['file']['name'] = get_post_meta($post_data->ID,'file_name');
          $data['file']['id'] = get_post_meta($post_data->ID,'attachment_file');
          //get list post with post_type='faq'
          $args = array(
            'post_type' => 'faq',
            'post_status' => 'publish'
          );
          $query = new WP_Query( $args );
          $data['faq'] = $query->get_posts();
          break;
        
      }
    }else {
    	if( isset($atts['taxonomy']) && isset($atts['term']) ) {
    		$args = array (
          	'post_type' => $atts['type'],
    		'tax_query' => array(
              array(
              'taxonomy' => $atts['taxonomy'],
              'field' => 'slug',
              'terms' => $atts['term']
              )
            )
      		);
    	}else {
    		$args = array (
          		'post_type' => $atts['type'],
      		);
    	}	
      $loop = new WP_Query( $args );
      $data = array (
          'loop' => $loop
      );
    }
    return sm_theme_load_shortcode_template( $atts['template'], $data );
}

/**
 * function load shortcode template
 */
function sm_theme_load_shortcode_template( $template_name, $data = array() ) {
    if ( $data && is_array( $data ) ) {
        extract( $data );
    }
    
    $template_file = sprintf( THEMEDIR . '/templates/shortcodes/%s.php', $template_name );
    ob_start();
    if ( file_exists( $template_file ) ) {
        include $template_file;
    }
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}