<?php
/**
 * Starter Content Compatibility.
 *
 * @since 1.4.2
 * @package TH Shop Mania
 */

class Th_Shop_Mania_Starter_Content {
	const HOME_SLUG     = 'home';
	const COLLECTIONS_SLUG = '#collections';
	const SALE_SLUG  = '#sale';
	const SHOP_SLUG   = '#shop';
	const OFFERS_SLUG  = '#offers';
	const REVIEWS_SLUG  = '#reviews';
	const CONTACT_SLUG  = '#contact';


	/**
	 * Run the hooks and filters.
	 */
	public function __construct() {
		$is_fresh_site = get_option( 'fresh_site' );
		if ( ! $is_fresh_site ) {
			return;
		}

		add_action(
			'wp_insert_post',
			[
				$this,
				'register_listener',
			],
			99,
			3
		); // starter content does not provide means of adding post meta so we need to adjust these.

		if ( ! is_customize_preview() ) {
			return;
		}
		add_filter(
			'default_post_metadata',
			[ $this, 'starter_meta' ],
			99,
			3
		);

	}

	/**
	 * Load default starter meta.
	 *
	 * @param mixed  $value Value.
	 * @param int    $post_id Post id.
	 * @param string $meta_key Meta key.
	 *
	 * @return string Meta value.
	 */
	public function starter_meta( $value, $post_id, $meta_key ) {
		if ( get_post_type( $post_id ) !== 'page' ) {
			return $value;
		}
		

		return $value;
	}


	/**
	 * Register listener to insert post.
	 *
	 * @param int      $post_ID Post Id.
	 * @param \WP_Post $post Post object.
	 * @param bool     $update Is update.
	 */
	public function register_listener( $post_ID, $post, $update ) {
		if ( $update ) {
			return;
		}
		$is_from_starter_content = ! empty( get_post_meta( $post_ID, '_customize_draft_post_name', true ) );
		if ( ! $is_from_starter_content ) {
			return;
		}
		if ( $post->post_type === 'page' ) {
			update_post_meta( $post_ID, 'th_shop_mania_disable_title_dyn', 'on' );
		}
	}

	/**
	 * Return starter content definition.
	 *
	 * @return mixed|void
	 */
	public function get() {

		$nav_items_header = array(
			'home'     => array(
				'type'      => 'post_type',
				'object'    => 'page',
				'object_id' => '{{' . self::HOME_SLUG . '}}',
			),
			'collections'    => array(
				'title' => __( 'Collections', 'th-shop-mania' ),
				'type'  => 'custom',
				'url'   => '{{' . self::COLLECTIONS_SLUG . '}}',
			),
			'sale' => array(
				'title' => __( 'Sale', 'th-shop-mania' ),
				'type'  => 'custom',
				'url'   => '{{' . self::SALE_SLUG . '}}',
			),
			'shop'  => array(
				'title' => __( 'Shop', 'th-shop-mania' ),
				'type'  => 'custom',
				'url'   => '{{' . self::SHOP_SLUG . '}}',
			),
			'offers'      => array(
				'title' => __( 'Offers', 'th-shop-mania' ),
				'type'  => 'custom',
				'url'   => '{{' . self::OFFERS_SLUG . '}}',
			),
			'reviews'  => array(
				'title' => __( 'Reviews', 'th-shop-mania' ),
				'type'  => 'custom',
				'url'   => '{{' . self::REVIEWS_SLUG . '}}',
			),
			'contact'  => array(
				'title' => __( 'Contact', 'th-shop-mania' ),
				'type'  => 'custom',
				'url'   => '{{' . self::CONTACT_SLUG . '}}',
			),
		);

		$content = [
			'nav_menus'   =>
				[
					'th-shop-mania-main-menu' => [
						'items' => $nav_items_header,
					],
				],
			'options'     => array(
				'page_on_front' => '{{' . self::HOME_SLUG . '}}',
				'show_on_front' => 'page',
			),
			'theme_mods'  => array(
				'th_shop_mania_theme_clr' => '#0029ff',
				// 'title_disable' 		=>	false,
				'tagline_disable'		=> false
			),
			
			'posts'       => [
				self::HOME_SLUG       => require TH_SHOP_MANIA_THEME_DIR . 'inc/starter-content/home.php',				
			],
		];


		return apply_filters( 'th_shop_mania_starter_content', $content );
	}
}
