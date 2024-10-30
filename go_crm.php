<?php 
/**
 * @package GoAbroad HQ Plugin
 */
/*
Plugin Name: GoAbroad HQ Plugin
Plugin URI: https://www.darrenalba.com/
Description: GoAbroad HQ Plugin
Version: 1.6.1
Author: GoAbroad HQ Team
Author URI: https://www.goabroad.com/
License: https://www.goabroad.com/
Text Domain: GoAbroad HQ Plugin
*/

define( 'HQCRM_VERSION', '1.6.2' );
define( 'HQCRM_MINIMUM_WP_VERSION', '3.7' );
define( 'HQCRM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

global $hqcrm;
$hqcrm = HQCRM_VERSION;

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Please contact GoAbroad CRM for more info.';
	exit;
}

require_once( HQCRM_PLUGIN_DIR . 'includes/utils.php' );
require_once( HQCRM_PLUGIN_DIR . 'includes/functions.php' );
require_once( HQCRM_PLUGIN_DIR . 'includes/gocaptcha.php' );

register_activation_hook( __FILE__, 'goabrod_install_db' );

add_action( 'admin_menu', 'gocrm_menu' );

add_shortcode( 'gocrmforms', 'gocrmforms' );

 
// Wordpress action that says, hey wait! lets add the scripts mentioned in the function as well.
add_action( 'wp_ajax_gocrm_delete_field', 'gocrm_delete_field' ); //admin side
add_action( 'wp_ajax_gocrm_update_field', 'gocrm_update_field' ); //admin side
add_action( 'wp_ajax_gocrm_update_formname', 'gocrm_update_formname' ); //admin side
add_action( 'wp_ajax_gocrm_add_field', 'gocrm_add_field' ); //admin side
add_action( 'plugins_loaded', 'gocrm_update_db_check' );
//register_deactivation_hook( __FILE__, 'removegocrm' );