jQuery( document ).ready( function( $ ) {

	// init 
	mxmpotm_add_custom_marker_script( $ );

	// reset marker
	mxmpotm_custom_marker_reset_marker_script( $ );

	// button delete point
	check_count_points_and_hidden_del_button( $ );

	/*************
	* AJAX
	*/
	// create map
	$( '#mxmpotm_map_create' ).on( 'submit', function( e ) {

		e.preventDefault();

		// action
		var action = 'mxmpotm_add_map';

		// required fields
		var requiredFields = $( '#mxmpotm_points_wrap' ).find( '.mx-is_required' );

		// points wrap
		var wrapPoints = $( '#mxmpotm_points_wrap' );

		if(
			mxmpotm_check_invalid_point_fields( $, requiredFields, wrapPoints ) &&
			mxmpotm_is_coordinates_fields( $, $( '.mx-is_coordinates' ) )
		) {

			// get data and send it
			mxmpotm_ajax_data( $, $( this ), action );

		}

	} );

	// update map
	$( '#mxmpotm_map_update' ).on( 'submit', function( e ) {

		e.preventDefault();

		// action
		var action = 'mxmpotm_update_map';

		// required fields
		var requiredFields = $( '#mxmpotm_points_wrap' ).find( '.mx-is_required' );

		// points wrap
		var wrapPoints = $( '#mxmpotm_points_wrap' );

		if(
			mxmpotm_check_invalid_point_fields( $, requiredFields, wrapPoints ) &&
			mxmpotm_is_coordinates_fields( $, $( '.mx-is_coordinates' ) )
		) {

			// get data and send it
			mxmpotm_ajax_data( $, $( this ), action );

		}
		
	} );

	// delete map
	$( '#mxmpotm_delete_map_btn' ).on( 'click', function() {

		var nonce = $( this ).attr( 'data-nonce' );

		var id_map = $( this ).attr( 'data-id-map' );

		// del map
		mxmpotm_delete_map( $, nonce, id_map );		

	} );

	/****************
	* point box
	*/
	// create a new box point
	var pointBox = $( '#mxmpotm_points_wrap_example' ).find( '.mxmpotm_point_wrap' );

	// create a new box area
	var arerBox = $( '#mxmpotm_points_wrap_example' ).find( '.mxmpotm_point_area' );

	// Add the first point if the block is empty
	if( $( '#mxmpotm_points_wrap' ).find( '.mxmpotm_point_wrap' ).length === 0 ) {

		$( pointBox ).clone().appendTo( '#mxmpotm_points_wrap' );

	}
	
	// event add points
	$( '#mxmpotm_points_wrap' ).on( 'click', '.mx-add_point', function() {

		var requiredFields = $( '#mxmpotm_points_wrap' ).find( '.mx-is_required' );		

		var wrapPoints = $( '#mxmpotm_points_wrap' );

		setTimeout( function(){

			if( mxmpotm_check_invalid_point_fields( $, requiredFields, wrapPoints ) ) {

				// set the number of point
				mxmpotm_set_attr_for_poins( $, pointBox );	

				$( pointBox ).clone().appendTo( '#mxmpotm_points_wrap' );

			}

			// chech count point
			check_count_points_and_hidden_del_button( $ );

		},500 );

	} );

	// delete point
	$( '#mxmpotm_points_wrap' ).on( 'click', '.mx-del_point', function() {

		if( confirm( confirmTextdelPoint ) ) {

			$( this ).parent().css( 'opacity', 0.4 );

			$( this ).parent().animate( { 'height': '15px' }, 500, function() {

				$( this ).remove();

			} );

			// chech count point
			check_count_points_and_hidden_del_button( $ );

		}		

	} );	

	// open box
	$( '#mxmpotm_points_wrap' ).on( 'click', '.mx-open_point_box', function( e ) {

		e.preventDefault();

		if( $( this ).parent().hasClass( 'mxmpotm_point_wrap_open' ) ) {

			$( this ).parent().animate( { 'height': '50px' }, 500, function(){

				$( this ).removeClass( 'mxmpotm_point_wrap_open' );

				$( this ).attr( 'style', '' );

			} );			

		} else {

			$( this ).parent().animate( { 'height': '200px' }, 500, function(){

				$( this ).addClass( 'mxmpotm_point_wrap_open' );

				$( this ).css( 'height', 'auto' );

			} );

		}		

	} );

	// focus input name of the point
	$( '#mxmpotm_points_wrap' ).on( 'focus', '.mx_new_point_name', function() {

		if( !$( this ).parent().parent().hasClass( 'mxmpotm_point_wrap_open' ) ) {

			$( this ).parent().parent().animate( { 'height': '200px' }, 500, function(){

				$( this ).addClass( 'mxmpotm_point_wrap_open' );

				$( this ).css( 'height', 'auto' );

			} );

		}

	} );

	/***************
	* Areas
	*/
	// event add ares
	$( '#mxmpotm_points_wrap' ).on( 'click', '.mx-add_region', function() {

		var areaParent = $( this ).parent().parent();

		// check empty region inputs
		if( mxmpotm_check_empty_areas( $, areaParent ) ) {

			$( arerBox ).clone().appendTo( areaParent );

		}

	} );

	// event delete region
	$( '#mxmpotm_points_wrap' ).on( 'click', '.mx-delete_region', function() {

		$( this ).parent().remove();

	} );

	/***************
	* Settings page
	*/
	$( '#mxmpotm_settings' ).on( 'submit', function(e) {

		e.preventDefault();

		const api_key = mxmpotm_sanitize_text($( '#mx_google_map_api_key' ).val());

		if(api_key === '') {
			alert('Enter a Google Map API Key!');
			return;
		}

		var nonce = mxmpotm_sanitize_text($(this).find( '#mxmpotm_wpnonce' ).val());

		const data = {
			action: 'mxmpotm_update_map_settings',
			nonce: nonce,
			api_key: api_key
		};


		jQuery.post( ajaxurl, data, function( response ) {

			if(response === 'success') {
				alert('Saved');
			} else {
				alert('Something went wrong. Make sure you have changed the API key.');
			}

		} );

	} );

} );

