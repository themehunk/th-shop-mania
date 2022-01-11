<?php 
/**
 * Common Function for Th Shop ManiaTheme.
 *
 * @package     Th Shop Mania
 * @author      ThemeHunk
 * @copyright   Copyright (c) 2019, Th Shop Mania
 * @since       Th Shop Mania 1.0.0
 */
 if ( ! function_exists( 'th_shop_mania_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 * Does nothing if the custom logo is not available.
 */
function th_shop_mania_custom_logo(){
    if ( function_exists( 'the_custom_logo' ) ){?>
    	<div class="thunk-logo">
        <?php the_custom_logo();?>
        </div>
   <?php  }
}
endif;
/*********************/
// Menu 
/*********************/
function th_shop_mania_header_menu_style(){
 $th_shop_mania_main_header_layout = get_theme_mod('th_shop_mania_main_header_layout');
        	$menustyle='horizontal';	
        	return $menustyle;
		}
function th_shop_mania_add_classes_to_page_menu( $ulclass ){
  return preg_replace( '/<ul>/', '<ul class="th-shop-mania-menu" data-menu-style='.esc_attr(th_shop_mania_header_menu_style()).'>', $ulclass, 1 );
}
add_filter( 'wp_page_menu', 'th_shop_mania_add_classes_to_page_menu' );		
     // This theme uses wp_nav_menu() in two locations.
	  function th_shop_mania_custom_menu(){
		     register_nav_menus(array(
		    'th-shop-mania-above-menu'       => esc_html__( 'Header Above Menu', 'th-shop-mania' ),
			'th-shop-mania-main-menu'        => esc_html__( 'Main', 'th-shop-mania' ),
			'th-shop-mania-sticky-menu'        => esc_html__( 'Sticky', 'th-shop-mania' ),
			'th-shop-mania-footer-menu'  => esc_html__( 'Footer Menu', 'th-shop-mania' ),
		) );
	  }
	  add_action( 'after_setup_theme', 'th_shop_mania_custom_menu' );
	  // MAIN MENU
           function th_shop_mania_main_nav_menu(){
              wp_nav_menu( array(
              'theme_location' => 'th-shop-mania-main-menu', 
              'container'      => false, 
              'link_before'    =>'<span class="th-shop-mania-menu-link">',
              'link_after'     => '</span>',
              'items_wrap'     => '<ul id="th-shop-mania-menu" class="th-shop-mania-menu" data-menu-style='.esc_attr(th_shop_mania_header_menu_style()).'>%3$s</ul>',
             ));
         }
          //STICKY MENU
           function th_shop_mania_stick_nav_menu(){
              wp_nav_menu( array(
              'theme_location' => 'th-shop-mania-sticky-menu', 
              'container'      => false, 
              'link_before'    =>'<span class="th-shop-mania-menu-link">',
              'link_after'     => '</span>',
              'items_wrap'     => '<ul id="th-shop-mania-stick-menu" class="th-shop-mania-menu" data-menu-style='.esc_attr(th_shop_mania_header_menu_style()).'>%3$s</ul>',
             ));
         }
         // HEADER ABOVE MENU
         function th_shop_mania_abv_nav_menu(){
              wp_nav_menu( array('theme_location' => 'th-shop-mania-above-menu', 
              'container'   => false, 
              'link_before' => '<span class="th-shop-mania-menu-link">',
              'link_after'  => '</span>',
              'items_wrap'  => '<ul id="open-above-menu" class="th-shop-mania-menu" data-menu-style='.esc_attr(th_shop_mania_header_menu_style()).'>%3$s</ul>',
             ));
         }
         // FOOTER TOP MENU
         function th_shop_mania_footer_nav_menu(){
              wp_nav_menu( array('theme_location' => 'th-shop-mania-footer-menu', 
              'container'   => false, 
              'link_before' => '<span class="th-shop-mania-menu-link">',
              'link_after'  => '</span>',
              'items_wrap'  => '<ul id="open-footer-menu" class="open-bottom-menu">%3$s</ul>',
             ));
         }
function th_shop_mania_add_classes_to_page_menu_default( $ulclass ){
return preg_replace( '/<ul>/', '<ul class="th-shop-mania-menu" data-menu-style="horizontal">', $ulclass, 1 );
}
add_filter( 'wp_page_menu', 'th_shop_mania_add_classes_to_page_menu_default' );
/************************/
// description Menu
/************************/
function th_shop_mania_nav_description( $item_output, $item, $depth, $args ){
    if ( !empty( $item->description ) ) {
        $item_output = str_replace( $args->link_after . '</a>', '<p class="menu-item-description">' . esc_html($item->description) . '</p>' . $args->link_after . '</a>', $item_output );
    }
 
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'th_shop_mania_nav_description', 10, 4 );

/*********************/
/**
 * Function to check if it is Internet Explorer
 */
if ( ! function_exists( 'th_shop_mania_check_is_ie' ) ) :
	/**
	 * Function to check if it is Internet Explorer.
	 *
	 * @return true | false boolean
	 */
	function th_shop_mania_check_is_ie() {

		$is_ie = false;

		$ua = htmlentities( $_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8' );
		if ( strpos( $ua, 'Trident/7.0' ) !== false ) {
			$is_ie = true;
		}

		return apply_filters( 'th_shop_mania_check_is_ie', $is_ie );
	}

endif;
/**
 * ratia image
 */
if ( ! function_exists( 'th_shop_mania_replace_header_attr' ) ) :
	/**
	 * Replace header logo.
	 *
	 * @param array  $attr Image.
	 * @param object $attachment Image obj.
	 * @param sting  $size Size name.
	 *
	 * @return array Image attr.
	 */
	function th_shop_mania_replace_header_attr( $attr, $attachment, $size ){
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( $custom_logo_id == $attachment->ID ){
			$attach_data = array();
			if ( ! is_customize_preview() ){
				$attach_data = wp_get_attachment_image_src( $attachment->ID, 'open-logo-size' );


				if ( isset( $attach_data[0] ) ) {
					$attr['src'] = $attach_data[0];
				}
			}

			$file_type      = wp_check_filetype( $attr['src'] );
			$file_extension = $file_type['ext'];
			if ( 'svg' == $file_extension ) {
				$attr['class'] = 'open-logo-svg';
			}
			$retina_logo = get_theme_mod( 'th_shop_mania_header_retina_logo' );
			$attr['srcset'] = '';
			if ( apply_filters( 'open_main_header_retina', true ) && '' !== $retina_logo ) {
				$cutom_logo     = wp_get_attachment_image_src( $custom_logo_id, 'full' );
				$cutom_logo_url = $cutom_logo[0];

				if (th_shop_mania_check_is_ie() ){
					// Replace header logo url to retina logo url.
					$attr['src'] = $retina_logo;
				}

				$attr['srcset'] = $cutom_logo_url . ' 1x, ' . $retina_logo . ' 2x';

			}
		}

		return apply_filters( 'th_shop_mania_replace_header_attr', $attr );
	}

endif;

add_filter( 'wp_get_attachment_image_attributes', 'th_shop_mania_replace_header_attr', 10, 3 );
 
// Mobile Menu Wrapper Add.
function th_shop_mania_mobile_menu_wrap(){
echo '<div class="th-shop-mania-mobile-menu-wrapper"></div>';
}
add_action( 'wp_footer', 'th_shop_mania_mobile_menu_wrap' );



/*************************/
//Get Page Title
/*************************/
function th_shop_mania_get_page_title(){ ?>
			<?php if(is_search()){ ?> 
            <h2 class="thunk-page-top-title entry-title">
              	<?php printf( __( 'Search Results for: %s', 'th-shop-mania' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h2>

			<?php }elseif (th_shop_mania_is_blog() && !is_single() && !is_archive()){
				if( !(is_front_page()) ){
                    $our_title = get_the_title( get_option('page_for_posts', true) );
			echo '<h1 class="thunk-page-top-title entry-title">'.esc_html($our_title).'</h1>'; ?>
			<?php }else{
			echo'<h1 class="thunk-page-top-title entry-title">'.esc_html__('Blog','th-shop-mania').'</h1>'; ?>
			<?php }	 
			 }elseif(is_archive() && (class_exists( 'WooCommerce' ) && !is_shop())){
                   echo the_archive_title('<h1 class="thunk-page-top-title entry-title">','</h1>'); ?>
			<?php }elseif(class_exists( 'WooCommerce' ) && is_shop()) { ?>
				<h1 class="thunk-page-top-title entry-title"><?php woocommerce_page_title(); ?></h1> 
			<?php }elseif(is_page()) { 
				echo the_title('<h1 class="thunk-page-top-title entry-title">','</h1>'); ?>
			<?php } ?>
   <?php 
}

/**************************/
// Dynamic Social Link
/**************************/
function th_shop_mania_social_links(){
$social='';
$original_color = get_theme_mod('th_shop_mania_social_original_color',false);
if($original_color==true){
$class_original='original-social-icon';
}else{
$class_original='';	
}
$social.='<ul class="social-icon ' .esc_attr($class_original). ' ">';
if($f_link = get_theme_mod('social_shop_link_facebook','#')) :
	$social.='<li><a target="_blank" href="'.esc_url($f_link).'"><i class="fa fa-facebook"></i></a></li>';
endif;
if($l_link = get_theme_mod('social_shop_link_linkedin','#')) :
	$social.='<li><a target="_blank" href="'.esc_url($l_link).'"><i class="fa fa-linkedin"></i></a></li>';
endif;
if($p_link = get_theme_mod('social_shop_link_pintrest','#')) :
	$social.='<li><a target="_blank" href="'.esc_url($p_link).'"><i class="fa fa-pinterest"></i></a></li>';
endif;
if($t_link = get_theme_mod('social_shop_link_twitter','#')) :
	$social.='<li><a target="_blank" href="'.esc_url($t_link).'"><i class="fa fa-twitter"></i></a></li>';
endif;
if($insta_link = get_theme_mod('social_shop_link_insta','#')) :
	$social.='<li><a target="_blank" href="'.esc_url($insta_link).'"><i class="fa fa-instagram"></i></a></li>';
endif;
if($tum_link = get_theme_mod('social_shop_link_tumblr','#')) :
	$social.='<li><a target="_blank" href="'.esc_url($tum_link).'"><i class="fa fa-tumblr"></i></a></li>';
endif;
if($y_link = get_theme_mod('social_shop_link_youtube','#')) :
	$social.='<li><a target="_blank" href="'.esc_url($y_link).'"><i class="fa fa-youtube-play"></i></a></li>';
endif;
if($stumb_link = get_theme_mod('social_shop_link_stumbleupon','#')):
	$social.='<li><a target="_blank" href="'.esc_url($stumb_link).'">
	 <i class="fa fa-stumbleupon"></i></a></li>';
endif;
if($dribble_link = get_theme_mod('social_shop_link_dribble','#')):
	$social.='<li><a target="_blank" href="'.esc_url($dribble_link).'">
	 <i class="fa fa-dribbble"></i></a></li>';
endif;
if($skype_link = get_theme_mod('social_shop_link_skype','#')):
	$social.='<li><a target="_blank" href="'.esc_url($skype_link).'">
	 <i class="fa fa-skype"></i></a></li>';
endif;
$social.='</ul>';
return $social;
}

/*****************************/
//add class active
function th_shop_mania_body_classes( $classes ){
if(class_exists( 'WooCommerce' )):
$classes[] = 'woocommerce';
endif;     
return $classes;
}
add_filter( 'body_class', 'th_shop_mania_body_classes' );

// default size in upload image
function th_shop_mania_attachment_display_settings() {
    update_option( 'image_default_size', 'large' );
}
add_action( 'after_setup_theme', 'th_shop_mania_attachment_display_settings' );