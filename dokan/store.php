<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */
if (!class_exists('WeDevs_Dokan')) {
  return;
}
$store_user   = get_userdata( get_query_var( 'author' ) );
$store_info   = dokan_get_store_info( $store_user->ID );
$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';
$scheme       = is_ssl() ? 'https' : 'http';
$layout       = get_theme_mod( 'store_layout', 'left' );

wp_enqueue_script( 'google-maps', $scheme . '://maps.google.com/maps/api/js?sensor=true' );

get_header();
if (isset($post->ID)) {
if(empty(get_post_meta( $post->ID, 'th_shop_mania_sidebar_dyn', true ))){
$th_shop_mania_sidebar = 'no-sidebar';
}else{
$th_shop_mania_sidebar = get_post_meta( $post->ID, 'th_shop_mania_sidebar_dyn', true );
$id = $post->ID;
}
}
else{
   $th_shop_mania_sidebar = '';
}
$th_shop_mania_page_header_enable = get_theme_mod('th_shop_mania_page_header_enable',false);
$breadcrumb = get_theme_mod('th_shop_mania_pro_breadcrumb_select', 'default');
?>
<div id="content" class="page-content thunk-page <?php echo esc_attr($th_shop_mania_sidebar); ?>">
          <div class="container">
          <div class="content-wrap" >
              <div class="main-area">
                <div id="primary" class="primary-content-area">
                  <div class="primary-content-wrap">
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
                        <div class="thunk-content-wrap">
                        <?php do_action( 'woocommerce_before_main_content' ); ?>

   <div class="dokan-store-wrap layout-<?php echo esc_attr( $layout ); ?>">

        <div id="dokan-primary" class="dokan-single-store">
            <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

                <?php dokan_get_template_part( 'store-header' ); ?>

                <?php do_action( 'dokan_store_profile_frame_after', $store_user->data, $store_info ); ?>

                <?php if ( have_posts() ) { ?>

                    <div class="seller-items">

                        <?php woocommerce_product_loop_start(); ?>

                            <?php while ( have_posts() ) : the_post(); ?>

                                <?php wc_get_template_part( 'content', 'product' ); ?>

                            <?php endwhile; // end of the loop. ?>

                        <?php woocommerce_product_loop_end(); ?>

                    </div>

                    <?php dokan_content_nav( 'nav-below' ); ?>

                <?php } else { ?>

                    <p class="dokan-info"><?php esc_html_e( 'No products were found of this vendor!', 'th-shop-mania' ); ?></p>

                <?php } ?>
            </div>

        </div><!-- .dokan-single-store -->


    </div><!-- .dokan-store-wrap -->

    <?php do_action( 'woocommerce_after_main_content' ); ?>

                         </div>
                      </div> <!-- end primary-content-wrap-->
                </div> <!-- end primary primary-content-area-->
                <?php 
                if($th_shop_mania_sidebar != 'no-sidebar' ):
                $sidebar = apply_filters( 'th_shop_mania_get_sidebar', 'sidebar-1' ); ?>
              <div id="sidebar-primary" class="sidebar-content-area  <?php echo esc_attr(apply_filters( 'th_shop_mania_stick_sidebar_class',''));?>">
              <div class="sidebar-main">
                <?php
                if ( is_active_sidebar($sidebar) ){
                dynamic_sidebar($sidebar);
                 }

                 dokan_get_template_part( 'store', 'sidebar', array( 'store_user' => $store_user, 'store_info' => $store_info, 'map_location' => $map_location ) ); 
                  ?>
              </div>  <!-- sidebar-main End -->
            </div> <!-- sidebar-primary End -->  
              <?php  endif;
                 ?><!-- end sidebar-primary  sidebar-content-area-->
              </div> <!-- end main-area -->
            </div>  <!-- end content-wrap -->
          </div> 
        </div> <!-- end content page-content -->
<?php get_footer();