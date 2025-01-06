<?php
get_header();
if (isset($post->ID)) {
if(empty(get_post_meta( $post->ID, 'th_shop_mania_sidebar_dyn', true ))){
$th_shop_mania_sidebar = 'no-sidebar';
}else{
$th_shop_mania_sidebar = get_post_meta( $post->ID, 'th_shop_mania_sidebar_dyn', true );
$id = $post->ID;
}
}
else{
   $th_shop_mania_sidebar = '';
}
$th_shop_mania_page_header_enable = get_theme_mod('th_shop_mania_page_header_enable',false);
$breadcrumb = get_theme_mod('th_shop_mania_pro_breadcrumb_select', 'default');
?>
<div id="content" class="page-content thunk-page <?php echo esc_attr($th_shop_mania_sidebar); ?>">
          <div class="container">
        	<div class="content-wrap" >
        			<div class="main-area">
        				<div id="primary" class="primary-content-area">
        					<div class="primary-content-wrap">
                    <?php if ($th_shop_mania_page_header_enable != true) { ?>
                    <div class="page-head">
                      <?php
                      th_shop_mania_get_page_title($id);  
                      if ($breadcrumb == 'yoast' && function_exists('yoast_breadcrumb')) {
                          yoast_breadcrumb( '<p id="breadcrumbs" class="thunk-breadcrumb">','</p>' );
                      }
                      else {
                          th_shop_mania_breadcrumb_trail();
                      } 
                      ?>
                    </div>
                  <?php } ?>
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
        	</div> 
        </div> <!-- end content page-content -->
<?php get_footer();