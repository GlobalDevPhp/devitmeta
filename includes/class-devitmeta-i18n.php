<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://itnotes.org.ua/
 * @since      1.0.0
 *
 * @package    Devitmeta
 * @subpackage Devitmeta/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Devitmeta
 * @subpackage Devitmeta/includes
 * @author     Yevgen Khromykh <itnotes.org.ua@gmail.com >
 */
class Devitmeta_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'devitmeta',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
