<?php
/**
 * Register customizer site identity setting.
 *
 * @package     Th Shop Mania
 * @author      Th Shop Mania
 * @copyright   Copyright (c) 2021, Th Shop Mania
 * @since       Th Shop Mania 1.0.0
 */
/*************************/
/*Site Identity*/
/*************************/
   $wp_customize->add_setting('title_disable', array(
        'default'           => 'enable',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_checkbox',
    ));
$wp_customize->add_control('title_disable', array(
        'label'    => __('Display Site Title', 'th-shop-mania'),
        'section'  => 'title_tagline',
        'settings' => 'title_disable',
         'type'       => 'checkbox',
        'choices'    => array(
            'enable' => 'Display Site Title',
        ),
    ));
$wp_customize->add_setting('tagline_disable', array(
        'default'           => 'enable',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_checkbox',
    ));
$wp_customize->add_control('tagline_disable', array(
        'label'    => __('Display Tagline', 'th-shop-mania'),
        'section'  => 'title_tagline',
        'settings' => 'tagline_disable',
         'type'       => 'checkbox',
        'choices'    => array(
            'enable' => 'Display Tagline',
        ),
    ));

$wp_customize->add_section('th-shop-mania-bottom-footer', array(
    'title'    => __('Footer Copyright', 'th-shop-mania'),
));

$wp_customize->add_setting('th_shop_mania_footer_bottom_col1_texthtml', array(
        'default'           => __('Copyright | Th Shop Mania | Developed by ThemeHunk','th-shop-mania'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_textarea',
        
    ));
$wp_customize->add_control('th_shop_mania_footer_bottom_col1_texthtml', array(
        'label'    => __('Text', 'th-shop-mania'),
        'section'  => 'th-shop-mania-bottom-footer',
        'settings' => 'th_shop_mania_footer_bottom_col1_texthtml',
         'type'    => 'textarea',
    ));