<?php
/**
 * The WooCommerce template file
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#woocommerce
 * @package  Th Shop Mania
 * @since 1.0.0
 */
if ( ! class_exists( 'WooCommerce' ) ){
    return;
}
get_header();
$shoppage_id = '';
$id = '';
$breadcrumb = get_theme_mod('th_shop_mania_pro_breadcrumb_select', 'default');

    if(class_exists( 'WooCommerce' ) && is_shop() || class_exists( 'WooCommerce' ) && is_product_category()){
            // To make woocommerce archive or category page same as Woocommerce Shop Page
$shoppage_id = get_option( 'woocommerce_shop_page_id' );
$id = $shoppage_id;
$th_shop_mania_sidebar = get_post_meta( $shoppage_id, 'th_shop_mania_sidebar_dyn', true );
    if (empty($th_shop_mania_sidebar)) {
   $th_shop_mania_sidebar = 'no-sidebar';
    }
}
elseif(class_exists( 'WooCommerce' ) && is_product() && get_theme_mod('th_shop_mania_product_single_sidebar_disable',false) !==true){
    $th_shop_mania_sidebar = get_post_meta(get_the_ID(), 'th_shop_mania_sidebar_dyn', true );
    if ($th_shop_mania_sidebar == '') {
        $th_shop_mania_sidebar = 'no-sidebar';
    }
}
elseif(class_exists( 'WooCommerce' ) && is_product() && (get_theme_mod('th_shop_mania_product_single_sidebar_disable',false)) ==true){
    $th_shop_mania_sidebar = 'no-sidebar';
}
else{
$th_shop_mania_sidebar = 'no-sidebar';
} 
$th_shop_mania_page_header_enable = get_theme_mod('th_shop_mania_page_header_enable',false);
if (class_exists('WooCommerce') && is_product()) {
  $id = $post->ID;
}
?>
<div id="content" class="page-content <?php echo esc_attr($th_shop_mania_sidebar); ?>">
        	<div class="container">
          <div class="content-wrap" >
          <?php if ($th_shop_mania_page_header_enable != true) { ?>
                    <div class="page-head">
                      <?php
                      th_shop_mania_get_page_title($id);  
                      if ($breadcrumb == 'yoast' && function_exists('yoast_breadcrumb')) {
                          yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                      }
                      elseif (function_exists('woocommerce_breadcrumb')) {
                          woocommerce_breadcrumb();
                      }
                        
                      ?>
                    </div>
            <?php } ?>
        			<div class="main-area">
                 <?php 
                if($th_shop_mania_sidebar !== 'no-sidebar' ):
                get_sidebar();
                endif;
                 ?><!-- end sidebar-primary  sidebar-content-area-->
                 <div id="primary" class="primary-content-area">
                  <div class="primary-content-wrap">
        
                    <?php woocommerce_content();?>  
                           </div> <!-- end primary-content-wrap-->
                </div> <!-- end primary primary-content-area-->
        			</div> <!-- end main-area -->
        		</div>  <!-- end content-wrap -->
        	</div> 
        </div> <!-- end content page-content -->
<?php get_footer();?>