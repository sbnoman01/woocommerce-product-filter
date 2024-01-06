<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpnoman.com
 * @since             1.0.0
 * @package           Coastal_Windows
 *
 * @wordpress-plugin
 * Plugin Name:       Coastal Windows by WPNoman
 * Plugin URI:        https://wpnoman.com
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            WP Noman
 * Author URI:        https://wpnoman.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       coastal-windows
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'COASTAL_WINDOWS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-coastal-windows-activator.php
 */
function activate_coastal_windows() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-coastal-windows-activator.php';
	Coastal_Windows_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-coastal-windows-deactivator.php
 */
function deactivate_coastal_windows() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-coastal-windows-deactivator.php';
	Coastal_Windows_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_coastal_windows' );
register_deactivation_hook( __FILE__, 'deactivate_coastal_windows' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-coastal-windows.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_coastal_windows() {

	$plugin = new Coastal_Windows();
	$plugin->run();

}
run_coastal_windows();


/**
 * Allow SVG Uploads in WordPress
 */
function allow_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');


