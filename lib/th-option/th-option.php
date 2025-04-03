<?php
include_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
class Th_Shop_Mania_theme_option
{

  /**
     * Menu page title
     *
     * @since 1.0
     * @var array $menu_page_title
     */
    static public $menu_page_title = 'Shop Mania';

    /**
     * Current Slug
     *
     * @since 1.0
     * @var array $current_slug
     */
    static public $current_slug = 'general';

  function __construct()
  {
    add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
    add_action('admin_menu', array($this, 'menu_tab'),49);
    
    // self::save_settings();
    // AJAX.
    add_action('wp_ajax_th_activeplugin', array($this, 'th_activeplugin'));
    add_action('wp_ajax_default_home', array($this, 'default_home'));
    add_action( 'after_setup_theme', __CLASS__ . '::init_admin_settings', 99 );
      
  }
   /**
     * Admin settings init
     */
      static public function init_admin_settings() {
        self::save_settings();
        add_action('after_switch_theme',__CLASS__ . '::activation_reset');
      }
  function menu_tab()
  {
    $menu_title = sprintf( esc_html__( '%s Options', 'th-shop-mania' ), apply_filters( 'thsm_page_title', __( 'Shop Mania', 'th-shop-mania' ) ) );
    add_theme_page(esc_html__('Shop Mania', 'th-shop-mania'), $menu_title, 'edit_theme_options', 'th_shop_mania_thunk_started', array($this, 'tab_page'));

    $menu_page_title = '';
    $page_white_level_menu_func = __CLASS__ . '::white_level_menu_callback';
    $capability     = 'manage_options';
    if ( class_exists('Th_Shop_Mania_Ext_White_Label_Markup') && Th_Shop_Mania_Ext_White_Label_Markup::show_branding() ) {
    add_theme_page( 'White Label Page Title',' White Label Option', $capability, 'white-label', $page_white_level_menu_func,12 );
  }
}

static public function white_level_menu_callback() {

      // $current_slug = isset( $_GET['action'] ) ? esc_attr( $_GET['action'] ) : self::$current_slug;
      $current_slug = isset($_GET['action']) ? sanitize_key($_GET['action']) : self::$current_slug;

      $active_tab   = str_replace( '_', '-', $current_slug );
      $current_slug = str_replace( '-', '_', $current_slug );

      $ast_icon           = apply_filters( 'th_shop_mania_page_top_icon', true );
      $ast_visit_site_url = apply_filters( 'thsm_site_url', 'https:/themehunk.com' );
      $ast_wrapper_class  = apply_filters( 'th_shop_mania_welcome_wrapper_class', array( $current_slug ) );
      $my_theme = wp_get_theme();
      $zta_theme_version = $my_theme->get( 'Version' );
            
      ?>
            <div class="thsmstarter-page-content">  
            <div class="thsmstarter-container">
      <div class="zta-menu-page-wrapper wrap zta-clear <?php echo esc_attr( implode( ' ', $ast_wrapper_class ) ); ?>">
         <div class="thsmstarter-header">
            <header>
                <div class="logo-wrap">
                    <div class="logo"></div>
                    <span class="thsm-theme-version"><?php echo  esc_html(self::$menu_page_title.' '.$zta_theme_version); ?></span>
                </div>
                
            </header>

            </div>  
      <?php 

      do_action( 'th_shop_mania_menu_white_label_action' ); ?>
      </div>
       </div>
     </div>

      <?php

    }

     /**
     * Save All admin settings here
     */
    static public function save_settings() {

      // Only admins can save settings.
      if ( ! current_user_can( 'edit_theme_options' ) ){
        return;
      }

      // Let extensions hook into saving.
      do_action( 'th_shop_mania_admin_settings_save' );
    }

    /**
     * Activation Reset
     */
    static public function activation_reset() {

      add_rewrite_endpoint( 'partial', EP_PERMALINK );
      // flush rewrite rules.
      flush_rewrite_rules();

      if ( is_network_admin() ) {
        $branding = get_site_option( '_th_shop_mania_ext_white_label' );
      } else {
        $branding = get_option( '_th_shop_mania_ext_white_label' );
      }

      if ( isset( $branding['th-shop-mania-agency']['hide_branding'] ) && false != $branding['th-shop-mania-agency']['hide_branding'] ) {

        $branding['th-shop-mania-agency']['hide_branding'] = false;

        if ( is_network_admin() ) {

          update_site_option( '_th_shop_mania_ext_white_label', $branding );

        } else {
          update_option( '_th_shop_mania_ext_white_label', $branding );
        }
      }
    }

