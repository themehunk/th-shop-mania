<?php 
/**
 * Template Name: Full Width Template
 *
 * @package ThemeHunk
 * @subpackage Th Shop Mania
 * @since 1.0.0
 */
get_header();
$th_shop_mania_sidebar = 'no-sidebar';
?>
  <div id="content" class="page-content thunk-page <?php echo esc_attr($th_shop_mania_sidebar); ?> full-width-template">
          <div class="content-wrap" >
              <div class="main-area">
                <div id="primary" class="primary-content-area">
                  <div class="primary-content-wrap">
                        <div class="thunk-content-wrap">
                        <?php
                            while( have_posts() ) : the_post();
                               get_template_part( 'template-parts/content', 'page' );
                              // If comments are open or we have at least one comment, load up the comment template.
                              if ( comments_open() || get_comments_number() ) :
                                comments_template();
                               endif;
                               endwhile; // End of the loop.
                            ?>
                         </div>
                      </div> <!-- end primary-content-wrap-->
                </div> <!-- end primary primary-content-area-->
                <?php 
                if($th_shop_mania_sidebar != 'no-sidebar' ):
                get_sidebar();
                endif;
                 ?><!-- end sidebar-primary  sidebar-content-area-->
              </div> <!-- end main-area -->
            </div>  <!-- end content-wrap -->
        </div> <!-- end content page-content -->
<?php get_footer();?>