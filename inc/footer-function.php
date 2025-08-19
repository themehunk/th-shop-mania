<?php 
/**
 * Footer Function for Th Shop Mania theme.
 * 
 * @package     Th Shop Mania
 * @author      Th Shop Mania
 * @copyright   Copyright (c) 2022, Th Shop Mania
 * @since       Th Shop Mania 1.0.0
 */
if ( !function_exists('th_shop_mania_full_footer_markup') ) {
function th_shop_mania_full_footer_markup() { 
  global $post;
if ((is_single() || is_page()) || ((class_exists('WooCommerce')) && (is_woocommerce() || is_checkout() || is_cart() || is_account_page()))
||  is_front_page() || is_home()) {
    if (class_exists('WooCommerce') && is_shop()) {
        $shop_page_id = get_option('woocommerce_shop_page_id');
        $postid = $shop_page_id;
    } elseif(th_shop_mania_is_blog()){
        $blog_page_id = get_option('page_for_posts');
        $postid = $blog_page_id;
    } else {
        $postid =(isset($post->ID)) ? $post->ID : '';
    }
$th_shop_mania_disable_above_footer_dyn  = get_post_meta( $postid, 'th_shop_mania_disable_above_footer_dyn', true );
$th_shop_mania_disable_footer_widget_dyn = get_post_meta( $postid, 'th_shop_mania_disable_footer_widget_dyn', true ); 
$th_shop_mania_disable_bottom_footer_dyn = get_post_meta( $postid, 'th_shop_mania_disable_bottom_footer_dyn', true ); 
}else{
$th_shop_mania_disable_above_footer_dyn  ='';
$th_shop_mania_disable_footer_widget_dyn ='';
$th_shop_mania_disable_bottom_footer_dyn ='';
}
?>
  <footer class="thsm-footer">
         <?php        
  th_shop_mania_footer_abv_post_meta($th_shop_mania_disable_above_footer_dyn);
    th_shop_mania_footer_widget_post_meta($th_shop_mania_disable_footer_widget_dyn);
    th_shop_mania_footer_bottom_post_meta($th_shop_mania_disable_bottom_footer_dyn);
        ?>
</footer> <!-- end footer -->
    <?php }

// Hook the custom footer function into 'zita_footer'
add_action('th_shop_mania_footer', 'th_shop_mania_full_footer_markup');
}
/**************************************/
//Widgett footer function
/**************************************/
if ( ! function_exists( 'th_shop_mania_widget_footer_markup_lite' ) ){  
function th_shop_mania_widget_footer_markup_lite(){ 
$th_shop_mania_bottom_footer_widget_layout  = get_theme_mod( 'th_shop_mania_bottom_footer_widget_layout','ft-wgt-none');  
 //This is to check if any widget active then only add markup
 if( is_active_sidebar('footer-1' ) ){
  ?>  
  <div class="widget-footer">
      <div class="container">

          <div class="widget-footer-wrap thnk-col-4">
            <div class="widget-footer-col1">
             <?php if( is_active_sidebar('footer-1' ) ){
                      dynamic_sidebar('footer-1' );
            }elseif(is_customize_preview()){?>
                  <a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"><?php esc_html_e( 'Add Widget', 'th-shop-mania' );?></a>
                    <?php }?>
            </div>
            
            <div class="widget-footer-col2"><?php if( is_active_sidebar('footer-2' ) ){
                      dynamic_sidebar('footer-2' );
            }elseif(is_customize_preview()){?>
                    <a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"><?php esc_html_e( 'Add Widget', 'th-shop-mania' );?></a>
                          <?php }?>
            </div>
                  
            <div class="widget-footer-col3"><?php if( is_active_sidebar('footer-3' ) ){
                      dynamic_sidebar('footer-3' );
            }elseif(is_customize_preview()){?>
                    <a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"><?php esc_html_e( 'Add Widget', 'th-shop-mania' );?></a>
                          <?php }?>
            </div>
            
            <div class="widget-footer-col4"><?php if( is_active_sidebar('footer-4' ) ){
                      dynamic_sidebar('footer-4' );
            }elseif(is_customize_preview()){?>
                    <a href="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>"><?php esc_html_e( 'Add Widget', 'th-shop-mania' );?></a>
                          <?php }?>
            </div>
          </div>

      </div>
    </div>  
<?php } }
}
add_action( 'th_shop_mania_widget_footer_lite', 'th_shop_mania_widget_footer_markup_lite' );
/**************************************/
//Below footer function
/**************************************/
if ( ! function_exists( 'th_shop_mania_below_footer_markup_lite' ) ){  
function th_shop_mania_below_footer_markup_lite(){ ?>   
<div class="below-footer lite">
            <p class="footer-copyright">&copy;
              <?php
              esc_html_e(date_i18n(
                /* translators: Copyright date format, see https://www.php.net/date */
                _x( 'Y', 'copyright date format', 'th-shop-mania' )
              )); ?>
              &nbsp;
              <?php
              bloginfo( 'name' );
              ?>
              
              <span><?php esc_html_e( 'Made with', 'th-shop-mania' ); ?></span>
              <a href="<?php echo esc_url('https://themehunk.com/'); ?>" target="_blank" rel="nofollow noopener">
                <?php esc_html_e( 'ThemeHunk WordPress Theme', 'th-shop-mania' ); ?>
              </a>
            </p><!-- .footer-copyright -->         
</div>
                  
<?php }
}
add_action( 'th_shop_mania_below_footer_lite', 'th_shop_mania_below_footer_markup_lite' );


/***********************************************************
*Footer Post Meta Hide and show Function for TH SHOP MANIA Theme
***************************************************************/
if( ! function_exists( 'th_shop_mania_footer_abv_post_meta' ) ){
function th_shop_mania_footer_abv_post_meta($page_post_meta_set=''){
    if($page_post_meta_set!=='on'){
             // top-footer 
          do_action( 'th_shop_mania_pro_top_footer' ); 
  }
 }
}
//Widget footer
if( ! function_exists( 'th_shop_mania_footer_widget_post_meta' ) ){
function th_shop_mania_footer_widget_post_meta($page_post_meta_set=''){
    if($page_post_meta_set!=='on'){
      //Widget footer
      if (function_exists( 'th_shop_mania_pro_load_plugin' ) ){  
          do_action( 'th_shop_mania_pro_widget_footer' );
        }
        else{
          do_action( 'th_shop_mania_widget_footer_lite' );
        }
         
  }
 }
}
//Footer bottom
if( ! function_exists( 'th_shop_mania_footer_bottom_post_meta' ) ){
function th_shop_mania_footer_bottom_post_meta($page_post_meta_set=''){
    if($page_post_meta_set!=='on'){   
            // below-footer
          if (function_exists( 'th_shop_mania_pro_load_plugin' ) ){  
          do_action( 'th_shop_mania_pro_below_footer' );
        }
        else{
          do_action( 'th_shop_mania_below_footer_lite' );  
        }
  }
 }
}