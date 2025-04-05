<?php
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    function th_shop_mania_set_cookie() { 
        $expire_time = time() + (86400 * 7); // 7 days in seconds
        
        if (!isset($_COOKIE['th_shop_mania_thms_time'])) {
                // Set a cookie for 7 days
        setcookie('th_shop_mania_thms_time', $expire_time, $expire_time, COOKIEPATH, COOKIE_DOMAIN);
            }

        }
    function th_shop_mania_unset_cookie(){

        $visit_time = time();
        if (isset($_COOKIE['th_shop_mania_thms_time']) && $_COOKIE['th_shop_mania_thms_time'] < $visit_time) {
            setcookie('th_shop_mania_thms_time', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN);
        }
    }

    function th_shop_mania_clear_notice_cookie() {
    // Clear the cookie when the theme is switched
        if (isset($_COOKIE['th_shop_mania_thms_time'])) {
            setcookie('th_shop_mania_thms_time', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN);
        }
    }

    if(isset($_GET['notice-disable']) && $_GET['notice-disable'] == true){
        add_action('admin_init', 'th_shop_mania_set_cookie');
    }


    if(!isset($_COOKIE['th_shop_mania_thms_time'])) {
       add_action('admin_notices', 'th_shop_mania_display_admin_notice');

   }

   if(isset($_COOKIE['th_shop_mania_thms_time'])) {
    add_action( 'admin_notices', 'th_shop_mania_unset_cookie');
}

// add_action('admin_notices', 'th_shop_mania_display_admin_notice');

