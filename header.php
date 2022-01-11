<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Th Shop Mania
 * @since 1.0.0
 * 
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<?php
// page post meta
if ((is_single() || is_page()) || ((class_exists('WooCommerce')) && (is_woocommerce() || is_checkout() || is_cart() || is_account_page()))
) {
	if (class_exists('WooCommerce') && is_shop()) {
		$shop_page_id = get_option('woocommerce_shop_page_id');
		$postid = $shop_page_id;
	} else {
		$postid = $post->ID;
	}
	$th_shop_mania_transparent_header_dyn = get_post_meta($postid, 'th_shop_mania_transparent_header_dyn', true);
	$th_shop_mania_disable_main_header_dyn = get_post_meta($postid, 'th_shop_mania_disable_main_header_dyn', true);
	$th_shop_mania_disable_above_header_dyn = get_post_meta($postid, 'th_shop_mania_disable_above_header_dyn', true);
	$th_shop_mania_disable_bottom_header_dyn = get_post_meta($postid, 'th_shop_mania_disable_bottom_header_dyn', true);
	if (is_search() || is_404()) {
		$th_shop_mania_sticky_header_dyn = '';
	} else {
		$th_shop_mania_sticky_header_dyn = get_post_meta($postid, 'th_shop_mania_sticky_header_dyn', true);
	}
} else {
	$th_shop_mania_disable_above_header_dyn = '';
	$th_shop_mania_disable_main_header_dyn = '';
	$th_shop_mania_disable_bottom_header_dyn = '';
	$th_shop_mania_transparent_header_dyn = '';
	$th_shop_mania_sticky_header_dyn = '';
}
?>
<body <?php body_class();?>>

	<?php wp_body_open();?>

<div id="page" class="th-shop-mania-site">
	<header>
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'th-shop-mania' ); ?></a>
        <?php th_shop_mania_header_abv_post_meta($th_shop_mania_disable_above_header_dyn);
        	th_shop_mania_header_main_post_meta($th_shop_mania_disable_main_header_dyn);
			th_shop_mania_header_btm_post_meta($th_shop_mania_disable_bottom_header_dyn);
			do_action( 'th_shop_mania_sticky_header' );
        ?> 
		<!-- end below-header -->
	</header> <!-- end header -->
		