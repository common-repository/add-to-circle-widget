<?php
/**
 * Plugin Name: Add to Circle Widget
 * Plugin URI: http://wordpress.org/extend/plugins/add-to-circle-widget/
 * Description: WordPress widget to add Google+ badge on your blog. That can help you grow your audience on Google+ and allow people to add you to their circles and +1 your pages without leaving your site.
 * Version: 1.0
 * Author: Tesur Rajan
 * Author URI: http://www.bubbleindia.com
 */

/**
 * Add function to widgets_init that'll load our widget.
 * @since 1.0
 */
add_action( 'widgets_init', 'add_to_circle_load_widgets' );

/**
 * Register our widget.
 * 'Add_to_Circle_Widget' is the widget class used below.
 *
 * @since 1.0
 */
function add_to_circle_load_widgets() {
	register_widget( 'Add_to_Circle_Widget' );
}

/**
 * Add to Circle Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 1.0
 */
class Add_to_Circle_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Add_to_Circle_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Add_to_Circle_Widget', 'description' => 'Google+ add to Circle Badge.' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'add-to-circle-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'add-to-circle-widget', 'Add to Circle Widget', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$google_page_id = $instance['google_page_id'];
		$badge_layout = $instance['badge_layout'];
		$badge_color = $instance['badge_color'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display name from widget settings if one was input. */
		if ( $google_page_id || $badge_layout || $badge_color )
			echo "<g:plus href=\"https://plus.google.com/".$google_page_id."/\" size=\"".$badge_layout."\" theme=\"".$badge_color."\"></g:plus>";
		

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['google_page_id'] = strip_tags( $new_instance['google_page_id'] );

		/* No need to strip tags for sex and show_sex. */
		$instance['badge_layout'] = $new_instance['badge_layout'];
		$instance['badge_color'] = $new_instance['badge_color'];

		return $instance;
	}


	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'google_page_id' => '', 'badge_layout' => 'standard', 'badge_color' => 'light' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title (Optional)</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Google Page ID: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'google_page_id' ); ?>">Google+ Page ID:</label>
			<input id="<?php echo $this->get_field_id( 'google_page_id' ); ?>" name="<?php echo $this->get_field_name( 'google_page_id' ); ?>" value="<?php echo $instance['google_page_id']; ?>" style="width:100%;" />
		</p>

		<!-- Badge Layout Style: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'badge_layout' ); ?>">Layout Style:</label>
			<select id="<?php echo $this->get_field_id( 'badge_layout' ); ?>" name="<?php echo $this->get_field_name( 'badge_layout' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'smallbadge' == $instance['badge_layout'] ) echo 'selected="selected"'; ?> value="smallbadge">Small</option>
				<option <?php if ( 'badge' == $instance['badge_layout'] ) echo 'selected="selected"'; ?> value="badge">Standard</option>
			</select>
		</p>
		
                <!-- Badge Color Scheme: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'badge_color' ); ?>">Color Scheme:</label>
			<select id="<?php echo $this->get_field_id( 'badge_color' ); ?>" name="<?php echo $this->get_field_name( 'badge_color' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'light' == $instance['badge_color'] ) echo 'selected="selected"'; ?> value="light">Light</option>
				<option <?php if ( 'dark' == $instance['badge_color'] ) echo 'selected="selected"'; ?> value="dark">Dark</option>
			</select>
		</p>
		
		<p>

			<lable>Did you like it:</lable></br>
			<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FBubbleIndia.TheDigitalStreet&amp;send=false&amp;layout=standard&amp;width=300&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=lucida+grande&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:35px;" allowTransparency="true"></iframe>		

		</p>

		
	<?php
	}

}

function insert_google_script_in_head() {

                echo '<script type="text/javascript">';
		echo '(function()';
		echo '{var po = document.createElement("script");';
		echo 'po.type = "text/javascript"; po.async = true;po.src = "https://apis.google.com/js/plusone.js";';
		echo 'var s = document.getElementsByTagName("script")[0];';
		echo 's.parentNode.insertBefore(po, s);';
		echo '})();</script>';

}

add_action( 'wp_head', 'insert_google_script_in_head');

?>