<?php
/**
 * TH Shop Mania: Block Patterns
 *
 * @since TH Shop Mania
 */

/**
 * Registers block patterns and categories.
 *
 * @since TH Shop Mania
 *
 * @return void
 */
  function th_shop_mania_register_block_patterns() {
	$block_pattern_categories = array(
		'featured' => array( 'label' => __( 'Featured', 'th-shop-mania' ) ),
		'footer'   => array( 'label' => __( 'Footers', 'th-shop-mania' ) ),
		'header'   => array( 'label' => __( 'Headers', 'th-shop-mania' ) ),
		'query'    => array( 'label' => __( 'Query', 'th-shop-mania' ) ),
		'pages'    => array( 'label' => __( 'Pages', 'th-shop-mania' ) ),
		'thshopmania'    => array( 'label' => __( 'TH Shop Mania', 'th-shop-mania' ) ),
	);

	/**
	 * Filters the theme block pattern categories.
	 *
	 * @since TH Shop Mania
	 *
	 * @param array[] $block_pattern_categories {
	 *     An associative array of block pattern categories, keyed by category name.
	 *
	 *     @type array[] $properties {
	 *         An array of block category properties.
	 *
	 *         @type string $label A human-readable label for the pattern category.
	 *     }
	 * }
	 */
	$block_pattern_categories = apply_filters( 'thshopmania_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}

	$block_patterns = array(
		'ribbon',
		'pricing',
		'service',
		'about',
		'banner-ribbon',
		'testimonials'
	);

	if (class_exists('WooCommerce')) {
		// $block_patterns [] = 'all-products';

		array_push($block_patterns, 'all-products','new-products');
	}

	/**
	 * Filters the theme block patterns.
	 *
	 * @since TH Shop Mania
	 *
	 * @param array $block_patterns List of block patterns by name.
	 */
	$block_patterns = apply_filters( 'thshopmania_block_patterns', $block_patterns );

	foreach ( $block_patterns as $block_pattern ) {
		$pattern_file = get_theme_file_path( '/inc/patterns/' . $block_pattern . '.php' );

		register_block_pattern(
			'thshopmania/' . $block_pattern,
			require $pattern_file
		);
	}
}
add_action( 'init', 'th_shop_mania_register_block_patterns', 9 );