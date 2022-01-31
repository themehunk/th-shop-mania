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

$th_shop_mania_style.="a:hover,.thunk-icon-market a:hover,.th-shop-mania-menu li a:hover, .th-shop-mania-menu .current-menu-item a,.th-shop-mania-menu li ul.sub-menu li a:hover,.thunk-product .th-add-to-cart a,.thunk-product .th-add-to-cart a:hover,.woocommerce ul.products li.product .price ins,.thunk-product .thunk-compare a:hover,.woocommerce ul.cart_list li .woocommerce-Price-amount, .woocommerce ul.product_list_widget li .woocommerce-Price-amount,.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,.th-shop-mania-load-more button{color:{$th_shop_mania_theme_clr};}
";

$th_shop_mania_style.="#move-to-top,article.thunk-post-article .thunk-readmore.button:hover, [type='submit']:hover,.nav-links .page-numbers.current, .nav-links .page-numbers:hover,.tagcloud a:hover, .thunk-tags-wrapper a:hover,#searchform [type='submit']:hover, .widget_product_search button[type='submit']:hover,.cart-contents .count-item,.woocommerce .return-to-shop a:hover,.woocommerce span.onsale,.woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,.single_add_to_cart_button.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit, .woocommerce button.button, .woocommerce input.button, .woocommerce div.product form.cart .button,.thunk-single-product-summary-wrap.single span.onsale,.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,.menu-close-btn:hover:before, .menu-close-btn:hover:after, .cart-close-btn:hover:after, .cart-close-btn:hover:before,.cart-contents .cart-count-item,.woocommerce .woocommerce-error .button, .woocommerce .woocommerce-info .button, .woocommerce .woocommerce-message .button,.woocommerce .woocommerce-error .button:hover, .woocommerce .woocommerce-info .button:hover, .woocommerce .woocommerce-message .button:hover,.thunk-quik a.opn-quick-view-text,.cat-toggle,.th-shop-mania-load-more button:hover{background:{$th_shop_mania_theme_clr};}
";
$th_shop_mania_style.="#searchform [type='submit']:hover, .widget_product_search button[type='submit']:hover,.thunk-product .th-add-to-cart a,.th-shop-mania-pre-loader .th-loader,.th-shop-mania-load-more button{border-color:{$th_shop_mania_theme_clr};}";

$th_shop_mania_style.=".cart-contents:hover path{fill:{$th_shop_mania_theme_clr};}";

$th_shop_mania_style.=".loader{
	border-right-color:{$th_shop_mania_theme_clr};
	border-bottom-color:{$th_shop_mania_theme_clr};
	border-left-color:{$th_shop_mania_theme_clr};}";

return $th_shop_mania_style;
}