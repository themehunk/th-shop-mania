<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Th Shop Mania
 * @since 1.0.0
 */
get_header();
if(empty(get_post_meta( $post->ID, 'th_shop_mania_sidebar_dyn', true ))){
$th_shop_mania_sidebar = 'right';
}else{
$th_shop_mania_sidebar = get_post_meta( $post->ID, 'th_shop_mania_sidebar_dyn', true );
}
$th_shop_mania_page_header_enable = get_theme_mod('th_shop_mania_page_header_enable',false);
?>
<div id="content" class="page-content archive  <?php echo esc_attr($th_shop_mania_sidebar); ?>">
            <div class="content-wrap" >
                <div class="container">
                    <div class="main-area">
                        <div id="primary" class="primary-content-area">
                            <div class="primary-content-wrap">
                            <div class="page-head">
                   <?php if ($th_shop_mania_page_header_enable != true) { 
                       th_shop_mania_get_page_title();
                      }   
                      th_shop_mania_breadcrumb_trail();?>
                    </div>
                            <div class="primary-content-wrap">
                                 <?php
            if( have_posts()):
                /* Start the Loop */
                while ( have_posts() ) : the_post();
                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                get_template_part( 'template-parts/content', get_post_format() );
                endwhile;
                
            else :
                get_template_part( 'template-parts/content', 'none' );
            endif;

           th_shop_mania_post_loader();
            ?>
                           </div> <!-- end primary-content-wrap-->
                       </div>
                        </div> <!-- end primary primary-content-area-->
                        <?php if(th_shop_mania_is_blog()){
                               if(get_post_meta(get_option( 'page_for_posts' ),$th_shop_mania_sidebar)!='no-sidebar'){
                                            get_sidebar();
                            }
                        } ?><!-- end sidebar-primary  sidebar-content-area-->
                    </div> <!-- end main-area -->
                </div>
            </div> <!-- end content-wrap -->
        </div> <!-- end content page-content -->
<?php get_footer();?>