<?php
/**
 * Template part for displaying single post
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package  Th Shop Mania
 * @since 1.0.0
 */
$th_shop_mania_blog_single_image = get_theme_mod('th_shop_mania_blog_single_image',false);
?>
<article class="thunk-article ">
	<div class="entry-content">
					<div class="post-content-outer-wrapper">
						<div class="thunk-posts-description">
							<?php if ($th_shop_mania_blog_single_image) { ?>
							<div class="thunk-post-img-wrapper">
								<div class="thunk-post-img">
								<?php the_post_thumbnail(); ?>
						  		</div>
					   		</div>
					   	<?php } ?>
					   
					<div class="thunk-post-meta">
						<div class="th-post-categ"><span><?php the_category(' '); ?></span></div>
						<div class="thunk-post-info">
							<span><?php the_author_posts_link(); ?></span>
						    
						    <span><?php echo wp_kses_post(get_the_date()); ?></span>
					     </div>
					   </div>
					<div class="thunk-post-excerpt">
								<?php
				the_content( sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'th-shop-mania' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				) );

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'th-shop-mania' ),
					'after'  => '</div>',
				) );
			?>
						</div>
						
			</div> <!-- thunk-posts-description end -->
		</div> <!-- post-content-outer-wrapper end -->
	</div>
                                       <div class="thunk-post-footer">
                                                <?php if (has_tag()) { ?>
                                                <div class="thunk-tags-wrapper">
                                                    <?php
                                                        the_tags( 'Tag : ', ' ', ' ' );
                                                    ?>
                                                </div>
                                            <?php } ?>
                                       </div> <!-- thunk-post-footer end -->
</article>