// Display admin notice
function th_shop_mania_display_admin_notice() {

     $allowed_pages = array(
        'dashboard',             // index.php
        'themes',                // themes.php
        'plugins',               // plugins.php
        'users',
        'appearance_page_th_shop_mania_thunk_started' // appearance_page_thunk_started
    );

    // Get the current screen
    $current_screen = get_current_screen();

    // Check if the current screen is one of the allowed pages
    if (!in_array($current_screen->base, $allowed_pages)) {
        return; // Exit if not on an allowed page
    }

     global $current_user;
    $user_id   = $current_user->ID;
    $theme_data  = wp_get_theme();

    if ( get_user_meta( $user_id, esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore' ) ) {
        return;
    }

// Retrieve the theme support data
    $plugin_data = get_theme_support('recommend-plugins');

// Check if the theme support exists and has the plugin data

    $plugin_data = $plugin_data[0];

    // Get the specific plugin data
    $hunk_companion = isset($plugin_data['hunk-companion']) ? $plugin_data['hunk-companion'] : array();
    $th_shop_mania_pro = isset($hunk_companion['pro-plugin']) ? $hunk_companion['pro-plugin'] : array();

    // Extract the values
    $plugin_pro_slug = isset($th_shop_mania_pro['slug']) ? $th_shop_mania_pro['slug'] : '';
    $plugin_pro_file = isset($th_shop_mania_pro['init']) ? $th_shop_mania_pro['init'] : '';
    $plugin_companion_slug = isset($plugin_data['hunk-companion']['slug']) ? $plugin_data['hunk-companion']['slug'] : 'hunk-companion';
    $plugin_companion_file = isset($plugin_data['hunk-companion']['active_filename']) ? $plugin_data['hunk-companion']['active_filename'] : '';


    // Show admin notice to install or activate the secondary plugin
    $plugin_pro_installed = is_plugin_active($plugin_pro_file);
    $plugin_pro_exists = file_exists(WP_PLUGIN_DIR . '/' . $plugin_pro_file);
    $plugin_companion_installed = is_plugin_active($plugin_companion_file);
    $plugin_companion_exists = file_exists(WP_PLUGIN_DIR . '/' . $plugin_companion_file);

    // Check if 'th-shop-mania-pro' is installed
    $plugin_pro_installed = is_plugin_active($plugin_pro_file);
    $plugin_pro_exists = file_exists(WP_PLUGIN_DIR . '/' . $plugin_pro_file);

 if ((isset($_GET['page']) && $_GET['page'] == 'th_shop_mania_thunk_started' ) || ((!$plugin_pro_exists && !$plugin_companion_exists) ||($plugin_pro_exists && !$plugin_pro_installed) || (!$plugin_pro_exists && $plugin_companion_exists && !$plugin_companion_installed)) ) {


    if ($plugin_pro_exists) {
        // 'th-shop-mania-pro' is installed
        if ($plugin_pro_installed) {
            // Plugin is activated
            echo '<div class="notice notice-info th-shop-mania-wrapper-banner is-dismissible">
                <div class="left"><h2 class="title">
                     '.sprintf( esc_html__( 'Thank you for installing %1$s - Version %2$s', 'th-shop-mania' ), esc_html(apply_filters( 'thsm_page_title', esc_html__( 'Th Shop Mania', 'th-shop-mania' ) )), esc_html( $theme_data->Version ) ).'</h2>
                    <p>' . esc_html__('To take full advantage of all the features this theme has to offer, please install and activate the ', 'th-shop-mania') . '<strong>Hunk Companion</strong></p>
                    <button class="button button-primary" id="go-to-starter-sites" data-slug="' . esc_attr($plugin_pro_slug) . '">' . esc_html__('Go to Ready To Import website Templates ', 'th-shop-mania') . '</button>
                </div>
                <div class="right">
                    <img src="' . esc_url(get_template_directory_uri() . '/lib/notification/banner.png') . '" />
                </div>
                <a href="?notice-disable=1" class="notice-dismiss dashicons dashicons-dismiss dashicons-dismiss-icon"></a>
            </div>';
        } else {
            // Plugin is installed but not activated
            echo '<div class="notice notice-info th-shop-mania-wrapper-banner is-dismissible">
                <div class="left">
                    <h2 class="title">
                     '.sprintf( esc_html__( 'Thank you for installing %1$s - Version %2$s', 'th-shop-mania' ), esc_html(apply_filters( 'thsm_page_title', esc_html__( 'Th Shop Mania', 'th-shop-mania' ) )), esc_html( $theme_data->Version ) ).'</h2>
                    <p>' . esc_html__('To take full advantage of all the features this theme has to offer, please install and activate the ', 'th-shop-mania') . '<strong>TH Shop Mania Pro</strong></p>
                    <button class="button button-primary" id="activate-th-shop-mania-pro" data-slug="' . esc_attr($plugin_pro_slug) . '"><span>' . esc_html__('Activate', 'th-shop-mania') . '</span><span class="dashicons dashicons-update loader"></span></button>
                     <button class="button button-primary" id="go-to-starter-sites" data-slug="' . esc_attr($plugin_pro_slug) . '" disabled>' . esc_html__('Go to Ready To Import website Templates ', 'th-shop-mania') . '</button>
                </div>
                <div class="right">
                    <img src="' . esc_url(get_template_directory_uri() . '/lib/notification/banner.png') . '" />
                </div>
                <a href="?notice-disable=1" class="notice-dismiss dashicons dashicons-dismiss dashicons-dismiss-icon"></a>
            </div>';
        }
    } else {
        // 'th-shop-mania-pro' is not installed, check 'hunk-companion'
        $plugin_companion_installed = is_plugin_active($plugin_companion_file);
        $plugin_companion_exists = file_exists(WP_PLUGIN_DIR . '/' . $plugin_companion_file);

        echo '<div class="notice notice-info th-shop-mania-wrapper-banner is-dismissible">
            <div class="left">
                  <h2 class="title">
                     '.sprintf( esc_html__( 'Thank you for installing %1$s - Version %2$s', 'th-shop-mania' ), esc_html(apply_filters( 'thsm_page_title', esc_html__( 'Th Shop Mania', 'th-shop-mania' ) )), esc_html( $theme_data->Version ) ).'</h2>
                    <p>' . esc_html__('To take full advantage of all the features this theme has to offer, please install and activate the ', 'th-shop-mania') . '<strong>Hunk Companion</strong></p>';

        if ($plugin_companion_exists) {
            if ($plugin_companion_installed) {
                echo '<button class="button button-primary" id="go-to-starter-sites" data-slug="' . esc_attr($plugin_pro_slug) . '">' . esc_html__('Go to Ready To Import website Templates ', 'th-shop-mania') . '<span class="dashicons dashicons-update loader"></span></button>';
            } else {
                echo '<button class="button button-primary" id="activate-hunk-companion" data-slug="' . esc_attr($plugin_companion_slug) . '"><span>' . esc_html__('Activate', 'th-shop-mania') . '</span><span class="dashicons dashicons-update loader"></span></button> <button class="button button-primary" id="go-to-starter-sites" data-slug="' . esc_attr($plugin_pro_slug) . '" disabled>' . esc_html__('Go to Ready To Import website Templates ', 'th-shop-mania') . '</button>';
            }
        } else {
            echo '<button class="button button-primary" id="install-hunk-companion" data-slug="' . esc_attr($plugin_companion_slug) . '"><span>' . esc_html__('Install', 'th-shop-mania') . '</span><span class="dashicons dashicons-update loader"></span></button><button class="button button-primary" id="go-to-starter-sites" data-slug="' . esc_attr($plugin_pro_slug) . '"disabled >' . esc_html__('Go to Ready To Import website Templates ', 'th-shop-mania') . '</button>';
        }

        echo '</div>
            <div class="right">
                <img src="' . esc_url(get_template_directory_uri() . '/lib/notification/banner.png') . '" />
            </div>
             <a href="?notice-disable=1" class="notice-dismiss dashicons dashicons-dismiss dashicons-dismiss-icon"></a>
        </div>';
    }
}
}

// Custom function to check if a plugin is installed
// Safely install a plugin from WordPress.org
/**
 * Safely install a plugin from a trusted download link WordPress.org.
 *
 * @param object $plugin_info Plugin info object (must contain download_link).
 * @return void
 */
function th_shop_mania_install_custom_plugin( $plugin_slug ) {
	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';

	// Ensure the plugin slug is sanitized (just for extra safety)
	$plugin_slug = sanitize_key( $plugin_slug );

	// Fetch plugin data from WordPress.org API — this is a trusted source
	$plugin_info = plugins_api( 'plugin_information', array( 'slug' => $plugin_slug ) );

	if ( is_wp_error( $plugin_info ) ) {
		return $plugin_info->get_error_message();
	}

	// Validate download_link from the API response
	if (
		empty( $plugin_info->download_link ) ||
		! filter_var( $plugin_info->download_link, FILTER_VALIDATE_URL ) ||
		! wp_http_validate_url( $plugin_info->download_link )
	) {
		wp_die( esc_html__( 'Invalid plugin source.', 'th-shop-mania' ) );
	}

	// Restrict installation to plugins from WordPress.org only
	$parsed_url = wp_parse_url( $plugin_info->download_link );
	$allowed_hosts = array( 'downloads.wordpress.org' );

	if ( ! isset( $parsed_url['host'] ) || ! in_array( $parsed_url['host'], $allowed_hosts, true ) ) {
		wp_die( esc_html__( 'Untrusted plugin source.', 'th-shop-mania' ) );
	}

	// Now safe to proceed
	$upgrader = new Plugin_Upgrader(
		new Plugin_Installer_Skin(
			array(
				'api' => $plugin_info,
			)
		)
	);

	$result = $upgrader->install( esc_url_raw( $plugin_info->download_link ) );

	if ( is_wp_error( $result ) ) {
		return $result->get_error_message();
	}

	return 'success';
}

if ( !function_exists('th_shop_mania_install_and_activate_callback') ) {

// AJAX handler for installing and activating plugins
add_action('wp_ajax_th_shop_mania_install_and_activate_callback', 'th_shop_mania_install_and_activate_callback');

// Callback function to install and activate plugin
function th_shop_mania_install_and_activate_callback() {

    if ( ! current_user_can( 'administrator' ) ) {

        wp_die( - 1, 403 );
        
    } 
    // Check nonce for security
    check_ajax_referer('thactivatenonce', 'security');

    // Retrieve plugin slug from AJAX request
    $plugin_slug = isset($_POST['plugin_slug']) ? sanitize_text_field($_POST['plugin_slug']) : '';

    if (empty($plugin_slug)) {
        wp_send_json_error(array('message' => 'Plugin slug is missing.'));
        return;
    }

    $plugin_file = WP_PLUGIN_DIR . '/' . $plugin_slug . '/' . $plugin_slug . '.php';

    // Install the plugin
    if (!file_exists($plugin_file)) {
        // Start output buffering to capture the plugin installation output
        ob_start();
        
        $status = th_shop_mania_install_custom_plugin($plugin_slug);
        
        // Get the buffered content
        $install_output = ob_get_clean();
        
        if (is_wp_error($status)) {
            wp_send_json_error(array('message' => $status->get_error_message(), 'install_output' => $install_output));
            return;
        }
        
        // Check if the plugin file exists after installation
        if (!file_exists($plugin_file)) {
            wp_send_json_error(array('message' => 'Plugin file does not exist after installation.', 'install_output' => $install_output));
            return;
        }
    }

    // Activate the plugin
    if (!is_plugin_active($plugin_file)) {
        $status = activate_plugin($plugin_file);
        if (is_wp_error($status)) {
            wp_send_json_error(array('message' => $status->get_error_message()));
            return;
        }
       
    }
     return 'Plugin installed and activated successfully.';
   
}

}

function th_shop_mania_admin_script($hook_suffix) {
    // Define the pages where the script should be enqueued
    $allowed_pages = array(
        'index.php',
        'themes.php',
        'plugins.php',
        'users.php',
        'appearance_page_th_shop_mania_thunk_started'
    );

    // Check if the current page is one of the allowed pages
    if (!in_array($hook_suffix, $allowed_pages)) {
        return;
    }

    // Enqueue styles and scripts only on the allowed pages
    wp_enqueue_style('th-shop-mania-admin-css', get_template_directory_uri() . '/lib/notification/css/admin.css', array(), TH_SHOP_MANIA_THEME_VERSION, 'all');
    wp_enqueue_script('th-shop-mania-notifyjs', get_template_directory_uri() . '/lib/notification/js/notify.js', array('jquery'), TH_SHOP_MANIA_THEME_VERSION, true);

    // Pass AJAX URL to the script
    wp_localize_script('th-shop-mania-notifyjs', 'theme_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('thactivatenonce'), // Create nonce for security
        'redirectUrl' => esc_url(admin_url('themes.php?page=themehunk-site-library&template=step')) // Generate dynamic URL
    ));
}
add_action('admin_enqueue_scripts', 'th_shop_mania_admin_script');

// Hook the function to clear the cookie when the theme is switched to
add_action('after_switch_theme', 'th_shop_mania_clear_notice_cookie');

?>
