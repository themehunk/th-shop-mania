<?php
/**
 * THNEW Quick View
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class THNEW_Quick_View {

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_action(
			'wp_enqueue_scripts',
			array( $this, 'enqueue_assets' )
		);

		add_action(
			'wp_footer',
			array( $this, 'render_popup' )
		);

		add_action(
			'wp_ajax_thnew_quick_view',
			array( $this, 'quick_view_ajax' )
		);

		add_action(
			'wp_ajax_nopriv_thnew_quick_view',
			array( $this, 'quick_view_ajax' )
		);
	}

	/**
	 * Assets.
	 */
	public function enqueue_assets() {

		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		wp_enqueue_style( 'flexslider' );

		wp_enqueue_script( 'flexslider' );

		wp_enqueue_script(
			'wc-add-to-cart-variation'
		);

		wp_enqueue_style(
			'thnew-quick-view',
			get_template_directory_uri() .
			'/thnew-quick-view/thnew-quick-view.css',
			array(),
			TH_SHOP_MANIA_THEME_VERSION
		);

		wp_enqueue_script(
			'thnew-quick-view',
			get_template_directory_uri() .
			'/thnew-quick-view/thnew-quick-view.js',
			array(
				'jquery',
				'flexslider',
				'wc-add-to-cart-variation',
			),
			TH_SHOP_MANIA_THEME_VERSION,
			true
		);

		wp_localize_script(
			'thnew-quick-view',
			'thnewQuickView',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'thnew_qv_nonce' ),
			)
		);
	}

	/**
	 * Popup.
	 */
	public function render_popup() {
		?>

		<div class="thnew-popup">

			<div class="thnew-popup-overlay"></div>

			<div class="thnew-popup-wrapper">

				<button type="button"
						class="thnew-popup-close"
						aria-label="<?php echo esc_attr__( 'Close Popup', 'th-shop-mania' ); ?>">

					×
				</button>

				<div class="thnew-popup-content"></div>

			</div>

		</div>

		<?php
	}

	/**
	 * AJAX.
	 */
	public function quick_view_ajax() {

		check_ajax_referer(
			'thnew_qv_nonce',
			'nonce'
		);

		$product_id = isset( $_POST['product_id'] )
			? absint( wp_unslash( $_POST['product_id'] ) )
			: 0;

		if ( ! $product_id ) {

			wp_send_json_error();
		}

		$product = wc_get_product( $product_id );

		if ( ! $product ) {

			wp_send_json_error();
		}

		global $post;

		$post = get_post( $product_id );

		setup_postdata( $post );

		ob_start();

		$this->render_layout(
			$product,
			'style1'
		);

		wp_reset_postdata();

		wp_send_json_success(
			array(
				'html' => ob_get_clean(),
			)
		);
	}

	/**
	 * Layout Router.
	 */
	private function render_layout( $product, $layout ) {

		switch ( $layout ) {

			case 'style2':

				$this->render_layout_style2( $product );

				break;

			default:

				$this->render_layout_style1( $product );

				break;
		}
	}

	/**
	 * Layout 1.
	 */
	private function render_layout_style1( $product ) {
		?>

		<div class="thnew-qv-grid style-1">

			<div class="thnew-qv-left">

				<?php $this->render_gallery( $product ); ?>

			</div>

			<div class="thnew-qv-right">

				
				<?php $this->render_categories( $product ); ?>

				<?php $this->render_title( $product ); ?>

				<?php $this->render_price( $product ); ?>

				<?php $this->render_rating( $product ); ?>

				<?php $this->render_variations( $product ); ?>


				<?php $this->render_sku( $product ); ?>

				<?php $this->render_tags( $product ); ?>

				<?php $this->render_stock_status( $product ); ?>

				<?php do_action('thnew_quick_view_share_button'); ?>
				

				<?php $this->render_description( $product ); ?>

				<?php $this->render_long_description( $product ); ?>

				<?php do_action('thnew_quick_view_before_cart',$product);?>

				<div class="thnew-cart-wrapper">
					<?php $this->render_quantity(); ?>
					<?php $this->render_add_to_cart( $product ); ?>
					<?php
					 if( shortcode_exists( 'thwl_add_to_wishlist' )){ ?>
        <div class="thnew-qv-wishlist">
                <?php 
                    if( shortcode_exists( 'thwl_add_to_wishlist' )) {
                        echo do_shortcode('[thwl_add_to_wishlist 
                            product_id="' . esc_attr($product->id) . '" 
                            add_icon="th-icon th-icon-heart1" 
                            add_text="" 
                            add_browse_icon="th-icon th-icon-favorite"
                            browse_text=""
                            theme_style="yes"
                            icon_style="icon_only_no_style"
                            custom_class="th-wishlist-integrated"
                        ]');
                    }
                ?> 
        </div>

   <?php    } ?>


  			 <?php
			if(class_exists('th_product_compare') || class_exists('Tpcp_product_compare')){ ?>
                	<div class="thnew-qv-compare">
                		<a data-th-product-id="<?php echo ($product->id);  ?>" class="th-product-compare-btn compare">
                			<span class="th-icon th-icon-repeat"></span>
                		</a>
                	</div>
              <?php  } ?>
				</div>

				<?php do_action( 'thnew_quick_view_after_cart'); ?>


			</div>

		</div>

		<?php
	}

	/**
	 * Layout 2.
	 */
	private function render_layout_style2( $product ) {
		?>

		<div class="thnew-qv-layout2">

			<?php $this->render_gallery( $product ); ?>

			<div class="thnew-qv-layout2-right">

				<?php $this->render_title( $product ); ?>

				<?php $this->render_price( $product ); ?>

				<?php $this->render_cart_section( $product ); ?>

			</div>

		</div>

		<?php
	}

	/**
	 * Gallery.
	 */
	private function render_gallery( $product ) {

	$gallery_ids = array();

	/**
	 * Main Product Image.
	 */
	$product_image_id =
		$product->get_image_id();

	if (
		! empty( $product_image_id ) &&
		wp_attachment_is_image(
			$product_image_id
		)
	) {

		$gallery_ids[] =
			$product_image_id;
	}

	/**
	 * Gallery Images.
	 */
	$product_gallery_ids =
		$product->get_gallery_image_ids();

	if (
		! empty( $product_gallery_ids )
	) {

		foreach (
			$product_gallery_ids as $gallery_id
		) {

			if (
				wp_attachment_is_image(
					$gallery_id
				)
			) {

				$gallery_ids[] =
					$gallery_id;
			}
		}
	}

	/**
	 * Unique Images.
	 */
	$gallery_ids =
		array_unique( $gallery_ids );

	/**
	 * No Images.
	 */
	$has_images =
		! empty( $gallery_ids );

	?>

	<div class="thnew-qv-gallery-wrap">

		<div class="thnew-qv-gallery">

			<ul class="slides">

				<?php if ( $has_images ) : ?>

					<?php foreach ( $gallery_ids as $image_id ) : ?>

						<?php
						$image =
							wp_get_attachment_image_url(
								$image_id,
								'woocommerce_single'
							);

						if ( empty( $image ) ) {
							continue;
						}
						?>

						<li>

							<img class="th-gallery-image"
								 src="<?php echo esc_url( $image ); ?>"
								 alt="">

						</li>

					<?php endforeach; ?>

				<?php else : ?>

					<li>

						<img class="th-gallery-image"
							 src="<?php echo esc_url( wc_placeholder_img_src() ); ?>"
							 alt="">

					</li>

				<?php endif; ?>

			</ul>

		</div>

		

	</div>

	<?php
}

	/**
	 * Title.
	 */
	/**
 * Title.
 */
