<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

final class MXMPOTMManyPointsOnTheMap
{

	/*
	* MXMPOTMManyPointsOnTheMap constructor
	*/
	public function __construct()
	{

		$this->define_constants();
		
		$this->mxmpotm_include();		

	}

	/*
	* Define MXMPOTM constants
	*/
	public function define_constants()
	{

		$this->mxmpotm_define( 'MXMPOTM_TABLE_SLUG', 'mxmpotm_map_points' );

		// include php files
		$this->mxmpotm_define( 'MXMPOTM_PLUGIN_ABS_PATH', dirname( MXMPOTM_PLUGIN_PATH ) . '/' );

		// version
		$this->mxmpotm_define( 'MXMPOTM_PLUGIN_VERSION', '1.4.2' );// '1.3'

	}

	/*
	* Incude required core files
	*/
	public function mxmpotm_include()
	{

		// Basis functions
		require_once MXMPOTM_PLUGIN_ABS_PATH . 'includes/class-basis-plugin-class.php';

		// Helpers
		require_once MXMPOTM_PLUGIN_ABS_PATH . 'includes/core/helpers.php';

		// Part of the Frontend
		require_once MXMPOTM_PLUGIN_ABS_PATH . 'includes/frontend/class-frontend-main.php';

		// Part of the Administrator
		require_once MXMPOTM_PLUGIN_ABS_PATH . 'includes/admin/class-admin-main.php';

	}

	// Define function
	private function mxmpotm_define( $mame, $value )
	{

		if( ! defined( $mame ) )
		{

			define( $mame, $value );

		}

	}

}