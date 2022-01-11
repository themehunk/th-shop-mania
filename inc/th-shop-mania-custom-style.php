<?php 
/**
 * Custom Style for Th Shop Mania Theme.
 * @package     Th Shop Mania
 * @author      ThemeHunk
 * @copyright   Copyright (c) 2021, Th Shop Mania
 * @since       Th Shop Mania 1.0.0
 */
function th_shop_mania_custom_style(){
$th_shop_mania_style=""; 
/*********************/
// Theme Color Option
/*********************/ 
$th_shop_mania_theme_clr = esc_html(get_theme_mod('th_shop_mania_theme_clr','#ff3377'));

$th_shop_mania_style.="a:hover,.thunk-icon-market a:hover,.th-shop-mania-menu li a:hover, .th-shop-mania-menu .current-menu-item a,.th-shop-mania-menu li ul.sub-menu li a:hover,.thunk-product .th-add-to-cart a,.thunk-product .th-add-to-cart a:hover{color:{$th_shop_mania_theme_clr};}
";

$th_shop_mania_style.="#move-to-top,article.thunk-post-article .thunk-readmore.button:hover, [type='submit']:hover,.nav-links .page-numbers.current, .nav-links .page-numbers:hover,.tagcloud a:hover, .thunk-tags-wrapper a:hover,#searchform [type='submit']:hover, .widget_product_search button[type='submit']:hover,.cart-contents .count-item,.woocommerce .return-to-shop a:hover,.woocommerce span.onsale,.woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,.single_add_to_cart_button.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit, .woocommerce button.button, .woocommerce input.button, .woocommerce div.product form.cart .button,.thunk-single-product-summary-wrap.single span.onsale,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.cat-icon,.menu-close-btn:hover:before, .menu-close-btn:hover:after, .cart-close-btn:hover:after, .cart-close-btn:hover:before{background:{$th_shop_mania_theme_clr};}
";
$th_shop_mania_style.="#searchform [type='submit']:hover, .widget_product_search button[type='submit']:hover,.thunk-product .th-add-to-cart a{border-color:{$th_shop_mania_theme_clr};}
";

return $th_shop_mania_style;
}