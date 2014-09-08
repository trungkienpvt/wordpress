<?php
/**
 * Define functions used withs posts
 */

/**
 * Register post types use in theme
 */
function sm_theme_register_post_types() {
    // post type team
    register_post_type( 'faq', array (
        'labels' => array (
            'name' => __( 'FAQ' ),
            'singular_name' => __( 'FAQ' )
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => $icon = THEMEURL . '/images/articles_y.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array (
            'title',
            'editor',
            'thumbnail',
            'author'
        )
    ) );
    register_post_type( 'banner', array (
        'labels' => array (
            'name' => __( 'Banners' ),
            'singular_name' => __( 'Banners' )
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => THEMEURL . '/images/articles_y.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array (
            'title',
            'thumbnail'
        )
    ) );
    
    register_post_type( 'news', array (
        'labels' => array (
            'name' => __( 'News' ),
            'singular_name' => __( 'News' )
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => $icon = THEMEURL . '/images/articles_y.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array (
            'title',
            'editor',
            'thumbnail',
            'author'
        ),
        'taxonomies' => array (
            'newstype'
        )
    ) );
    
    register_post_type( 'rss', array (
        'labels' => array (
            'name' => __( 'Rss' ),
            'singular_name' => __( 'Rss' )
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => $icon = THEMEURL . '/images/articles_y.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array (
            'title','editor'
        ),
        'taxonomies' => array (
            'newstype'
        )
    ) );
    
    register_post_type( 'products', array (
        'labels' => array (
            'name' => __( 'Products' ),
            'singular_name' => __( 'Products' )
        ),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => $icon = THEMEURL . '/images/1399107342_Item_3D.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array (
            'title','editor'
        ),
        'taxonomies' => array (
            'products'
        )
    ) );
    
    
}
add_action( 'init', 'sm_theme_register_post_types' );

/**
 * Register taxonomies use in theme
 */
