<?php
/**
 * Get theme options
 * Require plugin support : Option Tree
 * Plugin URL :http://wordpress.org/plugins/option-tree
 */
function sm_theme_option( $option_id = null, $default = null ) {
    if ( $option_id && function_exists( 'ot_get_option' ) ) {
        return ot_get_option( $option_id, $default );
    }
    return null;
}