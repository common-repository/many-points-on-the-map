<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXMPOTMDataBaseTalk
{

	/*
	* MXMPOTMDataBaseTalk constructor
	*/
	public function __construct()
	{

		$this->mxmpotm_observe_update_data();

	}

	/*
	* Observe function
	*/
	public function mxmpotm_observe_update_data()
	{

		// create map
		add_action( 'wp_ajax_mxmpotm_add_map', array( $this, 'prepare_add_map' ) );

		// update map
		add_action( 'wp_ajax_mxmpotm_update_map', array( $this, 'prepare_update_map' ) );

		// delete map
		add_action( 'wp_ajax_mxmpotm_del_map', array( $this, 'prepare_del_map' ) );

		// custom marker notification
		add_action( 'wp_ajax_mxmpotm_confirm_notification', array( $this, 'mxmpotm_confirm_notification' ) );

		// points sort notification
		add_action( 'wp_ajax_mxmpotm_alphabet_order', array( $this, 'mxmpotm_alphabet_order' ) );

		// map settings
		add_action( 'wp_ajax_mxmpotm_update_map_settings', array( $this, 'update_settings' ) );

	}

	/*
	* Update Settings
	*/
	public function update_settings()
	{

		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxmpotm_nonce_request' ) ) {

			if($_POST['api_key'] == '') return;

			$api_key = sanitize_text_field($_POST['api_key']);

			$option = update_option('mx_google_map_api_key', $api_key);

			if($option) {
				echo 'success';
			} else {
				echo 'failed';
			}

		}

		wp_die();

	}

	/*
	* Prepare to map create
	*/
	public function prepare_add_map()
	{
		
		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxmpotm_nonce_request' ) ){

			// Add map
			$new_map = $this->add_new_map( $_POST['mapName'], $_POST['mapDesc'], $_POST['obj_points'], $_POST['latitude_center'], $_POST['longitude_center'], $_POST['zoom_map_center'], $_POST['zoom_map_to_point'], $_POST['map_width'], $_POST['map_height'], $_POST['filter_regions'], $_POST['filter_points'] );

		}

		wp_die();

	}

		// Add data
		public function add_new_map( $map_name, $map_desc, $obj_points, $latitude_center, $longitude_center, $zoom_map_center, $zoom_map_to_point, $map_width, $map_height, $filter_regions, $filter_points )
		{

			// name of the map
			$map_name = sanitize_text_field( $map_name );

			// desc of the map
			$map_desc = sanitize_text_field( $map_desc );

			// points
			$sanitize_points = array();

			foreach( $obj_points as $key => $value ) {

				$tmp_array = array();

				// point_id
				$point_id = intval( $value['point_id'] );

					$tmp_array['point_id'] = $point_id;

				// point_name
				$point_name = sanitize_text_field( $value['point_name'] );

					$tmp_array['point_name'] = $point_name;

				// point_desc
				$point_desc = sanitize_text_field( $value['point_desc'] );

					$tmp_array['point_desc'] = $point_desc;

				// point_latitude
				$point_latitude = sanitize_text_field( $value['point_latitude'] );

					$tmp_array['point_latitude'] = $point_latitude;

				// point_longitude
				$point_longitude = sanitize_text_field( $value['point_longitude'] );

					$tmp_array['point_longitude'] = $point_longitude;

				// point_address
				$point_address = sanitize_text_field( $value['point_address'] );

					$tmp_array['point_address'] = $point_address;

				// point_additional
				$point_additional = sanitize_text_field( $value['point_additional'] );

					$tmp_array['point_additional'] = $point_additional;

				// web_site
				$web_site = sanitize_text_field( $value['web_site'] );

					$tmp_array['web_site'] = $web_site;

				// phone
				$phone = sanitize_text_field( $value['phone'] );

					$tmp_array['phone'] = $phone;

				// custom marker
				$point_custom_marker = sanitize_text_field( $value['point_custom_marker'] );

					$tmp_array['point_custom_marker'] = $point_custom_marker;

				// areas
				$tmp_all_areas = array();

				if(isset($value['areas'])) {
					foreach ( $value['areas'] as $key => $_value ) {
						
						// point_desc
						$area = sanitize_text_field( $_value );

							array_push( $tmp_all_areas, $area );

					}
				}

				$tmp_array['areas'] = $tmp_all_areas;

				// push to main array
				array_push( $sanitize_points, $tmp_array );

			}

			$obj_points = serialize( $sanitize_points );			

			// latitude of the map
			$latitude_center = sanitize_text_field( $latitude_center );

			// latitude of the map
			$longitude_center = sanitize_text_field( $longitude_center );

			// zoom of the map
			$zoom_map_center = sanitize_text_field( $zoom_map_center );

			// zoom to the point
			$zoom_map_to_point = sanitize_text_field( $zoom_map_to_point );

			// map size
			$map_width = sanitize_text_field( $map_width );

			$map_height = sanitize_text_field( $map_height );

			// filters
			$filter_points = intval($filter_points);
			$filter_regions = intval($filter_regions);

			global $wpdb;

			$table_name = $wpdb->prefix . MXMPOTM_TABLE_SLUG;

			$map = $wpdb->insert( 
				$table_name, 
				array( 
					'map_name' 				=> $map_name,
					'map_desc' 				=> $map_desc,
					'points'				=> $obj_points,
					'latitude_map_center' 	=> $latitude_center,
					'longitude_map_center'	=> $longitude_center,
					'zoom_map_center'		=> $zoom_map_center,
					'zoom_to_point'			=> $zoom_map_to_point,
					'map_width'				=> $map_width,
					'map_height'			=> $map_height,
					'filter_points' 		=> $filter_points,
					'filter_regions' 		=> $filter_regions
				), 
				array( 
					'%s', 
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%d',
					'%s',
					'%s',
					'%d',
					'%d'
				) 
			);

			return $map;

		}

	/*
	* Prepare to map update
	*/
	public function prepare_update_map()
	{
		
		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxmpotm_nonce_request' ) ){

			// Update map
			$this->update_map( $_POST['id_map'], $_POST['mapName'], $_POST['mapDesc'], $_POST['obj_points'], $_POST['latitude_center'], $_POST['longitude_center'], $_POST['zoom_map_center'], $_POST['zoom_map_to_point'], $_POST['map_width'], $_POST['map_height'], $_POST['filter_regions'], $_POST['filter_points'] );

		}

		wp_die();

	}

		// Update map
		public function update_map( $id_map, $map_name, $map_desc, $obj_points, $latitude_center, $longitude_center, $zoom_map_center, $zoom_map_to_point, $map_width, $map_height, $filter_regions, $filter_points )
		{

			// name of the map
			$map_name = sanitize_text_field( $map_name );

			// desc of the map
			$map_desc = sanitize_text_field( $map_desc );

			// points
			$sanitize_points = array();

			foreach( $obj_points as $key => $value ) {

				$tmp_array = array();

				// point_id
				$point_id = intval( $value['point_id'] );

					$tmp_array['point_id'] = $point_id;

				// point_name
				$point_name = sanitize_text_field( $value['point_name'] );

					$tmp_array['point_name'] = $point_name;

				// point_desc
				$point_desc = sanitize_text_field( $value['point_desc'] );

					$tmp_array['point_desc'] = $point_desc;

				// point_latitude
				$point_latitude = sanitize_text_field( $value['point_latitude'] );

					$tmp_array['point_latitude'] = $point_latitude;

				// point_longitude
				$point_longitude = sanitize_text_field( $value['point_longitude'] );

					$tmp_array['point_longitude'] = $point_longitude;

				// point_address
				$point_address = sanitize_text_field( $value['point_address'] );

					$tmp_array['point_address'] = $point_address;

				// point_additional
				$point_additional = sanitize_text_field( $value['point_additional'] );

					$tmp_array['point_additional'] = $point_additional;

				// web_site
				$web_site = sanitize_text_field( $value['web_site'] );

					$tmp_array['web_site'] = $web_site;

				// phone
				$phone = sanitize_text_field( $value['phone'] );

					$tmp_array['phone'] = $phone;

				// custom marker
				$point_custom_marker = sanitize_text_field( $value['point_custom_marker'] );

					$tmp_array['point_custom_marker'] = $point_custom_marker;

				// areas
				$tmp_all_areas = array();

				if( isset($value['areas']) ) {

					foreach ( $value['areas'] as $key => $_value ) {
						
						// point_desc
						$area = sanitize_text_field( $_value );

							$push_area = array_push( $tmp_all_areas, $area );

					}

				}

				$tmp_array['areas'] = $tmp_all_areas;				

				// push to main array
				$push_to_main_array = array_push( $sanitize_points, $tmp_array );

			}

			$obj_points = serialize( $sanitize_points );

			// latitude of the map
			$latitude_center = sanitize_text_field( $latitude_center );

			// latitude of the map
			$longitude_center = sanitize_text_field( $longitude_center );

			// zoom of the map
			$zoom_map_center = sanitize_text_field( $zoom_map_center );

			// zoom to the point
			$zoom_map_to_point = sanitize_text_field( $zoom_map_to_point );

			// map size
			$map_width = sanitize_text_field( $map_width );

			$map_height = sanitize_text_field( $map_height );

			// filters
			$filter_points = intval($filter_points);
			$filter_regions = intval($filter_regions);

			global $wpdb;

			$table_name = $wpdb->prefix . MXMPOTM_TABLE_SLUG;

			$wpdb->update( 
				$table_name, 
				array( 
					'map_name' 				=> $map_name,
					'map_desc' 				=> $map_desc,
					'points'				=> $obj_points,
					'latitude_map_center' 	=> $latitude_center,
					'longitude_map_center'	=> $longitude_center,
					'zoom_map_center'		=> $zoom_map_center,
					'zoom_to_point'			=> $zoom_map_to_point,
					'map_width'				=> $map_width,
					'map_height'			=> $map_height,
					'filter_points' 		=> $filter_points,
					'filter_regions' 		=> $filter_regions
				), 
				array( 'id' => $id_map ),
				array( 
					'%s', 
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%d',
					'%s',
					'%s',
					'%d',
					'%d'
				) 
			);

		}

	/*
	* Prepare to map delete
	*/
	public function prepare_del_map()
	{

		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxmpotm_nonce_request' ) ){

			// Delete map
			$this->delete_map( $_POST['id_map'] );	

		}

		wp_die();

	}

		// delete map
		public function delete_map( $id_map )
		{

			global $wpdb;

			$table_name = $wpdb->prefix . MXMPOTM_TABLE_SLUG;

			$wpdb->delete(

				$table_name,
				array( 'id' => $id_map ),
				array( '%d' )

			);

		}

	/* custom marker notification */
	public function mxmpotm_confirm_notification()
	{

		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxmpotm_admin_nonce' ) ){

			add_option( '_mxmpotm_custom_markup_notice', 'was_seen' );

		}

		wp_die();

	}

	/* sort of points notification */
	public function mxmpotm_alphabet_order()
	{

		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxmpotm_admin_nonce' ) ){

			add_option( '_mxmpotm_alphabet_order_notice', 'was_seen' );

		}

		wp_die();

	}

}

// New instance
new MXMPOTMDataBaseTalk();