<?php 
/**
 * all customizer setting includeed
 *
 * @param  
 * @return mixed|string
 */
function th_shop_mania_customize_register( $wp_customize ){	
//site identity
require th_shop_mania_THEME_DIR . 'customizer/set-identity.php';
//Color Option
require th_shop_mania_THEME_DIR . 'customizer/section/color/global-color.php';

}
add_action('customize_register','th_shop_mania_customize_register');
