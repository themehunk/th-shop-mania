<?php
if ( ! class_exists( 'WP_Customize_Control' ) ) {
    return;
}
function th_shop_mania_customize_install_register($wp_customize) {
    // Include the custom section class
    include_once get_template_directory() . '/notification/customizer-notification/thsm-custom-section.php';

    $wp_customize->register_section_type('TH_Shop_Mania_Customizer_Notice_Section');

    $wp_customize->add_section(
        new TH_Shop_Mania_Customizer_Notice_Section(
            $wp_customize,
            'customizer-plugin-notice-section',
            array(
                'title' => __('Required Plugins', 'th-shop-mania'),
                'priority' => 0,
            )
        )
    );
}
add_action('customize_register', 'th_shop_mania_customize_install_register');


function th_shop_mania_customizer_scripts() {
    // wp_enqueue_style('th-shop-mania-customizer-notice', get_template_directory_uri() . '/path-to-your-customizer-notice.css', array());
    wp_enqueue_script('th-shop-mania-customizer-notice', get_template_directory_uri() . '/notification/customizer-notification/customizer.js', array('customize-controls'));
}
add_action('customize_controls_enqueue_scripts', 'th_shop_mania_customizer_scripts');
