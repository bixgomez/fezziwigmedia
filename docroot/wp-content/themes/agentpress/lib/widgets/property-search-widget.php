<?php
/**
 * undocumented 
 *
 * @package Genesis
 */

add_action('widgets_init', 'register_agentpress_property_search_widget');
function register_agentpress_property_search_widget() {
	register_widget('AgentPress_Property_Search_Widget');
}

class AgentPress_Property_Search_Widget extends WP_Widget {

	function AgentPress_Property_Search_Widget() {
		$widget_ops = array( 'classname' => 'property-search', 'description' => 'Display property search dropdown' );
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'property-search' );
		$this->WP_Widget( 'property-search', 'AgentPress - Property Search', $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		
		echo $before_widget;
		
		if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
		
		if(!empty($instance['label_1'])) {
			echo '<form action="'.get_bloginfo('url').'" method="get">';
		
			if ($instance['label_1']) echo apply_filters('widget_title', $instance['label_1']);
			echo '<br />';
			wp_dropdown_categories("child_of=".intval($instance['cat_1'])."&hierarchical=1&orderby=name");
		
			echo '<input type="submit" name="submit" class="view" value="view" />';
			echo '</form>';
			
		}	// End 1
		
		if(!empty($instance['label_2'])) {
			echo '<form action="'.get_bloginfo('url').'" method="get">';
		
			if ($instance['label_2']) echo apply_filters('widget_title', $instance['label_2']);
			echo '<br />';
			wp_dropdown_categories("child_of=".intval($instance['cat_2'])."&hierarchical=1&orderby=name");
		
			echo '<input type="submit" name="submit" class="view" value="view" />';
			echo '</form>';
			
		}	// End 2
		
		if(!empty($instance['label_3'])) {
			echo '<form action="'.get_bloginfo('url').'" method="get">';
		
			if ($instance['label_3']) echo apply_filters('widget_title', $instance['label_3']);
			echo '<br />';
			wp_dropdown_categories("child_of=".intval($instance['cat_3'])."&hierarchical=1&orderby=name");
		
			echo '<input type="submit" name="submit" class="view" value="view" />';
			echo '</form>';
			
		}	// End 3
		
		if(!empty($instance['label_4'])) {
			echo '<form action="'.get_bloginfo('url').'" method="get">';
		
			if ($instance['label_4']) echo apply_filters('widget_title', $instance['label_4']);
			echo '<br />';
			wp_dropdown_categories("child_of=".intval($instance['cat_4'])."&hierarchical=1&orderby=name");
		
			echo '<input type="submit" name="submit" class="view" value="view" />';
			echo '</form>';
			
		}	// End 4
		
		if(!empty($instance['label_5'])) {
			echo '<form action="'.get_bloginfo('url').'" method="get">';
		
			if ($instance['label_5']) echo apply_filters('widget_title', $instance['label_5']);
			echo '<br />';
			wp_dropdown_categories("child_of=".intval($instance['cat_5'])."&hierarchical=1&orderby=name");
		
			echo '<input type="submit" name="submit" class="view" value="view" />';
			echo '</form>';
		
		}	// End 5
		
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) { ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'genesis'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" />
		</p>
		
		<p><?php _e('Choose up to 5 Categories by which your users can search:', 'genesis'); ?></p>

		<p>
			<label for="<?php echo $this->get_field_id('label_1'); ?>"><?php _e('Label', 'genesis'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('label_1'); ?>" name="<?php echo $this->get_field_name('label_1'); ?>" value="<?php echo esc_attr( $instance['label_1'] ); ?>" style="width:95%;" /><br />
			<?php wp_dropdown_categories('show_option_none=Select Category&depth=1&hierarchical=1&name='.$this->get_field_name('cat_1').'&selected='.$instance['cat_1']); ?>
		</p>
		
		<?php // End 1 ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('label_2'); ?>"><?php _e('Label', 'genesis'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('label_2'); ?>" name="<?php echo $this->get_field_name('label_2'); ?>" value="<?php echo esc_attr( $instance['label_2'] ); ?>" style="width:95%;" /><br />
			<?php wp_dropdown_categories('show_option_none=Select Category&depth=1&hierarchical=1&name='.$this->get_field_name('cat_2').'&selected='.$instance['cat_2']); ?>
		</p>
		
		<?php // End 2 ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('label_3'); ?>"><?php _e('Label', 'genesis'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('label_3'); ?>" name="<?php echo $this->get_field_name('label_3'); ?>" value="<?php echo esc_attr( $instance['label_3'] ); ?>" style="width:95%;" /><br />
			<?php wp_dropdown_categories('show_option_none=Select Category&depth=1&hierarchical=1&name='.$this->get_field_name('cat_3').'&selected='.$instance['cat_3']); ?>
		</p>
		
		<?php // End 3 ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('label_4'); ?>"><?php _e('Label', 'genesis'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('label_4'); ?>" name="<?php echo $this->get_field_name('label_4'); ?>" value="<?php echo esc_attr( $instance['label_4'] ); ?>" style="width:95%;" /><br />
			<?php wp_dropdown_categories('show_option_none=Select Category&depth=1&hierarchical=1&name='.$this->get_field_name('cat_4').'&selected='.$instance['cat_4']); ?>
		</p>
		
		<?php // End 4 ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('label_5'); ?>"><?php _e('Label', 'genesis'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('label_5'); ?>" name="<?php echo $this->get_field_name('label_5'); ?>" value="<?php echo esc_attr( $instance['label_5'] ); ?>" style="width:95%;" /><br />
			<?php wp_dropdown_categories('show_option_none=Select Category&depth=1&hierarchical=1&name='.$this->get_field_name('cat_5').'&selected='.$instance['cat_5']); ?>
		</p>
		
		<?php // End 5 ?>
		
			
	<?php 
	}
}
?>