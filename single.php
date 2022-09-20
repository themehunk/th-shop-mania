<?php
get_header();
if(empty(get_post_meta( $post->ID, 'th_shop_mania_sidebar_dyn', true ))){
$th_shop_mania_sidebar = 'right';
}else{
$th_shop_mania_sidebar = get_post_meta( $post->ID, 'th_shop_mania_sidebar_dyn', true );
}
?>
<div id="content" class="page-content thunk-single-post <?php echo esc_attr($th_shop_mania_sidebar); ?>">
            <div class="container">
        	<div class="content-wrap" >
        			<div class="main-area">
        				<div id="primary" class="primary-content-area">
                   <div class="page-head">
                    <?php th_shop_mania_breadcrumb_trail();
                    the_title( '<h1 class="entry-title thunk-post-title">', '</h1>' ); ?>
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
                                            get_template_part( 'template-parts/content', 'single');?>

                                            <div class="thunk-related-links ">
                                            <?php the_post_navigation();?>
                                            </div>
                                          
                                           <?php 
                                           // Author bio.
                                            if ( 'post' === get_post_type() ) :
                                            get_template_part( 'template-parts/author-bio' );
                                            endif;
                                            // If comments are open or we have at least one comment, load up the comment template.
                                            if ( comments_open() || get_comments_number() ) :
                                            comments_template();
                                            endif;
                                            endwhile;
                                        endif;
                                        ?>
                           </div> <!-- end primary-content-wrap-->
        				</div> <!-- end primary primary-content-area-->
                        <?php 
                if($th_shop_mania_sidebar != 'no-sidebar' ):
                get_sidebar();
                endif;
                 ?><!-- end sidebar-primary  sidebar-content-area-->
        			</div> <!-- end main-area -->
        		</div>  <!-- end content-wrap -->
        	</div> 
        </div> <!-- end content page-content -->
<?php get_footer();?>