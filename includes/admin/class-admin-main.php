<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

class MXMPOTMAdminMain
{

	public $plugin_name;

	/*
	* MXMPOTMAdminMain constructor
	*/
	public function __construct()
	{

		$this->plugin_name = MXMPOTM_PLUGN_BASE_NAME;

		$this->mxmpotm_include();
	}

	/*
	* Include the necessary basic files for the admin panel
	*/
	public function mxmpotm_include()
	{

		// require database-talk class
		require_once MXMPOTM_PLUGIN_ABS_PATH . 'includes/admin/class-database-talk.php';
	}

	/*
	* Registration of styles and scripts
	*/
	public function mxmpotm_register()
	{

		// register scripts and styles
		add_action('admin_enqueue_scripts', array($this, 'mxmpotm_enqueue'));

		// register admin menu
		add_action('admin_menu', array($this, 'add_admin_pages'));

		// add link Settings under the name of the plugin
		add_filter("plugin_action_links_$this->plugin_name", array($this, 'settings_link'));
	}

	public function mxmpotm_enqueue()
	{

		// include custom file
		wp_enqueue_script('mxmpotm_admin_script_custom', MXMPOTM_PLUGIN_URL . 'includes/admin/assets/js/custom.js', array('jquery'), MXMPOTM_PLUGIN_VERSION, true);

		// localize object
		wp_localize_script('mxmpotm_admin_script_custom', 'mxmpotm_localize_script_custom_obj', array(

			'mxmpotm_nonce' 		=> wp_create_nonce('mxmpotm_admin_nonce')

		));

		if (!isset($_GET['page'])) return;

		// include bootstrap 4.1.1
		if (
			$_GET['page'] == 'mxmpotm-many-points-on-the-map' ||
			$_GET['page'] == 'mxmpotm-many-points-on-the-map-add' ||
			$_GET['page'] == 'mxmpotm-many-points-on-the-map-edit' ||
			$_GET['page'] == 'mxmpotm-many-points-on-the-map-settings'
		) {

			wp_enqueue_style('mxmpotm_bootstrap_4_1_1', MXMPOTM_PLUGIN_URL . 'includes/admin/assets/bootstrap-4.1.1/css/bootstrap.min.css');
		}

		// include font-awesome
		wp_enqueue_style('mxmpotm_font_awesome', MXMPOTM_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css');

		// include admin_style file
		wp_enqueue_style('mxmpotm_admin_style', MXMPOTM_PLUGIN_URL . 'includes/admin/assets/css/style.css', array('mxmpotm_font_awesome'), MXMPOTM_PLUGIN_VERSION, 'all');

		wp_enqueue_media();

		// include admin_script file
		wp_enqueue_script('mxmpotm_admin_script', MXMPOTM_PLUGIN_URL . 'includes/admin/assets/js/script.js', array('jquery'), MXMPOTM_PLUGIN_VERSION, true);

		// localize object
		wp_localize_script('jquery', 'mxmpotm_localize_script_obj', array(

			'default_marker_src' 	=> MXMPOTM_PLUGIN_URL . '/includes/admin/assets/img/default_icon.png',

			'mxmpotm_nonce' 		=> wp_create_nonce('mxmpotm_admin_nonce')

		));
	}

	// register admin menu
	public function add_admin_pages()
	{

		add_menu_page(__('List of the maps', 'mxmpotm-map'), __('Many points', 'mxmpotm-map'), 'manage_options', 'mxmpotm-many-points-on-the-map', array($this, 'admin_index'), 'dashicons-image-filter', 111); // icons https://developer.wordpress.org/resource/dashicons/#id

		// add map
		add_submenu_page('mxmpotm-many-points-on-the-map', __('Create a new map', 'mxmpotm-map'), __('Create a new map', 'mxmpotm-map'), 'manage_options', 'mxmpotm-many-points-on-the-map-add', array($this, 'add_map'));

		// edit map
		add_submenu_page('NULL', __('Edit Map', 'mxmpotm-map'), __('Edit Map', 'mxmpotm-map'), 'manage_options', 'mxmpotm-many-points-on-the-map-edit', array($this, 'edit_map'));

		// Settings page
		add_submenu_page('mxmpotm-many-points-on-the-map', __('Settings', 'mxmpotm-map'), __('Settings', 'mxmpotm-map'), 'manage_options', 'mxmpotm-many-points-on-the-map-settings', array($this, 'settings'));

	}

	public function admin_index()
	{

		// require index page
		mxmpotm_require_template_admin('index.php');
	}

	public function edit_map()
	{

		// require one_map page
		mxmpotm_require_template_admin('edit_map.php');
	}

	public function add_map()
	{

		// require add_new_map page
		mxmpotm_require_template_admin('add_new_map.php');
	}

	public function settings()
	{
	
		// require settings page
		mxmpotm_require_template_admin('settings.php');
	}

	// add settings link
	public function settings_link($links)
	{

		$settings_link = '<a href="' . get_admin_url() . 'admin.php?page=mxmpotm-many-points-on-the-map">' . __('Settings', 'mxmpotm-map') . '</a>'; // options-general.php

		array_push($links, $settings_link);

		return $links;
	}

	// notifications
	public function mxmpotm_notifications()
	{

		// marker notice
		if (is_admin() && get_option('_mxmpotm_custom_markup_notice') !== 'was_seen') {

			add_action('admin_notices', array($this, 'mxmpotm_custom_markup_notice'));
		}

		// alphabet order notice
		if (is_admin() && get_option('_mxmpotm_alphabet_order_notice') !== 'was_seen') {

			add_action('admin_notices', array($this, 'mxmpotm_alphabet_order_notice'));
		}
	}

	// marker notification
	public function mxmpotm_custom_markup_notice()
	{

?>
		<div class="notice notice-success mxmpotm_notification_marker">
			<h5><b>"Many points on the map" plugin:</b></h5>
			<p><?php echo __('Now you can set up your own custom marker for any point.', 'mxmpotm-map'); ?></p>

			<p>
				<a href="<?php get_admin_url(); ?>admin.php?page=mxmpotm-many-points-on-the-map"><?php echo __('Go to the map list', 'mxmpotm-map'); ?></a>
			</p>

			<p>
				<button class="button button-primary button-large">OK!</button>
			</p>
		</div>
	<?php

	}

	// alphabet order notice
	public function mxmpotm_alphabet_order_notice()
	{

	?>
		<div class="notice notice-success mxmpotm_notification_alphabet_order">
			<h5><b>"Many points on the map" plugin:</b></h5>
			<p><?php echo __('Now the plugin has the ability to sort points and regions alphabetically.', 'mxmpotm-map'); ?></p>

			<p>
				<a href="<?php get_admin_url(); ?>admin.php?page=mxmpotm-many-points-on-the-map"><?php echo __('Go to the map list', 'mxmpotm-map'); ?></a>
			</p>

			<p>
				<button class="button button-primary button-large">OK!</button>
			</p>
		</div>
<?php

	}
}

// Initialize
$initialize_class = new MXMPOTMAdminMain();

// Apply scripts and styles
$initialize_class->mxmpotm_register();

// apply notifications
// $initialize_class->mxmpotm_notifications();
