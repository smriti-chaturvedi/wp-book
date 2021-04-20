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

	//Crate custom taxonomy book tag
	public function Wp_Book_custom_taxonomy_tag () {
		$labels = array(
    'name' => _x( 'Books Tag', 'taxonomy general name' ),
    'singular_name' => _x( 'Book Tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Books Tag' ),
    'popular_items' => __( 'Popular Books Tag' ),
    'all_items' => __( 'All Books Tag' ),
    'edit_item' => __( 'Edit Book Tag' ),
    'update_item' => __( 'Update Book Tag' ),
    'add_new_item' => __( 'Add New Book Tag' ),
    'new_item_name' => __( 'New Book Tag Name' ),
    'separate_items_with_commas' => __( 'Separate books tag with commas' ),
    'add_or_remove_items' => __( 'Add or remove books tag' ),
    'choose_from_most_used' => __( 'Choose from the most used book tags' ),
    'menu_name' => __( 'Book Tags' ),
  	);
		$args = array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'book-tag' ),
  	);
		register_taxonomy('book tag', 'book', $args);
	}

	//Registers Custom Table
	public function Wp_Book_register_custom_table () {
		global $wpdb;
		$wpdb->bookmeta = $wpdb->prefix . 'bookmeta';
		$wpdb->tables[] = 'bookmeta';

		return;
	}

	//Adding Custom Meta Box
	public function Wp_Book_add_meta_box () {
		add_meta_box(
			'Wp_Book_meta_id',
			__('Book Details', 'Wp_Book'),
			array($this, 'Wp_Book_html'),
			'book'
		);
	}

	//HTML for meta box
	public function Wp_Book_html ($post) {
		?>
		<p>
			<label for="author">Author Name</label>
			<br/>
			<input type="text" name="author" id="author" value="<?php echo esc_attr( get_metadata('book', get_the_ID(), 'author', true ) ); ?>">
		</p>
		<p>
			<label for="price">Price</label>
			<br/>
			<input type="text" name="price" id="price" value="<?php echo esc_attr( get_metadata('book', get_the_ID(), 'price', true ) ); ?>">
		</p>
		<p>
			<label for="publisher">Publisher</label>
			<br/>
			<input type="text" name="publisher" id="publisher" value="<?php echo esc_attr( get_metadata('book', get_the_ID(), 'publisher', true ) ); ?>">
		</p>
		<p>
			<label for="year">Year</label>
			<br/>
			<input type="text" name="year" id="year" value="<?php echo esc_attr( get_metadata('book', get_the_ID(), 'year', true ) ); ?>">
		</p>
		<p>
			<label for="edition">Edition</label>
			<br/>
			<input type="text" name="edition" id="edition" value="<?php echo esc_attr( get_metadata('book', get_the_ID(), 'edition', true ) ); ?>">
		</p>
		<?php
	}

	//Saving contents of meta custom box in custom table
	public function Wp_Book_meta_save ($post_id) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
		$fields=['author', 'price', 'publisher', 'year', 'edition'];
		foreach ($fields as $field) {
			if ( array_key_exists( $field, $_POST ) ) {
				update_metadata('book', $post_id, $field,  sanitize_text_field( $_POST[$field] ));
			}
		}
	}

	//Adding custom menu page
	public function Wp_Book_admin_menu () {
		add_menu_page(
			__( 'Settings', 'Wp_Book' ),
			__( 'Booksmenu', 'Wp_Book' ),
			'manage_options',
			'booksmenu',
			array($this, 'Wp_Book_menu_render'),
			'',
			3
		);
	}

	//Adds section and fields to settings page
	public function Wp_Book_menu_render () {
		?>
	 <h1> <?php esc_html_e( 'Welcome to my custom admin page.', 'Wp_Book' ); ?> </h1>
	 <form method="POST" action="options.php">
	 <?php
	 settings_fields( 'book-setting' );
	 do_settings_sections( 'book-setting' );
	 submit_button();
	 ?>
	 </form>
	 <?php
	}

	//Registers the fields and calls the function to fill markup for settings page
	public function Wp_Book_settings_init() {

    add_settings_section(
        'book-section',
        __( 'Custom settings', 'Wp_Book' ),
        array($this, 'Wp_Book_setting_section'),
        'book-setting'
    );

		add_settings_field(
		   'number_of_books',
		   __( 'Number Of Books', 'Wp_Book' ),
		   array($this, 'Wp_Book_number_markup'),
		   'book-setting',
		   'book-section'
		);

		register_setting( 'book-setting', 'number_of_books' );

		add_settings_field(
		   'currency',
		   __( 'Currency', 'Wp_Book' ),
		   array($this, 'Wp_Book_currency_markup'),
		   'book-setting',
		   'book-section'
		);

		register_setting( 'book-setting', 'currency' );
	}


	//Rendering callback for settings section
	function Wp_Book_setting_section() {
	}

	//Markup for number of books
	function Wp_Book_number_markup() {
    ?>
    <label for="number_of_books"><?php _e( 'Number of Books on page' ); ?></label>
    <input type="number" id="number_of_books" name="number_of_books" value="<?php echo get_option( 'number_of_books' ); ?>">
    <?php
	}

	//Markup for currenct
	function Wp_Book_currency_markup() {
		$currencies = ['INR','USD','EUR'];
    ?>
    <label for="currency"><?php _e( 'Currency' ); ?></label>
    <select>
    	<?php
				$selected = get_option('currency');
				foreach ($currencies as $currency) {
					if($currency != $selected) {
						echo '<option value="'.$currency.'">'.$currency.'</option>';
					}
					else {
						echo '<option selected value="'.$currency.'">'.$currency.'</option>';
					}
				}
			?>
    </select>
    <?php
	}


	//Shortcode Rendering functions
	public function Wp_Book_render_shortcode ($atts) {
		$atts = shortcode_atts(array(
			'book_id'   => '',
			'author'    => '',
			'year'		  => '',
			'category'  => '',
			'tag'       => '',
			'publisher' => ''
		), $atts);

		$args = array(
			'post_type' => 'book',
			'post_status' => 'publish'
		);

		if( $atts[ 'author' ] != '' ) {
			$args[ 'author' ] = $atts[ 'author' ];
		}
		if( $atts[ 'book_id' ] != '' ) {
			$args[ 'book_id' ] = $atts[ 'book_id' ];
		}
		if( $atts[ 'category' ] != '' ) {
			$args[ 'tax_query' ] = array(
				array(
					'taxonomy' => 'book category',
          'terms' => array( $atts[ 'category' ] )
				),
			);
		}
		if( $atts[ 'tag' ] != '' ){
			$args[ 'tax_query' ] = array(
				array(
					'taxonomy' => 'book tag',
          'terms' => array( $atts[ 'tag' ] )
				),
			);
		}
		return $this->Wp_Book_shortcode_function( $args );
	}

	public function Wp_Book_shortcode_function( $args ) {
		global $wpdb;
		$Wp_Book_query = new WP_Query( $args );
		if( $Wp_Book_query-> have_posts() ) {
			while( $Wp_Book_query->have_posts() ) {
				$Wp_Book_query->the_post();
				$author = get_metadata( 'book', get_the_ID(), 'author' )[0];
				$price = get_metadata( 'book', get_the_ID(), 'price' )[0];
				$publisher = get_metadata( 'book', get_the_ID(), 'publisher' )[0];
				$link = get_permalink(get_the_ID());
				?>
				<ul style="list-style:none;">
					<?php
					if( get_the_title() != '' ){
					?>
						<li><?php _e( 'Book Title :', 'Wp_Book' ) ?><a href="<?php echo $link; ?>."><?php echo get_the_title(); ?></a></li>
					<?php
				}
				if( $author != '' ){
          ?>
          	<li><?php _e( 'Author Name :', 'Wp_Book' ) ?><?php echo $author; ?></li>
          <?php
          }
					if( $price != '' ){
	          ?>
	          	<li><?php _e( 'Price :', 'Wp_Book' ) ?><?php echo $price; ?></li>
	          <?php
	          }
						if( $publisher != '' ){
		          ?>
		          	<li><?php _e( 'Publisher :', 'Wp_Book' ) ?><?php echo $publisher;  ?></li>
		          <?php
		          }

					?>
				</ul>
				<?php
			}
		}
		else {
			?>
				<h1><?php _e( 'Sorry no Books Found', 'Wp_Book' ) ?></h1>
			<?php
		}
	}

	//Registers Shortcode
	public function Wp_Book_register_shortcode () {
		add_shortcode( 'book', array($this, 'Wp_Book_render_shortcode'));
	}

	//Creates Dashboard Widget
	public function Wp_Book_custom_dashboard_widget () {
		wp_add_dashboard_widget(
			'Wp_Book_dashboard_id',
			__('Top 5 Categories', 'Wp_Book'),
			array($this, 'Wp_Book_find_categories')
		);
	}

	//Finds and lists top 5 categories based on Count
	public function Wp_Book_find_categories () {
		$args = array(
			'orderby' => 'count',
			'order' => 'DESC',
			'number' => 5,
			'taxonomy' => 'book category'
		);
		wp_list_categories($args);
	}


}