private function render_title( $product ) {

	$product_link =
		$product->get_permalink();
	?>

	<h2 class="thnew-qv-title">

		<a href="<?php echo esc_url( $product_link ); ?>">

			<?php
			echo esc_html(
				$product->get_name()
			);
			?>

		</a>

	</h2>

	<?php
}

	/**
	 * Rating.
	 */
	/**
 * Rating.
 */
private function render_rating( $product ) {

	$rating_count =
		$product->get_rating_count();

	if ( empty( $rating_count ) ) {
		return;
	}
	?>

	<div class="thnew-qv-rating">

		<?php woocommerce_template_single_rating(); ?>

	</div>

	<?php
}

	/**
	 * Price.
	 */
	private function render_price( $product ) {
		?>

		<div class="thnew-qv-price"
			 id="th-dynamic-price">

			<?php
			echo wp_kses_post(
				$product->get_price_html()
			);
			?>

		</div>

		<?php
	}

	/**
 * Stock Status.
 */
private function render_stock_status( $product ) {

	$availability =
		wc_get_stock_html(
			$product
		);

	if ( empty( $availability ) ) {
		return;
	}
	?>

	<div class="thnew-qv-stock">
		<span class="thnew-qv-meta-label">

			<?php
			esc_html_e(
				'Availability:',
				'th-shop-mania'
			);
			?>

		</span>
		<?php
		echo wp_kses_post(
			$availability
		);
		?>

	</div>

	<?php
}
	/**
	 * Description.
	 */
	/**
 * Description Accordion.
 */