/*
* functions
*/
// get data from the form
function mxmpotm_ajax_data( $, _this, action ) {

	// data vars
	var id_map = null;

	var id_map_val = mxmpotm_sanitize_text($( '#mx_map_id' ).val());

	if( id_map_val.length !== 0 ) {

		id_map = parseInt( id_map_val );

	}

	var nonce 				= mxmpotm_sanitize_text(_this.find( '#mxmpotm_wpnonce' ).val());

	var mapName 			= mxmpotm_sanitize_text($( '#mx_name_of_the_map' ).val());

	var mapDesc 			= mxmpotm_sanitize_text($( '#mx_desc_of_the_map' ).val());

	var latitude_center		= mxmpotm_sanitize_text($( '#mx_latitude_map_center' ).val());

	var longitude_center 	= mxmpotm_sanitize_text($( '#mx_longitude_map_center' ).val());

	var zoom_map_center 	= mxmpotm_sanitize_text($( '#mx_default_zoon_map' ).val());

	var zoom_map_to_point 	= mxmpotm_sanitize_text($( '#mx_default_zoon_to_point' ).val());

	var map_width 			= mxmpotm_sanitize_text($( '#mx_size_map_width' ).val());

	var map_height 			= mxmpotm_sanitize_text($( '#mx_size_map_height' ).val());

	var filter_regions 		= 0;

	if( $( '#mx_show_region_filter' ).prop( 'checked' ) ) {

		filter_regions = 1;

	}

	var filter_points 		= 0;

	if( $( '#mx_show_points_filter' ).prop( 'checked' ) ) {

		filter_points = 1;

	}

	var obj_points 	= {};

	// get data of points
	var obj_point_tmp = {};

	var array_point_areas_tmp = [];

	$( '#mxmpotm_points_wrap' ).find( '.mxmpotm_point_wrap' ).each( function(  index, element ) {

		// push id into tmp obj
		obj_point_tmp['point_id'] = parseInt( $( this ).attr( 'data-id' ) );

		// push name into tmp obj
		obj_point_tmp['point_name'] = mxmpotm_sanitize_text($( this ).find( '.mx_new_point_name' ).val());

		// push desc into tmp obj
		obj_point_tmp['point_desc'] = mxmpotm_sanitize_text($( this ).find( '.mx_new_point_desc' ).val());

		// push latitude into tmp obj
		obj_point_tmp['point_latitude'] = mxmpotm_sanitize_text($( this ).find( '.mx_new_point_latitude' ).val());

		// push longitude into tmp obj
		obj_point_tmp['point_longitude'] = mxmpotm_sanitize_text($( this ).find( '.mx_new_point_longitude' ).val());

		// push address into tmp obj
		obj_point_tmp['point_address'] = mxmpotm_sanitize_text($( this ).find( '.mx_new_point_address' ).val());

		// web site
		obj_point_tmp['web_site'] = mxmpotm_sanitize_text($( this ).find( '.mx_new_point_web_site' ).val());

		// phone
		obj_point_tmp['phone'] = mxmpotm_sanitize_text($( this ).find( '.mx_new_point_phone' ).val());

		// push additional into tmp obj
		obj_point_tmp['point_additional'] = mxmpotm_sanitize_text($( this ).find( '.mx_new_point_additional' ).val());

		// custom marker
			// if there is need to update
			if( parseInt( $( this ).find( '.mxmpotm_add_custom_marker' ).attr( 'data-default-marker' ) ) === 1 ) {

				obj_point_tmp['point_custom_marker'] = $( this ).find( '.mxmpotm_add_custom_marker' ).attr( 'src' );

			} else {

				obj_point_tmp['point_custom_marker'] = 0;

			}

		// areas
		$( this ).find( '.mxmpotm_point_area_wrap' ).find( '.mx_new_point_region' ).each( function() {

			if( $( this ).val().length !== 0 ) {

				array_point_areas_tmp.push( $( this ).val() );

			}			

		} );

		obj_point_tmp['areas'] = array_point_areas_tmp;

		// --- push into main obj ---
		obj_points[index] = obj_point_tmp;

		// clean tmp obj
		obj_point_tmp = {};

		// clean tmp array
		array_point_areas_tmp = [];

	} );

	// set data
	$( '#mxmpotm_points_wrap' ).find( '.mxmpotm_point_wrap' ).promise().done( function() {

		var data = {

			'action'			: 	action,
			'nonce'				: 	nonce,
			'id_map'			: 	id_map,
			'mapName'			: 	mapName,
			'mapDesc'			: 	mapDesc,
			'latitude_center'	: 	latitude_center,
			'longitude_center'	: 	longitude_center,
			'obj_points' 		: 	obj_points,
			'zoom_map_center'	: 	zoom_map_center,
			'zoom_map_to_point' : 	zoom_map_to_point,
			'map_width'			: 	map_width,
			'map_height'		: 	map_height,
			'filter_regions' 	: 	filter_regions,
			'filter_points' 	:   filter_points

		};

		jQuery.post( ajaxurl, data, function( response ) {	

			console.log( response );

			if( response === '' ) {

				alert( dataSavedText );

				if( action === 'mxmpotm_add_map' ) {

					window.location.href = 'admin.php?page=mxmpotm-many-points-on-the-map';

				} else {

					window.location.href = 'admin.php?page=mxmpotm-many-points-on-the-map-edit&map=' + id_map;

				}				

			} else {

				alert( dataNotSavedText );

			}
			
		} );

	} );		

}

