<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<h1 class="text-secondary"><?php echo __( 'Map Settings', 'mxmpotm-map' ); ?></h1>

<form id="mxmpotm_settings" class="mx-settings" method="post">

    <div class="mx-block_wrap">
        
        <div class="form-group">
            <label for="mx_google_map_api_key"><?php echo __( 'Google Map Api Key:', 'mxmpotm-map' ); ?> <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="mx_google_map_api_key" name="mx_google_map_api_key" value="<?php echo get_option('mx_google_map_api_key') ? get_option('mx_google_map_api_key') : ''; ?>" required />	
        </div>

        <small><?php echo __( 'You can find Google Map Api Key here: ', 'mxmpotm-map' ); ?><a href="https://console.cloud.google.com/google/maps-apis/credentials" target="_blank">https://console.cloud.google.com/google/maps-apis/credentials</a></small>

    </div>

    <div class="mx-block_wrap">

		<p class="mx-submit_button_wrap">
			<input type="hidden" id="mxmpotm_wpnonce" name="mxmpotm_wpnonce" value="<?php echo wp_create_nonce( 'mxmpotm_nonce_request' ) ;?>" />
			<input class="button-primary" type="submit" name="mxmpotm-submit" value="<?php echo __( 'Save', 'mxmpotm-map' ); ?>" />
		</p>

	</div>

</form>