private function render_description( $product ) {

	$description =
		wp_strip_all_tags(
			$product->get_short_description()
		);

	if ( empty( $description ) ) {
		return;
	}
	?>

	<div class="thnew-qv-accordion th-qv-short active">

		<button type="button"
				class="thnew-qv-accordion-title">

			<span>

				<?php
				esc_html_e(
					'Short Description',
					'th-shop-mania'
				);
				?>

			</span>

			<span class="thnew-qv-accordion-icon">

				−

			</span>

		</button>

		<div class="thnew-qv-accordion-content">

			<p>

				<?php
				echo esc_html(
					$description
				);
				?>

			</p>

		</div>

	</div>

	<?php
}

private function render_long_description( $product ) {

	$description =
		wp_strip_all_tags(
			$product->get_description()
		);

	if ( empty( $description ) ) {
		return;
	}
	?>

	<div class="thnew-qv-accordion">

		<button type="button"
				class="thnew-qv-accordion-title">

			<span>

				<?php
				esc_html_e(
					'Description',
					'th-shop-mania'
				);
				?>

			</span>

			<span class="thnew-qv-accordion-icon">

				+

			</span>

		</button>

		<div class="thnew-qv-accordion-content">

			<p>

				<?php
				echo esc_html(
					$description
				);
				?>

			</p>

		</div>

	</div>

	<?php
}

/**
 * Short Description.
 */
