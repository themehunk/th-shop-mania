<?php 
/**
 * Header Function for Th Shop Mania theme.
 * 
 * @package     Th Shop Mania
 * @author      Th Shop Mania
 * @copyright   Copyright (c) 2021, Th Shop Mania
 * @since       Th Shop Mania 1.0.0
 */
/**************************************/
//Top Header function
/**************************************/
if (!function_exists('th_shop_mania_top_header_markup')) {

    /**
     * Returns top bar
     */
    add_action('th_shop_mania_top_header', 'th_shop_mania_top_header_markup');

    function th_shop_mania_top_header_markup() {
        if (is_active_sidebar('top-header-widget-col1')) {

           if ((! wp_is_mobile() ) || wp_is_mobile() && ( !get_theme_mod('th_shop_mania_above_header_disable',false ))) {
            ?>
            <div class="top-header">
                <?php 
                if (function_exists('th_shop_mania_display_color_customizer_shortcut')) {
                th_shop_mania_display_color_customizer_shortcut( 'th-shop-mania-abv-header-clr' );
                } ?>
              <div class="container">
                <div class="top-header-bar thnk-col-3">
            <?php dynamic_sidebar('top-header-widget-col1'); ?>
                </div>
              </div>
            </div>
            <?php }
        }
    }

}
/**************************************/
//Main Header function
/**************************************/
if ( ! function_exists( 'th_shop_mania_main_header_markup' ) ){	
function th_shop_mania_main_header_markup(){ 
$main_header_opt = get_theme_mod('th_shop_mania_main_header_option','none');
$th_shop_mania_menu_alignment = get_theme_mod('th_shop_mania_menu_alignment','center');
$th_shop_mania_menu_open = get_theme_mod('th_shop_mania_mobile_menu_open','left');
$offcanvas = get_theme_mod('th_shop_mania_canvas_alignment','cnv-none');
$th_shop_mania_pro_menu_effect = get_theme_mod('th_shop_mania_pro_menu_effect', 'linkeffect-none');
?>
<div class="main-header <?php echo esc_attr($main_header_opt);?> <?php echo esc_attr($th_shop_mania_menu_alignment).'-menu';?>  <?php echo esc_attr($offcanvas);?> <?php echo esc_attr($th_shop_mania_pro_menu_effect); ?>">
			<div class="container">
        <div class="desktop-main-header">
				<div class="main-header-bar thnk-col-3">
					<div class="main-header-col1">
          <span class="logo-content">
            <?php th_shop_mania_logo(); ?>
            </span>
            <?php
            if(function_exists('th_shop_mania_show_off_canvas_sidebar_icon')){
              th_shop_mania_show_off_canvas_sidebar_icon();}?> 
        </div>
					<div class="main-header-col2">
        <?php th_shop_mania_product_search_box(); ?>
          </div>
					<div class="main-header-col3">
           <div class="thunk-icon-market">
            <?php if ( defined( 'YITH_WCWL_SLUG' ) ) { ?>
              <a class="whishlist" aria-label="Wishlist" href="<?php echo esc_url(apply_filters('th_shop_mania_whishlist_url',' ','','')); ?>">
       <span class="th-icon th-icon-heartline"></span></a> 
     <?php } ?>

        <?php do_action( 'th_shop_mania_account' ); 
        do_action( 'th_shop_mania_cart_total_item' ); 
        ?>
          </div> 
          </div>
				</div> 
      </div>
        <!-- end main-header-bar -->
        <!-- responsive mobile main header-->
        <div class="responsive-main-header">
          <div class="main-header-bar thnk-col-3">
            <div class="main-header-col1">
            <span class="logo-content">
            <?php th_shop_mania_logo('responsive'); ?>
            </span>
            <?php
            if(function_exists('th_shop_mania_show_off_canvas_sidebar_icon')){
              th_shop_mania_show_off_canvas_sidebar_icon();} ?>
          </div>

           <div class="main-header-col2">
            <?php if ( class_exists( 'WooCommerce' ) ){
              th_shop_mania_product_search_box();
             } ?>
           </div>

           <div class="main-header-col3">
            <div class="thunk-icon-market">
                <div class="menu-toggle">
                    <button type="button" class="menu-btn" id="menu-btn" aria-label="Menu">
                        <div class="btn">
                           <span class="th-icon th-icon-TextEditor-Icons-01"></span>
                       </div>
                    </button>
                </div>
                <?php if ( defined( 'YITH_WCWL_SLUG' ) ) { ?>
                <div>
                  <a class="whishlist" aria-label="Wishlist" href="<?php echo esc_url(apply_filters('th_shop_mania_whishlist_url',' ','','')); ?>">
                  <span class="th-icon th-icon-heartline"></span></a>
                </div>
              <?php } ?>
                <div>
                <?php do_action( 'th_shop_mania_account' );  ?>
                </div>
                <?php do_action( 'th_shop_mania_cart_total_item' );  ?>

            </div>
          </div>
            </div>
          </div> <!-- responsive-main-header END -->
			</div>
		</div> 
      
<?php	}
}
add_action( 'th_shop_mania_main_header', 'th_shop_mania_main_header_markup' );

