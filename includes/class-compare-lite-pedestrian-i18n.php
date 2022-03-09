<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://pedestriangroup.com.au/
 * @since      1.1.1
 *
 * @package    Compare_Lite_Pedestrian
 * @subpackage Compare_Lite_Pedestrian/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.1.1
 * @package    Compare_Lite_Pedestrian
 * @subpackage Compare_Lite_Pedestrian/includes
 * @author     Jose Anton <jose.anton@pedestriangroup.com.au>
 */
class Compare_Lite_Pedestrian_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.1.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'compare-lite-pedestrian',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