private function render_short_description( $product ) {

	$short_description =
		wp_strip_all_tags(
			$product->get_short_description()
		);

	if ( empty( $short_description ) ) {
		return;
	}
	?>

	<div class="thnew-qv-short-description">

		<p>

			<?php
			echo esc_html(
				$short_description
			);
			?>

		</p>

	</div>

	<?php
}

	/**
	 * Variations.
	 */
	private function render_variations( $product ) {

		if ( ! $product->is_type( 'variable' ) ) {
			return;
		}
		?>

		<div class="thnew-qv-variation-wrap">

			<?php woocommerce_variable_add_to_cart(); ?>

		</div>

		<?php
	}

	/**
	 * Quantity.
	 */
	private function render_quantity() {
		?>
		<div class="thnew-qv-sr">
		<span class="thnew-qv-label">
			<?php  esc_html_e( 'Quantity','th-shop-mania');?>

		</span>

		<div class="thnew-qv-qty-wrap">

			<button type="button"
					class="thnew-qv-minus">

				−
			</button>

			<input type="number"
				   class="qty custom-th-qty"
				   value="1"
				   min="1">

			<button type="button"
					class="thnew-qv-plus">

				+
			</button>

		</div>
		</div>

		<?php
	}

	/**
	 * Add To Cart.
	 */
	private function render_add_to_cart( $product ) {
		?>
		<button type="button"
				id="th-custom-add-to-cart"
				data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
				data-variation_id="0"
				data-quantity="1"
				class="thnew-qv-add-to-cart">

				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag stroke-[1.5px]" aria-hidden="true"><path d="M16 10a4 4 0 0 1-8 0"></path><path d="M3.103 6.034h17.794"></path><path d="M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z"></path></svg>

				<span class="text">
					<?php echo esc_html__( 'Add To Cart', 'th-shop-mania');
			?>
				</span>

		</button>

		<?php
	}

	/**
	 * Cart Section.
	 */
	private function render_cart_section( $product ) {
		?>

		<div class="thnew-qv-cart-area">

			<div class="thnew-qv-cart-header">

				<span class="thnew-qv-label">

					<?php
					esc_html_e(
						'Quantity',
						'th-shop-mania'
					);
					?>

				</span>

				<?php $this->render_quantity(); ?>

			</div>

			<div class="thnew-qv-cart-button-row">

				<?php $this->render_add_to_cart( $product ); ?>

			</div>

		</div>

		<?php
	}

	/**
	 * SKU.
	 */
private function render_sku( $product ) {

	$sku =
		$product->get_sku();

	if ( empty( $sku ) ) {
		return;
	}
	?>

	<div class="thnew-qv-sku">

		<span class="thnew-qv-meta-label">

			<?php
			esc_html_e(
				'SKU:',
				'th-shop-mania'
			);
			?>

		</span>

		<span class="thnew-qv-meta-value">

			<?php echo esc_html( $sku ); ?>

		</span>

	</div>

	<?php
}

/**
 * Categories.
 */
private function render_categories( $product ) {

	$categories =
		get_the_terms(
			$product->get_id(),
			'product_cat'
		);

	if (
		empty( $categories ) ||
		is_wp_error( $categories )
	) {
		return;
	}

	/**
	 * Limit.
	 */
	$categories =
		array_slice(
			$categories,
			0,
			3
		);
	?>

	<div class="thnew-qv-categories">


			<?php
			foreach (
				$categories as $index => $category
			) :

				$category_link =
					get_term_link(
						$category
					);

				if (
					is_wp_error(
						$category_link
					)
				) {
					continue;
				}
				?>

				<a href="<?php echo esc_url( $category_link ); ?>">

					<?php
					echo esc_html(
						$category->name
					);
					?>

				</a>

				<?php
				if (
					$index !==
					count( $categories ) - 1
				) :

					echo ', ';

				endif;

			endforeach;
			?>

		

	</div>

	<?php
}

/**
 * Tags.
 */
private function render_tags( $product ) {

	$tags =
		get_the_terms(
			$product->get_id(),
			'product_tag'
		);

	if (
		empty( $tags ) ||
		is_wp_error( $tags )
	) {
		return;
	}
	?>

	<div class="thnew-qv-tags">

		<span class="thnew-qv-meta-label">

			<?php
			esc_html_e(
				'Tags:',
				'th-shop-mania'
			);
			?>

		</span>

		<div class="thnew-qv-meta-links">

			<?php
			foreach (
				$tags as $index => $tag
			) :

				$tag_link =
					get_term_link(
						$tag
					);

				if (
					is_wp_error(
						$tag_link
					)
				) {
					continue;
				}
				?>

				<a href="<?php echo esc_url( $tag_link ); ?>">

					<?php
					echo esc_html(
						$tag->name
					);
					?>

				</a>

				<?php
				if (
					$index !==
					count( $tags ) - 1
				) :

					echo ', ';

				endif;

			endforeach;
			?>

		</div>

	</div>

	<?php
}




}

new THNEW_Quick_View();