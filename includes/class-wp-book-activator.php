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
		// $version = '1.0.0';
		// $wp_book_admin = new Wp_Book_Admin('Wp_Book', $version);
		// $wp_book_admin->Wp_Book_custom_table();
		
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'bookmeta';
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php' );

		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {
			$query = "CREATE TABLE ".
								$table_name . "(
								meta_id bigint(20) NOT NULL AUTO_INCREMENT,
								book_id bigint(20) NOT NULL DEFAULT '0',
								meta_key varchar(255) DEFAULT NULL,
								meta_value longtext,
								PRIMARY KEY (meta_id),
								KEY book (book_id),
								KEY meta_key (meta_key)
								)" . $charset_collate . ";";

								dbDelta($query);
		}

	}
	

}
