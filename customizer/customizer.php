<?php 
/**
 * all customizer setting includeed
 *
 * @param  
 * @return mixed|string
 */
function th_shop_mania_customize_register( $wp_customize ){
require TH_SHOP_MANIA_THEME_DIR . 'customizer/section/woo/single-product.php';	
//site identity
require TH_SHOP_MANIA_THEME_DIR . 'customizer/set-identity.php';
//Color Option
require TH_SHOP_MANIA_THEME_DIR . 'customizer/section/color/global-color.php';
}
add_action('customize_register','th_shop_mania_customize_register');
// function th_shop_mania_is_json( $string ){
//     return is_string( $string ) && is_array( json_decode( $string, true ) ) ? true : false;
// }