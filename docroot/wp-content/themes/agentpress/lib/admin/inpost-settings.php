<?php
/**
 * This file defines a special meta box for the AgentPress theme,
 * which allows users to input details about the property.
 *
 * ap_add_inpost_details_box() is used to register the boxes.
 * @uses add_meta_box
 * ap_inpost_details_box() generates the content in the boxes.
 * @uses wp_create_nonce, checked, genesis_get_custom_field
 *
 */
add_action('admin_menu', 'ap_add_inpost_details_box', 9);
function ap_add_inpost_details_box() {
    add_meta_box('ap_inpost_details_box_1', __('Property Details - Section #1', 'genesis'), 'ap_inpost_details_box_1', 'post', 'normal', 'high');
    if( genesis_get_option('features_2_col1_1', AP_SETTINGS_FIELD) )
    add_meta_box('ap_inpost_details_box_2', __('Property Details - Section #2', 'genesis'), 'ap_inpost_details_box_2', 'post', 'normal', 'high');
}
function ap_inpost_details_box_1() {

    echo '<p><span class="description">Insert the following shortcode into your post where you would like this content to be displayed: <code>[property_details details="1"]</code></span></p>' . "\n";

    wp_nonce_field( plugin_basename(__FILE__), 'ap_inpost_details_nonce' );

    $columns_loop = array(1,2);
    $settings_loop = array(1,2,3,4,5,6,7,8,9,10);
    
    echo '<div style="width: 45%; float: left">';
    foreach ($columns_loop as $column) :
        
        foreach($settings_loop as $setting) :

            $label = genesis_get_option('features_1_col'.$column.'_'.$setting, AP_SETTINGS_FIELD);
            if( $label ) :
                
                if($column == 2 && $setting == 1)
                echo '</div><div style="width: 45%; float: right;">';
                
                $name = '_features_1_col'.$column.'_'.$setting;
                $value = genesis_get_custom_field($name);
                echo '<p><label>'.$label.'<br /><input type="text" name="ap['.$name.']" value="'.$value.'" /></label></p>';
                
            endif;
    
        endforeach;
        
    endforeach;
    echo '</div><br style="clear: both;" />';
}

function ap_inpost_details_box_2() {
    
    echo '<p><span class="description">Insert the following shortcode into your post where you would like this content to be displayed: <code>[property_details details="2"]</code></span></p>' . "\n";

    $columns_loop = array(1,2);
    $settings_loop = array(1,2,3,4,5,6,7,8,9,10);
    
    echo '<div style="width: 45%; float: left">';
    foreach ($columns_loop as $column) :
        
        foreach($settings_loop as $setting) :

            $label = genesis_get_option('features_2_col'.$column.'_'.$setting, AP_SETTINGS_FIELD);
            if( $label ) :
                
                if($column == 2 && $setting == 1)
                echo '</div><div style="width: 45%; float: right;">';
                
                $name = '_features_2_col'.$column.'_'.$setting;
                $value = genesis_get_custom_field($name);
                echo '<p><label>'.$label.'<br /><input type="text" name="ap['.$name.']" value="'.$value.'" /></label></p>';
                
            endif;
    
        endforeach;
        
    endforeach;
    echo '</div><br style="clear: both;" />';
}

/**
 * This function saves the layout options when we save a post/page.
 * It does so by grabbing the array passed in $_POST, looping through
 * it, and saving each key/value pair as a custom field.
 *
 * @uses wp_verify_nonce, plugin_basename, current_user_can
 * @uses add_post_meta, update_post_meta, delete_post_meta, get_custom_field
 */
add_action('save_post', 'ap_inpost_details_save', 1, 2);
function ap_inpost_details_save($post_id, $post) {
    
    //    verify the nonce
    if (!wp_verify_nonce($_POST['ap_inpost_details_nonce'], plugin_basename(__FILE__)))
        return $post_id;
        
    //    don't try to save the data under autosave, ajax, or future post.
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if(defined('DOING_AJAX') && DOING_AJAX) return;
    if(defined('DOING_CRON') && DOING_CRON) return;

    //    is the user allowed to edit the post or page?
    if(('page' == $_POST['post_type'] && !current_user_can('edit_page', $post_id)) || !current_user_can('edit_post', $post_id ))
        return $post_id;
        
    $property_details = $_POST['ap'];
    
    //    store the custom fields
    foreach ( (array)$property_details as $key => $value ) {
        if($post->post_type == 'revision') return; // don't try to store data during revision save
        
        //    save/update
        if( $value ) {
            // save/update
            update_post_meta($post->ID, $key, $value);
        } else {
            // delete if blank
            delete_post_meta($post->ID, $key);
        }
    }
    
}