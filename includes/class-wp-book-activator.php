<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/smriti-chaturvedi-hbwsl
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 * @author     Smriti Chaturvedi <smriti.chaturvedi@hbwsl.com>
 */
class Wp_Book_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$version = '1.0.0';
		$wp_book_admin = new Wp_Book_Admin('Wp_Book', $version);
		$wp_book_admin->Wp_Book_custom_table();
	}

}
