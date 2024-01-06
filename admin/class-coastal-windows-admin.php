<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpnoman.com
 * @since      1.0.0
 *
 * @package    Coastal_Windows
 * @subpackage Coastal_Windows/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Coastal_Windows
 * @subpackage Coastal_Windows/admin
 * @author     WP Noman <sbnoman27@gmail.com>
 */
class Coastal_Windows_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name , $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->woo_hooks();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Coastal_Windows_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Coastal_Windows_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/coastal-windows-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Coastal_Windows_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Coastal_Windows_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/coastal-windows-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	public function woo_hooks(){
		
		
// 		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
 		add_action('woocommerce_single_product_summary', [$this, 'add_to_cart_redirection'], 31);
		add_filter ( 'woocommerce_is_sold_individually', [ $this, 'custom_remove_all_quantity_fields'], 10, 2 );
		add_filter('woocommerce_product_single_add_to_cart_text', [ $this, 'custom_single_add_to_cart_text'] );
	}
	
	public function add_to_cart_redirection(){
		
		$id = get_the_ID();
		?>
	<script>
		(function( $ ) {

		 $('.single_add_to_cart_button').on('click', function(e){
			 e.preventDefault();

			 var redirectTo = "https://coastalcustomwindows.com/where-to-buy/?id=<?php echo $id; ?>";

			  // Perform the redirect
			  window.location.href = redirectTo;
		 });
		})( jQuery );

	</script>
<?php
	}
	public function custom_remove_all_quantity_fields( $return, $product ) {
	  return true;
	}
	
	public function custom_single_add_to_cart_text($text) {
		return __('Request a Quote', 'woocommerce');
	}

}
