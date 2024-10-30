<!-- point wrap -->
<div class="mxmpotm_point_wrap" data-id="1">

	<div class="mx_number_of_point">
		<span class="mx_number_of_point_s">#</span>
		<span class="mx_number_of_point_n">1</span>
	</div>

	<button type="button" class="mx-open_point_box"><i class="fa fa-angle-down"></i></button>

	<button type="button" class="mx-add_point" title="<?php echo __( 'Add a new point', 'mxmpotm-map' ); ?>"><i class="fa fa-plus"></i></button>

	<button type="button" class="mx-del_point" title="<?php echo __( 'Delete point', 'mxmpotm-map' ); ?>"><i class="fa fa-trash"></i></button>
		
	<div class="form-group mx-form-group_first">

		<small class="form-text text-dark"><?php echo __( 'Set point name', 'mxmpotm-map' ); ?> *</small>
		<input type="text" class="mx_new_point_name form-control mx-is_required" name="mx_new_point_name" placeholder="" />

		<small class="form-text text-dark"><?php echo __( 'Describe the point', 'mxmpotm-map' ); ?></small>
		<textarea name="mx_new_point_desc" class="mx_new_point_desc form-control" placeholder=""></textarea>

		<div>
			
			<small class="form-text text-dark"><?php echo __( 'Latitude', 'mxmpotm-map' ); ?> *</small>
			<input type="text" name="mx_new_point_latitude" class="mx_new_point_latitude form-control mx-is_required mx-is_coordinates" placeholder="<?php echo __( 'For example: 50.456608', 'mxmpotm-map' ); ?>" />
			
			<small class="form-text text-dark"><?php echo __( 'Longitude', 'mxmpotm-map' ); ?> *</small>
			<input type="text" name="mx_new_point_longitude" class="mx_new_point_longitude form-control mx-is_required mx-is_coordinates" placeholder="<?php echo __( 'For example: 30.343306', 'mxmpotm-map' ); ?>" />
			
		</div>

		<small class="form-text text-dark"><?php echo __( 'Address', 'mxmpotm-map' ); ?> *</small>
		<input type="text" name="mx_new_point_address" class="mx_new_point_address form-control mx-is_required" placeholder="" />

		<!-- web site -->
		<small class="form-text text-dark"><?php echo __( 'WebSite', 'mxmpotm-map' ); ?></small>
		<input type="text" name="mx_new_point_web_site" class="mx_new_point_web_site form-control" placeholder="" value="" />

		<!-- phone -->
		<small class="form-text text-dark"><?php echo __( 'Phone', 'mxmpotm-map' ); ?></small>
		<input type="text" name="mx_new_point_phone" class="mx_new_point_phone form-control" placeholder="" value="" />

		<small class="form-text text-dark"><?php echo __( 'Additional information', 'mxmpotm-map' ); ?></small>
		<textarea name="mx_new_point_additional" class="mx_new_point_additional form-control" placeholder=""></textarea>

		<!-- regions -->
		<div class="mxmpotm_point_area_wrap">

			<h6><?php echo __( 'Below you can add a list of regions that are related to this point.', 'mxmpotm-map' ); ?></h6>

			<div class="form-group mxmpotm_point_area">
				<input type="text" class="mx_new_point_region form-control" placeholder="<?php echo __( 'For example: Podol', 'mxmpotm-map' ); ?>" /><button type="button" class="mx-add_region" title="<?php echo __( 'Add region', 'mxmpotm-map' ); ?>"><i class="fa fa-plus"></i></button>
				<button type="button" class="mx-delete_region" title="<?php echo __( 'Delete region', 'mxmpotm-map' ); ?>"><i class="fa fa-trash"></i></button>
				<div class="clearfix"></div>
			</div>
			
		</div>

		<!-- custom marker -->
		<div class="mxmpotm_custom_marker_wrap">
			
			<img src="<?php echo MXMPOTM_PLUGIN_URL . '/includes/admin/assets/img/default_icon.png'; ?>" alt="" width="50" height="50" class="mxmpotm_add_custom_marker" data-default-marker="0" title="<?php echo __( 'Add Custom Marker', 'mxmpotm-map' ); ?>" />
			<div>
				<p><?php echo __( 'You can add your own custom marker. (e.g 50x50 px.)', 'mxmpotm-map' ); ?></p>
			</div>

			<div class="mxmpotm_custom_marker_reset_marker" style="display: none;" title="<?php echo __( 'Reset Marker', 'mxmpotm-map' ); ?>">
				<i class="fa fa-close"></i>
			</div>
			
		</div>

	</div>

</div>
<!-- point wrap -->
