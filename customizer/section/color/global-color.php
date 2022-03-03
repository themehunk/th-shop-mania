<?php
/******************/
//Global Option
/******************/
$wp_customize->add_panel( 'th-shop-mania-panel-color-background', array(
        'priority' => 22,
        'title'    => __( 'Total Color & BG Options', 'th-shop-mania' ),
    ) );
// Section gloab color and background
$wp_customize->add_section('th-shop-mania-gloabal-color', array(
    'title'    => __('Global Colors', 'th-shop-mania'),
    'panel'    => 'th-shop-mania-panel-color-background',
    'priority' => 1,
));

// theme color
 $wp_customize->add_setting('th_shop_mania_theme_clr', array(
        'default'        => '#008000',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_color',
        'transport'         => 'postMessage',
    ));
$wp_customize->add_control( 
    new WP_Customize_Color_Control($wp_customize,'th_shop_mania_theme_clr', array(
        'label'      => __('Theme Color', 'th-shop-mania' ),
        'section'    => 'th-shop-mania-gloabal-color',
        'settings'   => 'th_shop_mania_theme_clr',
        'priority' => 1,
    ) ) 
 ); 

// gloabal background option
$wp_customize->get_control( 'background_color' )->section = 'th-shop-mania-gloabal-color';
$wp_customize->get_control( 'background_color' )->priority = 9;
$wp_customize->get_control( 'background_image' )->section = 'th-shop-mania-gloabal-color';
$wp_customize->get_control( 'background_image' )->priority = 10;
$wp_customize->get_control( 'background_preset' )->section = 'th-shop-mania-gloabal-color';
$wp_customize->get_control( 'background_preset' )->priority = 11;
$wp_customize->get_control( 'background_position' )->section = 'th-shop-mania-gloabal-color';
$wp_customize->get_control( 'background_position' )->priority = 11;
$wp_customize->get_control( 'background_repeat' )->section = 'th-shop-mania-gloabal-color';
$wp_customize->get_control( 'background_repeat' )->priority = 12;
$wp_customize->get_control( 'background_attachment' )->section = 'th-shop-mania-gloabal-color';
$wp_customize->get_control( 'background_attachment' )->priority = 13;
$wp_customize->get_control( 'background_size' )->section = 'th-shop-mania-gloabal-color';
$wp_customize->get_control( 'background_size' )->priority = 14;
