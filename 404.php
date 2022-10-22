<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ThemeHunk
 * @subpackage Th Shop Mania
 * @since 1.0.0
 */
$th_shop_mania_pro_404_layout = get_theme_mod('th_shop_mania_pro_404_layout','thsm-404-layout-2');
$th_shop_mania_404_title = get_theme_mod('th_shop_mania_404_title','404');
$th_shop_mania_404_subtitle = get_theme_mod('th_shop_mania_404_subtitle','Oops! That page can’t be found.');
$th_shop_mania_404_description = get_theme_mod('th_shop_mania_404_description','It looks like nothing was found at this location. Maybe try a search?');
$th_shop_mania_404_shortcode = get_theme_mod('th_shop_mania_404_shortcode','[featured_products]');
$th_shop_mania_404_image = esc_url(get_theme_mod('th_shop_mania_404_image',''));
$th_shop_mania_404_button_text = get_theme_mod('th_shop_mania_404_button_text','Back To Home');
$th_shop_mania_404_button_link = esc_url(get_theme_mod('th_shop_mania_404_button_link',home_url( '/' )));
$th_shop_mania_404_type = esc_html(get_theme_mod('th_shop_mania_404_type','text'));
get_header();?>
<div id="content" class="page-content <?php echo esc_attr($th_shop_mania_pro_404_layout); ?>">
        	<div class="content-wrap" >
        		<div class="container">
        			<div class="main-area">
        				<div id="primary" class="primary-content-area">
        					<div class="primary-content-wrap">
        					<div class="thunk-content-wrap">
                                <article id="error-404" >
			<div class="error-404 not-found">
				<?php	if ($th_shop_mania_404_type == 'image') { ?>
						<img src="<?php echo esc_url($th_shop_mania_404_image); ?>" class="error-404-image">
				<?php	} ?>
				<div class="error-heading">
			<?php if ($th_shop_mania_404_type == 'text' && $th_shop_mania_404_title != '') { ?>
				<h2 class="thunk-page-top-title entry-title"><?php echo esc_html($th_shop_mania_404_title); ?></h2>
			<?php	} 

			if ($th_shop_mania_404_subtitle != '') { ?>
				<h3><?php echo esc_html($th_shop_mania_404_subtitle); ?></h3>
			<?php	} ?>	
				</div><!-- .error-heading -->

				<div class="page-content">
					<?php if ($th_shop_mania_404_description != '') { ?>
						<p><?php echo esc_html($th_shop_mania_404_description); ?></p>
				<?php	} 
					 
					get_search_form(); 
					if ($th_shop_mania_404_button_text != '') { ?>
						<a href="<?php echo esc_url($th_shop_mania_404_button_link); ?>" rel="home" class="theme-button back-to"><span class="th-icon th-icon-arrow-left"></span><?php echo esc_html($th_shop_mania_404_button_text); ?></a>
				<?php	} ?>			
				</div><!-- .page-content -->

				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-404',
					'depth'          => 1,
					'container'      => 'div',
					'container_id'   => 'quick-links-404',
					'fallback_cb'    => false,
					) );
				?>
			</div><!-- .error-404 -->
          </article>
          					</div>
                           </div> <!-- end primary-content-wrap-->

                           <?php if ($th_shop_mania_pro_404_layout == 'thsm-404-layout-2') {
                            echo do_shortcode(esc_html($th_shop_mania_404_shortcode));
                        }
                            ?>
        				</div> <!-- end primary primary-content-area-->
        				<?php 
        				if ($th_shop_mania_pro_404_layout == 'thsm-404-layout-1') {
        				 	get_sidebar();
        				 }  ?><!-- end sidebar-primary  sidebar-content-area-->
        			</div> <!-- end main-area -->
        		</div>
        	</div> <!-- end content-wrap -->
        </div> <!-- end content page-content -->
<?php get_footer();?>