// delete map
function mxmpotm_delete_map( $, nonce, id_map ) {

	var data = {

		'action'			: 	'mxmpotm_del_map',
		'nonce'				: 	nonce,
		'id_map'			: 	id_map

	};

	if( confirm( confirmTextdelMap ) ) {

		jQuery.post( ajaxurl, data, function( response ) {

			console.log( response );

			window.location.href = 'admin.php?page=mxmpotm-many-points-on-the-map';

		} );

	}

}

// check empty fields
function mxmpotm_check_invalid_point_fields( $, requiredFields, wrapPoints ) {

	var arrayBolleans = [];

	requiredFields.each( function(){

		if( $( this ).val().length === 0 ) {

			$( this ).addClass( 'is-invalid' );

			arrayBolleans.push( 'false' );

			// find parents and open it
			mxmpotm_find_parent_by_className( $, $( this ), 'mxmpotm_point_wrap' );

		} else {

			// check coordinates
			if( $( this ).hasClass( 'mx-is_coordinates' ) ) {		

				if( mxmpotm_is_coordinates( $, $( this ).val() ) ) {

					$( this ).removeClass( 'is-invalid' );

					arrayBolleans.push( 'true' );

				} else {

					$( this ).addClass( 'is-invalid' );

					arrayBolleans.push( 'false' );

					// find parents and open it
					mxmpotm_find_parent_by_className( $, $( this ), 'mxmpotm_point_wrap' );

				}

			} else {

				$( this ).removeClass( 'is-invalid' );

				arrayBolleans.push( 'true' );

			}			

		}		

	} );

	if( $.inArray( 'false', arrayBolleans ) === -1 ) {

		wrapPoints.removeClass( 'is-invalid' );

		return true;

	} else {

		wrapPoints.addClass( 'is-invalid' );

		return false;

	}

}

