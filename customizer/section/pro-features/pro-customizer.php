<?php 
$wp_customize->add_panel( 'th-shop-mania-panel-layout', array(
                'priority' => 4,
                'title'    => __( 'Layout', 'th-shop-mania-pro' ),
) );

$th_shop_mania_above_header = new Th_Shop_Mania_WP_Customize_Section( $wp_customize, 'th-shop-mania-above-header', array(
    'title'    => __( 'Above Header', 'th-shop-mania-pro' ),
    'panel'    => 'th-shop-mania-panel-layout',
    'section'  => 'th-shop-mania-section-header-group',
    'priority' => 6,
  ));
$wp_customize->add_section($th_shop_mania_above_header);
// Main-header
$th_shop_mania_main_header = new Th_Shop_Mania_WP_Customize_Section( $wp_customize, 'th-shop-mania-main-header', array(
    'title'    => __( 'Main Header', 'th-shop-mania-pro' ),
    'panel'    => 'th-shop-mania-panel-layout',
    'section'  => 'th-shop-mania-section-header-group',
    'priority' => 6,
  ));
$wp_customize->add_section($th_shop_mania_main_header);
// Below-header
$th_shop_mania_below_header = new Th_Shop_Mania_WP_Customize_Section( $wp_customize, 'th-shop-mania-below-header', array(
    'title'    => __( 'Below Header', 'th-shop-mania-pro' ),
    'panel'    => 'th-shop-mania-panel-layout',
    'section'  => 'th-shop-mania-section-header-group',
    'priority' => 6,
  ));
$wp_customize->add_section($th_shop_mania_below_header);

// transparent-header
$th_shop_mania_transparent_header = new Th_Shop_Mania_WP_Customize_Section( $wp_customize, 'th-shop-mania-transparent-header', array(
    'title'    => __( 'Transparent Header', 'th-shop-mania-pro' ),
    'panel'    => 'th-shop-mania-panel-layout',
    'section'  => 'th-shop-mania-section-header-group',
    'priority' => 6,
  ));
$wp_customize->add_section($th_shop_mania_transparent_header);

// page-header
$th_shop_mania_page_header = new Th_Shop_Mania_WP_Customize_Section( $wp_customize, 'th-shop-mania-page-header', array(
    'title'    => __( 'Page Header', 'th-shop-mania-pro' ),
    'panel'    => 'th-shop-mania-panel-layout',
    'section'  => 'th-shop-mania-section-header-group',
    'priority' => 6,
  ));
$wp_customize->add_section($th_shop_mania_page_header);

if(class_exists('th_shop_mania_WP_Customize_Control_Radio_Image')){
        $wp_customize->add_setting(
            'th_shop_mania_pro_main_header_layout', array(
                'default'           => 'mhdrone',
                'sanitize_callback' => 'th_shop_mania_sanitize_radio',
            )
        );
$wp_customize->add_control(
            new th_shop_mania_WP_Customize_Control_Radio_Image(
                $wp_customize, 'th_shop_mania_pro_main_header_layout', array(
                    'label'    => esc_html__( 'Header Layout', 'th-shop-mania-pro' ),
                    'section'  => 'th-shop-mania-main-header',
                    'choices'  => array(
                        
                        'mhdrone' => array(
                            'url' => TH_SHOP_MANIA_MAIN_HEADER_LAYOUT_ONE,
                        ),
                        'mhdrtwo' => array(
                            'url' => TH_SHOP_MANIA_MAIN_HEADER_LAYOUT_TWO,
                        ),
                        'mhdrthree' => array(
                            'url' => TH_SHOP_MANIA_MAIN_HEADER_LAYOUT_THREE,
                        ),
                        
                        'mhdrfour' => array(
                            'url' => TH_SHOP_MANIA_MAIN_HEADER_LAYOUT_FOUR,
                        ),
                        'mhdrfive' => array(
                            'url' => TH_SHOP_MANIA_MAIN_HEADER_LAYOUT_FIVE,
                        ),
                        'mhdrsix' => array(
                            'url' => TH_SHOP_MANIA_MAIN_HEADER_LAYOUT_SIX,
                        ),  
                        'mhdrseven' => array(
                            'url' => TH_SHOP_MANIA_MAIN_HEADER_LAYOUT_SEVEN,
                        ),                                   
                    ),
                )
            )
        );
} 

