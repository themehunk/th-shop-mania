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
			'1.0.0'
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
			'1.0.0',
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
						aria-label="<?php echo esc_attr__( 'Close Popup', 'textdomain' ); ?>">

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

				<?php $this->render_title( $product ); ?>

				<?php $this->render_meta(); ?>

				<?php $this->render_price( $product ); ?>

				<?php $this->render_variations( $product ); ?>

				<?php $this->render_rating(); ?>

				<?php $this->render_description( $product ); ?>


				<?php do_action('thnew_quick_view_before_cart',$product);?>

				<div class="thnew-cart-wrapper">
					<?php $this->render_quantity(); ?>
					<?php $this->render_add_to_cart( $product ); ?>
				</div>

				<?php do_action( 'thnew_quick_view_after_cart',$product); ?>


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

		$gallery_ids = $product->get_gallery_image_ids();

		array_unshift(
			$gallery_ids,
			$product->get_image_id()
		);

		$gallery_ids = array_unique(
			array_filter( $gallery_ids )
		);
		?>

		<div class="thnew-qv-gallery-wrap">

			<div class="thnew-qv-gallery">

				<ul class="slides">

					<?php foreach ( $gallery_ids as $image_id ) : ?>

						<?php
						$image = wp_get_attachment_image_url(
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

				</ul>

			</div>

			<?php if ( count( $gallery_ids ) > 1 ) : ?>

				<div class="thnew-qv-thumbs">

					<ul class="slides">

						<?php foreach ( $gallery_ids as $image_id ) : ?>

							<?php
							$thumb = wp_get_attachment_image_url(
								$image_id,
								'woocommerce_gallery_thumbnail'
							);

							if ( empty( $thumb ) ) {
								continue;
							}
							?>

							<li>

								<img src="<?php echo esc_url( $thumb ); ?>"
									 alt="">

							</li>

						<?php endforeach; ?>

					</ul>

				</div>

			<?php endif; ?>

		</div>

		<?php
	}

	/**
	 * Title.
	 */
	private function render_title( $product ) {
		?>

		<h2 class="thnew-qv-title">

			<?php echo esc_html( $product->get_name() ); ?>

		</h2>

		<?php
	}

	/**
	 * Rating.
	 */
	private function render_rating() {
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
	 * Description.
	 */
	private function render_description( $product ) {
		?>

		<div class="thnew-qv-description"
			 id="th-dynamic-desc">

			<?php
			echo wp_kses_post(
				wpautop(
					$product->get_short_description()
				)
			);
			?>

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

			<?php
			echo esc_html__(
				'Add To Cart',
				'th-shop-mania'
			);
			?>

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
						'textdomain'
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
	 * Meta.
	 */
	private function render_meta() {
		?>

		<div class="thnew-qv-meta">

			<?php woocommerce_template_single_meta(); ?>

		</div>

		<?php
	}
}

new THNEW_Quick_View();