  /**
   * Enqueue scripts for admin page only: Theme info page
   */
  function admin_scripts($hook)
  {
    if ($hook === 'appearance_page_th_shop_mania_thunk_started') {
      wp_enqueue_style('thunk-started-css', get_template_directory_uri() . '/lib/th-option/assets/css/started.css');
      wp_enqueue_script('th-shop-mania-admin-load', get_template_directory_uri() . '/lib/th-option/assets/js/th-options.js', array('jquery', 'updates'), '1', true);

      

      $data = apply_filters(
        'th_option_localize_vars',
        array(
          'oneClickDemo' => esc_url(admin_url('themes.php?page=themehunk-site-library&template=step')),
          'wpnonce'    => wp_create_nonce( "ajaxnonce" ),

        )
      );
      wp_localize_script('th-shop-mania-admin-load', 'THAdmin', $data);
    }
  }
  function tab_constant()
  {
    $theme_data = wp_get_theme();
    $tab_array = array();
    $tab_array['header'] = array(
      'theme_brand' => __('ThemeHunk', 'th-shop-mania'),
      'theme_brand_url' => esc_url($theme_data->get('AuthorURI')),
      'welcome' => sprintf(esc_html__('Welcome To %1s Theme', 'th-shop-mania'), esc_html($theme_data->get('Name'), 'th-shop-mania'), $theme_data->get('Version')),
      'welcome_desc' => esc_html($theme_data->get('Name') . ' is a Free WooCommerce theme for creating clean and professional shopping stores.', 'th-shop-mania'),
      'v' => 'Version ' . $theme_data->get('Version')
    );
    return $tab_array;
  }


  function tab_page()
  {
    $text_array = $this->tab_constant();
    $theme_header = $text_array['header'];
    require_once('tab-html.php');
  }


  // Home Page Setup

  function default_home()
  {
    $pages = get_pages(array(
      'meta_key' => '_wp_page_template',
      'meta_value' => 'frontpage.php'
    ));
    $post_id = isset($pages[0]->ID) ? $pages[0]->ID : false;
    if (empty($pages)) {
      $post_id = wp_insert_post(array(
        'post_type' => 'page',
        'post_title' => __('Home Page', 'th-shop-mania'),
        'post_content' => '',
        'post_status' => 'publish',
        'comment_status' => 'closed',   // if you prefer
        'ping_status' => 'closed',      // if you prefer
        'page_template' => 'frontpage.php', //Sets the template for the page.
      ));
    }
    if ($post_id) {
      update_option('page_on_front', $post_id);
      update_option('show_on_front', 'page');
    }
    wp_die(); // this is required to terminate immediately and return a proper response
  }


  function _check_homepage_setup()
  {

    $fid =  get_option('page_on_front');

    $pages = get_pages(array(
      'meta_key' => '_wp_page_template',
      'meta_value' => 'frontpage.php'
    ));
    $post_id = isset($pages[0]->ID) ? $pages[0]->ID : false;


    return ($fid == $post_id) ? true : false;
  }
  /*
          * Plugin install
          * Active plugin
          * Setup Homepage
          */
  public function th_activeplugin()
  {
    if ( ! current_user_can( 'administrator' ) ) {

                wp_die( - 1, 403 );
                
          } 

    check_ajax_referer( 'ajaxnonce', 'nonce' );

    $plugin_init = isset($_POST['init']) ? sanitize_text_field($_POST['init']) : '';

    if (!current_user_can('install_plugins') || empty($plugin_init)) {
      wp_send_json_error(
        array(
          'success' => false,
          'message' => __('No plugin specified', 'th-shop-mania'),
        )
      );
    }

    // $plugin_init = (isset($_POST['init'])) ? esc_attr($_POST['init']) : '';

    $activate = activate_plugin($plugin_init);

    if (is_wp_error($activate)) {
      wp_send_json_error(
        array(
          'success' => false,
          'message' => $activate->get_error_message(),
        )
      );
    }

    wp_send_json_success(
      array(
        'success' => true,
        'message' => __('Plugin Successfully Activated', 'th-shop-mania'),
      )
    );
  }


function plugin_install_button($plugin){
            $pro_text = '<b class="pro-text">'.$plugin['pro_text'].'</b>';

            $button = '<div class="rcp theme_link th-row">';
            $button .= ' <div class="th-column"><img src="'.esc_url( $plugin['thumb'] ).'" /> </div>';
            $button .= '<div class="th-column">';

           $pro_settings = ($plugin['pro_active'] && $plugin['admin_link'] !=='')?'<a href="'.esc_url( admin_url( 'themes.php?page='.$plugin['admin_link'] )).'">Settings</a>':'<a id="'.esc_attr( $plugin['slug'] ).'" style="display:none;" href="'.esc_url( admin_url( 'themes.php?page='.$plugin['admin_link'] )).'">Settings</a>';

            $docs = '<a target="_blank"  class="plugin-detail" href="'.esc_url( $plugin['docs'] ).'">'.esc_html__( 'Documentation', 'th-shop-mania' ).'</a>';

            if($plugin['pro_text'] ==''){
                 $pro_settings = ($plugin['pro_link']!='')?'<a href="'.esc_url( $plugin['pro_link'] ).'" class="buy-pro">GO PRO</a>':'';
                 $docs = '<a class="plugin-detail thickbox open-plugin-details-modal" href="'.esc_url( $plugin['detail_link'] ).'">'.esc_html__( 'Details & Version', 'th-shop-mania' ).'</a>';
                            $pro_text = "";

            }

            $button .= '<div class="title-plugin">
            <h4>'.esc_html( $plugin['plugin_name'] ).$pro_text. '</h4><div class="th-option-bpro"> '.$docs .$pro_settings. '
            </div>
            </div>';
             $button .='<button data-activated="Activated" data-msg="Activating" data-init="'.esc_attr($plugin['plugin_init']).'" data-slug="'.esc_attr( $plugin['slug'] ).'" class="button '.esc_attr( $plugin['button_class'] ).'">'.esc_html($plugin['button_txt']).'</button>';
            $button .= '</div></div>';

            echo wp_kses_post($button);
            
}

