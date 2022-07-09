<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package  Th Shop Mania
 * @since 1.0.0
 */ 
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
        $postid = $post->ID;
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
    </div> <!-- end th-shop-mania-site -->
<?php wp_footer(); ?>
</body>
</html>