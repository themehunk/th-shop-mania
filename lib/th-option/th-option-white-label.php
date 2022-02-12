<?php
/**
 * Admin settings helper
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package     zita
 * @author      zita
 * @copyright   Copyright (c) 2018, Zita
 * @link        https://wpzita.com/
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ){
	exit;
}
/*****************************************/

if ( ! class_exists( 'Zita_Admin_Settings' ) ){
    /**
	 * Zita Admin Settings
	 */
	class Zita_Admin_Settings{

    /**
		 * View all actions
		 *
		 * @since 1.0
		 * @var array $view_actions
		 */
		static public $view_actions = array();

		/**
		 * Menu page title
		 *
		 * @since 1.0
		 * @var array $menu_page_title
		 */
		static public $menu_page_title = 'Zita Theme';

		/**
		 * Page title
		 *
		 * @since 1.0
		 * @var array $page_title
		 */
		static public $page_title = 'Zita';

		/**
		 * Plugin slug
		 *
		 * @since 1.0
		 * @var array $plugin_slug
		 */
		static public $plugin_slug = 'zita';

		/**
		 * Default Menu position
		 *
		 * @since 1.0
		 * @var array $default_menu_position
		 */
		static public $default_menu_position = 'themes.php';

		/**
		 * Parent Page Slug
		 *
		 * @since 1.0
		 * @var array $parent_page_slug
		 */
		static public $parent_page_slug = 'general';

		/**
		 * Current Slug
		 *
		 * @since 1.0
		 * @var array $current_slug
		 */
		static public $current_slug = 'general';

		/**
		 * Constructor
		 */
		function __construct() {

			if ( ! is_admin() ) {
				return;
			}

			add_action( 'after_setup_theme', __CLASS__ . '::init_admin_settings', 99 );
		}
        /**
		 * Admin settings init
		 */
		  static public function init_admin_settings() {
			self::$menu_page_title = apply_filters( 'zita_menu_page_title', __( 'Zita Options', 'zita' ) );
			self::$page_title      = apply_filters( 'zita_page_title', __( 'Zita', 'zita' ) );

			
            
			// Let extensions hook into saving.
				do_action( 'zita_admin_settings_scripts' );
				self::save_settings();
            
			add_action( 'admin_menu', __CLASS__ . '::add_admin_menu', 99 );
           
			add_filter( 'admin_title', __CLASS__ . '::zita_admin_title', 10, 2 );
            
 
			add_action('after_switch_theme',__CLASS__ . '::activation_reset');
			//remove_menu_page( 'zita-site-library.php' );

		}
		 /**
		 * View actions
		 */
		static public function get_view_actions() {

			if ( empty( self::$view_actions ) ) {

				$actions            = array(
					'general' => array(
						'label' => __( 'Welcome', 'zita' ),
						'show'  => ! is_network_admin(),
					),
				);
				self::$view_actions = apply_filters( 'zita_menu_options', $actions );
			}

			return self::$view_actions;
		}
        /**
		 * Save All admin settings here
		 */
		static public function save_settings() {

			// Only admins can save settings.
			if ( ! current_user_can( 'manage_options' ) ){
				return;
			}

			// Let extensions hook into saving.
			do_action( 'zita_admin_settings_save' );
		}

        /**
		 * Enqueues the needed CSS/JS for the builder's admin settings page.
		 *
		 * @since 1.0
		 */
		static public function styles_scripts($hook){
		

			// Styles.
			wp_enqueue_style( 'zita-admin-settings', ZITA_THEME_URI . 'lib/theme-option/assets/css/zita-admin-menu-settings.css', array(), ZITA_THEME_VERSION );
			// Script.
			wp_enqueue_script( 'zita-step-settings', ZITA_THEME_URI . 'lib/theme-option/assets/js/zita-started-step.js', array( 'jquery'), '1.0.1',true );
			wp_enqueue_script( 'zita-admin-settings', ZITA_THEME_URI . 'lib/theme-option/assets/js/zita-admin-menu-settings.js', array( 'jquery', 'wp-util', 'updates' ), '1.0.1' );

			$localize = array(
				'ajaxUrl'             => admin_url( 'admin-ajax.php' ),
				'btnActivating'       => __( 'Activating Importer Plugin ', 'zita' ) . '&hellip;',
				'zitaSitesLink'      => admin_url( 'themes.php?page=zita-site-library' ),
				'zitaSitesLinkTitle' => __( 'See Library', 'zita' ),
			);
			$localizee = array(
				'ajaxUrl'             => admin_url( 'admin-ajax.php' ),
			);
			wp_localize_script( 'zita-step-settings', 'zita', apply_filters( 'zita_theme_js_localize', $localizee ) );
			wp_localize_script( 'zita-admin-settings', 'zita', apply_filters( 'zita_theme_js_localize', $localize ) );
		}

		/**
		 * Enqueues the needed CSS/JS for Backend.
		 *
		 * @since 1.0
		 */
		static public function admin_scripts(){
			
			// Styles.
			wp_enqueue_style( 'zita-admin', ZITA_THEME_URI . 'lib/theme-option/assets/css/zita-admin.css', array(), ZITA_THEME_VERSION );

		}
        /**
		 * Add main menu
		 *
		 * @since 1.0
		 */
		static public function add_admin_menu() {

			$parent_page    = self::$default_menu_position;
			$page_title     = self::$menu_page_title;
			$capability     = 'manage_options';
			$page_menu_slug = self::$plugin_slug;
			$page_menu_func = __CLASS__ . '::menu_callback';
            $page_white_level_menu_func = __CLASS__ . '::white_level_menu_callback';
			if ( apply_filters( 'zita_dashboard_admin_menu', true ) ) {
			
				add_theme_page( $page_title.' White Label', $page_title.' White Label', $capability, 'white-label', $page_white_level_menu_func );
			   
			
			} 
		}



        /**
		 * Menu callback
		 *
		 * @since 1.0
		 */
		static public function menu_callback() {

			$current_slug = isset( $_GET['action'] ) ? esc_attr( $_GET['action'] ) : self::$current_slug;

			$active_tab   = str_replace( '_', '-', $current_slug );
			$current_slug = str_replace( '-', '_', $current_slug );

			$ast_icon           = apply_filters( 'zita_page_top_icon', true );
			$ast_visit_site_url = apply_filters( 'zita_site_url', 'https://wpzita.com' );
			$ast_wrapper_class  = apply_filters( 'zita_welcome_wrapper_class', array( $current_slug ) );
			$my_theme = wp_get_theme();
			$zta_theme_version = $my_theme->get( 'Version' );
            
			?>
			<div class="zta-menu-page-wrapper wrap zta-clear <?php echo esc_attr( implode( ' ', $ast_wrapper_class ) ); ?>">
					<?php include_once 'starter-templates.php'; ?>
			</div>

			<?php

		}

		static public function white_level_menu_callback() {

			$current_slug = isset( $_GET['action'] ) ? esc_attr( $_GET['action'] ) : self::$current_slug;

			$active_tab   = str_replace( '_', '-', $current_slug );
			$current_slug = str_replace( '-', '_', $current_slug );

			$ast_icon           = apply_filters( 'zita_page_top_icon', true );
			$ast_visit_site_url = apply_filters( 'zita_site_url', 'https://wpzita.com' );
			$ast_wrapper_class  = apply_filters( 'zita_welcome_wrapper_class', array( $current_slug ) );
			$my_theme = wp_get_theme();
			$zta_theme_version = $my_theme->get( 'Version' );
            
			?>
            <div class="zitastarter-page-content"> 	
            <div class="zitastarter-container">
			<div class="zta-menu-page-wrapper wrap zta-clear <?php echo esc_attr( implode( ' ', $ast_wrapper_class ) ); ?>">
			   <div class="zitastarter-header">
            <header>
                <div class="logo-wrap">
                    <div class="logo"></div>
                    <span class="zita-theme-version"><?php echo  esc_html(self::$menu_page_title.' '.$zta_theme_version); ?></span>
                </div>
                
            </header>

            </div>	
			<?php 

			do_action( 'zita_menu_white_label_action' ); ?>
			</div>
		   </div>
		 </div>

			<?php

		}
   
 
		/**
		 * Update Admin Title.
		 *
		 * @since 1.0.19
		 *
		 * @param string $admin_title Admin Title.
		 * @param string $title Title.
		 * @return string
		 */
		static public function zita_admin_title( $admin_title, $title ) {

			$screen = get_current_screen();
			if ( 'appearance_page_zita' == $screen->id ) {

				$view_actions = self::get_view_actions();

				$current_slug = isset( $_GET['action'] ) ? esc_attr( $_GET['action'] ) : self::$current_slug;
				$active_tab   = str_replace( '_', '-', $current_slug );

				if ( 'general' != $active_tab && isset( $view_actions[ $active_tab ]['label'] ) ) {
					$admin_title = str_replace( $title, $view_actions[ $active_tab ]['label'], $admin_title );
				}
			}

			return $admin_title;
		}


       /**
		 * Required Plugin Activate
		 *
		 * @since 1.2.4
		 */
		static public function required_plugin_activate() {

			if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
				wp_send_json_error(
					array(
						'success' => false,
						'message' => __( 'No plugin specified', 'zita' ),
					)
				);
			}

			$plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : '';

			$activate = activate_plugin( $plugin_init, '', false, true );

			if ( is_wp_error( $activate ) ) {
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
					'message' => __( 'Plugin Successfully Activated', 'zita' ),
				)
			);

		}


		/**
		 * Activation Reset
		 */
		static public function activation_reset() {

			add_rewrite_endpoint( 'partial', EP_PERMALINK );
			// flush rewrite rules.
			flush_rewrite_rules();

			if ( is_network_admin() ) {
				$branding = get_site_option( '_zita_ext_white_label' );
			} else {
				$branding = get_option( '_zita_ext_white_label' );
			}

			if ( isset( $branding['zita-agency']['hide_branding'] ) && false != $branding['zita-agency']['hide_branding'] ) {

				$branding['zita-agency']['hide_branding'] = false;

				if ( is_network_admin() ) {

					update_site_option( '_zita_ext_white_label', $branding );

				} else {
					update_option( '_zita_ext_white_label', $branding );
				}
			}
		}

		
	}
   new Zita_Admin_Settings;
}