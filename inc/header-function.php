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
            ?>
            <div class="top-header">
              <div class="container">
                <div class="top-header-bar thnk-col-3">
                        <?php dynamic_sidebar('top-header-widget-col1'); ?>
                </div>
              </div>
            </div>
            <?php
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
?>
<div class="main-header <?php echo esc_attr($main_header_opt);?> <?php echo esc_attr($th_shop_mania_menu_alignment).'-menu';?>  <?php echo esc_attr($offcanvas);?>">
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
            <?php if ( is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ) { ?>
              <a class="whishlist" href="<?php echo esc_url(apply_filters('th_shop_mania_whishlist_url','th_shop_mania_whishlist_url','','')); ?>">
       <i  class="fa fa-heart-o" aria-hidden="true"></i></a> 
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
            <?php th_shop_mania_logo(); ?>
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
                    <button type="button" class="menu-btn" id="menu-btn">
                        <div class="btn">
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                           <span class="icon-bar"></span>
                       </div>
                    </button>
                </div>
                <?php if ( is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ) { ?>
                <div>
                  <a class="whishlist" href="<?php echo esc_url(apply_filters('th_shop_mania_whishlist_url',' ','','')); ?>">
                  <i  class="fa fa-heart-o" aria-hidden="true"></i></a>
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
if ( ! function_exists( 'th_shop_mania_below_header_markup' ) ){  
function th_shop_mania_below_header_markup(){
$th_shop_mania_menu_open = get_theme_mod('th_shop_mania_mobile_menu_open','left'); ?>
  <div class="below-header <?php echo esc_attr($th_shop_mania_menu_open).'-menu'; ?>">
      <div class="container">
        <div class="below-header-bar thnk-col-1">
           <div class="below-header-col1">
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
              <?php if(class_exists( 'WooCommerce' )){
              th_shop_mania_product_list_categories();
              } ?>
             </div><!-- menu-category-list -->    
            </div>
          <div class="below-header-col2">
              <nav>
        <!-- Menu Toggle btn-->
        <div class="menu-toggle">
            <button type="button" class="menu-btn" id="menu-btn">
                <div class="btn">
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </div>
            </button>
        </div>
        <div class="sider main  th-shop-mania-menu-hide <?php echo esc_attr($th_shop_mania_menu_open);?>">
        <div class="sider-inner">
          <?php if(has_nav_menu('th-shop-mania-main-menu' )){ 

             if (wp_is_mobile()!== false){
                   if(has_nav_menu('th-shop-mania-above-menu' )){
                                th_shop_mania_abv_nav_menu();
                       }
                  }  
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
function th_shop_mania_logo(){
$title_disable          = get_theme_mod( 'title_disable','enable');
$tagline_disable        = get_theme_mod( 'tagline_disable','enable');
$description            = get_bloginfo( 'description', 'display' );
th_shop_mania_custom_logo(); 
if($title_disable!='' || $tagline_disable!=''){
if($title_disable!=''){ 
?>
<div class="site-title"><span>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
</span>
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
  if (shortcode_exists( 'th-aps' )) {
    echo do_shortcode('[th-aps]');          
  }       
}
// mobile panel
function th_shop_mania_cart_mobile_panel(){
$th_shop_mania_mobile_menu_open = get_theme_mod('th_shop_mania_mobile_menu_open','left');
  ?>
      <div class="mobile-nav-bar sider main  th-shop-mania-menu-hide <?php echo esc_attr($th_shop_mania_mobile_menu_open); ?>">
        <div class="sider-inner">
        
          <div class="mobile-tab-wrap">
              <?php if(class_exists( 'WooCommerce' )){?>
            <div class="mobile-nav-tabs">
                <ul>
                  <li class="primary active" data-menu="primary">
                     <a href="#mobile-nav-tab-menu"><?php _e('Menu','th-shop-mania');?></a>
                  </li>
                  
                  <li class="categories" data-menu="categories">
                    <a href="#mobile-nav-tab-category"><?php _e('Categories','th-shop-mania');?></a>
                  </li>
                
                </ul>
            </div>
            <?php }?>
            <div id="mobile-nav-tab-menu" class="mobile-nav-tab-menu panel">
          <?php if(has_nav_menu('th-shop-mania-main-menu' )){ 
                    if(has_nav_menu('th-shop-mania-above-menu' )){
                         th_shop_mania_abv_nav_menu();
                       }
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
 *Header Post Meta Hide and show Function for Zita Theme
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
          do_action( 'th_shop_mania_main_header' );
        }
    }
}
// bottom
if (!function_exists('th_shop_mania_header_btm_post_meta')) {
    function th_shop_mania_header_btm_post_meta($page_post_meta_set = '')
    {
        if ($page_post_meta_set !== 'on') {
          do_action( 'th_shop_mania_below_header' );
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
       <div class="th-loader">&nbsp;</div>
    </div>
    </div> 
   <?php 
   }
 }

}
add_action('th_shop_mania_site_preloader','th_shop_mania_preloader');