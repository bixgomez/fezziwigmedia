<?php

add_shortcode( 'property_details', 'ap_property_details_shortcode' );
function ap_property_details_shortcode( $atts ) {
	
	global $post;
	
	$defaults = array( 'details' => 1 );
	$atts = shortcode_atts( $defaults, $atts );
	
	$columns_loop = array(1,2);
	$settings_loop = array(1,2,3,4,5,6,7,8,9,10);
	
	$output .= '<div class="property-details-col1">';
	
	foreach ($columns_loop as $column) :
		
		foreach($settings_loop as $setting) :

			$label = genesis_get_option('features_'.$atts['details'].'_col'.$column.'_'.$setting, AP_SETTINGS_FIELD);
			
			if( $label ) :
				
				if($column == 2 && $setting == 1)
				$output .= '</div><div class="property-details-col2">';
				
				$name = '_features_'.$atts['details'].'_col'.$column.'_'.$setting;
				$value = genesis_get_custom_field($name);
				
				$output .= '<b>'. $label .'</b> '. $value . '<br />';
				
			endif;
	
		endforeach;
		
	endforeach;
	
	$output .= '</div>';
	
	return '<div class="property-details">' . "\n" . $output . "\n" . '</div>';
	
}