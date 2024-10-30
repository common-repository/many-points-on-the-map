<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

$map_id = $_GET['map'];

// ger results
$map_rows = mxmpotm_select_row( $map_id );

// exit if the result is not found
if( $map_rows == NULL ) {

	//wp_redirect( get_admin_url() . 'admin.php?page=mxmpotm-many-points-on-the-map' );

	$back_url = get_admin_url() . 'admin.php?page=mxmpotm-many-points-on-the-map';

	?>
		<script> window.location.href = '<?php echo $back_url; ?>'; </script>
	<?php

	die( '<a href="' . $back_url . '">Something wrong, come back</a>' );

}

// get current page url
$current_page_url = get_admin_url() . 'admin.php?page=mxmpotm-many-points-on-the-map&map=' . $map_id;

// translate points data into array
$unserialize_points = maybe_unserialize( $map_rows->points );

?>

<h1 class="text-secondary"><?php echo __( 'Edit map', 'mxmpotm-map' ); ?></h1>

<form id="mxmpotm_map_update" class="mx-settings" method="post" action="">

	<div class="mx-block_wrap">

		<input type="hidden" id="mx_map_id" name="mx_map_id" value="<?php echo $map_id; ?>" />

		<input type="hidden" id="current_page_url" name="current_page_url" value="<?php echo $current_page_url; ?>" />

		<div class="form-group">
			<label for="mx_name_of_the_map"><?php echo __( 'The name of the map:', 'mxmpotm-map' ); ?> <span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="mx_name_of_the_map" name="mx_name_of_the_map" value="<?php echo $map_rows->map_name; ?>" required />	
		</div>

		<div class="form-group">
			<label for="mx_desc_of_the_map"><?php echo __( 'Map description:', 'mxmpotm-map' ); ?></label>
			<textarea name="mx_desc_of_the_map" id="mx_desc_of_the_map"><?php echo $map_rows->map_desc; ?></textarea>
		</div>			

	</div>

	<div class="mx-block_wrap">

		<h5><?php echo __( 'Coordinates of the map', 'mxmpotm-map' ); ?></h5>

		<div class="form-group">

			<label for="mx_latitude_map_center"><?php echo __( 'Latitude Map Center:', 'mxmpotm-map' ); ?> <span class="text-danger">*</span></label>
			<input type="text" name="mx_latitude_map_center" class="form-control mx-is_coordinates" id="mx_latitude_map_center" placeholder="<?php echo __( 'For example: 50.428545', 'mxmpotm-map' ); ?>" value="<?php echo $map_rows->latitude_map_center; ?>" required />

		</div>

		<div class="form-group">
			
			<label for="mx_longitude_map_center"><?php echo __( 'Longitude Map Center:', 'mxmpotm-map' ); ?> <span class="text-danger">*</span></label>
			<input type="text" name="mx_longitude_map_center" class="form-control mx-is_coordinates" id="mx_longitude_map_center" placeholder="<?php echo __( 'For example: 30.689375', 'mxmpotm-map' ); ?>" value="<?php echo $map_rows->longitude_map_center; ?>" required />

		</div>

	</div>

	<div class="mx-block_wrap">

		<h5><?php echo __( 'Scaling a map', 'mxmpotm-map' ); ?></h5>

		<div class="form-group">
			
			<label for="mx_default_zoon_map"><?php echo __( 'Default zoom map:', 'mxmpotm-map' ); ?></label>

			<select name="mx_default_zoon_map" id="mx_default_zoon_map" class="form-control">
				
				<?php for( $i = 1; $i <= 18; $i++ ) : ?>
					
					<option value="<?php echo $i; ?>" <?php if( $map_rows->zoom_map_center == $i ) echo 'selected'; ?>><?php echo $i; ?></option>

				<?php endfor; ?>

			</select>

		</div>

		<div class="form-group">
			
			<label for="mx_default_zoon_to_point"><?php echo __( 'Default zoom to the point:', 'mxmpotm-map' ); ?></label>

			<select name="mx_default_zoon_to_point" id="mx_default_zoon_to_point" class="form-control">
				
				<?php for( $y = 8; $y <= 18; $y++ ) : ?>
					
					<option value="<?php echo $y; ?>" <?php if( $map_rows->zoom_to_point == $y ) echo 'selected'; ?>><?php echo $y; ?></option>

				<?php endfor; ?>

			</select>

		</div>

	</div>

	<div class="mx-block_wrap">

		<h5><?php echo __( 'Map size', 'mxmpotm-map' ); ?></h5>

		<div class="form-group">			
			
			<label for="mx_size_map_width"><?php echo __( 'Width:', 'mxmpotm-map' ); ?></label>

			<input type="text" name="mx_size_map_width" class="form-control" id="mx_size_map_width" placeholder="<?php echo __( 'For example: 700px or 100%', 'mxmpotm-map' ); ?>" value="<?php echo $map_rows->map_width; ?>" required />

		</div>

		<div class="form-group">

			<label for="mx_size_map_height"><?php echo __( 'Height:', 'mxmpotm-map' ); ?></label>

			<input type="text" name="mx_size_map_height" class="form-control" id="mx_size_map_height" placeholder="<?php echo __( 'For example: 500px', 'mxmpotm-map' ); ?>" value="<?php echo $map_rows->map_height; ?>" required />

		</div>

	</div>

	<div class="mx-block_wrap">

		<h5><?php echo __( 'Filters', 'mxmpotm-map' ); ?></h5>

		<div class="form-group">

			<label for="mx_show_points_filter"><?php echo __( 'Show points filter:', 'mxmpotm-map' ); ?></label>

			<input type="checkbox" name="mx_show_points_filter" class="form-control" id="mx_show_points_filter" value="<?php echo $map_rows->filter_points; ?>" <?php if( $map_rows->filter_points == 1 ) echo 'checked'; ?> />

		</div>

	</div>

	<!-- <div class="mx-block_wrap">

		<h5><?php echo __( 'Filters', 'mxmpotm-map' ); ?></h5>

		<div class="form-group">

			<label for="mx_show_region_filter"><?php echo __( 'Show region filter:', 'mxmpotm-map' ); ?></label>

			<input type="checkbox" name="mx_show_region_filter" class="form-control" id="mx_show_region_filter" value="<?php echo $map_rows->filter_regions; ?>" <?php if( $map_rows->filter_regions == 1 ) echo 'checked'; ?> />

		</div>	

	</div> -->

	<!-- area of creating a new points  -->
	<br>
	<h2 class="text-secondary"><?php echo __( 'Create points on the map', 'mxmpotm-map' ); ?></h2>

	<!-- Working block -->
	<div class="mx-block_wrap" id="mxmpotm_points_wrap">
		
		<?php foreach( $unserialize_points as $point ) : ?>

			<div class="mxmpotm_point_wrap" data-id="<?php echo $point['point_id']; ?>">

				<div class="mx_number_of_point">
					<span class="mx_number_of_point_s">#</span>
					<span class="mx_number_of_point_n"><?php echo $point['point_id']; ?></span>
				</div>

				<button type="button" class="mx-open_point_box"><i class="fa fa-angle-down"></i></button>

				<button type="button" class="mx-add_point" title="<?php echo __( 'Add a new point', 'mxmpotm-map' ); ?>"><i class="fa fa-plus"></i></button>

				<button type="button" class="mx-del_point" title="<?php echo __( 'Delete point', 'mxmpotm-map' ); ?>"><i class="fa fa-trash"></i></button>
					
				<div class="form-group mx-form-group_first">

					<small class="form-text text-dark"><?php echo __( 'Set point name', 'mxmpotm-map' ); ?> *</small>
					<input type="text" class="mx_new_point_name form-control mx-is_required" name="mx_new_point_name" placeholder="" value="<?php echo $point['point_name']; ?>" />

					<small class="form-text text-dark"><?php echo __( 'Describe the point', 'mxmpotm-map' ); ?></small>
					<textarea name="mx_new_point_desc" class="mx_new_point_desc form-control" placeholder=""><?php echo $point['point_desc']; ?></textarea>

					<div>
						
						<small class="form-text text-dark"><?php echo __( 'Latitude', 'mxmpotm-map' ); ?> *</small>
						<input type="text" name="mx_new_point_latitude" class="mx_new_point_latitude form-control mx-is_required mx-is_coordinates"  placeholder="<?php echo __( 'For example: 50.456608', 'mxmpotm-map' ); ?>" value="<?php echo $point['point_latitude']; ?>" />

						<small class="form-text text-dark"><?php echo __( 'Longitude', 'mxmpotm-map' ); ?> *</small>
						<input type="text" name="mx_new_point_longitude" class="mx_new_point_longitude form-control mx-is_required mx-is_coordinates"  placeholder="<?php echo __( 'For example: 30.343306', 'mxmpotm-map' ); ?>" value="<?php echo $point['point_longitude']; ?>" />

					</div>

					<small class="form-text text-dark"><?php echo __( 'Address', 'mxmpotm-map' ); ?> *</small>
					<input type="text" name="mx_new_point_address" class="mx_new_point_address form-control mx-is_required" placeholder="" value="<?php echo $point['point_address']; ?>" />

					<!-- web site -->
					<small class="form-text text-dark"><?php echo __( 'WebSite', 'mxmpotm-map' ); ?></small>
					<input type="text" name="mx_new_point_web_site" class="mx_new_point_web_site form-control" placeholder="" value="<?php echo $point['web_site']; ?>" />

					<!-- phone -->
					<small class="form-text text-dark"><?php echo __( 'Phone', 'mxmpotm-map' ); ?></small>
					<input type="text" name="mx_new_point_phone" class="mx_new_point_phone form-control" placeholder="" value="<?php echo $point['phone']; ?>" />

					<small class="form-text text-dark"><?php echo __( 'Additional information', 'mxmpotm-map' ); ?></small>
					<textarea name="mx_new_point_additional" class="mx_new_point_additional form-control" placeholder=""><?php echo $point['point_additional']; ?></textarea>
				
					<!-- regions -->
					<div class="mxmpotm_point_area_wrap">

						<h6><?php echo __( 'Below you can add a list of regions that are related to this point.', 'mxmpotm-map' ); ?></h6>

						<?php if( ! isset( $point['areas'] ) or count( $point['areas'] ) == 0 ) : ?>

							<div class="form-group mxmpotm_point_area">
								<input type="text" class="mx_new_point_region form-control" placeholder="Which region belongs to this point" /><button type="button" class="mx-add_region" title="<?php echo __( 'Add region', 'mxmpotm-map' ); ?>"><i class="fa fa-plus"></i></button>
								<button type="button" class="mx-delete_region" title="<?php echo __( 'Delete region', 'mxmpotm-map' ); ?>"><i class="fa fa-trash"></i></button>
								<div class="clearfix"></div>
							</div>

						<?php else : ?>
						
							<?php foreach( $point['areas'] as $area ) : ?>

								<div class="form-group mxmpotm_point_area">
									<input type="text" class="mx_new_point_region form-control" placeholder="Which region belongs to this point" value="<?php echo $area; ?>" /><button type="button" class="mx-add_region" title="<?php echo __( 'Add region', 'mxmpotm-map' ); ?>"><i class="fa fa-plus"></i></button>
									<button type="button" class="mx-delete_region" title="<?php echo __( 'Delete region', 'mxmpotm-map' ); ?>"><i class="fa fa-trash"></i></button>
									<div class="clearfix"></div>
								</div>

							<?php endforeach; ?>

						<?php endif; ?>
						
					</div>

					<!-- custom marker -->
					<div class="mxmpotm_custom_marker_wrap">

						<?php

							$mxmpotm_image_src = MXMPOTM_PLUGIN_URL . '/includes/admin/assets/img/default_icon.png';

							$data_default_marker = 0;

							$reset_button = 'style="display: none;"';

							if( strlen( $point['point_custom_marker'] ) > 4 ) {

								$mxmpotm_image_src = $point['point_custom_marker'];

								$data_default_marker = 1;

								$reset_button = '';

							}

						?>

						<img src="<?php echo $mxmpotm_image_src; ?>" alt="" width="50" height="50" class="mxmpotm_add_custom_marker" data-default-marker="<?php echo $data_default_marker; ?>" title="<?php echo __( 'Add Custom Marker', 'mxmpotm-map' ); ?>" />
						<div>
							<p><?php echo __( 'You can add your own custom marker. (e.g 50x50 px.)', 'mxmpotm-map' ); ?></p>
						</div>

						<div class="mxmpotm_custom_marker_reset_marker" <?php echo $reset_button; ?> title="<?php echo __( 'Reset Marker', 'mxmpotm-map' ); ?>">
							<i class="fa fa-close"></i>
						</div>
											
					</div>

				</div>

			</div>

		<?php endforeach; ?>

	</div>

	<!-- This block is an example block structure. For JS -->
	<div class="mx-block_wrap" id="mxmpotm_points_wrap_example" style="display: none;">
		<?php include( 'components/add_point_for_js.php' ); ?>
	</div>
	<!-- end JS block -->	

	<div class="mx-block_wrap">

		<p class="mx-submit_button_wrap">
			<input type="hidden" id="mxmpotm_wpnonce" name="mxmpotm_wpnonce" value="<?php echo wp_create_nonce( 'mxmpotm_nonce_request' ) ;?>" />

			<input class="btn btn-danger btn-sm float-left" type="button" name="mxmpotm_delete_map_btn" data-id-map="<?php echo $map_id; ?>" data-nonce="<?php echo wp_create_nonce( 'mxmpotm_nonce_request' ) ;?>" value="<?php echo __( 'Delete map', 'mxmpotm-map' ); ?>" id="mxmpotm_delete_map_btn" />

			<input class="btn btn-success btn-sm" type="submit" name="mxmpotm-submit" value="<?php echo __( 'Edit map', 'mxmpotm-map' ); ?>" />
		</p>

	</div>

</form>

<!-- Variables for javascript with translation functions -->
<?php include( 'components/js_vars.php' ); ?>