<?php
// If plugin - 'WooCommerce' not exist then return.
if (!class_exists('WooCommerce')) {
  return;
}
if (!function_exists('th_shop_mania_whishlist_url')) {
  function th_shop_mania_whishlist_url($argu = '')
  {
    $wishlist_page_id   =  get_option('yith_wcwl_wishlist_page_id');
    $wishlist_permalink = get_the_permalink($wishlist_page_id);
    return $wishlist_permalink;
  }
  add_filter('th_shop_mania_whishlist_url', 'th_shop_mania_whishlist_url');
}
// display admin name
if (!function_exists('th_shop_mania_display_admin_name')) {
  function th_shop_mania_display_admin_name()
  {
    $user = wp_get_current_user();
    echo esc_html($user->display_name);
  }
}
/*******************************/
/** Sidebar Add Cart Product **/
/*******************************/
if (!function_exists('th_shop_mania_cart_total_item')) {
  /**
   * Cart Link
   * Displayed a link to the cart including the number of items present and the cart total
   */
  function th_shop_mania_cart_total_item()
  {
    if (shortcode_exists('taiowc')) { ?>
      <div class="cart-contents">
        <?php echo do_shortcode('[taiowc]'); ?>
      </div>
    <?php }
  }
  add_action('th_shop_mania_cart_total_item', 'th_shop_mania_cart_total_item');
}
/** My Account Menu **/
if (!function_exists('th_shop_mania_account')) {
  function th_shop_mania_account()
  { ?>
    <a class="account" href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"><span class="th-icon th-icon-user"></span>
      </a>

        <?php  if( shortcode_exists( 'thsmw-popup' ) ){
              do_shortcode("[thsmw-popup popup='Popup-2']");
          } ?>
  <?php }
  add_action('th_shop_mania_account', 'th_shop_mania_account');
}
/***************/
// single page
/***************/
if (!function_exists('th_shop_mania_single_summary_start')) {
  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_single_summary_start()
  {

    echo '<div class="thunk-single-product-summary-wrap single">';
  }
}
if (!function_exists('th_shop_mania_single_summary_end')) {
  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_single_summary_end()
  {
    echo '</div>';
  }
}
add_action('woocommerce_before_single_product_summary', 'th_shop_mania_single_summary_start', 0);
add_action('woocommerce_after_single_product_summary', 'th_shop_mania_single_summary_end', 0);
//Below lines are to show meta tab right side of product image
// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
// add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs',40 );
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// add_filter( 'woocommerce_product_tabs', 'th_shop_mania_woocommerce_custom_product_tabs', 40 );
function th_shop_mania_woocommerce_custom_product_tabs($tabs)
{
  $tabs['delivery_information'] = array(
    'title'     => __('Meta Information', 'th-shop-mania'),
    'priority'  => 10,
    'callback'  => 'woocommerce_product_meta_tab'
  );
  return $tabs;
}
function woocommerce_product_meta_tab()
{ // this is where you indicate what appears in the description tab
  wc_get_template('single-product/meta.php'); // The meta content first
}
/**
 * Add next/prev buttons @ WooCommerce Single Product Page
 */
add_action('woocommerce_before_single_product_summary', 'th_shop_mania_prev_next_product', 0);

// and if you also want them at the bottom...
// add_action( 'woocommerce_single_product_summary', 'th_shop_mania_prev_next_product',0 );

