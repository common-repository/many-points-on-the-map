<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/*
* Require template for admin panel
*/
function mxmpotm_require_template_admin($file)
{

	require_once MXMPOTM_PLUGIN_ABS_PATH . 'includes/admin/templates/' . $file;
}

/*
* Select data
*/
// select row by id
function mxmpotm_select_row($id)
{

	global $wpdb;

	$table_name = $wpdb->prefix . MXMPOTM_TABLE_SLUG;

	$get_row_map = $wpdb->get_row("SELECT map_name, map_desc, points, latitude_map_center, longitude_map_center, zoom_map_center, zoom_to_point, map_width, map_height, filter_regions, filter_points FROM $table_name WHERE id = $id");

	return $get_row_map;
}

// select rows
function mxmpotm_select_rows()
{

	global $wpdb;

	$table_name = $wpdb->prefix . MXMPOTM_TABLE_SLUG;

	$get_all_rows_map = $wpdb->get_results("SELECT id, map_name, map_desc, points FROM $table_name ORDER BY id DESC");

	return $get_all_rows_map;
}

/*
* Shortcodes
*/
function mxmpotm_show_many_points_map($args)
{

	ob_start();

	// if isset id of the map
	if (!isset($args['id'])) return '<strong>Error in shortcode!</strong>';

	// save this id
	$id_map = intval($args['id']);

	// get result by id
	$result_map = mxmpotm_select_row($id_map);

	// check if the map exists
	if ($result_map == NULL) return '<strong>Error in shortcode!</strong>';

	// unserialize points
	$unserialize_points = maybe_unserialize($result_map->points);

	// sortable
	$array_result = mxmpotm_sort_array_by_alphabet_order($unserialize_points);

	// $result_map, $array_result

	$points = maybe_unserialize($result_map->points);

	$map_id = get_the_ID();

	// var_dump(json_encode($result_map)); 
?>

	<div class="mx-map_wrapper">

		<div class="mx-map_desc">
			<h3><?php echo $result_map->map_name; ?></h3>

			<?php if ($result_map->filter_points == '1') : ?>

				<div class="mx-map_filter">
					<label for="mxmpotm_map_search_point"><?php echo __('Search points:', 'mxmpotm-map'); ?></label>
					<select id="mx-map-select" name="mxmpotm_map_search_point">
						<option value="">All</option>
						<?php foreach ($points as $point) : ?>
							<option value="<?php echo $point['point_latitude']; ?>,<?php echo $point['point_longitude']; ?>"><?php echo $point['point_name']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>

			<?php endif; ?>

			<p><?php echo $result_map->map_desc; ?></p>
		</div>

		<div id="mxmpotm_map" style="width: <?php echo $result_map->map_width; ?>; height:<?php echo $result_map->map_height; ?>" data-mx-map='<?php echo mx_map_data_to_json($result_map); ?>' data-map_id="<?php echo $map_id; ?>"></div>

	</div>

<?php return ob_get_clean();
}

add_shortcode('many_points_map', 'mxmpotm_show_many_points_map');

/*
* components of map
*/

// data to json
function mx_map_data_to_json($data)
{

	$prepared_data = [];

	foreach ($data as $key => $value) {

		if ($key !== 'points') {
			$prepared_data[$key] = $value;
		} else {
			$prepared_data[$key] = maybe_unserialize($value);
		}
	}

	return json_encode($prepared_data);
}

// 
function mxmpotm_sort_array_by_alphabet_order($_array)
{

	$new_array_of_names = array();

	foreach ($_array as $key => $value) {

		array_push($new_array_of_names, $value["point_name"]);
	}

	// get names by alphabet order
	$array_of_names_sorted = mxmpotm_sort_array_by_alphabet_order_recursion($new_array_of_names, array());

	// create sortable array
	$sortable_array = mxmpotm_crate_sortable_array($_array, $array_of_names_sorted);

	return $sortable_array;
}

// sort name value
function mxmpotm_sort_array_by_alphabet_order_recursion($new_array_of_names, $new_array_of_names_sorted)
{

	$new_array_of_names = $new_array_of_names;

	$new_array_of_names_sorted = $new_array_of_names_sorted;

	if (count($new_array_of_names) > 0) {

		// find minimal value
		$min_value = min($new_array_of_names);

		array_push($new_array_of_names_sorted, $min_value);

		// remove minimal value from main array
		foreach ($new_array_of_names as $key => $value) {

			if ($key = array_search($min_value, $new_array_of_names)) {

				unset($new_array_of_names[$key]);

				$new_array_of_names_sorted = mxmpotm_sort_array_by_alphabet_order_recursion($new_array_of_names, $new_array_of_names_sorted);
			}
		}
	}

	return $new_array_of_names_sorted;
}

// crate sortable array
function mxmpotm_crate_sortable_array($full_array, $name_ordered_array)
{

	$sortable_array = array();

	foreach ($name_ordered_array as $key => $value) {

		foreach ($full_array as $_key => $_value) {

			if ($value == $_value["point_name"]) {

				array_push($sortable_array, $full_array[$_key]);
			}
		}
	}


	return $sortable_array;
}
