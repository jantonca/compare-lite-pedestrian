<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://pedestriangroup.com.au/
 * @since             1.1.0
 * @package           Compare_Lite_Pedestrian
 *
 * @wordpress-plugin
 * Plugin Name:       Compare Lite Pedestrian
 * Plugin URI:        https://pedestriangroup.com.au/
 * Description:       This is plugin produces a shortcode to create a form that redirects to https://www.econnex.com.au/ to compare Energy Prices, Rates & Tariffs.
 * Version:           1.1.0
 * Author:            Jose Anton
 * Author URI:        https://pedestriangroup.com.au/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       compare-lite-pedestrian
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.1.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'COMPARE_LITE_PEDESTRIAN_VERSION', '1.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-compare-lite-pedestrian-activator.php
 */
function activate_compare_lite_pedestrian() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-compare-lite-pedestrian-activator.php';
	Compare_Lite_Pedestrian_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-compare-lite-pedestrian-deactivator.php
 */
function deactivate_compare_lite_pedestrian() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-compare-lite-pedestrian-deactivator.php';
	Compare_Lite_Pedestrian_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_compare_lite_pedestrian' );
register_deactivation_hook( __FILE__, 'deactivate_compare_lite_pedestrian' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-compare-lite-pedestrian.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.1.0
 */
function run_compare_lite_pedestrian() {

	$plugin = new Compare_Lite_Pedestrian();
	$plugin->run();

}
run_compare_lite_pedestrian();
