<?php
// If plugin - 'WooCommerce' not exist then return.
if ( ! class_exists( 'WooCommerce' ) ){
     return;
}
if ( ! function_exists( 'th_shop_mania_whishlist_url' ) ){
function th_shop_mania_whishlist_url(){
$wishlist_page_id =  get_option( 'yith_wcwl_wishlist_page_id' );
$wishlist_permalink = get_the_permalink( $wishlist_page_id );
return $wishlist_permalink ;
}
add_filter( 'th_shop_mania_whishlist_url','th_shop_mania_whishlist_url' );
}
// display admin name
if ( ! function_exists( 'th_shop_mania_display_admin_name' ) ){
function th_shop_mania_display_admin_name(){
$user=wp_get_current_user();
echo esc_html($user->display_name);
}
}
/*******************************/
/** Sidebar Add Cart Product **/
/*******************************/
if ( ! function_exists( 'th_shop_mania_cart_total_item' ) ){
  /**
   * Cart Link
   * Displayed a link to the cart including the number of items present and the cart total
   */
 function th_shop_mania_cart_total_item(){
  if (shortcode_exists( 'taiowc' )) { ?>
    <div class="cart-contents">
   <?php echo do_shortcode('[taiowc]'); ?>
   </div>
 <?php }
}
  add_action('th_shop_mania_cart_total_item','th_shop_mania_cart_total_item');
}
/** My Account Menu **/
if ( ! function_exists( 'th_shop_mania_account' ) ){
function th_shop_mania_account(){
 if ( is_user_logged_in() ){?>
<a class="account" href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') ));?>"><i class="fa fa-user-o" aria-hidden="true"></i></a>
<?php } else {?>
<a class="account" href="<?php echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') ));?>"><i class="fa fa-lock" aria-hidden="true"></i></a>
<?php }
 }
 add_action('th_shop_mania_account','th_shop_mania_account');
}
/***************/
// single page
/***************/
if ( ! function_exists( 'th_shop_mania_single_summary_start' ) ){

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_single_summary_start(){
    
    echo '<div class="thunk-single-product-summary-wrap single">';
  }
}
if( ! function_exists( 'th_shop_mania_single_summary_end' ) ){

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_single_summary_end(){
    
    echo '</div>';
  }
}
add_action( 'woocommerce_before_single_product_summary', 'th_shop_mania_single_summary_start',0);
add_action( 'woocommerce_after_single_product_summary', 'th_shop_mania_single_summary_end',0);
    //Below lines are to show meta tab right side of product image
// remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
// add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs',40 );
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// add_filter( 'woocommerce_product_tabs', 'th_shop_mania_woocommerce_custom_product_tabs', 40 );
function th_shop_mania_woocommerce_custom_product_tabs( $tabs ) {
     $tabs['delivery_information'] = array(
        'title'     => __( 'Meta Information', 'th-shop-mania' ),
        'priority'  => 10,
        'callback'  => 'woocommerce_product_meta_tab'
    );
   return $tabs;
}
function woocommerce_product_meta_tab(){// this is where you indicate what appears in the description tab
wc_get_template( 'single-product/meta.php' ); // The meta content first
}

/**
 * Add next/prev buttons @ WooCommerce Single Product Page
 */
 
add_action( 'woocommerce_single_product_summary', 'th_shop_mania_prev_next_product',0 );
 
// and if you also want them at the bottom...
add_action( 'woocommerce_single_product_summary', 'th_shop_mania_prev_next_product',0 );
 
function th_shop_mania_prev_next_product(){
 
echo '<div class="prev_next_buttons">';
 
   // 'product_cat' will make sure to return next/prev from current category
   $previous = next_post_link('%link', '&larr;', TRUE, ' ', 'product_cat');
   $next = previous_post_link('%link', '&rarr;', TRUE, ' ', 'product_cat');
 
   echo $previous;
   echo $next;
    
echo '</div>';
         
}
 // Plus Minus Quantity Buttons @ WooCommerce Single Product Page