//Main menu option
$wp_customize->add_setting('th_shop_mania_main_header_option', array(
        'default'        => 'none',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_select',
    ));
$wp_customize->add_control( 'th_shop_mania_main_header_option', array(
        'settings' => 'th_shop_mania_main_header_option',
        'label'    => __('Header Options','th-shop-mania-pro'),
        'section'  => 'th-shop-mania-main-header',
        'type'     => 'select',
        'choices'    => array(
        'none'       => __('None','th-shop-mania-pro'),
        'button'     => __('Button','th-shop-mania-pro'),
        'callto'     => __('Call-To','th-shop-mania-pro'),
        'widget'     => __('Widget','th-shop-mania-pro'),  
        'social'     => __('Social Media','th-shop-mania-pro'),   
        ),
    ));

//**************/
// BUTTON TEXT //
//**************/
$wp_customize->add_setting('th_shop_mania_main_hdr_btn_txt', array(
        'default' => __('Button Text','th-shop-mania-pro'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_text',
        'transport'         => 'postMessage',
));
$wp_customize->add_control( 'th_shop_mania_main_hdr_btn_txt', array(
        'label'    => __('Button Text', 'th-shop-mania-pro'),
        'section'  => 'th-shop-mania-main-header',
         'type'    => 'text',
));

$wp_customize->add_setting('th_shop_mania_main_hdr_btn_lnk', array(
        'default' => __('#','th-shop-mania-pro'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_text',
        
));
$wp_customize->add_control( 'th_shop_mania_main_hdr_btn_lnk', array(
        'label'    => __('Button Link', 'th-shop-mania-pro'),
        'section'  => 'th-shop-mania-main-header',
         'type'    => 'text',
));

if ( class_exists( 'th_shop_mania_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'th_shop_mania_main_hdr_btn_bdr_radius', array(
                'sanitize_callback' => 'th_shop_mania_sanitize_range_value',
                'default'           => '5',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new th_shop_mania_WP_Customizer_Range_Value_Control(
                $wp_customize, 'th_shop_mania_main_hdr_btn_bdr_radius', array(
                    'label'       => esc_html__( 'Button Border Radius', 'th-shop-mania-pro' ),
                    'section'     => 'th-shop-mania-main-header',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 90,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
);
}
/*****************/
// Call-to
/*****************/
$wp_customize->add_setting('th_shop_mania_main_hdr_calto_txt', array(
        'default' => __('Call To','th-shop-mania-pro'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_text',
        'transport'         => 'postMessage',
));
$wp_customize->add_control( 'th_shop_mania_main_hdr_calto_txt', array(
        'label'    => __('Call To Text', 'th-shop-mania-pro'),
        'section'  => 'th-shop-mania-main-header',
         'type'    => 'text',
));

$wp_customize->add_setting('th_shop_mania_main_hdr_calto_nub', array(
        'default' => __('+1800090098','th-shop-mania-pro'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_text',
        'transport'         => 'postMessage',
));
$wp_customize->add_control( 'th_shop_mania_main_hdr_calto_nub', array(
        'label'    => __('Call To Number', 'th-shop-mania-pro'),
        'section'  => 'th-shop-mania-main-header',
         'type'    => 'text',
));

// col1 widget redirection
if (class_exists('th_shop_mania_Widegt_Redirect')){ 
$wp_customize->add_setting(
            'th_shop_mania_main_header_widget_redirect', array(
            'sanitize_callback' => 'sanitize_text_field',
     )
);
$wp_customize->add_control(
            new th_shop_mania_Widegt_Redirect(
                $wp_customize, 'th_shop_mania_main_header_widget_redirect', array(
                    'section'      => 'th-shop-mania-main-header',
                    'button_text'  => esc_html__( 'Go To Widget', 'th-shop-mania-pro' ),
                    'button_class' => 'focus-customizer-widget-redirect',  
                )
            )
        );
}

if (class_exists('th_shop_mania_Widegt_Redirect')){ 
$wp_customize->add_setting(
            'th_shop_mania_main_header_social_media_redirect', array(
            'sanitize_callback' => 'sanitize_text_field',
     )
);
$wp_customize->add_control(
            new th_shop_mania_Widegt_Redirect(
                $wp_customize, 'th_shop_mania_main_header_social_media_redirect', array(
                    'section'      => 'th-shop-mania-main-header',
                    'button_text'  => esc_html__( 'Go To Social Media', 'th-shop-mania-pro' ),
                    'button_class' => 'focus-customizer-social_media-redirect-col1',  
                )
            )
        );
}
    if (class_exists('th_shop_mania_Toggle_Control')) {
 $wp_customize->add_setting( 'th_shop_mania_main_header_shadow', array(
    'default'           => false,
    'sanitize_callback' => 'th_shop_mania_sanitize_checkbox',
  ) );
  $wp_customize->add_control( new th_shop_mania_Toggle_Control( $wp_customize, 'th_shop_mania_main_header_shadow', array(
    'label'       => esc_html__( 'Enable Header Shadow', 'th-shop-mania-pro' ),
    'section'     => 'th-shop-mania-main-header',
    'type'        => 'toggle',
    'settings'    => 'th_shop_mania_main_header_shadow',
  ) ) );

}
$wp_customize->add_setting('th_shop_mania_canvas_alignment', array(
        'default'        => 'cnv-none',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_select',
    ));
$wp_customize->add_control( 'th_shop_mania_canvas_alignment', array(
        'settings' => 'th_shop_mania_canvas_alignment',
        'label'    => __('Off Canvas Sidebar','th-shop-mania-pro'),
        'section'  => 'th-shop-mania-main-header',
        'type'     => 'select',
        'choices'    => array(
        'cnv-none'      => __('None','th-shop-mania-pro'),
        'bfr-logo'      => __('Before logo','th-shop-mania-pro'),
        'aftr-logo'     => __('After logo','th-shop-mania-pro'),
        ),
    ));
// exclude header category
function th_shop_mania_get_category_id($arr='',$all=true){
    $cats = array();
    foreach ( get_categories($arr) as $categories => $category ){
       
        $cats[$category->term_id] = $category->name;
     }
     return $cats;
  }

  if (class_exists('th_shop_mania_Toggle_Control')) {
 $wp_customize->add_setting( 'th_shop_mania_category_enable', array(
    'default'           => true,
    'sanitize_callback' => 'th_shop_mania_sanitize_checkbox',
  ) );
  $wp_customize->add_control( new th_shop_mania_Toggle_Control( $wp_customize, 'th_shop_mania_category_enable', array(
    'label'       => esc_html__( 'Enable Category Display', 'th-shop-mania-pro' ),
    'section'     => 'th-shop-mania-main-header',
    'type'        => 'toggle',
    'settings'    => 'th_shop_mania_category_enable',
  ) ) );
  
}

//  Move To Top
if ( class_exists( 'th_shop_mania_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'th_shop_mania_category_bdr_radius', array(
                'sanitize_callback' => 'th_shop_mania_sanitize_range_value',
                'default'           => '15',
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new th_shop_mania_WP_Customizer_Range_Value_Control(
                $wp_customize, 'th_shop_mania_category_bdr_radius', array(
                    'label'       => esc_html__( 'Category Border Radius', 'th-shop-mania-pro' ),
                    'section'     => 'th-shop-mania-main-header',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 90,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
);
}

$wp_customize->add_setting('th_shop_mania_main_hdr_cat_txt', array(
        'default' => __('All Categories','th-shop-mania-pro'),
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_text',
        'transport'         => 'postMessage',
));
$wp_customize->add_control( 'th_shop_mania_main_hdr_cat_txt', array(
        'label'    => __('Category Text', 'th-shop-mania-pro'),
        'section'  => 'th-shop-mania-main-header',
         'type'    => 'text',
));

 if (class_exists( 'th_shop_mania_Customize_Control_Checkbox_Multiple')) {
   $wp_customize->add_setting('th_shop_mania_exclde_category', array(
        'default'           => '',
        'sanitize_callback' => 'th_shop_mania_checkbox_explode'
    ));
    $wp_customize->add_control(new th_shop_mania_Customize_Control_Checkbox_Multiple(
            $wp_customize,'th_shop_mania_exclde_category', array(
        'settings'=> 'th_shop_mania_exclde_category',
        'label'   => __( 'Choose Categories To Exclude', 'th-shop-mania-pro' ),
        'section' => 'th-shop-mania-main-header',
        'choices' => th_shop_mania_get_category_id(array('taxonomy' =>'product_cat'),true),
        ) 
    ));

}

/***********************************/  
// menu alignment
/***********************************/ 
$wp_customize->add_setting('th_shop_mania_menu_alignment', array(
                'default'               => 'center',
                'sanitize_callback'     => 'th_shop_mania_sanitize_select',
            ) );
$wp_customize->add_control( new th_shop_mania_Customizer_Buttonset_Control( $wp_customize, 'th_shop_mania_menu_alignment', array(
                'label'                 => esc_html__( 'Menu Alignment', 'th-shop-mania-pro' ),
                'section'               => 'th-shop-mania-main-header',
                'settings'              => 'th_shop_mania_menu_alignment',
                'choices'               => array(
                    'left'              => esc_html__( 'Left', 'th-shop-mania-pro' ),
                    'center'            => esc_html__( 'center', 'th-shop-mania-pro' ),
                    'right'             => esc_html__( 'Right', 'th-shop-mania-pro' ),
                ),
        ) ) );
/***********************************/  
// menu alignment
/***********************************/ 
$wp_customize->add_setting('th_shop_mania_mobile_menu_open', array(
                'default'               => 'left',
                'sanitize_callback'     => 'th_shop_mania_sanitize_select',
            ) );
$wp_customize->add_control( new th_shop_mania_Customizer_Buttonset_Control( $wp_customize, 'th_shop_mania_mobile_menu_open', array(
                'label'                 => esc_html__( 'Mobile Menu', 'th-shop-mania-pro' ),
                'section'               => 'th-shop-mania-main-header',
                'settings'              => 'th_shop_mania_mobile_menu_open',
                'choices'               => array(
                    'left'              => esc_html__( 'Left', 'th-shop-mania-pro' ),
                    // 'overcenter'        => esc_html__( 'center', 'th-shop-mania-pro' ),
                    'right'             => esc_html__( 'Right', 'th-shop-mania-pro' ),
                ),
        ) ) );

//Link Effect
$wp_customize->add_setting('th_shop_mania_pro_menu_effect', array(
        'default'        => 'linkeffect-none',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_attr',
    ));
$wp_customize->add_control('th_shop_mania_pro_menu_effect', array(
        'settings' => 'th_shop_mania_pro_menu_effect',
        'label'    => __('Link Effect (Menu Links)','th-shop-mania-pro'),
        'section'  => 'th-shop-mania-main-header',
        'type'     => 'select',
        'choices'      => array(
        'linkeffect-none'         => __('No Effect','th-shop-mania-pro'),
        'linkeffect-1' => __('Brackets','th-shop-mania-pro'),
        'linkeffect-2' => __('Triple Dots Under','th-shop-mania-pro'),
        'linkeffect-3' => __('Underline Up','th-shop-mania-pro'),
        'linkeffect-4' => __('Underline & Overline','th-shop-mania-pro'),
        'linkeffect-5' => __('Underline From Left','th-shop-mania-pro'),
        'linkeffect-6' => __('Flip Line','th-shop-mania-pro'),
        'linkeffect-7' => __('Corner Style','th-shop-mania-pro'),
        'linkeffect-8' => __('Left Right Underline & Overline','th-shop-mania-pro')
        ),

    ));

// Link Effect Color
 $wp_customize->add_setting('th_shop_mania_pro_menu_link_effect_clr', array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_color'
    ));
$wp_customize->add_control( 
    new Th_Shop_Mania_Customizer_Color_Control($wp_customize,'th_shop_mania_pro_menu_link_effect_clr', array(
        'label'      => __('Link Effect Color', 'th-shop-mania-pro' ),
        'section'    => 'th-shop-mania-main-header',
        'settings'   => 'th_shop_mania_pro_menu_link_effect_clr',
    ) ) 
 ); 
/***********************************/  
// Sticky Header
/***********************************/ 
  $wp_customize->add_setting( 'th_shop_mania_sticky_header', array(
    'default'           => false,
    'sanitize_callback' => 'th_shop_mania_sanitize_checkbox',
  ) );
  $wp_customize->add_control( new th_shop_mania_Toggle_Control( $wp_customize, 'th_shop_mania_sticky_header', array(
    'label'       => esc_html__( 'Sticky Header Pro', 'th-shop-mania-pro' ),
    'section'     => 'th-shop-mania-main-header',
    'type'        => 'toggle',
    'settings'    => 'th_shop_mania_sticky_header',
  ) ) );

  $wp_customize->add_setting('th_shop_mania_sticky_header_effect', array(
        'default'        => 'scrldwmn',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'th_shop_mania_sanitize_select',
    ));
$wp_customize->add_control( 'th_shop_mania_sticky_header_effect', array(
        'settings' => 'th_shop_mania_sticky_header_effect',
        'label'    => __('Sticky Header Effect','th-shop-mania-pro'),
        'section'  => 'th-shop-mania-main-header',
        'type'     => 'select',
        'choices'    => array(
        'scrltop'     => __('Effect One','th-shop-mania-pro'),
        'scrldwmn'    => __('Effect Two','th-shop-mania-pro'),
        
        ),
    ));

if ( class_exists( 'th_shop_mania_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'th_shop_mania_main_hdr_padding_top', array(
                'sanitize_callback' => 'th_shop_mania_sanitize_range_value',
                'default'           => 0,
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new th_shop_mania_WP_Customizer_Range_Value_Control(
                $wp_customize, 'th_shop_mania_main_hdr_padding_top', array(
                    'label'       => esc_html__( 'Top Padding', 'th-shop-mania-pro' ),
                    'section'     => 'th-shop-mania-main-header',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
);
}
if ( class_exists( 'th_shop_mania_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'th_shop_mania_main_hdr_padding_bottom', array(
                'sanitize_callback' => 'th_shop_mania_sanitize_range_value',
                'default'           => 0,
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new th_shop_mania_WP_Customizer_Range_Value_Control(
                $wp_customize, 'th_shop_mania_main_hdr_padding_bottom', array(
                    'label'       => esc_html__( 'Bottom Padding', 'th-shop-mania-pro' ),
                    'section'     => 'th-shop-mania-main-header',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
);
}
/************************/
//Header Transparent
/************************/
$wp_customize->add_setting( 'th_shop_mania_header_transparent', array(
                'default'               => false,
                'sanitize_callback'     => 'th_shop_mania_sanitize_checkbox',
            ) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'th_shop_mania_header_transparent', array(
                'label'                 => esc_html__('Header Transparent', 'th-shop-mania-pro'),
                'type'                  => 'checkbox',
                'section'               => 'th-shop-mania-transparent-header',
                'settings'              => 'th_shop_mania_header_transparent',
            ) ) );

// force disable on special page 
$wp_customize->add_setting( 'th_shop_mania_header_transparent_special_page_disable', array(
                'default'               => false,
                'sanitize_callback'     => 'th_shop_mania_sanitize_checkbox',
            ) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'th_shop_mania_header_transparent_special_page_disable', array(
                'label'                 => esc_html__('Disable transparent header for inner pages', 'th-shop-mania-pro'),
                'description'           => esc_html__('(like archive,404,search etc.)', 'th-shop-mania-pro'),
                'type'                  => 'checkbox',
                'section'               => 'th-shop-mania-transparent-header',
                'settings'              => 'th_shop_mania_header_transparent_special_page_disable',
            ) ) );

//Page Header
if (class_exists('th_shop_mania_Toggle_Control')) {
 $wp_customize->add_setting( 'th_shop_mania_page_header_enable', array(
    'default'           => false,
    'sanitize_callback' => 'th_shop_mania_sanitize_checkbox',
  ) );
  $wp_customize->add_control( new th_shop_mania_Toggle_Control( $wp_customize, 'th_shop_mania_page_header_enable', array(
    'label'       => esc_html__( 'Enable Page Header', 'th-shop-mania-pro' ),
    'section'     => 'th-shop-mania-page-header',
    'type'        => 'toggle',
    'settings'    => 'th_shop_mania_page_header_enable',
    'priority'    => 2,
  ) ) );
  
}

if ( class_exists( 'th_shop_mania_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'th_shop_mania_page_header_hgt', array(
                'sanitize_callback' => 'th_shop_mania_sanitize_range_value',
                'default'           => 400,
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new th_shop_mania_WP_Customizer_Range_Value_Control(
                $wp_customize, 'th_shop_mania_page_header_hgt', array(
                    'label'       => esc_html__( 'Height', 'th-shop-mania-pro' ),
                    'section'     => 'th-shop-mania-page-header',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 30,
                        'max'  => 1000,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
);
}




//  Above Header Padding Options
if ( class_exists( 'th_shop_mania_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'th_shop_mania_above_hdr_padding_top', array(
                'sanitize_callback' => 'th_shop_mania_sanitize_range_value',
                'default'           => 0,
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new th_shop_mania_WP_Customizer_Range_Value_Control(
                $wp_customize, 'th_shop_mania_above_hdr_padding_top', array(
                    'label'       => esc_html__( 'Top Padding', 'th-shop-mania-pro' ),
                    'section'     => 'th-shop-mania-above-header',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
);
}
if ( class_exists( 'th_shop_mania_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'th_shop_mania_above_hdr_padding_bottom', array(
                'sanitize_callback' => 'th_shop_mania_sanitize_range_value',
                'default'           => 0,
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new th_shop_mania_WP_Customizer_Range_Value_Control(
                $wp_customize, 'th_shop_mania_above_hdr_padding_bottom', array(
                    'label'       => esc_html__( 'Bottom Padding', 'th-shop-mania-pro' ),
                    'section'     => 'th-shop-mania-above-header',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
);
}

$wp_customize->add_setting( 'th_shop_mania_above_header_disable', array(
                'default'               => false,
                'sanitize_callback'     => 'th_shop_mania_sanitize_checkbox',
            ) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'th_shop_mania_above_header_disable', array(
                'label'                 => esc_html__('Disable in Mobile View', 'th-shop-mania-pro'),
                'type'                  => 'checkbox',
                'section'               => 'th-shop-mania-above-header',
                'settings'              => 'th_shop_mania_above_header_disable',
            ) ) );

//  Below Header Padding Options
if ( class_exists( 'th_shop_mania_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'th_shop_mania_below_hdr_padding_top', array(
                'sanitize_callback' => 'th_shop_mania_sanitize_range_value',
                'default'           => 0,
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new th_shop_mania_WP_Customizer_Range_Value_Control(
                $wp_customize, 'th_shop_mania_below_hdr_padding_top', array(
                    'label'       => esc_html__( 'Top Padding', 'th-shop-mania-pro' ),
                    'section'     => 'th-shop-mania-below-header',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
);
}
if ( class_exists( 'th_shop_mania_WP_Customizer_Range_Value_Control' ) ){
$wp_customize->add_setting(
            'th_shop_mania_below_hdr_padding_bottom', array(
                'sanitize_callback' => 'th_shop_mania_sanitize_range_value',
                'default'           => 0,
                'transport'         => 'postMessage',
            )
        );
$wp_customize->add_control(
            new th_shop_mania_WP_Customizer_Range_Value_Control(
                $wp_customize, 'th_shop_mania_below_hdr_padding_bottom', array(
                    'label'       => esc_html__( 'Bottom Padding', 'th-shop-mania-pro' ),
                    'section'     => 'th-shop-mania-below-header',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1,
                    ),
                    'media_query' => true,
                    'sum_type'    => true,
                )
        )
);
}


if (class_exists('th_shop_mania_Toggle_Control')) {
 $wp_customize->add_setting( 'th_shop_mania_category_open_bydefault', array(
    'default'           => true,
    'sanitize_callback' => 'th_shop_mania_sanitize_checkbox',
  ) );
  $wp_customize->add_control( new th_shop_mania_Toggle_Control( $wp_customize, 'th_shop_mania_category_open_bydefault', array(
    'label'       => esc_html__( 'Homepage Category Vertical Display', 'th-shop-mania-pro' ),
    'section'     => 'th-shop-mania-main-header',
    'type'        => 'toggle',
    'settings'    => 'th_shop_mania_category_open_bydefault',
  ) ) );
  
}