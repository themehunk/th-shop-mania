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