<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="container-fluid mt-1">
	
	<div class="row">
		<div class="col-12 mt-2">

			<h1 class="float-left text-secondary"><?php echo __( 'All maps', 'mxmpotm-map' ); ?></h1>

			<a href="admin.php?page=mxmpotm-many-points-on-the-map-add" class="btn btn-primary float-right"><?php echo __( 'Create map', 'mxmpotm-map' ); ?></a>
			
		</div>
	</div>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col"><?php echo __( 'Name', 'mxmpotm-map' ); ?></th>
			<th scope="col"><?php echo __( 'Description', 'mxmpotm-map' ); ?></th>
			<th scope="col"><?php echo __( 'Shortcode', 'mxmpotm-map' ); ?></th>
			<th scope="col"><?php echo __( 'Action', 'mxmpotm-map' ); ?></th>
		</tr>
	</thead>

	<tbody>
	<!-- # -->

	<?php $all_maps = mxmpotm_select_rows(); ?>

	<?php foreach( $all_maps as $key => $map ) : ?>

		<?php $key++; ?>

	    <tr>
			<th scope="row"><?php echo $key; ?></th>
			<td>
				<a href="<?php echo get_admin_url(); ?>admin.php?page=mxmpotm-many-points-on-the-map-edit&map=<?php echo $map->id; ?>">
					<strong>
						<?php echo $map->map_name; ?>
					</strong>
				</a>
			</td>
			<td><p><?php echo $map->map_desc; ?></p></td>
			<td><span class="mx-shortcode">[many_points_map id="<?php echo $map->id; ?>"]</span></td>
			<td><span class="mx-del-map">
				<button type="button" data-id-map="<?php echo $map->id; ?>" data-nonce="<?php echo wp_create_nonce( 'mxmpotm_nonce_request' ) ;?>" class="btn btn-danger" id="mxmpotm_delete_map_btn"><i class="fa fa-trash"></i></button>
			</span></td>
	    </tr>

	<?php endforeach; ?>

	<!-- # -->
	</tbody>

	<tfoot>
	<tr>
	  <th scope="col">#</th>
	  <th scope="col"><?php echo __( 'Name', 'mxmpotm-map' ); ?></th>
	  <th scope="col"><?php echo __( 'Description', 'mxmpotm-map' ); ?></th>
	  <th scope="col"><?php echo __( 'Shortcode', 'mxmpotm-map' ); ?></th>
	  <th scope="col"><?php echo __( 'Action', 'mxmpotm-map' ); ?></th>
	</tr>
	</tfoot>

</table>

<script>

	// for JS
	var confirmTextdelMap = '<?php echo __( 'Delete map?', 'mxmpotm-map' ); ?>';

</script>