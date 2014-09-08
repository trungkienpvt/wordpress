<?php
/**
 * Image widget class.
 *
 * @package SimpleImageWidget
 *
 * @since 3.0.0
 */
class Second_Menu_Widget extends WP_Widget {
	/**
	 * Setup widget options.
	 *
	 * Allows child classes to overload the defaults.
	 *
	 * @since 3.0.0
	 * @see WP_Widget::construct()
	 */
	function __construct( $id_base = false, $name = false, $widget_options = array(), $control_options = array() ) {
		$id_base = ( $id_base ) ? $id_base : 'Second Menu'; // Legacy ID.
		$name = ( $name ) ? $name : __( 'Second Menu', 'second-menu-widget' );
		$widget_options = wp_parse_args( $widget_options, array(
			'classname'   => 'widget_simpleimage', // Legacy class name.
			'description' => __( 'Display second menu', 'second-menu-widget' ),
		) );

		$control_options = wp_parse_args( $control_options, array(
			'width' => 300
		) );

		parent::__construct( $id_base, $name, $widget_options, $control_options );

	}

	/**
	 * Default widget front end display method.
	 *
	 * Filters the instance data, fetches the output, displays it, then caches
	 * it. Overload or filter the render() method to modify output.
	 *
	 * @since 3.0.0
	 */
	function widget( $args, $instance ) {
		global $wpdb;
    $arrMenu = wp_get_nav_menu_items( 'Menu 1' );
    $arrSecondMenu = array();
    $currentRootMenu = $_SESSION['parent_menu_id'];
    $currentRootMenuTitle = $_SESSION['parent_menu_title'];
    if(!empty($arrMenu)){
      foreach($arrMenu as $item) {
        if($item->menu_item_parent!=0 && $item->post_status=='publish' && $item->menu_item_parent==$currentRootMenu){
            $arr['data'] = $item;
            if($_SESSION['current_menu'] == $item->ID)
              $arr['active_link'] = 'active';
            else
              $arr['active_link'] = '';
            $arrSecondMenu[] = $arr;
          
        }
        
      }
      if($_SESSION['root_menu']) {
        $arrSecondMenu[0]['active_link'] = 'active';
        $_SESSION['current_post_url'] = $arrSecondMenu[0]['data']->url;
      }else{
        $_SESSION['current_post_url'] = '';
      }
    }
    include_once 'templates/second_menu.php';
	}
	/**
	 * Form for modifying widget settings.
	 *
	 * @since 3.0.0
	 */
	function form( $instance ) {
	}
	function update( $new_instance, $old_instance ) {
	}
	
}
