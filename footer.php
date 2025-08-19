<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package  Th Shop Mania
 * @since 1.0.0
 */ 

 do_action( 'th_shop_mania_before_footer' ); 
 do_action( 'th_shop_mania_footer' );   
 do_action( 'th_shop_mania_after_footer' ); ?>
    </div> <!-- end th-shop-mania-site -->
<?php wp_footer(); ?>
</body>
</html>