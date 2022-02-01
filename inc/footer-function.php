<?php 
/**
 * Footer Function for Th Shop Mania theme.
 * 
 * @package     Th Shop Mania
 * @author      Th Shop Mania
 * @copyright   Copyright (c) 2019, Th Shop Mania
 * @since       Th Shop Mania 1.0.0
 */
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
<div class="below-footer">
      <div class="container">
        <div class="below-footer-bar thnk-col-1">
          <div class="below-footer-col1"> 
           <p class="footer-copyright">
              <?php
              echo esc_html(get_theme_mod('th_shop_mania_footer_bottom_col1_texthtml','Copyright | Th Shop Mania | Developed by ThemeHunk'));
               ?>
              </a>
            </span>
            </p><!-- .footer-copyright -->
           </div>
        </div>
      </div>
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