function th_shop_mania_prev_next_product()
{
  echo '<div class="prev_next_buttons">';
  // 'product_cat' will make sure to return next/prev from current category
  $previous = next_post_link('%link', '&larr;', false, ' ', 'product_cat');
  $next = previous_post_link('%link', '&rarr;', false, ' ', 'product_cat');

  echo $previous;
  echo $next;

  echo '</div>';
}
// Plus Minus Quantity Buttons @ WooCommerce Single Product Page
add_action('woocommerce_before_add_to_cart_quantity', 'th_shop_mania_display_quantity_minus', 10, 2);
function th_shop_mania_display_quantity_minus()
{
  global $product;
  if ($product->get_sold_individually() != '1') :
    echo '<div class="th-shop-mania-quantity"><button type="button" class="minus" >-</button>';
  endif;
}
add_action('woocommerce_after_add_to_cart_quantity', 'th_shop_mania_display_quantity_plus', 10, 2);
function th_shop_mania_display_quantity_plus()
{
  global $product;
  if ($product->get_sold_individually() != '1') :
    echo '<button type="button" class="plus" >+</button></div>';
  endif;
}
//Woocommerce: How to remove page-title at the home/shop page archive & category pages
add_filter('woocommerce_show_page_title', '__return_null');

function th_shop_mania_not_a_shop_page()
{
  return boolval(!is_shop());
}
//***********************/
// product category list
//************************/
if (!function_exists('th_shop_mania_product_list_categories')) {
  function th_shop_mania_product_list_categories($args = '')
  {
    $term = get_theme_mod('th_shop_mania_exclde_category', '');
    if(!empty($term['0'])){

  $exclude_id = $term;

  $list_pluck = wp_list_pluck(get_terms(), 'term_id');

  $list_pluck_include  = array_diff($list_pluck, $exclude_id);

  }else{

  $exclude_id = '';
  $list_pluck_include = 'all';

  }
    $defaults = array(
      'include' => $list_pluck_include,
      'child_of'            => 0,
      'current_category'    => 0,
      'depth'               => '5',
      'echo'                => 0,
      'exclude'             => $exclude_id,
      'exclude_tree'        => $exclude_id,
      'feed'                => '',
      'feed_image'          => '',
      'feed_type'           => '',
      'hide_empty'          => 1,
      'hide_title_if_empty' => false,
      'hierarchical'        => true,
      'order'               => 'ASC',
      'orderby'             => 'menu_order',
      'separator'           => '<br />',
      'show_count'          => 0,
      'show_option_all'     => '',
      'show_option_none'    => __('No categories', 'th-shop-mania'),
      'style'               => 'list',
      'taxonomy'            => 'product_cat',
      'title_li'            => '',
      'use_desc_for_title'  => 0,
    );
    $html = wp_list_categories($defaults);
    echo '<ul class="product-cat-list thunk-product-cat-list" data-menu-style="vertical">' . $html . '</ul>';
  }
}
if (!function_exists('th_shop_mania_product_list_categories_mobile')) {
  function th_shop_mania_product_list_categories_mobile($args = '')
  {
    $term = get_theme_mod('th_shop_mania_exclde_category');
    if(!empty($term['0'])){

  $exclude_id = $term;

  $list_pluck = wp_list_pluck(get_terms(), 'term_id');

  $list_pluck_include  = array_diff($list_pluck, $exclude_id);

  }else{

  $exclude_id = '';
  $list_pluck_include = 'all';

  }
    $defaults = array(
      'include' => $list_pluck_include,
      'child_of'            => 0,
      'current_category'    => 0,
      'depth'               => 5,
      'echo'                => 0,
      'exclude'             => $exclude_id,
      'exclude_tree'        => $exclude_id,
      'feed'                => '',
      'feed_image'          => '',
      'feed_type'           => '',
      'hide_empty'          => 1,
      'hide_title_if_empty' => false,
      'hierarchical'        => true,
      'order'               => 'ASC',
      'orderby'             => 'menu_order',
      'separator'           => '<br />',
      'show_count'          => 0,
      'show_option_all'     => '',
      'show_option_none'    => __('No categories', 'th-shop-mania'),
      'style'               => 'list',
      'taxonomy'            => 'product_cat',
      'title_li'            => '',
      'use_desc_for_title'  => 0,
    );
    $html = wp_list_categories($defaults);
    echo '<ul class="mob-product-cat-list thunk-product-cat-list mobile" data-menu-style="accordion">' .wp_kses_post($html). '</ul>';
  }
}
/**********************************/
//Shop Product Markup
/**********************************/
if (!function_exists('th_shop_mania_pro_product_meta_start')) {
  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_meta_start()
  {
    echo '<div class="thunk-product-wrap"><div class="thunk-product">';
  }
}
if (!function_exists('th_shop_mania_pro_product_meta_end')) {
  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_meta_end()
  {

    echo '</div></div>';
  }
}
/**********************************/
//Shop Product Image Markup
/**********************************/
if (!function_exists('th_shop_mania_pro_product_image_start')) {
  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_image_start()
  {
    echo '<div class="thunk-product-image">';
  }
}
if (!function_exists('th_shop_mania_pro_product_image_end')) {

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_image_end()
  {
    do_action('quickview');
    echo '</div>';
  }
}
if (!function_exists('th_shop_mania_pro_product_content_start')) {
  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_content_start()
  {
    echo '<div class="thunk-product-content">';
  }
}
if (!function_exists('th_shop_mania_pro_product_content_end')) {

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_content_end()
  {

    echo '</div>';
  }
}
/**
 * Thunk-product-hover start.
 */
