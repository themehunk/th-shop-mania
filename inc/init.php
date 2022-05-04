<?php 
/**
 * all file includeed
 *
 * @param  
 * @return mixed|string
 */
get_template_part( 'inc/admin-function');
get_template_part( 'inc/header-function');
get_template_part( 'inc/footer-function');
get_template_part( 'inc/blog-function');
//breadcrumbs
get_template_part( 'lib/breadcrumbs/breadcrumbs');
//page-post-meta
get_template_part( 'lib/page-meta-box/page-meta-box');
//custom-style
get_template_part( 'inc/th-shop-mania-custom-style');
/******************************/
// woocommerce
/******************************/
get_template_part( 'inc/woocommerce/woo-core');
get_template_part( 'inc/woocommerce/woo-function');
 //theme-option
get_template_part( 'lib/th-option/th-option');
//CHILD THEME 
// get_template_part( 'lib/th-option/child-notify');
get_template_part( 'lib/welcome-bar/welcome-bar');
//customizer
if (is_customize_preview()) {
get_template_part('customizer/extend-customizer/class-th-shop-mania-wp-customize-panel');
get_template_part('customizer/extend-customizer/class-th-shop-mania-wp-customize-section');
get_template_part('customizer/customizer-radio-image/class/class-th-shop-mania-customize-control-radio-image');
get_template_part('customizer/customizer-range-value/class/class-th-shop-mania-customizer-range-value-control');
get_template_part('customizer/customizer-toggle/class-th-shop-mania-toggle-control');
get_template_part('customizer/pro-button/class-customize');
get_template_part('customizer/custom-customizer');
get_template_part('customizer/customizer');
}
