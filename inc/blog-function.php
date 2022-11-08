<?php 
/**
 * Blog Function
 * @package     Th Shop Mania
 * @author      ThemeHunk
 * @copyright   Copyright (c) 2022, ThemeHunk
 * @since       ThemeHunk 1.0.0
 */
        /**
		 * Excerpt count.
		 *
		 * @param int $length default count of words.
		 * @return int count of words
		 */
		function th_shop_mania_excerpt_length( $length ){
			if(is_admin()){
             	return $length;
             }
			 $excerpt_length = (string) get_theme_mod( 'th_shop_mania_blog_expt_length' );

			if ( '' != $excerpt_length ) {
			   $length = $excerpt_length;
			}
			return $length;
		}
		add_filter( 'excerpt_length','th_shop_mania_excerpt_length', 999 );
/**
 * Display Blog Post Excerpt
 */
if ( ! function_exists( 'th_shop_mania_the_excerpt' ) ){
	/**
	 * Display Blog Post Excerpt
	 *
	 * @since 1.0.0
	 */
	function th_shop_mania_the_excerpt($excerpt_type=''){ ?>
		<div class="entry-content">
		<?php $excerpt_type = get_theme_mod( 'th_shop_mania_blog_post_content','excerpt');
		if ( 'full' == $excerpt_type ){
			the_content();
		} 
		elseif('excerpt' == $excerpt_type ){
			the_excerpt();

		} else {
          return false;
		}?>
		</div>	
	<?php }
}
/**
		 * Read more text.
		 *
		 * @param string $text default read more text.
		 * @return string read more text
		 */
		function th_shop_mania_read_more_text( $text ) {

			$read_more = esc_html(get_theme_mod( 'th_shop_mania_blog_read_more_txt','Read More' ));

			
				$text = $read_more;
			

			return $text;
		}
      add_filter( 'th_shop_mania_blog_read_more_txt', 'th_shop_mania_read_more_text');

/**
 * Function to get Read More Link of Post
 *
 * @since 1.0.0
 * @return html
 */
if ( ! function_exists( 'th_shop_mania_post_link' ) ){
	/**
	 * Function to get Read More Link of Post
	 *
	 * @param  string $output_filter Filter string.
	 * @return html                Markup.
	 */
	function th_shop_mania_post_link( $output_filter = '' ){

		$enabled = apply_filters( 'open_post_link_enabled', '__return_true' );
		if ( ( is_admin() && ! wp_doing_ajax() ) || ! $enabled ){
			return $output_filter;
		}
		$read_more_text = apply_filters( 'th_shop_mania_blog_read_more_txt', __( 'Read More', 'th-shop-mania' ) );
		if ($read_more_text == '') {
			return;
		}
		$read_more_classes        = apply_filters( 'th_shop_mania_blog_read_more_txt_class', array() );
		$post_link = sprintf(
			esc_html( '%s' ),
			'<a class="' . implode( ' ', $read_more_classes ) . ' thunk-readmore button " href="' . esc_url( get_permalink() ) . '"> ' . the_title( '<span class="screen-reader-text">', '</span>', false ) . esc_html($read_more_text) . '</a>'
		);
		$output = ' &hellip;<p class="read-more"> ' . $post_link . '</p>';
		return apply_filters( 'th_shop_mania_post_link', $output, $output_filter );
	}
}
add_filter( 'excerpt_more', 'th_shop_mania_post_link', 1 );
/*******************/
// loader function
/*******************/
if ( ! function_exists( 'th_shop_mania_post_loader' ) ):
function th_shop_mania_post_loader(){
the_posts_pagination(array(
    'mid_size'  => 2,
    'prev_text' => __( '&nbsp;', 'th-shop-mania' ),
    'next_text' => __( '&nbsp;', 'th-shop-mania' ),
));
}
endif;

if ( ! function_exists( 'th_shop_blog_image' ) ){
function th_shop_blog_image($layout = ''){

	if (!wp_is_mobile() && ($layout == 'thsm-blog-layout-4')) {
		the_post_thumbnail( 'medium' );  
	} 
	elseif(!wp_is_mobile() && ($layout == 'thsm-blog-layout-2' || $layout == 'thsm-blog-layout-3' || $layout == 'thsm-blog-layout-5')){
		the_post_thumbnail( 'medium_large' );
	}
	elseif (!wp_is_mobile() && $layout == 'thsm-blog-layout-1') {
	// Full resolution (original size uploaded)
		the_post_thumbnail( 'full' ); 
	}
	elseif(wp_is_mobile()){
		the_post_thumbnail( 'post-thumbnail' );
	}
}
}