//  Below Header Markup
if ( ! function_exists( 'th_shop_mania_below_header_markup' ) ){  
function th_shop_mania_below_header_markup(){
$th_shop_mania_menu_open = get_theme_mod('th_shop_mania_mobile_menu_open','left');
$th_shop_mania_pro_menu_effect = get_theme_mod('th_shop_mania_pro_menu_effect', 'linkeffect-none'); ?>
  <div class="below-header <?php echo (esc_attr($th_shop_mania_menu_open).'-menu '.esc_attr($th_shop_mania_pro_menu_effect));?> ">
      <div class="container">
        <div class="below-header-bar thnk-col-1">
           <div class="below-header-col1">
            <?php if(class_exists( 'WooCommerce' )){ ?>
              <div class="menu-category-list toogleclose">
              <div class="toggle-cat-wrap">
                  <p class="cat-toggle" tabindex="0">
                    <span class="cat-icon"> 
                      <span class="cat-top"></span>
                       <span class="cat-mid"></span>
                       <span class="cat-bot"></span>
                     </span>
                     <span class="cate-text">
                       <?php echo esc_html(get_theme_mod('th_shop_mania_main_hdr_cat_txt','All Categories')); ?>
                     </span>
                    
                  </p>
              </div>
              <?php 
              th_shop_mania_product_list_categories();
              ?>
             </div><!-- menu-category-list -->    
         <?php } ?>
            </div>
          <div class="below-header-col2">
              <nav>
        <!-- Menu Toggle btn-->
        <div class="menu-toggle">
                <button type="button" class="menu-btn" id="menu-btn" aria-label="Menu">
                        <div class="btn">
                           <span class="th-icon th-icon-TextEditor-Icons-01"></span>
                       </div>
                </button>
        </div>
        <div class="sider main  th-shop-mania-menu-hide <?php echo esc_attr($th_shop_mania_menu_open);?>">
        <div class="sider-inner">
          <?php if(has_nav_menu('th-shop-mania-main-menu' )){ 
  
                    th_shop_mania_main_nav_menu();
              }else{
                 wp_page_menu(array( 
                 'items_wrap'  => '<ul class="th-shop-mania-menu" data-menu-style="horizontal">%3$s</ul>',
                 'link_before' => '<span>',
                 'link_after'  => '</span>'));
             }?>
        </div>
        </div>
        </nav>
           </div>
      </div>
    </div>
      </div> 
<?php }
}
add_action( 'th_shop_mania_below_header', 'th_shop_mania_below_header_markup' );
/**************************************/
//logo & site title function
/**************************************/
if ( ! function_exists( 'th_shop_mania_logo' ) ){
function th_shop_mania_logo($headertype = ''){
$title_disable          = get_theme_mod( 'title_disable','enable');
$tagline_disable        = get_theme_mod( 'tagline_disable','enable');
$description            = get_bloginfo( 'description', 'display' );
th_shop_mania_custom_logo(); 
if($title_disable!='' || $tagline_disable!=''){
if($title_disable!=''){ 
?>
<div class="site-title">
   <?php //latest post
   if ( (is_home() || is_front_page()) && $headertype === '') { ?>
    <h1>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
    </h1>
<?php } else { ?>
    <span>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
    </span>
<?php } ?>
</div>
<?php
}
if($tagline_disable!=''){
if( $description || is_customize_preview() ):?>
<div class="site-description">
   <p><?php echo esc_html($description); ?></p>
</div>
<?php endif;
      }
    } 
  }
}
/***************************/
// Product search
/***************************/
function th_shop_mania_product_search_box(){  
  if ( shortcode_exists( 'th-aps' ) ) {
    echo do_shortcode('[th-aps]');          
  }
  elseif ( shortcode_exists('tapsp') ){
    echo do_shortcode('[tapsp]');
    }       
}
// mobile panel
function th_shop_mania_cart_mobile_panel(){
$th_shop_mania_mobile_menu_open = get_theme_mod('th_shop_mania_mobile_menu_open','left');
$th_shop_mania_pro_resp_mobile_header_layout = get_theme_mod('th_shop_mania_pro_resp_mobile_header_layout','respmobile-layout-1');
  ?>
      <div class="mobile-nav-bar sider main  th-shop-mania-menu-hide <?php echo esc_attr($th_shop_mania_mobile_menu_open).' '.esc_attr($th_shop_mania_pro_resp_mobile_header_layout); ?>">
        <?php th_shop_mania_product_search_box(); ?>
        <div class="sider-inner">
        
          <div class="mobile-tab-wrap">
              <?php if(class_exists( 'WooCommerce' )){?>
            <div class="mobile-nav-tabs">
                <ul>
                  <li class="primary active" data-menu="primary">
                     <a href="#mobile-nav-tab-menu"><?php esc_html_e('Menu','th-shop-mania');?></a>
                  </li>
                  <?php 

                    if (th_shop_mania_product_categories_exist()) { ?>

                  <li class="categories" data-menu="categories">
                    <a href="#mobile-nav-tab-category"><?php esc_html_e('Categories','th-shop-mania');?></a>
                  </li>

              <?php } ?>
                
                </ul>
            </div>
            <?php }?>
            <div id="mobile-nav-tab-menu" class="mobile-nav-tab-menu panel">
          <?php if(has_nav_menu('th-shop-mania-main-menu' )){ 
                        th_shop_mania_main_nav_menu();
              }else{
                 wp_page_menu(array( 
                 'items_wrap'  => '<ul class="th-shop-mania-menu" data-menu-style="horizontal">%3$s</ul>',
                 'link_before' => '<span>',
                 'link_after'  => '</span>'));
             }?>
           </div>
            <?php if(class_exists( 'WooCommerce' )){?>
           <div id="mobile-nav-tab-category" class="mobile-nav-tab-category panel">
             <?php th_shop_mania_product_list_categories_mobile(); ?>
           </div>
           <?php }?>
          </div>
        </div>
      </div>
<?php 
}
add_action( 'th_shop_mania_below_header', 'th_shop_mania_cart_mobile_panel' );
/***********************************************************
 *Header Post Meta Hide and show Function for Theme
 ***************************************************************/
