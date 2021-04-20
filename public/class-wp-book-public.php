<?php //phpcs:ignore

/**
 * The public-facing functionality of the plugin.
 *
 * @link  https://github.com/smriti-chaturvedi-hbwsl
 * @since 1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 * @author     Smriti Chaturvedi <smriti.chaturvedi@hbwsl.com>
 */
class Wp_Book_Public {





	/**
	 * The ID of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.0.0
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-book-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since 1.0.0
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-book-public.js', array( 'jquery' ), $this->version, false );

	}

	/** Shortcode Rendering functions
	 *
	 * @param array $atts //phpcs:ignore.
	 */
	public function wp_book_render_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'book_id'   => '',
				'author'    => '',
				'year'      => '',
				'category'  => '',
				'tag'       => '',
				'publisher' => '',
			),
			$atts
		);

		$args = array(
			'post_type'   => 'book',
			'post_status' => 'publish',
		);

		if ( '' !== $atts['author'] ) {
			$args['author'] = $atts['author'];
		}
		if ( '' !== $atts['book_id'] ) {
			$args['p'] = $atts['book_id'];
		}
		if ( '' !== $atts['category'] ) {
			$args['tax_query'] = array( //phpcs:ignore
				array(
					'taxonomy' => 'book category',
					'terms'    => array( $atts['category'] ),
				),
			);
		}
		if ( '' !== $atts['tag'] ) {
			$args['tax_query'] = array( //phpcs:ignore
				array(
					'taxonomy' => 'book tag',
					'terms'    => array( $atts['tag'] ),
				),
			);
		}
		return $this->wp_book_shortcode_function( $args );
	}

	/** Function to query the database and display information
	 *
	 * @param array $args //phpcs:ignore.
	 */
	public function wp_book_shortcode_function( $args ) {
		$content = '';
		global $wpdb;
		$wp_book_query = new WP_Query( $args );
		if ( $wp_book_query->have_posts() ) {
			while ( $wp_book_query->have_posts() ) {
				$wp_book_query->the_post();
				$author    = get_metadata( 'book', get_the_ID(), 'author' )[0];
				$price     = get_metadata( 'book', get_the_ID(), 'price' )[0];
				$publisher = get_metadata( 'book', get_the_ID(), 'publisher' )[0];
				$link      = get_permalink( get_the_ID() );
				$title     = get_the_title();
				$content  .= '<ul>';
				if ( '' !== $title ) {
					$title    = get_the_title();
					$content .= '<li>' . __( 'Book Title : ', 'Wp_Domain' ) . '<a href="' . $link . '">' . $title . '</a></li>';
					$content .= '<li>' . __( 'Author Name : ', 'Wp_Domain' ) . $author . '</li>';
					$content .= '<li>' . __( 'Price : ', 'Wp_Domain' ) . $price . '</li>';
					$content .= '<li>' . __( 'Publisher : ', 'Wp_Domain' ) . $publisher . '</li>';
					$content .= '</ul>';
				}
				return $content;
			}
		} else {
			return '<h1>No Books Found</h1>';
		}
	}

	/** Registers Shortcode */
	public function wp_book_register_shortcode() {
		add_shortcode( 'book', array( $this, 'wp_book_render_shortcode' ) );
	}


}
