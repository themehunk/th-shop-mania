<?php
/**
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Th Shop Mania
 * @since 1.0.0
 */
get_header();

$th_shop_mania_page_header_enable = get_theme_mod('th_shop_mania_page_header_enable',false);
$sidebar_meta = get_post_meta(get_option('page_for_posts'), 'th_shop_mania_sidebar_dyn', true);
$breadcrumb = get_theme_mod('th_shop_mania_pro_breadcrumb_select', 'default');
?>
<div id="content" class="page-content archive  <?php echo esc_attr($sidebar_meta); ?>">
            <div class="content-wrap" >
                <div class="container">
                    <div class="main-area">
                        <div id="primary" class="primary-content-area">
                            <div class="primary-content-wrap">
                            <div class="page-head">
                   <?php if ($th_shop_mania_page_header_enable != true) { 
                       th_shop_mania_get_page_title();
                      }   
                       if ($breadcrumb == 'yoast' && function_exists('yoast_breadcrumb')) {
                          yoast_breadcrumb( '<p id="breadcrumbs" class="thunk-breadcrumb">','</p>' );
                      }
                      else {
                          th_shop_mania_breadcrumb_trail();

                      } 

                      ?>
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
                                if ($sidebar_meta !== 'no-sidebar' && !empty($sidebar_meta)) {
                                            get_sidebar();
                            }
                        } ?><!-- end sidebar-primary  sidebar-content-area-->
                    </div> <!-- end main-area -->
                </div>
            </div> <!-- end content-wrap -->
        </div> <!-- end content page-content -->
<?php get_footer();?>