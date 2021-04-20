<?php //phpcs:ignore
/**  Creating the widget */
class Wp_Book_Category_Widget extends WP_Widget {




	/** Constructore for class */
	public function __construct() {
		$widget_options = array(
			'classname'   => 'WP_Book_category_widget',
			'description' => __( 'Custom widget to display the books of selected category.', 'Wp_Book' ),
		);
		parent::__construct( 'Wp_Book_category', __( 'Book Category', 'Wp_book' ), $widget_options );
	}

	/**  Front End
	 *
	 * @param array    $args phpcs:ignore.
	 * @param instance $instance phpcs:ignore.
	 */
	public function widget( $args, $instance ) {
		$before_widget = isset( $args['before_widget'] ) ? $args['before_widget'] : '';
		$after_widget  = isset( $args['after_widget'] ) ? $args['after_widget'] : '';
		$before_title  = isset( $args['before_title'] ) ? $args['before_title'] : '';
		$after_title   = isset( $args['after_title'] ) ? $args['after_title'] : '';

		extract( $args ); //phpcs:ignore

		$title    = apply_filters( 'widget_title', $instance['title'] );
		$taxonomy = $instance['taxonomy'];

		$args = array(
			'post_type' => 'book',
			'tax_query' => array( //phpcs:ignore
				array(
					'taxonomy' => 'book category',
					'field'    => 'slug',
					'terms'    => $taxonomy,
				),
			),
		);

		?>
		<?php echo $before_widget; // phpcs:ignore
		?>
		<?php
		if ( $title ) {
			echo  $before_title . $title . $after_title ; // phpcs:ignore
		}
		?>
		<ol>
		<?php
		$query = new Wp_Query( $args );
		while ( $query->have_posts() ) {
			$query->the_post();
			$link = get_permalink( get_the_ID() );
			echo '<li><a href="' . esc_html( $link ) . '">' . esc_html( get_the_title() ) . '</a></li>';
		}
		?>
		</ol>
		<?php echo  $after_widget ;  //phpcs:ignore
		?>
		<?php

	}

	/** Widget Backend
	 *
	 * @param array $instance phpcs:ignore.
	 */
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = esc_attr( $instance['title'] );
		} else {
			$title = '';
		}
		if ( isset( $instance['taxonomy'] ) ) {
			$taxonomy = esc_attr( $instance['taxonomy'] );
		} else {
			$taxonomy = '';
		}
		?>
		<p>
			<label for="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>"><?php esc_html( 'Title' ); ?></label>
			<input id="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_html( $this->get_field_name( 'taxonomy' ) ); ?>"> <?php esc_html( 'Choose the category' ); ?></label>
			<select id="<?php echo esc_html( $this->get_field_name( 'taxonomy' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'taxonomy' ) ); ?>" >
		<?php
		$taxonomies = get_terms( array( 'taxonomy' => 'book category' ) );
		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $category ) {
				if ( 'book category' === $category->taxonomy ) {
					echo '<option value="' . esc_html( $category->name ) . '"', $taxonomy === $category->name ? ' selected="selected"' : '', '>', esc_html( $category->name ), '</option>';
				}
			}
		}
		?>
			</select>
		</p>
		<?php
	}

	//phpcs:disable.
	/** Function for updating
	 * @param array $new_instance
	 * @param array $old_instance
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = $old_instance;
		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : ''; 
		$instance['taxonomy'] = ( ! empty( $new_instance['taxonomy'] ) ) ? strip_tags( $new_instance['taxonomy'] ) : ''; 
		return $instance;
	}
	//phpcs:enable.
}
