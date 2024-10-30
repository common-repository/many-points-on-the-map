jQuery( document ).ready( function( $ ) {

	// marker
	$( '.mxmpotm_notification_marker' ).on( 'click', 'button', function( e ) {

		e.preventDefault();

		var data = {

			'action'		: 'mxmpotm_confirm_notification',
			'nonce'			: mxmpotm_localize_script_custom_obj.mxmpotm_nonce,

		};

		mxmpotm_confirm_notification_option( $, data );

		$( '.mxmpotm_notification_marker' ).hide( 'slow' );

	} );

	// sort of points
	$( '.mxmpotm_notification_alphabet_order' ).on( 'click', 'button', function( e ) {

		e.preventDefault();

		var data = {

			'action'		: 'mxmpotm_alphabet_order',
			'nonce'			: mxmpotm_localize_script_custom_obj.mxmpotm_nonce,

		};

		mxmpotm_confirm_notification_option( $, data );

		$( '.mxmpotm_notification_alphabet_order' ).hide( 'slow' );

	} );

} );

function mxmpotm_confirm_notification_option( $, data ) {

	jQuery.post( ajaxurl, data, function( response ) {

		console.log( response );

	} );

} 