function sm_theme_register_taxonomies() {
    // Register taxonomy team group
    register_taxonomy('products', array('products'), array (
        // Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'Categories', THEMENAME ),
            'singular_name' => _x( 'Categories', THEMENAME ),
            'search_items' =>  __( 'Search Categories', THEMENAME ),
            'all_items' => __( 'All Products', THEMENAME ),
            'parent_item' => __( 'Parent Categories', THEMENAME ),
            'parent_item_colon' => __( 'Parent Categories:', THEMENAME ),
            'edit_item' => __( 'Edit Categories', THEMENAME ),
            'update_item' => __( 'Update Categories', THEMENAME ),
            'add_new_item' => __( 'Add New Categories', THEMENAME ),
            'new_item_name' => __( 'New Categories', THEMENAME ),
            'menu_name' => __( 'Categories', THEMENAME ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'products', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ));

    
    // Add new "News Type" taxonomy to Posts
    register_taxonomy('newstype', array('news','document', 'rss'), array(
        // Hierarchical taxonomy (like categories)
        'hierarchical' => true,
        // This array of options controls the labels displayed in the WordPress Admin UI
        'labels' => array(
            'name' => _x( 'News Type', THEMENAME ),
            'singular_name' => _x( 'News Type', THEMENAME ),
            'search_items' =>  __( 'Search News Type', THEMENAME ),
            'all_items' => __( 'All Type', THEMENAME ),
            'parent_item' => __( 'Parent News Type', THEMENAME ),
            'parent_item_colon' => __( 'Parent News Type:', THEMENAME ),
            'edit_item' => __( 'Edit News Type', THEMENAME ),
            'update_item' => __( 'Update News Type', THEMENAME ),
            'add_new_item' => __( 'Add New News Type', THEMENAME ),
            'new_item_name' => __( 'New News Type Name', THEMENAME ),
            'menu_name' => __( 'News Type', THEMENAME ),
        ),
        // Control the slugs used for this taxonomy
        'rewrite' => array(
            'slug' => 'newstype', // This controls the base slug that will display before each term
            'with_front' => false, // Don't display the category base before "/locations/"
            'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
        ),
    ));
}
add_action( 'init', 'sm_theme_register_taxonomies' );
function sm_add_taxonomy_filters() {
	global $typenow,$wpdb;
	switch($typenow){
    case 'news':case "document":case "rss":
      $tax_obj = get_taxonomy('newstype'); 
      $tax_slug = 'newstype';
      break;
    case 'reporttype':
      $tax_obj = get_taxonomy('reporttype'); 
      $tax_slug = 'reporttype';
      break;
  }
  if(!empty($tax_obj)) {
  $tax_name = $tax_obj->labels->name;
      $query = 'SELECT t.* from wp_terms t INNER JOIN wp_term_taxonomy tx ON t.term_id = tx.term_id WHERE tx.taxonomy = "'. $tax_slug .'"';
      $terms = $wpdb->get_results($query);
			if(count($terms) > 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>Show All $tax_name</option>";
				foreach ($terms as $term) { 
					echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .'</option>'; 
				}
				echo "</select>";
			}
  }
}
add_action( 'restrict_manage_posts', 'sm_add_taxonomy_filters' );

/**
 * Remove link view in list custom post type
 */
add_filter( 'post_row_actions', 'remove_row_actions', 10, 1 );
function remove_row_actions( $actions )
{
    if( get_post_type() != 'post' )
        unset( $actions['view'] );
    return $actions;
}

/**
 * Download file from browser
 *
 * @return type
 */
function download_file()
{
    include_once "EasyDownload.php";
    if(isset($_REQUEST['file_id']))
    	$file_id = $_REQUEST['file_id'];
    else
    	$file_id = 0;
    if ( isset( $file_id ) && $file_id != "" ) {
        $file_path = get_attached_file( $file_id );
        $path = pathinfo($file_path);
        $objDownload = new EasyDownload();
        // Set physical path
        $objDownload->setPath( $path['dirname'] );
        $objDownload->setFileName( $path['basename'] );
        $objDownload->setFileExtension($path['extension']);
        $objDownload->Send();
    } else {
        return;
    }
}

/**
 * Render ajax content 
 * @return type
 */
function ajax_load() {
  if(isset($_REQUEST['ajax']))
    $ajax = $_REQUEST['ajax'];
  else
    $ajax = '';
  if(isset($_REQUEST['pages']))
    $paged = $_REQUEST['pages'];
  else
    $paged = 1;
  if($ajax) {
    $type = $_REQUEST['type'];
    if(isset($_REQUEST['id']))
      $id = $_REQUEST['id'];
    else {
      $id = 0;
    }
    if(!empty($type)) {
      switch($type) {
      case 'faq':
        $post = get_postdata($id);
        echo $post['Content'];
        break;
      case "report":
        if(isset($_REQUEST['pages']))
          $paged = $_REQUEST['pages'];
        else
          $paged = 1;
        $term_slug = $_REQUEST['term'];
        $args = array(
            'post_type' => 'report',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' =>POST_PER_PAGE_2,
            'paged'=>$paged,
            'tax_query' => array(
              array(
              'taxonomy' => 'reporttype',
              'field' => 'slug',
              'terms' => $term_slug
            )
          )
          );
        $paging = custom_paging($args);
        $list_post = $paging['list'];
        $total_page = $paging['total_page'];
        $arr_data= array();
        if(!empty($list_post)) {
          foreach($list_post as $item) {

            $release_date = get_post_meta($item->ID,'release_date');
            if(!empty($release_date))
              $data['release_date'] = $release_date[0];
            else
              $data['release_date'] = '';
            $data['ID'] = $item->ID;
            $data['file']= get_post_meta($item->ID,'document_file');
            $data['title'] = $item->post_title;
            $arr_data[] = $data;

          }
        }
        $category = $term_slug;
        if( $paged == $total_page) {
          $next_page = 0;
        }else {
          $next_page = $paged + 1;
        }
        include_once THEMEDIR . '/templates/shortcodes/sub_report.php';
        break;
      case "news":
        $term_slug = $_REQUEST['term'];
        if(isset($_REQUEST['pages']))
          $paged = $_REQUEST['pages'];    
        else
          $paged = 0;
        //load list post with type = "news"
        $args = array(
            'post_type' => 'news',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'tax_query' => array(
              array(
              'taxonomy' => 'newstype',
              'field' => 'slug',
              'terms' => $term_slug
            )
          )
        );
        $query = new WP_Query($args);
        $list_news = $query->get_posts();
        //load list post with type = "document"
        $args = array(
            'post_type' => 'document',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'tax_query' => array(
              array(
              'taxonomy' => 'newstype',
              'field' => 'slug',
              'terms' => $term_slug
            )
          )
        );
        $query = new WP_Query($args);
        $list_document = $query->get_posts();
        //load list post with type = "rss"
        $args = array(
            'post_type' => 'rss',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'tax_query' => array(
              array(
              'taxonomy' => 'newstype',
              'field' => 'slug',
              'terms' => $term_slug
            )
          )
        );
        $query = new WP_Query($args);
        $list_rss = $query->get_posts();
        $results = array_merge($list_news,$list_document, $list_rss);
        $total_item = count($results);
        $total_page = ceil($total_item/POST_PER_PAGE_2);
//        echo $total_pagel;exit;
        $list = array_slice($results, POST_PER_PAGE_2*$paged, POST_PER_PAGE_2);
        $arr_data= array();
        if(!empty($list)) {
          foreach($list as $item) {
            $release_date = get_post_meta($item->ID,'release_date');
            $data['post_type'] = $item->post_type;
            if(!empty($release_date))
              $data['release_date'] = $release_date[0];
            else
              $data['release_date'] = '';
            $data['ID'] = $item->ID;
            if($item->post_type== 'document') {
              $data['file']= get_post_meta($item->ID,'document_file');
              $data['title'] = $item->post_title;
            }elseif($item->post_type=='news' || $item->post_type == 'rss') {
              $data['title'] = $item->post_title;
              $data['content'] = $item->post_content;
            }
            $arr_data[] = $data;

          }
        }
        $category = $term_slug;
        if( $paged == $total_page) {
          $next_page = 0;
        }else {
          $next_page = $paged + 1;
        }
        include_once THEMEDIR . '/templates/shortcodes/sub_news.php';
        break;
      case "detail_news":
        $id = $_REQUEST['id'];
        $post_data = get_postdata($id);
        include_once THEMEDIR . '/templates/shortcodes/detail_news.php';
        break;
      case "lazyload_report":
        $term_slug = $_REQUEST['term'];
        $paged = $_REQUEST['pages'];
        if(!$paged)
          $paged = 1;
        $args = array(
            'post_type' => 'report',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' =>POST_PER_PAGE,
            'paged'=>$paged,
            'tax_query' => array(
              array(
              'taxonomy' => 'reporttype',
              'field' => 'slug',
              'terms' => $term_slug
            )
          )
          );
          $query = new WP_Query($args);
          $arr_data= array();
          $paging = custom_paging($args);
          $results = $paging['list'];
          $total_page = $paging['total_page'];
          if(!empty($results)) {
            foreach($results as $item) {
              $release_date = get_post_meta($item->ID,'release_date');
              if(!empty($release_date))
                $data['release_date'] = $release_date[0];
              else
                $data['release_date'] = '';
              $data['ID'] = $item->ID;
              $data['file']= get_post_meta($item->ID,'document_file');
              $data['title'] = $item->post_title;
              $arr_data[] = $data;

            }
          }
          if( $paged==$total_page ) {
            $next_page = 0;
          }else {
            $next_page = $paged++;
          }
          $category = $term_slug;
          include_once THEMEDIR . '/templates/shortcodes/lazyload-report.php';
        break;
      case "lazyload_news":
        $term_slug = $_REQUEST['term'];
        $paged = $_REQUEST['pages'];
        $term_slug = $_REQUEST['term'];
        if(isset($_REQUEST['pages']))
          $paged = $_REQUEST['pages'];    
        else
          $paged = 0;
        //load list post with type = "news"
        $args = array(
            'post_type' => 'news',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'tax_query' => array(
              array(
              'taxonomy' => 'newstype',
              'field' => 'slug',
              'terms' => $term_slug
            )
          )
          );
          $query = new WP_Query($args);
          $list_news = $query->get_posts();
          //load list post with type = "document"
        $args = array(
            'post_type' => 'document',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'tax_query' => array(
              array(
              'taxonomy' => 'newstype',
              'field' => 'slug',
              'terms' => $term_slug
            )
          )
          );
          $query = new WP_Query($args);
          $list_document = $query->get_posts();
        //load list post with type = "rss"
        $args = array(
            'post_type' => 'rss',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'tax_query' => array(
              array(
              'taxonomy' => 'newstype',
              'field' => 'slug',
              'terms' => $term_slug
            )
          )
          );
          global $wpdb;
          $query = new WP_Query($args);
          $list_rss = $query->get_posts();
          $results = array_merge($list_news,$list_document, $list_rss);
          $total_item = count($results);
          $total_page = ceil($total_item/POST_PER_PAGE_2);
          $list = array_slice($results, POST_PER_PAGE_2*$paged, POST_PER_PAGE_2);
          $arr_data= array();
          if(!empty($list)) {
            foreach($list as $item) {
              $release_date = get_post_meta($item->ID,'release_date');
              $data['post_type'] = $item->post_type;
              if(!empty($release_date))
                $data['release_date'] = $release_date[0];
              else
                $data['release_date'] = '';
              $data['ID'] = $item->ID;
              if($item->post_type== 'document') {
                $data['file']= get_post_meta($item->ID,'document_file');
                $data['title'] = $item->post_title;
              }elseif($item->post_type=='news' || $item->post_type == 'rss') {
                $data['title'] = $item->post_title;
                $data['content'] = $item->post_content;
              }
              $arr_data[] = $data;

            }
          }
          $category = $term_slug;
          if( $paged >= $total_page -1 ) {
            $next_page = 0;
          }
          else {
            $next_page = $paged + 1;
          }
          include_once THEMEDIR . '/templates/shortcodes/lazyload-news.php';
        break;
      case "lazyload_media":
        $term_slug = $_REQUEST['term'];
        $paged = $_REQUEST['pages'];
        $term_slug = $_REQUEST['term'];
        if(isset($_REQUEST['pages']))
          $paged = $_REQUEST['pages'];    
        else
          $paged = 0;
        //load list post with type = "news"
        $args = array(
            'post_type' => 'news',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'tax_query' => array(
              array(
              'taxonomy' => 'newstype',
              'field' => 'slug',
              'terms' => $term_slug
            )
          )
          );
          $query = new WP_Query($args);
          $list_news = $query->get_posts();
          //load list post with type = "document"
        $args = array(
            'post_type' => 'document',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'tax_query' => array(
              array(
              'taxonomy' => 'newstype',
              'field' => 'slug',
              'terms' => $term_slug
            )
          )
          );
          $list_document = $query->get_posts();
          $results = array_merge($list_news,$list_document);
          $total_item = count($results);
          $total_page = ceil($total_item/POST_PER_PAGE_2);
          $list = array_slice($results, POST_PER_PAGE_2*$paged, POST_PER_PAGE_2);
          $arr_data= array();
          if(!empty($list)) {
            foreach($list as $item) {
              $release_date = get_post_meta($item->ID,'release_date');
              $data['post_type'] = $item->post_type;
              if(!empty($release_date))
                $data['release_date'] = $release_date[0];
              else
                $data['release_date'] = '';
              $data['ID'] = $item->ID;
              if($item->post_type== 'document') {
                $data['file']= get_post_meta($item->ID,'document_file');
                $data['title'] = $item->post_title;
              }elseif($item->post_type=='news') {
                $data['title'] = $item->post_title;
                $data['content'] = $item->post_content;
              }
              $arr_data[] = $data;

            }
          }
          $category = $term_slug;
          if( $paged >= $total_page -1 ) {
            $next_page = 0;
          }
          else {
            $next_page = $paged + 1;
          }
          include_once THEMEDIR . '/templates/shortcodes/lazyload-media.php';
        break;
    }
    exit;
    }
  }
  return;
}

function custom_paging( $args = array(), $posts_per_page = 0 ) {
  $arr_result = array();
  if( !empty($args) ) {
    if(isset( $args['posts_per_page'] )) {
      $posts_per_page = $args['posts_per_page'];
    }
    $args['posts_per_page'] = -1;
    $paged = 1;
    if(isset( $args['paged'] )) {
      $paged = $args['paged'];
      unset( $args['paged'] );
    }
    $query = new WP_Query( $args );
    $result = $query->get_posts();
    $arr_result['total_item'] = count( $result );
    if( $posts_per_page!=0 )
      $args['posts_per_page'] = $posts_per_page;
    if( $paged!=1 ) {
      $args['paged'] = $paged;
    }
    unset($args['posts_per_page']);
    $query = new WP_Query( $args );
    $result = $query->get_posts();
    $arr_result['list'] = $result;
    $arr_result['total_page'] = ceil($arr_result['total_item']/$posts_per_page);
    return $arr_result;
    
  }
  
}
/**
 * Todo: Cut String
 * @param type $str
 * @param type $length
 * @param type $char
 * @param type $moreStr
 * @return type
 */
function cutString($str ,$length = 100 , $char = ' ', $moreStr = '(...)'){
    
		$output = '';
		if(strlen($str) > $length){
			$temp   	= substr($str,0,$length);
			$lastAppear	= strrpos($temp,$char);
			$output		= substr($temp,0,$lastAppear).' '.$moreStr;
		}
		else
			$output   = $str;
		return $output;
	}		

