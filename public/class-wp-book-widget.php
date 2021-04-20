<?php 
// Creating the widget
class Wp_Book_category_widget extends WP_Widget {

	function __construct() {
    parent::__construct(
      'Wp_Book_widget',
      __('Book Category Widget', 'Wp_Book domain'), 
      array( 'description' => __( 'Creates a custom widget', 'Wp_Book domain' ), ) 
    );
	}

	// Front End
	public function widget( $args, $instance ) {
	    $title 		  = apply_filters( 'widget_title', $instance[ 'title' ] );
	    $taxonomy 	= $instance[ 'taxonomy' ];

      $args = array(
		    'post_type' => 'book',
        'tax_query' => array(
          array(
            'taxonomy' => 'book category',
            'field'    => 'slug',
            'terms'    => $taxonomy,
          ),
        ),
	    );

	    ?>
  		<?php echo $before_widget; ?>
  	  <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
  		<ol>
        <?php
          $query = new Wp_Query( $args );
          while($query->have_posts()){
            $query->the_post();
            $link = get_permalink(get_the_ID());
            echo '<li><a href="' .$link. '">'. get_the_title() . '</a></li>';
          }
        ?>
  		</ol>
    	<?php echo $after_widget; ?>
	     <?php
	}

	// Widget Backend
	public function form( $instance ) {
		if( isset( $instance[ 'title' ]) ) {
        $title = esc_attr($instance['title']);
      } else {
        $title = '';
      }
	    if( isset( $instance[ 'taxonomy' ]) ) {
        $taxonomy	= esc_attr($instance['taxonomy']);
      } else {
        $taxonomy = '';
      }
	    ?>
	    <p>
	      <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
	      <input id="<?php echo $this->get_field_name( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
	    </p>
	    <p>
		    <label for="<?php echo $this->get_field_name( 'taxonomy' ); ?>"> <?php _e( 'Choose the category' ); ?></label>
		    <select id="<?php echo $this->get_field_name('taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" >
			    <?php
          $taxonomies = get_terms( array( 'taxonomy' => 'book category') );
          if( !empty($taxonomies)) {
            foreach( $taxonomies as $category ) {
              if( $category->taxonomy == 'book category' ) {
                echo '<option value="' .$category->name. '"', $taxonomy == $category->name?' selected="selected"' : '', '>', $category->name, '</option>';
              }
            }
          }
			    ?>
		    </select>
	    </p>
	    <?php
	}

	function update($new_instance, $old_instance) {
	    $instance = $old_instance;
	    $instance[ 'title' ]    = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';;
	    $instance[ 'taxonomy' ] = ( ! empty( $new_instance['taxonomy'] ) ) ? strip_tags( $new_instance['taxonomy'] ) : '';;
	    return $instance;
    }
}

