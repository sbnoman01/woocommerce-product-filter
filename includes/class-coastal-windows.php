<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wpnoman.com
 * @since      1.0.0
 *
 * @package    Coastal_Windows
 * @subpackage Coastal_Windows/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Coastal_Windows
 * @subpackage Coastal_Windows/includes
 * @author     WP Noman <sbnoman27@gmail.com>
 */
class Coastal_Windows
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Coastal_Windows_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('COASTAL_WINDOWS_VERSION')) {
			$this->version = COASTAL_WINDOWS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'coastal-windows';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Coastal_Windows_Loader. Orchestrates the hooks of the plugin.
	 * - Coastal_Windows_i18n. Defines internationalization functionality.
	 * - Coastal_Windows_Admin. Defines all hooks for the admin area.
	 * - Coastal_Windows_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-coastal-windows-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-coastal-windows-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-coastal-windows-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-coastal-windows-public.php';

		$this->loader = new Coastal_Windows_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Coastal_Windows_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Coastal_Windows_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Coastal_Windows_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		add_action('init', [$plugin_admin, 'woo_hooks']);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Coastal_Windows_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

		add_action("wp_ajax_wc_product_filter", [$this, "wc_product_filter"]);
		add_action("wp_ajax_nopriv_wc_product_filter", [$this, "wc_product_filter"]);
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
		$this->public_class_loaders();
		$this->shortcode_register();
	}

	public function shortcode_register()
	{
		$shortcode = new Class_ShortCode();
		add_shortcode('wc-slider-by-noman', [$shortcode, 'wc_product_slider']);
		add_shortcode('wc-product-filter-by-noman', [$shortcode, 'wc_product_filter']);
		add_shortcode('wc-related-product-by-noman', [$shortcode, 'wc_related_product']);
	}
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Coastal_Windows_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}

	public function public_class_loaders()
	{
		require_once plugin_dir_path(__FILE__) . '/class-wpnoman-shortcode.php';
	}

	/****
	 * 
	 * Filer ajax requests handlers
	 */
	public function wc_product_filter()
	{

		// verify nonce
		$nonce = $_REQUEST['nonce'];
		if (wp_verify_nonce($nonce, 'product-filter') != true) {
			return;
		}

		//get posts ID for specific type
		$args = [
			'post_type' => 'product',
			'fields'         => 'ids',
		];
	
		if (!empty($vars['type'])) {
			$args['tax_query'] =  array(
				array(
					'taxonomy' => 'item-type',
					'field'    => 'slug',
					'terms'    => sanitize_text_field( $_REQUEST['type'] ),
				),
			);
		}
		$post_ids = get_posts($args);

		$paged = 1; //sanitize_text_field($_REQUEST['page']);

		$product_post_args = [
			'post_type' => 'product',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query' => ['relation' => 'AND'],
			'post__in' => $post_ids,
			'order'             => 'ASC'
			// 'paged' => $paged
		];

		$get_perforance_term = (sanitize_text_field($_REQUEST['perforance'])) ? explode(',', sanitize_text_field($_REQUEST['perforance'])) : null;
		if ($get_perforance_term != null && count($get_perforance_term) > 0) {
			$product_post_args['tax_query'][] = [
				'taxonomy' => 'performance',
				'field'     => 'slug',
				'terms' => $get_perforance_term
			];
		}

		$get_styles_term = (sanitize_text_field($_REQUEST['styles'])) ? explode(',', sanitize_text_field($_REQUEST['styles'])) : null;
		if ($get_styles_term != null && count($get_styles_term) > 0) {
			$product_post_args['tax_query'][] = [
				'taxonomy' => 'styles',
				'field'     => 'slug',
				'terms' => $get_styles_term
			];
		}
		$get_frame_term = (sanitize_text_field($_REQUEST['frame'])) ? explode(',', sanitize_text_field($_REQUEST['frame'])) : null;
		if ($get_frame_term != null && count($get_frame_term) > 0) {
			$product_post_args['tax_query'][] = [
				'taxonomy' => 'frames',
				'field'     => 'slug',
				'terms' => $get_frame_term
			];
		}

		$product_query = new WP_Query($product_post_args);

		if ($product_query->have_posts()) {
			while ($product_query->have_posts()) {
				$product_query->the_post();
				ob_start();
					?>
						<div class="filter-col-4">
							<div class="filter-single-item">
								<div class="wcproduct-thumb">
									<a href="<?php echo esc_url(get_the_permalink()) ?>">
										<?php echo get_the_post_thumbnail(); ?>
									</a>
								</div>
								<div class="wcproduct-inner-content">
									<a href="<?php echo esc_url(get_the_permalink()) ?>">
										<h3>
											<?php the_title(); ?>
										</h3>
									</a>
								</div>
							</div>
						</div>
					<?php
				$_post[] = ob_get_clean();
			}
			wp_reset_postdata();
		}
		wp_send_json(['max_num_page' => $product_query->max_num_pages, 'posts' => $_post, 'query' =>  $product_post_args, 'type' => $_REQUEST['type']]);

		die();
	}
}