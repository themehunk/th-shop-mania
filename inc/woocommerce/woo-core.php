<?php
/**
 * Perform all main WooCommerce configurations for this theme
 *
 * @package Th Shop Mania WordPress theme
 */
// If plugin - 'WooCommerce' not exist then return.
if ( ! class_exists( 'WooCommerce' ) ){
	return;
}
/**
 * Th Shop Mania WooCommerce Compatibility
 */
if ( ! class_exists( 'Th_Shop_Mania_Pro_Woocommerce_Ext' ) ) :
	/**
	 * Th_Shop_Mania_Pro_Woocommerce_Ext Compatibility
	 *
	 * @since 1.0.0
	 */
	class Th_Shop_Mania_Pro_Woocommerce_Ext{

        /**
		 * Member Variable
		 *
		 * @var object instance
		 */
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
        /**
		 * Constructor
		 */
		public function __construct(){
		    add_action( 'wp_enqueue_scripts',array( $this, 'th_shop_mania_add_scripts' ));	
		    add_action( 'wp_enqueue_scripts',array( $this, 'th_shop_mania_add_style' ));	

		    add_filter( 'post_class', array( $this, 'th_shop_mania_post_class' ) );
		   
		    add_action( 'wp', array( $this, 'th_shop_mania_common_actions' ), 999 );
		    add_filter( 'open_theme_js_localize', array( $this, 'th_shop_mania_js_localize' ) );
		    // In this theme product image gallery is inserted directly so this is commented
		    // add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'th_shop_mania_product_flip_image' ), 10 );
		    // Register Store Sidebars.
			add_action( 'widgets_init', array( $this, 'th_shop_mania_store_widgets_init' ), 15 );
			add_action( 'after_setup_theme', array( $this, 'th_shop_mania_setup_theme' ) );
			// Replace Store Sidebars.
			add_filter( 'th_shop_mania_get_sidebar', array( $this, 'th_shop_mania_replace_store_sidebar' ) );
		    // quick view ajax.
			add_action( 'wp_ajax_alm_load_product_quick_view', array( $this, 'th_shop_mania_load_product_quick_view_ajax' ) );
			add_action( 'wp_ajax_nopriv_alm_load_product_quick_view', array( $this, 'th_shop_mania_load_product_quick_view_ajax' ) );
			add_action('th_shop_mania_woo_quick_view_product_summary', array( $this, 'th_shop_mania_woo_single_product_content_structure' ), 10, 1 );			
				// pagination
            add_action( 'th_shop_mania_pagination_infinite', array( $this, 'shop_page_styles' ) );
            add_action( 'th_shop_mania_pagination_infinite', array( $this, 'th_shop_mania_common_actions' ), 999 );

            add_action( 'wp_ajax_th_shop_mania_pagination_infinite', array( $this, 'th_shop_mania_pagination_infinite' ) );
            
			add_action( 'wp_ajax_nopriv_th_shop_mania_pagination_infinite', array( $this, 'th_shop_mania_pagination_infinite' ) );
			// // Custom Template Quick View.
			$this->th_shop_mania_quick_view_content_actions();
			
		   add_action( 'wp', array( $this, 'th_shop_mania_single_product_customization' ) );
           
   		//  // Alter cross-sells display
			if ( '0' != get_theme_mod( 'th_shop_mania_cross_num_col_shw', '5' ) ) {
				add_action( 'woocommerce_after_cart', array( $this, 'th_shop_mania_cross_sell_display' ) );
			}
			// Woocommerce Cart Page Customisation
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

			// add share button
			add_action( 'woocommerce_single_product_summary', array( $this, 'th_shop_mania_product_share_button_func'),90 );
		 }
		 // woocommerce sidebar
		/**
		 * Store widgets init.
		 */
		function th_shop_mania_store_widgets_init(){
			register_sidebar(array(
		              'name'          => esc_html__( 'WooCommerce Shop Page Sidebar', 'th-shop-mania' ),
		              'id'            => 'open-woo-shop-sidebar',
		              'description'   => esc_html__( 'Add widgets here to appear in your WooCommerce Sidebar.', 'th-shop-mania' ),
		              'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="th-shop-mania-widget-content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	        ) );
			register_sidebar(array(
		              'name'          => esc_html__( 'Product Page Sidebar', 'th-shop-mania' ),
		              'id'            => 'open-woo-product-sidebar',
		              'description'   => esc_html__( 'This sidebar will be used on Single Product page.', 'th-shop-mania' ),
		              'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="th-shop-mania-widget-content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	        ) );    
		}
		/**
		 * Assign shop sidebar for store page.
		 *
		 * @param String $sidebar Sidebar.
		 *
		 * @return String $sidebar Sidebar.
		 */
		function th_shop_mania_replace_store_sidebar( $sidebar ){

			if ( is_shop() || is_product_taxonomy() || is_checkout() || is_cart() || is_account_page() ){
				$sidebar = 'open-woo-shop-sidebar';
			}elseif ( is_product() ){
				$sidebar = 'open-woo-product-sidebar';
			}
			return $sidebar;
		}
       /**
		 * Setup theme
		 *
		 * @since 1.0.3
		 */
		function th_shop_mania_setup_theme(){
			// WooCommerce.
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}
		/**
		 * Product Flip Image (with hook you can insert image gallery in product on shop page)
		 */
		function th_shop_mania_product_flip_image(){
			global $product;
			$hover_style = get_theme_mod( 'th_shop_mania_woo_product_animation' );

			if ( 'swap' === $hover_style ) {

				$attachment_ids = $product->get_gallery_image_ids();

				if ( $attachment_ids ) {

					$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' );

        			$image_html = apply_filters( 'open_woocommerce_th_shop_mania_product_flip_image', wp_get_attachment_image( reset( $attachment_ids ), $image_size, false, array( 'class' => 'show-on-hover' ) ) );

        			echo wp_kses_post( $image_html );
					// echo  $image_html ;
				}
			}
			if ('slide' === $hover_style ) {

				$attachment_ids = $product->get_gallery_image_ids();

				if ( $attachment_ids ) {

					$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' );

					$image_html = apply_filters( 'th_shop_mania_woocommerce_product_flip_image', wp_get_attachment_image( reset( $attachment_ids ), $image_size, false, array( 'class' => 'show-on-slide' ) ) );
				
					echo wp_kses_post( $image_html );
					// echo  $image_html ;
				}
			}
		}	
		/**
		 * Post Class
		 *
		 * @param array $classes Default argument array.
		 *
		 * @return array;
		 */
		function th_shop_mania_post_class( $classes ) {
    // Only run inside WooCommerce product loops (shop, archive, related, upsell, cross-sell)
    if ( !( is_product() && function_exists( 'wc_get_loop_prop' ) && !wc_get_loop_prop( 'name' ) )) {

        if ( ! th_shop_mania_is_blog() || is_shop() || is_product_taxonomy() ) {
            $classes[] = 'thunk-woo-product-list';

            $qv_enable = get_theme_mod( 'th_shop_mania_woo_quickview_enable', false );
            if ( true == $qv_enable ) {
                $classes[] = 'opn-qv-enable';
            }
        }

        $hover_style = get_theme_mod( 'th_shop_mania_woo_product_animation' );
        if ( '' !== $hover_style ) {
            $classes[] = 'th-shop-mania-woo-hover-' . esc_attr( $hover_style );
        }

        $single_product_tab_style = get_theme_mod( 'th_shop_mania_single_product_tab_layout', 'horizontal' );
        if ( '' !== $single_product_tab_style ) {
            $classes[] = 'open-single-product-tab-' . esc_attr( $single_product_tab_style );
        }

        $shadow_style = get_theme_mod( 'th_shop_mania_product_box_shadow' );
        if ( '' !== $shadow_style ) {
            $classes[] = 'open-shadow-' . esc_attr( $shadow_style );
        }

        $shadow_hvr_style = get_theme_mod( 'th_shop_mania_product_box_shadow_on_hover' );
        if ( '' !== $shadow_hvr_style ) {
            $classes[] = 'open-shadow-hover-' . esc_attr( $shadow_hvr_style );
        }

        // Hover effects only when gallery images exist
        if ( in_array( $hover_style, array( 'swap', 'slide' ), true ) && ! is_front_page() && ! is_admin() && ! th_shop_mania_is_blog() ) {
            global $product;
            if ( $product instanceof WC_Product ) {
                $attachment_ids = $product->get_gallery_image_ids();
                if ( count( $attachment_ids ) > 0 ) {
                    $classes[] = 'th-shop-mania-' . $hover_style . '-item-hover';
                }
            }
        }

        if ( function_exists( 'th_shop_mania_pro_load_plugin' ) ) {
            $single_product_style = get_theme_mod( 'th_shop_mania_single_product_alignment', 'left' );
            $classes[] = 'th-shop-mania-single-product-content-' . esc_attr( $single_product_style );
        }
    }

    return $classes;
}

		/**
		 * Infinite Products Show on scroll
		 *
		 * @since 1.1.0
		 * @param array $localize   JS localize variables.
		 * @return array
		 */
		function th_shop_mania_js_localize( $localize ){
			global $wp_query;
			$th_shop_mania_pagination               = (string)get_theme_mod( 'th_shop_mania_pagination' );
			$localize['ajax_url']                   = esc_url(admin_url( 'admin-ajax.php' ));
			$localize['is_cart']                    = is_cart();
			$localize['is_single_product']          = is_product();
			$localize['query_vars']                 = json_encode( $wp_query->query );
			$localize['shop_quick_view_enable']     = (bool)get_theme_mod('th_shop_mania_woo_quickview_enable',false );
			$localize['shop_infinite_nonce']        = wp_create_nonce( 'opn-shop-load-more-nonce' );
			$localize['shop_infinite_count']        = 2;
			$localize['shop_infinite_total']        = $wp_query->max_num_pages;
			$localize['shop_pagination']            = $th_shop_mania_pagination;
			$localize['shop_infinite_scroll_event'] = $th_shop_mania_pagination;
			$localize['query_vars']                 = json_encode( $wp_query->query );
			$localize['shop_no_more_post_message']  = apply_filters( 'th_shop_mania_no_more_product_text', __( 'No more products to show.', 'th-shop-mania' ) );
			return $localize;			
		}
       /**
		 * Common Actions.
		 *
		 * @since 1.1.0
		 * @return void
		 */
		function th_shop_mania_common_actions(){
			// Shop Pagination.
			$this->shop_pagination();
			// Quick View.
			$this->th_shop_mania_shop_init_quick_view();
		}
		/**
		 * Init Quick View
		 */
		function th_shop_mania_shop_init_quick_view(){
			$qv_enable = get_theme_mod( 'th_shop_mania_woo_quickview_enable',false );
			if ( true == $qv_enable ){
				add_filter( 'open_theme_js_localize', array( $this, 'th_shop_mania_th_shop_mania_qv_js_localize' ) );
				add_action( 'quickview', array( $this,'th_shop_mania_add_quick_view_on_img' ),15);
				// load modal template.
				add_action( 'wp_footer', array( $this, 'th_shop_mania_quick_view_html' ) );
			}
		}
		/**
		 * Add Scripts
		 */
		function th_shop_mania_add_scripts(){
		   wp_enqueue_script( 'th-shop-mania-woocommerce-js', TH_SHOP_MANIA_THEME_URI .'inc/woocommerce/js/woocommerce.js', array( 'jquery' ), '2.0.0', array('in_footer' => true,'strategy'  => 'defer',) );
           
           wp_enqueue_script('open-quick-view', TH_SHOP_MANIA_THEME_URI.'inc/woocommerce/quick-view/js/quick-view.js', array( 'jquery' ), '', array('in_footer' => true,'strategy'  => 'defer',) );
           wp_localize_script('open-quick-view', 'thlocalizeqv', array('ajaxurl' => esc_url(admin_url( 'admin-ajax.php' ))));      
		   }
		/**
		 * Add Style
		 */
		function th_shop_mania_add_style(){
        wp_enqueue_style( 'open-quick-view', TH_SHOP_MANIA_THEME_URI. 'inc/woocommerce/quick-view/css/quick-view.css', null, '');
		}
        /**
		 * Quick view localize.
		 *
		 * @since 1.0
		 * @param array $localize   JS localize variables.
		 * @return array
		 */
		function th_shop_mania_th_shop_mania_qv_js_localize( $localize ){
			global $wp_query;
			$loader = '';
			if ( ! isset( $localize['ajax_url'] ) ){
				$localize['ajax_url'] = admin_url( 'admin-ajax.php', 'relative' );
			}
			$localize['qv_loader'] = $loader;
			return $localize;
		}
		/**
		 * Quick view on image
		 */
		function th_shop_mania_add_quick_view_on_img(){
			global $product;
            $button='';
			$product_id = $product->get_id();

			// Get label.
			$label = __( 'Quick View', 'th-shop-mania' );
			?>
			<div class="thunk-quik">
			             <div class="thunk-quickview">
                               <span class="quik-view">
                                   <a href="#" class="opn-quick-view-text" data-product_id="<?php echo esc_attr($product_id); ?>"><div th-tooltip="<?php echo esc_attr__('Quick View', 'th-shop-mania'); ?>" class="quik-view-tooltip">
                                   	  <span class="th-icon th-icon-eye"></span>
                                      <span class="qv-text"><?php echo esc_html($label); ?></span>
                                      </div>
                                    
                                   </a>
                            </span>
                          </div>
            </div>
            <?php
			// $button = apply_filters( 'open_woo_add_quick_view_text_html', $button, $label, $product );
			// echo $button;
		}
		/**
		 * Quick view html
		 */
		function th_shop_mania_quick_view_html(){
			$this->th_shop_mania_quick_view_dependent_data();
			require_once TH_SHOP_MANIA_THEME_DIR . 'inc/woocommerce/quick-view/quick-view-modal.php';
		}
		/**
		 * Quick view dependent data
		 */
		function th_shop_mania_quick_view_dependent_data(){
			wp_enqueue_script( 'wc-add-to-cart-variation' );
			wp_enqueue_script( 'flexslider' );
		}
        /**
		 * Quick view ajax
		 */
		function th_shop_mania_load_product_quick_view_ajax(){
			if ( ! isset( $_REQUEST['product_id'] ) ){
				die();
			}
			$product_id = intval( $_REQUEST['product_id'] );
			// set the main wp query for the product.
			wp( 'p=' . $product_id . '&post_type=product' );
			// remove product thumbnails gallery.
			remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
			ob_start();
			// load content template.
			require_once TH_SHOP_MANIA_THEME_DIR . 'inc/woocommerce/quick-view/quick-view-product.php';
			// echo ob_get_clean();
			$content = ob_get_clean();

    		echo wp_kses_post( $content ); // Proper escaping applied
			die();
		}
		/**
		 * Quick view actions
		 */
		public function th_shop_mania_quick_view_content_actions(){
			// Image.
			add_action('th_shop_mania_woo_qv_product_image', 'woocommerce_show_product_sale_flash', 10 );
			add_action('th_shop_mania_woo_qv_product_image', array( $this, 'th_shop_mania_qv_product_images_markup' ), 20 );
		} 		
		/**
		 * Footer markup.
		 */
		function th_shop_mania_qv_product_images_markup(){
           require_once TH_SHOP_MANIA_THEME_DIR . 'inc/woocommerce/quick-view/quick-view-product-image.php';
		}
        function th_shop_mania_woo_single_product_content_structure(){
							/**
							 * Add Product Title on single product page for all products.
							 */
							do_action( 'th_shop_mania_woo_single_title_before' );
							woocommerce_template_single_title();
							do_action( 'th_shop_mania_woo_single_title_after' );
							/**
							 * Add Product Price on single product page for all products.
							 */
							do_action( 'th_shop_mania_woo_single_price_before' );
							woocommerce_template_single_price();
							do_action( 'th_shop_mania_woo_single_price_after' );
							/**
							 * Add rating on single product page for all products.
							 */
							do_action( 'th_shop_mania_woo_single_rating_before' );
							woocommerce_template_single_rating();
							do_action( 'th_shop_mania_woo_single_rating_after' );
							
							do_action( 'th_shop_mania_woo_single_short_description_before' );
							woocommerce_template_single_excerpt();
							do_action( 'th_shop_mania_woo_single_short_description_after' );
							
							do_action( 'th_shop_mania_woo_single_add_to_cart_before' );
							woocommerce_template_single_add_to_cart();
							do_action( 'th_shop_mania_woo_single_add_to_cart_after' );
							
							do_action( 'th_shop_mania_woo_single_category_before' );
							woocommerce_template_single_meta();
							do_action( 'th_shop_mania_woo_single_category_after' );			
		}

        /**
		 * Single Product customization.
		 *
		 * @return void
		 */
		function th_shop_mania_single_product_customization(){
			if ( ! is_product() ){
				return;
			}

			$single_product_layout = get_theme_mod('th_shop_mania_pro_single_product_layout','standard');
			if ($single_product_layout == 'twocolumn' && function_exists('th_shop_mania_pro_load_plugin')) {
				// Single Product Two Column Customization.
				add_filter('woocommerce_product_description_heading', '__return_empty_string');
            add_filter('woocommerce_product_reviews_heading', '__return_empty_string');
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

				add_action( 'woocommerce_before_single_product_summary', 'woocommerce_output_product_data_tabs',108 );


				add_action( 'woocommerce_before_single_product_summary', 'th_shop_mania_start_left_side', 5 );
				function th_shop_mania_start_left_side() {
				  echo '<div class="left-side">';
				}
				add_action( 'woocommerce_before_single_product_summary', 'th_shop_mania_end_left_side', 40 );
				function th_shop_mania_end_left_side() {
				  echo '</div>';
				}

				add_action( 'woocommerce_before_single_product_summary', 'th_shop_mania_start_right_side', 41 );
				function th_shop_mania_start_right_side() {
				  echo '<div class="right-side">';
				}
				add_action( 'woocommerce_after_single_product_summary', 'th_shop_mania_end_right_side', 7 );
				function th_shop_mania_end_right_side() {
				  echo '</div>';
				}
			}
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
            add_filter('woocommerce_product_description_heading', '__return_empty_string');
            add_filter('woocommerce_product_reviews_heading', '__return_empty_string');
            add_filter('woocommerce_product_additional_information_heading', '__return_empty_string');   
			/* Display Related Products */
			if ( ! get_theme_mod( 'th_shop_mania_related_product_display',true ) && (function_exists('th_shop_mania_pro_load_plugin')) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			}
			/* Display upsell Products */
			if ( ! get_theme_mod( 'th_shop_mania_upsell_product_display',true ) && (function_exists('th_shop_mania_pro_load_plugin')) ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 20 );
			}
			if(get_theme_mod( 'th_shop_mania_upsell_product_display',true )==true || (!function_exists('th_shop_mania_pro_load_plugin'))){
			  add_action( 'woocommerce_after_single_product_summary',array( $this, 'th_shop_mania_woocommerce_output_upsells' ),15);
             }else{
             remove_action( 'woocommerce_after_single_product_summary',array( $this, 'th_shop_mania_woocommerce_output_upsells' ));	
             }
             add_filter( 'woocommerce_output_related_products_args', array( $this, 'th_shop_mania_related_no_col_product_show' ) );
             	/**
 				* Remove "Description" Heading Title @ WooCommerce Single Product Tabs
 				*/
			add_filter( 'woocommerce_product_description_heading', '__return_null' );

			add_filter( 'woocommerce_get_availability', array( $this, 'th_shop_mania_override_get_availability'),10, 2 );
		}

		  /**
		 * Single Product customization.
		 *
		 * @return void
		 */
		function th_shop_mania_single_product_two_column_customization(){
			if ( ! is_product() ){
				return;
			}
				add_filter('woocommerce_product_description_heading', '__return_empty_string');
            add_filter('woocommerce_product_reviews_heading', '__return_empty_string');
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

				add_action( 'woocommerce_before_single_product_summary', 'woocommerce_output_product_data_tabs',40 );


				add_action( 'woocommerce_before_single_product_summary', 'th_shop_mania_start_left_side', 5 );
				function th_shop_mania_start_left_side() {
				  echo '<div class="left-side">';
				}
				add_action( 'woocommerce_before_single_product_summary', 'th_shop_mania_end_left_side', 40 );
				function th_shop_mania_end_left_side() {
				  echo '</div>';
				}

				add_action( 'woocommerce_before_single_product_summary', 'th_shop_mania_start_right_side', 41 );
				function th_shop_mania_start_right_side() {
				  echo '<div class="right-side">';
				}
				add_action( 'woocommerce_after_single_product_summary', 'th_shop_mania_end_right_side', 7 );
				function th_shop_mania_end_right_side() {
				  echo '</div>';
				}
				
		}
	    /*****************/
		// upsale product
       /*****************/
		function th_shop_mania_woocommerce_output_upsells(){
		$upsell_columns = get_theme_mod('th_shop_mania_upsale_num_col_shw','5');
		$upsell_no_product = get_theme_mod( 'th_shop_mania_upsale_num_product_shw','5');	
        woocommerce_upsell_display($upsell_no_product,$upsell_columns); // Display max 3 products, 3 per row
         }
        /*****************************/ 
        // realted product argument pass
        /*****************************/ 
        function th_shop_mania_related_no_col_product_show( $args){
		$rel_columns = get_theme_mod('th_shop_mania_related_num_col_shw','5');
		$rel_no_product = get_theme_mod( 'th_shop_mania_related_num_product_shw','5');
		$args['posts_per_page'] = $rel_no_product; // related products
	    $args['columns'] = $rel_columns; // arranged in columns
	    return $args;
		}   
        /**
		 * Shop page view list and grid view.
		 */
        function th_shop_mania_before_shop_loop(){
        $viewshow = get_theme_mod('th_shop_mania_prd_view','grid-view');
        echo '<div class="thunk-list-grid-switcher">';
        if($viewshow == 'grid-view'){
             echo '<a title="' . esc_attr__('Grid View', 'th-shop-mania') . '" href="#" data-type="grid" class="thunk-grid-view selected"><i class="fa fa-th"></i></a>';

             echo '<a title="' . esc_attr__('List View', 'th-shop-mania') . '" href="#" data-type="list" class="thunk-list-view"><i class="fa fa-bars"></i></a>';
        }else{
        	  echo '<a title="' . esc_attr__('Grid View', 'th-shop-mania') . '" href="#" data-type="grid" class="thunk-grid-view"><i class="fa fa-th"></i></a>';

             echo '<a title="' . esc_attr__('List View', 'th-shop-mania') . '" href="#" data-type="list" class="thunk-list-view selected"><i class="fa fa-bars"></i></a>';
        }
        echo '</div>';
        }
        // shop page content
        function th_shop_mania_list_after_shop_loop_item(){
        ?>
         <div class="os-product-excerpt"><?php the_excerpt(); ?></div>
        <?php   
        }
		/**
		 * Change products per row for crossells.
		 */
		 function th_shop_mania_cross_sell_display(){
			// Get count
			$count = get_theme_mod( 'th_shop_mania_cross_num_product_shw', '5' );
			$count = $count ? $count : '5';
			// Get columns
			$columns = get_theme_mod( 'th_shop_mania_cross_num_col_shw', '5' );
			$columns = $columns ? $columns : '5';
			// Alter cross-sell display
			woocommerce_cross_sell_display( $count, $columns );
		} 
        /**************************
		 * Shop Pagination.
		 **************************/
		function th_shop_mania_pagination_infinite(){
         	check_ajax_referer( 'opn-shop-load-more-nonce', 'nonce' );
			do_action( 'th_shop_mania_pagination_infinite' );
			$query_vars                   = json_decode( stripslashes( $_POST['query_vars'] ), true );
			$query_vars['paged']          = isset( $_POST['page_no'] ) ? absint( $_POST['page_no'] ) : 1;
			$query_vars['post_status']    = 'publish';
			$query_vars['posts_per_page'] = wc_get_default_products_per_row() * wc_get_default_product_rows_per_page();
			$query_vars                   = array_merge( $query_vars, wc()->query->get_catalog_ordering_args() );
			$posts = new WP_Query( $query_vars );

			if ( $posts->have_posts() ) {
				while ( $posts->have_posts() ) {
					$posts->the_post();
					/**
					 * Woocommerce: woocommerce_shop_loop hook.
					 *
					 * @hooked WC_Structured_Data::generate_product_data() - 10
					 */
					do_action( 'woocommerce_shop_loop' );

					
					wc_get_template_part( 'content', 'product' );
				}
			}
			wp_reset_query();

			wp_die();
        }

        function shop_pagination(){
			$pagination = get_theme_mod( 'th_shop_mania_pagination','num' );
			if ( ('click' == $pagination || 'scroll' == $pagination ) && function_exists('th_shop_mania_pro_load_plugin') ){
				remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
				add_action( 'woocommerce_after_shop_loop', array( $this, 'th_shop_mania_pagination' ), 10 );
			}
		}
       function th_shop_mania_pagination( $output ){
			global $wp_query;
			$infinite_event = get_theme_mod( 'th_shop_mania_pagination' );
			$load_more_text = get_theme_mod( 'th_shop_mania_pagination_loadmore_btn_text',__( 'Load More','th-shop-mania'));
			if ( '' === $load_more_text ){
				$load_more_text = __( 'Load More', 'th-shop-mania' );
			}
			if ( $wp_query->max_num_pages > 1 ){
				?>
				<nav class="opn-shop-pagination-infinite">
					<span class="inifiniteLoader"><div class="loader"></div></span>
					<?php if ( 'click' == $infinite_event ){ ?>
						
							<div class="th-shop-mania-load-more">
								<button id="load-more-product" class="load-more-product-button thunk-button opn-shop-load-more active">
									<?php echo esc_html( apply_filters( 'open_load_more_text', $load_more_text ) ); ?>
								</button>

							</div>
							
					<?php } ?>
				</nav>
				<?php
			}
		}
        /**
		 * Shop page template.
		 *
		 * @since 1.0.0
		 * @return void if not a shop page.
		 */
		function shop_page_styles(){
			$is_ajax_pagination = $this->is_ajax_pagination();
			if ( ! ( is_shop() || is_product_taxonomy() ) && ! $is_ajax_pagination ) {
				return;
			}
		}
		/**
		 * Check if ajax pagination is calling.
		 *
		 * @return boolean classes
		 */
		function is_ajax_pagination(){
			$pagination = false;
			if ( isset( $_POST['open_infinite'] ) && wp_doing_ajax() && check_ajax_referer( 'opn-shop-load-more-nonce', 'nonce', false ) ){
				$pagination = true;
			}
			return $pagination;
		}

		// The hook in function $availability is passed via the filter!
		function th_shop_mania_override_get_availability( $availability, $_product ) {
		if ( $_product->is_in_stock() ) $availability['availability'] = __('(In Stock)', 'th-shop-mania');
		return $availability;
		}
		//Share Icon on Product Single Page
		function th_shop_mania_product_share_button_func() { 
		echo'<div class="social-share"><h3>'.esc_html__('Share','th-shop-mania').'</h3><ul>'?>
		 <li class="fb-icon"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php esc_url(the_permalink()); ?>"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 2C6.5 2 2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12c0-5.5-4.5-10-10-10z"></path></svg></a></li>
		 <li class="twt-icon">
	    <a target="_blank" href="https://twitter.com/intent/tweet?url=<?php esc_url(the_permalink()); ?>&text=<?php the_title(); ?>">
	        <svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
	            <path d="M13.982 10.622 20.54 3h-1.554l-5.693 6.618L8.745 3H3.5l6.876 10.007L3.5 21h1.554l6.012-6.989L15.868 21h5.245l-7.131-10.378Zm-2.128 2.474-.697-.997-5.543-7.93H8l4.474 6.4.697.996 5.815 8.318h-2.387l-4.745-6.787Z"></path>
	        </svg>
	    </a>
		</li>
		 <li class="pinterest-icon"><a data-pin-do="skipLink" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php esc_url(the_permalink()); ?>&amp;media=&amp;description=<?php the_title(); ?>"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12.289,2C6.617,2,3.606,5.648,3.606,9.622c0,1.846,1.025,4.146,2.666,4.878c0.25,0.111,0.381,0.063,0.439-0.169 c0.044-0.175,0.267-1.029,0.365-1.428c0.032-0.128,0.017-0.237-0.091-0.362C6.445,11.911,6.01,10.75,6.01,9.668 c0-2.777,2.194-5.464,5.933-5.464c3.23,0,5.49,2.108,5.49,5.122c0,3.407-1.794,5.768-4.13,5.768c-1.291,0-2.257-1.021-1.948-2.277 c0.372-1.495,1.089-3.112,1.089-4.191c0-0.967-0.542-1.775-1.663-1.775c-1.319,0-2.379,1.309-2.379,3.059 c0,1.115,0.394,1.869,0.394,1.869s-1.302,5.279-1.54,6.261c-0.405,1.666,0.053,4.368,0.094,4.604 c0.021,0.126,0.167,0.169,0.25,0.063c0.129-0.165,1.699-2.419,2.142-4.051c0.158-0.59,0.817-2.995,0.817-2.995 c0.43,0.784,1.681,1.446,3.013,1.446c3.963,0,6.822-3.494,6.822-7.833C20.394,5.112,16.849,2,12.289,2"></path></svg></a></li>
		 <li class="linked-icon"><a target="_blank" href="https://www.linkedin.com/shareArticle?url=<?php esc_url(the_permalink()); ?>&title=<?php the_title(); ?>"><svg width="24" height="24" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M19.7,3H4.3C3.582,3,3,3.582,3,4.3v15.4C3,20.418,3.582,21,4.3,21h15.4c0.718,0,1.3-0.582,1.3-1.3V4.3 C21,3.582,20.418,3,19.7,3z M8.339,18.338H5.667v-8.59h2.672V18.338z M7.004,8.574c-0.857,0-1.549-0.694-1.549-1.548 c0-0.855,0.691-1.548,1.549-1.548c0.854,0,1.547,0.694,1.547,1.548C8.551,7.881,7.858,8.574,7.004,8.574z M18.339,18.338h-2.669 v-4.177c0-0.996-0.017-2.278-1.387-2.278c-1.389,0-1.601,1.086-1.601,2.206v4.249h-2.667v-8.59h2.559v1.174h0.037 c0.356-0.675,1.227-1.387,2.526-1.387c2.703,0,3.203,1.779,3.203,4.092V18.338z"></path></svg></a></li>
		 <!-- Copy Link -->
		<li class="copy-link-icon">
		    <button class="copy-product-link" data-link="<?php echo esc_url(get_permalink()); ?>" aria-label="Copy Link">
		        <span class="dashicons dashicons-admin-links"></span>
		    </button>
		</li>

		 <?php echo'</ul> 
		</div>';
}
	}
endif;
Th_Shop_Mania_Pro_Woocommerce_Ext::get_instance();