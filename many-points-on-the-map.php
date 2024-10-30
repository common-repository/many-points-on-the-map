<?php
/*
Plugin Name: Many points on the map
Plugin URI: https://github.com/Maxim-us/many-points-on-the-map
Description: The plugin helps you set points on the map and filter them in the future.
Author: Maksym Marko
Version: 1.4.1
Author URI: https://github.com/Maxim-us
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Unique string - MXMPOTM
*/

/*
* Define MXMPOTM_PLUGIN_PATH
*/
if ( ! defined( 'MXMPOTM_PLUGIN_PATH' ) ) {

	define( 'MXMPOTM_PLUGIN_PATH', __FILE__ );

}

/*
* Define MXMPOTM_PLUGIN_URL
*/
if ( ! defined( 'MXMPOTM_PLUGIN_URL' ) ) {

	// Return http://my-domain.com/wp-content/plugins/many-points-on-the-map/
	define( 'MXMPOTM_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

}

/*
* Define MXMPOTM_PLUGN_BASE_NAME
*/
if ( ! defined( 'MXMPOTM_PLUGN_BASE_NAME' ) ) {

	// Return many-points-on-the-map/many-points-on-the-map.php
	define( 'MXMPOTM_PLUGN_BASE_NAME', plugin_basename( __FILE__ ) );

}

/*
* Include the main MXMPOTMManyPointsOnTheMap class
*/
if ( ! class_exists( 'MXMPOTMManyPointsOnTheMap' ) ) {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-final-main-class.php';

	// Create new instance
	new MXMPOTMManyPointsOnTheMap();

	/*
	* Registration hooks
	*/
	// Activation
	register_activation_hook( __FILE__, array( 'MXMPOTMBasisPluginClass', 'activate' ) );

	// Deactivation
	register_deactivation_hook( __FILE__, array( 'MXMPOTMBasisPluginClass', 'deactivate' ) );

	/*
	* Translate plugin
	*/
	add_action( 'plugins_loaded', 'mxmpotm_translate' );

	function mxmpotm_translate()
	{

		load_plugin_textdomain( 'mxmpotm-map', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	}

}