 public  function plugin_install($rplugins = 'recommend-plugins'){
    $recommend_plugins = get_theme_support( $rplugins );

       if ( is_array( $recommend_plugins ) && isset( $recommend_plugins[0] ) ){

        $pluginArr =array();
        foreach($recommend_plugins[0] as $slug=>$plugin){
            // pro plugin check
            $pro_path = isset($plugin['pro-plugin'])?ABSPATH . 'wp-content/plugins/'.$plugin['pro-plugin']['init']:'';
            $plugin_init = $plugin['active_filename'];
                $img_slug = $slug;
                $pro_text = $admin_link = $docs = ''; 
                 $pro_active = false;

                 $plugin['img'] = "https://ps.w.org/". $img_slug."/assets/".$plugin['img'];



            if( file_exists($pro_path)) {

              if($slug==='hunk-companion'){
                $plugin['name'] = 'Shop Mania Pro';
                $plugin['img'] = get_template_directory_uri() . '/lib/th-option/assets/images/shop-mania.png';
              }

                $slug = $plugin['pro-plugin']['slug'];
                $plugin_init = $plugin['pro-plugin']['init'];
                $admin_link = $plugin['pro-plugin']['admin_link'];
                $pro_text = 'pro'; 
                $docs = $plugin['pro-plugin']['docs'];

                if(is_plugin_active( $plugin['pro-plugin']['init'] )){
                    $pro_active = true; 
                }
             }

            $status = is_dir( WP_PLUGIN_DIR . '/' . $slug );

            $button_class = 'install-now button '.$slug;

             if ( is_plugin_active( $plugin_init ) ) {

                   $button_class = 'button disabled '.$slug;
                   $button_txt = esc_html__( 'Activated', 'th-shop-mania' );
                   $detail_link = $install_url = '';
                }

                if ( ! is_plugin_active( $plugin_init ) ){
                    $button_txt = esc_html__( 'Install Now', 'th-shop-mania' );
                    if ( ! $status ) {
                        $install_url = wp_nonce_url(
                            add_query_arg(
                                array(
                                    'action' => 'install-plugin',
                                    'plugin' => $slug
                                ),
                                network_admin_url( 'update.php' )
                            ),
                            'install-plugin_'.$slug
                        );

                    } else {
                        $install_url = add_query_arg(array(
                            'action' => 'activate',
                            'plugin' => rawurlencode( $plugin_init ),
                            'plugin_status' => 'all',
                            'paged' => '1',
                            '_wpnonce' => wp_create_nonce('activate-plugin_' . $plugin_init ),
                        ), network_admin_url('plugins.php'));
                        $button_class = 'activate-now button-primary '.$slug;
                        $button_txt = esc_html__( 'Activate Now', 'th-shop-mania' );
                    }
                }
                $detail_link = add_query_arg(
                        array(
                            'tab' => 'plugin-information',
                            'plugin' => $slug,
                            'TB_iframe' => 'true',
                            'width' => '772',
                            'height' => '500',
                        ),
                        network_admin_url( 'plugin-install.php' )
                    );

                    $pluginArr['plugin_name'] =  $plugin['name'];
                    $pluginArr['slug']= $slug;
                    $pluginArr['thumb']= $plugin['img'];
                    $pluginArr['plugin_init']= $plugin_init;
                    $pluginArr['detail_link']= $detail_link;
                    $pluginArr['button_txt']= $button_txt;
                    $pluginArr['button_class']= $button_class;

                    // pro variable
                    $pluginArr['pro_link']= $plugin['pro_link'];
                    $pluginArr['pro_text']= $pro_text;
                    $pluginArr['docs']= $docs;
                    $pluginArr['admin_link']= $admin_link;
                    $pluginArr['pro_active']= $pro_active;
                    
                   $this->plugin_install_button($pluginArr);
        }
    } // plugin check
}


} // class end
$boj = new Th_Shop_Mania_theme_option();
