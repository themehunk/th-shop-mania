<?php
/**
 * Register WooCommerce Single Product Page
 */

if ( ! class_exists( 'WooCommerce' ) ){
    return;
}
$th_shop_mania_woo_single_product = new Th_Shop_Mania_WP_Customize_Section( $wp_customize, 'th-shop-mania-woo-single-product', array(
    'title'    => __( 'Single Product', 'th-shop-mania' ),
     'panel'    => 'woocommerce',
     'priority' => 3,
));
$wp_customize->add_section($th_shop_mania_woo_single_product );

$wp_customize->add_setting( 'th_shop_mania_product_single_sidebar_disable', array(
                'default'               => false,
                'sanitize_callback'     => 'th_shop_mania_sanitize_checkbox',
            ) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'th_shop_mania_product_single_sidebar_disable', array(
                'label'                 => esc_html__('Force to disable sidebar in product page.', 'th-shop-mania'),
                'type'                  => 'checkbox',
                'section'               => 'th-shop-mania-woo-single-product',
                'settings'              => 'th_shop_mania_product_single_sidebar_disable',
 ) ) );