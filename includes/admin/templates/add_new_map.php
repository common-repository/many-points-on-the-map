<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<h1 class="text-secondary"><?php echo __( 'Create a new map', 'mxmpotm-map' ); ?></h1>

<form id="mxmpotm_map_create" class="mx-settings" method="post" action="">

	<div class="mx-block_wrap">

		<input type="hidden" id="mx_map_id" name="mx_map_id" value="" />

		<input type="hidden" id="current_page_url" name="current_page_url" value="" />

		<div class="form-group">
			<label for="mx_name_of_the_map"><?php echo __( 'The name of the map:', 'mxmpotm-map' ); ?> <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="mx_name_of_the_map" name="mx_name_of_the_map" value="" required />	
		</div>

		<div class="form-group">
			<label for="mx_desc_of_the_map"><?php echo __( 'Map description:', 'mxmpotm-map' ); ?></label>
			<textarea name="mx_desc_of_the_map" id="mx_desc_of_the_map"></textarea>
		</div>			

	</div>

	<div class="mx-block_wrap">

		<h5><?php echo __( 'Coordinates of the map', 'mxmpotm-map' ); ?></h5>

		<div class="form-group">

			<label for="mx_latitude_map_center"><?php echo __( 'Latitude Map Center:', 'mxmpotm-map' ); ?> <span class="text-danger">*</span></label>
			<input type="text" name="mx_latitude_map_center form-control" class="form-control mx-is_coordinates" placeholder="<?php echo __( 'For example: 50.428545', 'mxmpotm-map' ); ?>" id="mx_latitude_map_center" required />

		</div>

		<div class="form-group">
			
			<label for="mx_longitude_map_center"><?php echo __( 'Longitude Map Center:', 'mxmpotm-map' ); ?> <span class="text-danger">*</span></label>
			<input type="text" name="mx_longitude_map_center" class="form-control mx-is_coordinates" placeholder="<?php echo __( 'For example: 30.689375', 'mxmpotm-map' ); ?>" id="mx_longitude_map_center" required />

		</div>

	</div>

	<div class="mx-block_wrap">

		<h5><?php echo __( 'Scaling a map', 'mxmpotm-map' ); ?></h5>

		<div class="form-group">
			
			<label for="mx_default_zoon_map"><?php echo __( 'Default zoom map:', 'mxmpotm-map' ); ?></label>

			<select name="mx_default_zoon_map" id="mx_default_zoon_map" class="form-control">
				
				<?php for( $i = 1; $i <= 18; $i++ ) : ?>
					
					<option value="<?php echo $i; ?>" <?php if( 9 == $i ) echo 'selected'; ?>><?php echo $i; ?></option>

				<?php endfor; ?>

			</select>

		</div>

		<div class="form-group">
			
			<label for="mx_default_zoon_to_point"><?php echo __( 'Default zoom to the point:', 'mxmpotm-map' ); ?></label>

			<select name="mx_default_zoon_to_point" id="mx_default_zoon_to_point" class="form-control">
				
				<?php for( $y = 8; $y <= 18; $y++ ) : ?>
					
					<option value="<?php echo $y; ?>" <?php if( 12 == $y ) echo 'selected'; ?>><?php echo $y; ?></option>

				<?php endfor; ?>

			</select>

		</div>		

	</div>

	<div class="mx-block_wrap">

		<div class="form-group">

			<h6><?php echo __( 'Map size', 'mxmpotm-map' ); ?></h6>
			
			<label for="mx_size_map_width"><?php echo __( 'Width:', 'mxmpotm-map' ); ?></label>

			<input type="text" name="mx_size_map_width" class="form-control" id="mx_size_map_width" placeholder="<?php echo __( 'For example: 700px or 100%', 'mxmpotm-map' ); ?>" value="100%" required />

		</div>

		<div class="form-group">

			<label for="mx_size_map_height"><?php echo __( 'Height:', 'mxmpotm-map' ); ?></label>

			<input type="text" name="mx_size_map_height" class="form-control" id="mx_size_map_height" placeholder="<?php echo __( 'For example: 500px', 'mxmpotm-map' ); ?>" value="500px" required />

		</div>

	</div>

	<div class="mx-block_wrap">

		<h5><?php echo __( 'Search points', 'mxmpotm-map' ); ?></h5>

		<div class="form-group">

			<label for="mx_show_points_filter"><?php echo __( 'Show points filter:', 'mxmpotm-map' ); ?></label>

			<input type="checkbox" name="mx_show_points_filter" class="form-control" id="mx_show_points_filter" value="0" />

		</div>	

	</div>

	<!-- <div class="mx-block_wrap">

		<h5><?php echo __( 'Filters', 'mxmpotm-map' ); ?></h5>

		<div class="form-group">

			<label for="mx_show_region_filter"><?php echo __( 'Show region filter:', 'mxmpotm-map' ); ?></label>

			<input type="checkbox" name="mx_show_region_filter" class="form-control" id="mx_show_region_filter" value="0" />

		</div>	

	</div> -->

	<!-- area of creating a new points  -->
	<br>
	<h2 class="text-secondary"><?php echo __( 'Create new points on the map', 'mxmpotm-map' ); ?></h2>

	<!-- Working block -->
	<div class="mx-block_wrap" id="mxmpotm_points_wrap"></div>

	<!-- This block is an example block structure. For JS -->
	<div class="mx-block_wrap" id="mxmpotm_points_wrap_example" style="display: none;">
		<?php include( 'components/add_point_for_js.php' ); ?>
	</div>
	<!-- end JS block -->

	<div class="mx-block_wrap">

		<p class="mx-submit_button_wrap">
			<input type="hidden" id="mxmpotm_wpnonce" name="mxmpotm_wpnonce" value="<?php echo wp_create_nonce( 'mxmpotm_nonce_request' ) ;?>" />
			<input class="button-primary" type="submit" name="mxmpotm-submit" value="<?php echo __( 'Create map', 'mxmpotm-map' ); ?>" />
		</p>

	</div>

</form>

<!-- Variables for javascript with translation functions -->
<?php include( 'components/js_vars.php' ); ?>