add_action( 'woocommerce_before_add_to_cart_quantity', 'th_shop_mania_display_quantity_minus',10,2 );
function th_shop_mania_display_quantity_minus(){

    echo '<div class="th-shop-mania-quantity"><button type="button" class="minus" >-</button>';
  
  
}
add_action( 'woocommerce_after_add_to_cart_quantity', 'th_shop_mania_display_quantity_plus',10,2 );
function th_shop_mania_display_quantity_plus(){
  
    echo '<button type="button" class="plus" >+</button></div>';
  
}
//Woocommerce: How to remove page-title at the home/shop page but not category pages
add_filter( 'woocommerce_show_page_title', 'th_shop_mania_not_a_shop_page' );
function th_shop_mania_not_a_shop_page() {
    return boolval(!is_shop());
}
//***********************/
// product category list
//************************/
if ( ! function_exists( 'th_shop_mania_product_list_categories' ) ){
function th_shop_mania_product_list_categories( $args = '' ){
$term = get_theme_mod('th_shop_mania_exclde_category');
if(!empty($term[0])){
  $exclude_id = $term;
  }else{
  $exclude_id = '';
 }
$defaults = array(
        'child_of'            => 0,
        'current_category'    => 0,
        'depth'               => 5,
        'echo'                => 0,
        'exclude'             => $exclude_id,
        'exclude_tree'        => '',
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
        'show_option_none'    => __( 'No categories','th-shop-mania' ),
        'style'               => 'list',
        'taxonomy'            => 'product_cat',
        'title_li'            => '',
        'use_desc_for_title'  => 0,
    );
 $html = wp_list_categories($defaults);
        echo '<ul class="product-cat-list thunk-product-cat-list" data-menu-style="vertical">'.$html.'</ul>';
  }
}
if ( ! function_exists( 'th_shop_mania_product_list_categories_mobile' ) ){
 function th_shop_mania_product_list_categories_mobile( $args = '' ){
  $term = get_theme_mod('th_shop_mania_exclde_category');
if(!empty($term[0])){
  $exclude_id = $term;
  }else{
  $exclude_id = '';
 }
    $defaults = array(
        'child_of'            => 0,
        'current_category'    => 0,
        'depth'               => 5,
        'echo'                => 0,
        'exclude'             => $exclude_id,
        'exclude_tree'        => '',
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
        'show_option_none'    => __( 'No categories','th-shop-mania' ),
        'style'               => 'list',
        'taxonomy'            => 'product_cat',
        'title_li'            => '',
        'use_desc_for_title'  => 0,
    );
 $html = wp_list_categories($defaults);
        echo '<ul class="product-cat-list thunk-product-cat-list mobile" data-menu-style="accordion">'.$html.'</ul>';
  }
}

/**********************************/
//Shop Product Markup
/**********************************/
if ( ! function_exists( 'th_shop_mania_pro_product_meta_start' ) ){
  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_meta_start(){
    echo '<div class="thunk-product-wrap"><div class="thunk-product">';
  }
}
if ( ! function_exists( 'th_shop_mania_pro_product_meta_end' ) ){

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_meta_end(){

    echo '</div></div>';
  }
}
/**********************************/
//Shop Product Image Markup
/**********************************/
if ( ! function_exists( 'th_shop_mania_pro_product_image_start' ) ){
  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_image_start(){
    echo '<div class="thunk-product-image">';
  }
}
if ( ! function_exists( 'th_shop_mania_pro_product_image_end' ) ){

  /**
   * Thumbnail wrap start.
   */
    function th_shop_mania_pro_product_image_end(){
    do_action('quickview');
    echo '</div>';
  }
}

if ( ! function_exists( 'th_shop_mania_pro_product_content_start' ) ){
  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_content_start(){
    echo '<div class="thunk-product-content">';
  }
}
if ( ! function_exists( 'th_shop_mania_pro_product_content_end' ) ){

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_content_end(){

    echo '</div>';
  }
}
 /**
   * Thunk-product-hover start.
   */
 if ( ! function_exists( 'th_shop_mania_pro_product_hover_start' ) ){
  function th_shop_mania_pro_product_hover_start(){
    global $product;
    $pid = $product->get_id();

    echo'<div class="thunk-product-hover">';
    // do_action('th_shop_mania_wishlist');
    // do_action('th_shop_mania_compare');
      th_shop_mania_add_to_cart();
      th_shop_mania_whish_list($pid);
      th_shop_mania_add_to_compare_fltr($pid);
      
  }
}
if ( ! function_exists( 'th_shop_mania_pro_product_hover_end' ) ){

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_product_hover_end(){
    
    echo '</div>';
  }
}