if (!function_exists('th_shop_mania_pro_product_hover_start')) {
  function th_shop_mania_pro_product_hover_start()
  {
    global $product;
    $pid = $product->get_id();

    echo '<div class="thunk-product-hover">';
    th_shop_mania_add_to_cart();
    th_shop_mania_whish_list($pid);
    th_shop_mania_add_to_compare_fltr($pid);
  }
}
if (!function_exists('th_shop_mania_pro_product_hover_end')) {

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_hover_end()
  {

    echo '</div>';
  }
}

if (!function_exists('th_shop_mania_pro_shop_content_start')) {

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_shop_content_start()
  {
    $viewshow = get_theme_mod('th_shop_mania_prd_view', 'grid-view');
    if ($viewshow == 'grid-view') {
      echo '<div id="shop-product-wrap" class="thunk-grid-view">';
    } else {
      echo '<div id="shop-product-wrap" class="thunk-list-view">';
    }
  }
}
if (!function_exists('th_shop_mania_pro_shop_content_end')) {

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_shop_content_end()
  {

    echo '</div>';
  }
}
/**
 * add to cart start.
 */
if (!function_exists('th_shop_mania_add_to_cart')) {
  function th_shop_mania_add_to_cart($layout = '')
  {
    if ($layout == 'tooltip') {
      echo '<div class="th-add-to-cart"><div th-tooltip="' . __('Add To Cart', 'th-shop-mania') . '">';
      echo woocommerce_template_loop_add_to_cart();
      echo '</div></div>';
    } else {
      echo '<div class="th-add-to-cart">';
      echo woocommerce_template_loop_add_to_cart();
      echo '</div>';
    }
  }
}
/****************/
// add to compare
/****************/
if (!function_exists('th_shop_mania_add_to_compare_fltr')) {
  function th_shop_mania_add_to_compare_fltr($pid = '')
  {
    if (class_exists('th_product_compare') || class_exists('Tpcp_product_compare')) {
      echo '<div class="thunk-compare"><div th-tooltip="' . __('Compare', 'th-shop-mania') . '" class="compare-tooltip"><a class="th-product-compare-btn compare button" data-th-product-id="' . esc_attr($pid) . '"><span class="th-icon th-icon-repeat"></span><span class="text">' . __('Compare', 'th-shop-mania') . '</span></a></div></div>';
    }
  }
}
/**********************/
/** wishlist **/
/**********************/
if (!function_exists('th_shop_mania_whish_list')) {
  function th_shop_mania_whish_list($pid = '')
  {
    if (shortcode_exists('yith_wcwl_add_to_wishlist')) {
      echo '<div class="thunk-wishlist"><span class="thunk-wishlist-inner"><div th-tooltip="' . __('Wishlist', 'th-shop-mania') . '" class="wishlist-tooltip">' . do_shortcode('[yith_wcwl_add_to_wishlist product_id=' . esc_attr($pid) . ' icon="th-icon th-icon-heart1" label=' . __('wishlist', 'th-shop-mania') . ' already_in_wishslist_text=' . __('Already', 'th-shop-mania') . ' browse_wishlist_text=' . __('Added', 'th-shop-mania') . ']') . '</div></span></div>';
    }
  }
}
// * Shop customization.
// * @return void
add_action('woocommerce_before_shop_loop', 'th_shop_mania_pro_shop_content_start', 1);
add_action('woocommerce_after_shop_loop', 'th_shop_mania_pro_shop_content_end', 1);

