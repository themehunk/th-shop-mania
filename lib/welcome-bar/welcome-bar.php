<?php
/**
 * Add admin notice when active theme, just show one time
 *
 * @return bool|null
 */
add_action( 'admin_notices', 'th_shop_mania_started_admin_notice' );

function th_shop_mania_started_admin_notice() {
  global $current_user;
  $user_id   = $current_user->ID;
  $theme_data  = wp_get_theme();
  if ( !get_user_meta( $user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore' ) ) {
    ?>
    <div class="notice thunk-notice">

      <h1>
        <?php
        /* translators: %1$s: theme name, %2$s theme version */
        printf( esc_html__( 'Welcome to %1$s - Version %2$s', 'th-shop-mania' ), apply_filters( 'thsm_page_title', __( 'Th Shop Mania', 'th-shop-mania' ) ), esc_html( $theme_data->Version ) );
        ?>
      </h1>
      <p>
        <?php
        /* translators: %1$s: theme name, %2$s link */
        printf( __( 'Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our <a href="%2$s">Welcome page</a>', 'th-shop-mania' ), apply_filters( 'thsm_page_title', __( 'Th Shop Mania', 'th-shop-mania' ) ), esc_url( admin_url( 'themes.php?page=th_shop_mania_thunk_started' ) ) );
        printf( '<a href="%1$s" class="notice-dismiss dashicons dashicons-dismiss dashicons-dismiss-icon"></a>', '?' . esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore=0' );
        ?>
      </p>
      <p>
        <a href="<?php echo esc_url( admin_url( 'themes.php?page=th_shop_mania_thunk_started' ) ) ?>" class="button button-primary button-hero" style="text-decoration: none;">
          <?php
          /* translators: %s theme name */
          printf( esc_html__( 'Get started with %s', 'th-shop-mania' ), apply_filters( 'thsm_page_title', __( 'Th Shop Mania', 'th-shop-mania' ) ) )
          ?>
        </a>
        
        <a href="<?php echo esc_url( admin_url( 'themes.php?page=th_shop_mania_thunk_started&th-tab=import-demo-content' ) ); ?>" class="th-inst-demo-btn"><?php echo __('Install Demo','th-shop-mania'); ?></a>
      </p>
    </div>
    <?php
  }
}

add_action( 'admin_init', 'th_shop_mania_started_notice_ignore' );
function th_shop_mania_started_notice_ignore() {
  global $current_user;
  $theme_data  = wp_get_theme();
  $user_id   = $current_user->ID;
  /* If user clicks to ignore the notice, add that to their user meta */
  if ( isset( $_GET[ esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore' ] ) && '0' == $_GET[ esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore' ] ) {
    add_user_meta( $user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore', 'true', true );
  }
}
if (!function_exists('th_shop_mania_admin_enqueue_scripts')) {
function th_shop_mania_admin_enqueue_scripts(){
  wp_enqueue_style( 'thunk-admin-css', get_template_directory_uri() . '/lib/welcome-bar/admin.css' );
}
}
add_action( 'admin_enqueue_scripts', 'th_shop_mania_admin_enqueue_scripts');
?>