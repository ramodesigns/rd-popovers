<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.paulramotowski.com
 * @since      1.0.0
 *
 * @package    Rd_Popovers
 * @subpackage Rd_Popovers/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Rd_Popovers
 * @subpackage Rd_Popovers/includes
 * @author     Paul Ramotowski <paulramotowski@gmail.com>
 */
class Rd_Popovers_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rd-popovers',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
