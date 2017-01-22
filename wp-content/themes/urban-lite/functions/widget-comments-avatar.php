<?php
add_action( 'widgets_init', 'comments_avatar_widget' );
function comments_avatar_widget() {
	register_widget( 'comments_avatar' );
}
class comments_avatar extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'comments-avatar', 'description' => __('Display comments with avatar.', 'czs'));
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'comments_avatar-widget' );
		parent::__construct( 'comments_avatar-widget',__('Recent Comments with avatar', 'czs'), $widget_ops, $control_ops);
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', $instance['title'] );
		$no_of_comments = ( ! empty( $instance['no_of_comments'] ) ) ? absint( $instance['no_of_comments'] ) : 5;

		echo $before_widget;
		 ?>

		<div class="widget-home"><h3 class="widget-title">  <?php echo ''.$title.'' ?>  </h3></div>
			<ul>	
		<?php czs_most_commented( $no_of_comments ); ?>
		</ul>
	<?php 
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['no_of_comments'] = (int) $new_instance['no_of_comments'];
		
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' =>__( 'Recent Comments' , 'czs'), 'no_of_comments' => '5'  );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'czs'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" type="text" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'no_of_comments' ); ?>"><?php _e('Number of comments to show:', 'czs'); ?></label>
			<input id="<?php echo $this->get_field_id( 'no_of_comments' ); ?>" name="<?php echo $this->get_field_name( 'no_of_comments' ); ?>" value="<?php echo $instance['no_of_comments']; ?>" type="text" size="3" />
		</p>


	<?php
	}
}
?>