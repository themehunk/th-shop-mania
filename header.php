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
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url(get_bloginfo('pingback_url')); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<?php
// page post meta
global $post;
?>
<body <?php body_class();?>>

	<?php wp_body_open();
	if (function_exists( 'th_shop_mania_pro_load_plugin' ) ){  
		do_action('th_shop_mania_pro_site_preloader');
	}
	else{
		do_action('th_shop_mania_site_preloader');
	}
	?>

<div id="page" class="th-shop-mania-site">
	<?php do_action( 'th_shop_mania_before_header' ); ?>
	<?php do_action( 'th_shop_mania_header' ); ?>
	<?php do_action( 'th_shop_mania_after_header' ); ?>
	<?php 
	//Page Header 
		$id = (isset($post->ID)) ? $post->ID : '';
		if (has_action('th_shop_mania_page_header_markup')) {

		do_action( 'th_shop_mania_page_header_markup', $id );
	}