<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package  Th Shop Mania
 * @since 1.0.0
 */ 
if ( is_single() || is_page() ){
$th_shop_mania_disable_above_footer_dyn  = get_post_meta( $post->ID, 'th_shop_mania_disable_above_footer_dyn', true );
$th_shop_mania_disable_footer_widget_dyn = get_post_meta( $post->ID, 'th_shop_mania_disable_footer_widget_dyn', true ); 
$th_shop_mania_disable_bottom_footer_dyn = get_post_meta( $post->ID, 'th_shop_mania_disable_bottom_footer_dyn', true ); 
}else{
$th_shop_mania_disable_above_footer_dyn  ='';
$th_shop_mania_disable_footer_widget_dyn ='';
$th_shop_mania_disable_bottom_footer_dyn ='';
}
?>
<footer>
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