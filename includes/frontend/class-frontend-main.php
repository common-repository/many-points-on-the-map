<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class MXMPOTMFrontEndMain
{

	/*
	* Registration of styles and scripts
	*/
	public function register()
	{

		add_action('wp_enqueue_scripts', array($this, 'enqueue'));
	}

	public function enqueue()
	{

		wp_enqueue_style('mxmpotm_font_awesome', MXMPOTM_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css');

		wp_enqueue_style('mxmpotm_style', MXMPOTM_PLUGIN_URL . 'includes/frontend/assets/css/style.css', array('mxmpotm_font_awesome'), MXMPOTM_PLUGIN_VERSION, 'all');

		$api_key = get_option('mx_google_map_api_key');

		if ($api_key && $api_key !== '') {

			wp_enqueue_script('mxmpotm_script', MXMPOTM_PLUGIN_URL . 'includes/frontend/assets/js/script.js', array(), MXMPOTM_PLUGIN_VERSION, true);

			wp_enqueue_script('mxmpotm_google_maps_script', 'https://maps.googleapis.com/maps/api/js?key='.$api_key.'&callback=mx_map_init', array(), MXMPOTM_PLUGIN_VERSION, true);

		}
	}
}

// Initialize
$initialize_class = new MXMPOTMFrontEndMain();

// Apply scripts and styles
$initialize_class->register();