// set attr for points
function mxmpotm_set_attr_for_poins( $, pointBox ) {
	
	var data_id_last_point = parseInt( $( '#mxmpotm_points_wrap' ).find( '.mxmpotm_point_wrap' ).last().attr( 'data-id' ) );

	data_id_last_point++;

	// set number
	pointBox.find( '.mx_number_of_point_n' ).text( data_id_last_point );

	// set data
	pointBox.attr( 'data-id', data_id_last_point );

}

// check empty areas
function mxmpotm_check_empty_areas( $, areaParent ) {

	var _return = true;

	var inputs = areaParent.find( '.mx_new_point_region' );

	inputs.each( function() {

		if( $( this ).val().length === 0 ) {

			$( this ).addClass( 'is-invalid' );

			_return = false;

			return false;

		} else {

			$( this ).removeClass( 'is-invalid' );

			_return = true;

		}

	} );

	return _return;

}

// find parent by className
function mxmpotm_find_parent_by_className( $, element, findParent ) {

	var allParents = element.parents();

	allParents.map( function( i, el ) {

		if( this.className.indexOf( findParent ) > -1 ) {

			var parentDataId = parseInt( this.dataset.id );

			$( '.' + findParent ).each( function() {

				var getDataId = parseInt( $( this ).attr( 'data-id' ) );

				if( getDataId === parentDataId ) {

					$( this ).addClass( 'mxmpotm_point_wrap_open' );

					$( this ).attr( 'style', '' );

				}

			} );


		}		

	} );	

}

// is coordinates fields
function mxmpotm_is_coordinates_fields( $, element ) {

	var arrayBolleans = [];

	element.each( function() {

		if( mxmpotm_is_coordinates( $, $( this ).val() ) ) {

			$( this ).removeClass( 'is-invalid' );

			arrayBolleans.push( 'true' );

		} else {

			$( this ).addClass( 'is-invalid' );

			arrayBolleans.push( 'false' );

		}

	} );

	if( $.inArray( 'false', arrayBolleans ) === -1 ) {

		return true;

	} else {

		return false;

	}

}

// is coordinates
function mxmpotm_is_coordinates( $, $value ) {

	if( isNaN( $value ) ) {

		return false;

	}

	return true;

}

// button delete point hidden
function check_count_points_and_hidden_del_button( $ ) {

	setTimeout( function() {

		var countPoints = $( '#mxmpotm_points_wrap' ).find( '.mxmpotm_point_wrap' ).length;

		if( countPoints === 1 ) {

			$( '#mxmpotm_points_wrap' ).find( '.mxmpotm_point_wrap' ).addClass( 'mxmpotm_hide_del_point' );
		
		} else {

			$( '#mxmpotm_points_wrap' ).find( '.mxmpotm_point_wrap' ).removeClass( 'mxmpotm_hide_del_point' );

		}

	},1000 );	

}

// Add Custom Marker
function mxmpotm_add_custom_marker_script( $ ) {

	$( '#mxmpotm_points_wrap' ).on( 'click', '.mxmpotm_add_custom_marker', function() {

		var _this = $( this );

        var upload = wp.media( {

	        title: 'Choose Image',

	        multiple: false

        } ).on( 'select', function(){

            var select = upload.state().get('selection');

            var attach = select.first().toJSON();

            _this.attr( 'src', attach.url );

            _this.attr( 'data-default-marker', 1 );

            _this.parent().find( '.mxmpotm_custom_marker_reset_marker' ).show();

        } ).open();

	} );

}

// reset marker
function mxmpotm_custom_marker_reset_marker_script( $ ) {

	$( '#mxmpotm_points_wrap' ).on( 'click', '.mxmpotm_custom_marker_reset_marker', function() {

		$( this ).parent().find( '.mxmpotm_add_custom_marker' ).attr( 'src', mxmpotm_localize_script_obj.default_marker_src );

		$( this ).parent().find( '.mxmpotm_add_custom_marker' ).attr( 'data-default-marker', 0 );

		$( this ).hide();

	} );
	
}

// sanitize_text
function mxmpotm_sanitize_text(text) {
	return text.replace(/\'/g, "&apos;").replace(/\"/g, "&ldquo;");
}