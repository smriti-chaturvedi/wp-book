<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/smriti-chaturvedi-hbwsl
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 * @author     Smriti Chaturvedi <smriti.chaturvedi@hbwsl.com>
 */
class Wp_Book_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Wp_Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-book-admin.css', array(), $this->version, 'all' );

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
		 * defined in Wp_Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-book-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	//Create custom book type Post
	public function Wp_Book_custom_post () {
		$labels = array(
    'name'               => _x( 'Books', 'post type general name' ),
    'singular_name'      => _x( 'Book', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Book' ),
    'edit_item'          => __( 'Edit Book' ),
    'new_item'           => __( 'New Book' ),
    'all_items'          => __( 'All Books' ),
    'view_item'          => __( 'View Book' ),
    'search_items'       => __( 'Search Books' ),
    'not_found'          => __( 'No books found' ),
    'not_found_in_trash' => __( 'No books found in the Trash' ),
    'menu_name'          => 'Books'
  	);
  	$args = array(
    'labels'        => $labels,
    'description'   => 'Holds data related to books',
    'public'        => true,
    'has_archive'   => true,
		'rewrite' => array('slug' => 'book'),
  	);
  	register_post_type( 'book', $args );
	}
	
	//Create custom hierarchical taxonomy book category
	public function Wp_Book_custom_taxonomy_category () {
		$labels = array(
    'name' => _x( 'Books Category', 'taxonomy general name' ),
    'singular_name' => _x( 'Book Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Books Category' ),
    'all_items' => __( 'All Books Category' ),
    'parent_item' => __( 'Parent Book Category' ),
    'parent_item_colon' => __( 'Parent Book Category:' ),
    'edit_item' => __( 'Edit Book Category' ),
    'update_item' => __( 'Update Book Category' ),
    'add_new_item' => __( 'Add New Book Category' ),
    'new_item_name' => __( 'New Book Name Category' ),
    'menu_name' => __( 'Book Category' ),
  	);
		$args =  array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'book-category' ),
		);
		register_taxonomy('book category', array('book'), $args);
	}

}