//To disable th compare button 
remove_action('woocommerce_init', 'th_compare_add_action_shop_list');

//To disable th compare Pro button 
remove_action('woocommerce_init', 'tpcp_add_action_shop_list');

// Woocommerce Cart Page Customisation
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');

// Sale Badge Text change
add_filter('woocommerce_sale_flash', 'woocommerce_custom_sale_text', 10, 3);
function woocommerce_custom_sale_text($text, $post, $_product)
{
  return '<span class="onsale">' . esc_html(get_theme_mod('th_shop_mania_woo_sale_text', 'Sale')) . '</span>';
}
// This Action for product style in shop page
add_action('wp', 'th_shop_mania_shop_customization', 5);

// This Action for product style in shop page with ajax
add_action('th_shop_mania_pagination_infinite', 'th_shop_mania_shop_customization');
/**
 * Shop customization.
 *
 * @return void
 */
function th_shop_mania_shop_customization()
{
  remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
  remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10, 0);
  remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
  remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
  remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
  remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
  remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
  /**
   * Shop Page Product Content Sorting
   */
  add_action('woocommerce_after_shop_loop_item', 'th_shop_mania_woo_woocommerce_shop_product_content', 10);
  // // ========================+++prev+++========================
}
if (!function_exists('th_shop_mania_woo_shop_product_price')) {
  function th_shop_mania_woo_shop_product_price($product)
  {
    $price_html = $product->get_price_html();
    echo $price_html ? '<span class="price">' .wp_kses_post($price_html). '</span>' : '';
  }
}
if (!function_exists('th_shop_mania_woo_shop_product_on_sale')) {
  function th_shop_mania_woo_shop_product_on_sale()
  {
    global $post, $product;
    return $product->is_on_sale() ?  apply_filters('woocommerce_sale_flash', '<span class="onsale">' . esc_html__('Sale!', 'th-shop-mania') . '</span>', $post, $product) : '';
  }
}
if (!function_exists('th_shop_mania_woo_shop_product_rating')) {
  function th_shop_mania_woo_shop_product_rating($product)
  {
    return wc_review_ratings_enabled() ? wc_get_rating_html($product->get_average_rating()) : '';
  }
}
if (!function_exists('th_shop_mania_woo_woocommerce_template_loop_product_title')) {
  /**
   * Show the product title in the product loop. By default this is an H2.
   */
  function th_shop_mania_woo_woocommerce_template_loop_product_title()
  { ?>
    <a href="<?php echo esc_url(get_the_permalink()); ?>" class="zta-loop-product__link"><h2 class="woocommerce-loop-product__title"><?php echo esc_html(get_the_title()); ?></h2></a>
<?php  }
}
if (!function_exists('th_shop_mania_woo_woocommerce_shop_product_content')) {
  /**
   * Show the product title in the product loop. By default this is an H2.
   */
  function th_shop_mania_woo_woocommerce_shop_product_content()
  {
    $shop_th_shop_mania_woo_product_layout = get_theme_mod('th_shop_mania_woo_product_layout', 1);
    $shop_th_shop_mania_woo_product_layout = $shop_th_shop_mania_woo_product_layout ? $shop_th_shop_mania_woo_product_layout : 1;
    global $product;
    $productId = $product->get_id();
    if ($shop_th_shop_mania_woo_product_layout == 1) {
      th_shop_mania_woocommerce_product_layout_default($product, $productId);
    } else if ($shop_th_shop_mania_woo_product_layout == 2) {
      th_shop_mania_woocommerce_product_layout2($product, $productId);
    } else if ($shop_th_shop_mania_woo_product_layout == 3) {
      th_shop_mania_woocommerce_product_layout3($product, $productId);
    } else if ($shop_th_shop_mania_woo_product_layout == 4) {
      th_shop_mania_woocommerce_product_layout4($product, $productId);
    } else if ($shop_th_shop_mania_woo_product_layout == 5) {
      th_shop_mania_woocommerce_product_layout5($product, $productId);
    }
      else if ($shop_th_shop_mania_woo_product_layout == 6) {
        if (function_exists('th_shop_mania_woocommerce_product_layout6')) {
          th_shop_mania_woocommerce_product_layout6($product, $productId);
        }
        
    }
  }
}
//woocommerce layouts--------------------------------------------
//woocommerce layout 1------------
function th_shop_mania_woocommerce_product_layout_default($product, $productId)
{
  ?>
  <div class="th-shop-mania-shop-page-layout-default" id="shop-page-products-layouts">
    <div class="thunk-product-wrap">
      <div class="thunk-product">
        <a href=" <?php echo esc_url(get_the_permalink()) . ' ' ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
          <div class="thunk-product-image">
            <?php echo wp_kses(th_shop_mania_woo_shop_product_on_sale(),th_shop_mania_wp_kses_allowed_html()
          );
            echo wp_kses_post(woocommerce_get_product_thumbnail());
            $hover_style = get_theme_mod('th_shop_mania_woo_product_animation');
            // the_post_thumbnail();
            if ('swap' === $hover_style) {
              $attachment_ids = $product->get_gallery_image_ids($productId);
              if (!empty($attachment_ids)) {

                $glr = wp_get_attachment_image($attachment_ids[0], 'shop_catalog', false, array('class' => 'show-on-hover'));
                $category_product['glr'] = $glr;
                echo wp_kses_post($category_product['glr']);
              }
            }
            if ('slide' === $hover_style) {
              $attachment_ids = $product->get_gallery_image_ids($productId);
              if (!empty($attachment_ids)) {

                $glr = wp_get_attachment_image($attachment_ids[0], 'shop_catalog', false, array('class' => 'show-on-slide'));
                $category_product['glr'] = $glr;
                echo wp_kses_post($category_product['glr']);
              }
            }
            do_action('quickview');
            ?>
          </div>
          <div class="thunk-product-content"> 
              <?php th_shop_mania_woo_woocommerce_template_loop_product_title(); ?>
            <?php th_shop_mania_woo_shop_product_price($product);
            echo th_shop_mania_woo_shop_product_rating($product); ?>
          </div>
        </a>
        <div class="thunk-product-hover">
          <?php th_shop_mania_add_to_cart('layout1');
          th_shop_mania_whish_list($productId);
          th_shop_mania_add_to_compare_fltr($productId); ?>
        </div>
      </div>
    </div>
  </div>
<?php }

/************************/
// description Menu
/************************/
if ( !function_exists('th_shop_mania_nav_description') ) {
function th_shop_mania_nav_description( $item_output, $item, $depth, $args ){
    if ( !empty( $item->description ) ) {
        $item_output = str_replace( $args->link_after . '</a>', '<p class="menu-item-description">' . esc_html($item->description) . '</p>' . $args->link_after . '</a>', $item_output );
    }
 
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'th_shop_mania_nav_description', 10, 4 );
}