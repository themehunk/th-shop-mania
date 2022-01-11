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
    if(class_exists( 'WooCommerce' ) && is_shop()){
$shoppage_id = get_option( 'woocommerce_shop_page_id' );

$th_shop_mania_sidebar = get_post_meta( $shoppage_id, 'th_shop_mania_sidebar_dyn', true );
}
  elseif(class_exists( 'WooCommerce' ) && is_product()){
$th_shop_mania_sidebar = get_post_meta(get_the_ID(), 'th_shop_mania_sidebar_dyn', true );
}
  elseif(empty(get_post_meta( $post->ID, 'th_shop_mania_sidebar_dyn', true ))){
$th_shop_mania_sidebar = 'right';
                  } 
?>
<div id="content" class="page-content <?php echo esc_attr($th_shop_mania_sidebar); ?>">
        	<div class="container">
          <div class="content-wrap" >
        			<div class="main-area">
                 <?php 
                if($th_shop_mania_sidebar != 'no-sidebar' ):
                get_sidebar();
                endif;
                 ?><!-- end sidebar-primary  sidebar-content-area-->
                 <div id="primary" class="primary-content-area">
                  <div class="primary-content-wrap">
                          <div class="page-head">
                   <?php th_shop_mania_get_page_title();
                   th_shop_mania_breadcrumb_trail();?>
                    </div>
                            <?php woocommerce_content();?>  
                           </div> <!-- end primary-content-wrap-->
                </div> <!-- end primary primary-content-area-->
        			</div> <!-- end main-area -->
        		</div>  <!-- end content-wrap -->
        	</div> 
        </div> <!-- end content page-content -->
<?php get_footer();?>