if (!function_exists('th_shop_mania_header_abv_post_meta')) {
    function th_shop_mania_header_abv_post_meta($page_post_meta_set = '')
    {
        if ($page_post_meta_set !== 'on') {
            do_action( 'th_shop_mania_top_header' );
        }
    }
}
// main
if (!function_exists('th_shop_mania_header_main_post_meta')) {
    function th_shop_mania_header_main_post_meta($page_post_meta_set = '')
    {
        if ($page_post_meta_set !== 'on') {
          if (function_exists('th_shop_mania_pro_load_plugin')) {
           do_action( 'th_shop_mania_pro_main_header' );
          }
          else{
            do_action( 'th_shop_mania_main_header' );
          }
        }
    }
}
// bottom
if (!function_exists('th_shop_mania_header_btm_post_meta')) {
    function th_shop_mania_header_btm_post_meta($page_post_meta_set = '')
    {
        if ($page_post_meta_set !== 'on') {
          if (function_exists('th_shop_mania_pro_load_plugin')) {
          add_action( 'th_shop_mania_pro_below_header', 'th_shop_mania_cart_mobile_panel' );
          do_action( 'th_shop_mania_pro_below_header' );

        }
        else{
          do_action( 'th_shop_mania_below_header' );
        }
      }
    }
}
/**************************/
//PRELOADER
/**************************/
if( ! function_exists( 'th_shop_mania_preloader' ) ){
 function th_shop_mania_preloader(){
 if (( isset( $_REQUEST['action'] ) && 'elementor' == $_REQUEST['action'] ) ||
                isset( $_REQUEST['elementor-preview'] )){
      return;
 }else{  ?>
    <div class="th_shop_mania_overlayloader">
    <div class="th-shop-mania-pre-loader">
       <div class="th-loader"><?php esc_html_e(' ','th-shop-mania'); ?></div>
    </div>
    </div> 
   <?php 
   }
 }

}
add_action('th_shop_mania_site_preloader','th_shop_mania_preloader');


/******************************/
//Transparent header function
/******************************/
function th_shop_mania_header_transparent_class($th_shop_mania_transparent_post_meta)
{
    if ($th_shop_mania_transparent_post_meta == 'default' || $th_shop_mania_transparent_post_meta == '') {
        $class = '';
        $th_shop_mania_header_transparent_special_page_disable = get_theme_mod('th_shop_mania_header_transparent_special_page_disable', false);
        $th_shop_mania_header_transparent = get_theme_mod('th_shop_mania_header_transparent', false);
        if ($th_shop_mania_header_transparent == true) {
            if (($th_shop_mania_header_transparent_special_page_disable == true) && (is_archive() || is_404() || is_search() || (class_exists('WooCommerce') && (is_shop() || is_product())))) {
                $class = '';
            } else {
                $class = 'zta-transparent-header';
            }
            if (is_front_page() && is_home()) {
             $class = '';
            }
        }
        return $class;
    } else {
        if ($th_shop_mania_transparent_post_meta == 'enable') {
            return $class = 'zta-transparent-header';
        }
    }
}
