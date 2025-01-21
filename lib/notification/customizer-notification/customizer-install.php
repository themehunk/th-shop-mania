<?php
if ( ! class_exists( 'WP_Customize_Control' ) ) {
    return;
}
function th_shop_mania_customizer_scripts() {
    wp_enqueue_script('th-shop-mania-customizer', get_template_directory_uri() . '/lib/notification/customizer-notification/customizer.js', array('jquery'), '1.0', true);

    wp_localize_script('th-shop-mania-customizer', 'theme_data_customizer', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('thactivatenonce'),
        'redirectUrl' => esc_url(admin_url('themes.php?page=themehunk-site-library&template=step'))
    ));
}
add_action('customize_controls_enqueue_scripts', 'th_shop_mania_customizer_scripts');

// style
function th_shop_mania_customizer_notify_css(){
    
  wp_enqueue_style('th_shop_mania_customizer_notify-styles', TH_SHOP_MANIA_THEME_URI .'lib/notification/customizer-notification/customizer-notify.css');
}
add_action('customize_controls_print_styles', 'th_shop_mania_customizer_notify_css');

if ( !function_exists('th_shop_mania_install_and_activate_callback') ) {
   
// AJAX handler for installing and activating plugins
add_action('wp_ajax_th_shop_mania_install_and_activate_callback', 'th_shop_mania_install_and_activate_callback');

// Callback function to install and activate plugin
function th_shop_mania_install_and_activate_callback() {

    if ( ! current_user_can( 'administrator' ) ) {

        wp_die( - 1, 403 );
        
    } 
    // Check nonce for security
    check_ajax_referer('thactivatenonce', 'security');

    // Retrieve plugin slug from AJAX request
    $plugin_slug = isset($_POST['plugin_slug']) ? sanitize_text_field($_POST['plugin_slug']) : '';

    if (empty($plugin_slug)) {
        wp_send_json_error(array('message' => 'Plugin slug is missing.'));
        return;
    }

    $plugin_file = WP_PLUGIN_DIR . '/' . $plugin_slug . '/' . $plugin_slug . '.php';

    // Install the plugin
    if (!file_exists($plugin_file)) {
        // Start output buffering to capture the plugin installation output
        ob_start();
        
        $status = th_shop_mania_install_custom_plugin($plugin_slug);
        
        // Get the buffered content
        $install_output = ob_get_clean();
        
        if (is_wp_error($status)) {
            wp_send_json_error(array('message' => $status->get_error_message(), 'install_output' => $install_output));
            return;
        }
        
        // Check if the plugin file exists after installation
        if (!file_exists($plugin_file)) {
            wp_send_json_error(array('message' => 'Plugin file does not exist after installation.', 'install_output' => $install_output));
            return;
        }
    }

    // Activate the plugin
    if (!is_plugin_active($plugin_file)) {
        $status = activate_plugin($plugin_file);
        if (is_wp_error($status)) {
            wp_send_json_error(array('message' => $status->get_error_message()));
            return;
        }
       
    }
     return 'Plugin installed and activated successfully.';
   
}

}