if ( ! function_exists( 'th_shop_mania_pro_shop_content_start' ) ){

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_shop_content_start(){
    $viewshow = get_theme_mod('th_shop_mania_prd_view','grid-view');
    if($viewshow == 'grid-view'){
    echo '<div id="shop-product-wrap" class="thunk-grid-view">';
    }else{
    echo '<div id="shop-product-wrap" class="thunk-list-view">';
    }
  }
}

if ( ! function_exists( 'th_shop_mania_pro_shop_content_end' ) ){

  /**
   * Thumbnail wrap start.
   */
  function th_shop_mania_pro_shop_content_end(){
    
    echo '</div>';
  }
}

/**
   * add to cart start.
   */
 if ( ! function_exists( 'th_shop_mania_add_to_cart' ) ){
  function th_shop_mania_add_to_cart(){

    echo'<div class="th-add-to-cart">';
    echo woocommerce_template_loop_add_to_cart();

    echo '</div>';
      
  }
}
/****************/
// add to compare
/****************/
if (!function_exists('th_shop_mania_add_to_compare_fltr')) {
function th_shop_mania_add_to_compare_fltr($pid = ''){
  global $product;
  $product_id = $pid;
        if(class_exists('th_product_compare')){
          echo '<div class="thunk-compare"><a class="th-product-compare-btn compare button" data-th-product-id="'.$pid.'">'.__('Compare','th-shop-mania').'</a></div>';
           }
        }
}
/**********************/
/** wishlist **/
/**********************/
if (!function_exists('th_shop_mania_whish_list')) {
function th_shop_mania_whish_list($pid = ''){
       if( shortcode_exists( 'yith_wcwl_add_to_wishlist' )){
       echo '<div class="thunk-wishlist"><span class="thunk-wishlist-inner">'.do_shortcode('[yith_wcwl_add_to_wishlist product_id='.$pid.' icon="fa fa-heart" label='.__('wishlist','th-shop-mania').' already_in_wishslist_text='.__('Already','th-shop-mania').' browse_wishlist_text='.__('Added','th-shop-mania').']' ).'</span></div>';
       }
 } 
}
/**
* Shop customization.
*
* @return void
*/
add_action( 'woocommerce_before_shop_loop_item', 'th_shop_mania_pro_product_meta_start', 10);
add_action( 'woocommerce_after_shop_loop_item', 'th_shop_mania_pro_product_meta_end', 12 );
add_action( 'woocommerce_before_shop_loop_item_title', 'th_shop_mania_pro_product_content_start',20);
add_action( 'woocommerce_after_shop_loop_item_title', 'th_shop_mania_pro_product_content_end', 20 );
add_action( 'woocommerce_after_shop_loop_item_title', 'th_shop_mania_pro_product_hover_start',50);
add_action( 'woocommerce_after_shop_loop_item', 'th_shop_mania_pro_product_hover_end',20);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open',0);
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price',0);
add_action( 'woocommerce_before_shop_loop_item_title', 'th_shop_mania_pro_product_image_start', 0);
add_action( 'woocommerce_before_shop_loop_item_title', 'th_shop_mania_pro_product_image_end',10 );
// add_action( 'woocommerce_after_single_product_summary', 'woocommerce_show_product_sale_flash',4);
add_action( 'woocommerce_before_shop_loop', 'th_shop_mania_pro_shop_content_start',1);
add_action( 'woocommerce_after_shop_loop', 'th_shop_mania_pro_shop_content_end',1);

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

//To disable th compare button 
remove_action('woocommerce_init','th_compare_add_action_shop_list');

/**
 * Remove "Description" Heading Title @ WooCommerce Single Product Tabs
 */
add_filter( 'woocommerce_product_description_heading', '__return_null' );


// Hook in
add_filter( 'woocommerce_get_availability', 'custom_override_get_availability', 10, 2);
 
// The hook in function $availability is passed via the filter!
function custom_override_get_availability( $availability, $_product ) {
if ( $_product->is_in_stock() ) $availability['availability'] = __('(In Stock)', 'th-shop-mania');
return $availability;
}