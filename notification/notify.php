<?php
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

// Define the plugins to check
$plugin_pro_slug = 'th-shop-mania-pro';
$plugin_pro_file = 'th-shop-mania-pro/th-shop-mania-pro.php';
$plugin_companion_slug = 'hunk-companion';
$plugin_companion_file = 'hunk-companion/hunk-companion.php';

// Show admin notice to install or activate the secondary plugin
$plugin_pro_installed = is_plugin_active($plugin_pro_file);
$plugin_pro_exists = file_exists(WP_PLUGIN_DIR . '/' . $plugin_pro_file);
$plugin_companion_installed = is_plugin_active($plugin_companion_file);
$plugin_companion_exists = file_exists(WP_PLUGIN_DIR . '/' . $plugin_companion_file);
if (isset($_GET['page']) && $_GET['page'] == 'th_shop_mania_thunk_started' ) {
    add_action('admin_notices', 'th_shop_mania_display_admin_notice');
}
elseif((!$plugin_pro_exists && !$plugin_companion_exists) ||($plugin_pro_exists && !$plugin_pro_installed) || (!$plugin_pro_exists && $plugin_companion_exists && !$plugin_companion_installed)
) {
    add_action('admin_notices', 'th_shop_mania_display_admin_notice');
}
// Display admin notice
function th_shop_mania_display_admin_notice() {
    global $plugin_pro_file, $plugin_pro_slug, $plugin_companion_file, $plugin_companion_slug;
    global $current_user;
    $user_id   = $current_user->ID;
    $theme_data  = wp_get_theme();

    // Check if 'th-shop-mania-pro' is installed
    $plugin_pro_installed = is_plugin_active($plugin_pro_file);
    $plugin_pro_exists = file_exists(WP_PLUGIN_DIR . '/' . $plugin_pro_file);

    if ($plugin_pro_exists) {
        // 'th-shop-mania-pro' is installed
        if ($plugin_pro_installed) {
            // Plugin is activated
            echo '<div class="notice notice-info th-shop-mania-wrapper-banner is-dismissible">
                <div class="left"><h2 class="title">
                     '.sprintf( esc_html__( 'Thank you for installing %1$s - Version %2$s', 'th-shop-mania' ), apply_filters( 'thsm_page_title', __( 'Th Shop Mania', 'th-shop-mania' ) ), esc_html( $theme_data->Version ) ).'</h2>
                    <p>' . esc_html__('To take full advantage of all the features this theme has to offer, please install and activate the ', 'th-shop-mania') . '<strong>Starter plugin</strong></p>
                    <a href="' . esc_url(admin_url('themes.php?page=themehunk-site-library&template=step')) . '" class="button button-primary">' . esc_html__('Go to Starter Sites', 'th-shop-mania') . '<span class="dashicons dashicons-update loader"></span></a>
                </div>
                <div class="right">
                    <img src="' . esc_url(get_template_directory_uri() . '/notification/banner.png') . '" />
                </div>
            </div>';
        } else {
            // Plugin is installed but not activated
            echo '<div class="notice notice-info th-shop-mania-wrapper-banner is-dismissible">
                <div class="left">
                    <h2 class="title">
                     '.sprintf( esc_html__( 'Thank you for installing %1$s - Version %2$s', 'th-shop-mania' ), apply_filters( 'thsm_page_title', __( 'Th Shop Mania', 'th-shop-mania' ) ), esc_html( $theme_data->Version ) ).'</h2>
                    <p>' . esc_html__('To take full advantage of all the features this theme has to offer, please install and activate the ', 'th-shop-mania') . '<strong>TH Shop Mania Pro</strong></p>
                    <button class="button button-primary" id="activate-th-shop-mania-pro" data-slug="' . esc_attr($plugin_pro_slug) . '"><span>' . esc_html__('Activate', 'th-shop-mania') . '</span><span class="dashicons dashicons-update loader"></span></button>
                </div>
                <div class="right">
                    <img src="' . esc_url(get_template_directory_uri() . '/notification/banner.png') . '" />
                </div>
            </div>';
        }
    } else {
        // 'th-shop-mania-pro' is not installed, check 'hunk-companion'
        $plugin_companion_installed = is_plugin_active($plugin_companion_file);
        $plugin_companion_exists = file_exists(WP_PLUGIN_DIR . '/' . $plugin_companion_file);

        echo '<div class="notice notice-info th-shop-mania-wrapper-banner is-dismissible">
            <div class="left">
                  <h2 class="title">
                     '.sprintf( esc_html__( 'Thank you for installing %1$s - Version %2$s', 'th-shop-mania' ), apply_filters( 'thsm_page_title', __( 'Th Shop Mania', 'th-shop-mania' ) ), esc_html( $theme_data->Version ) ).'</h2>
                    <p>' . esc_html__('To take full advantage of all the features this theme has to offer, please install and activate the ', 'th-shop-mania') . '<strong>Starter plugin</strong></p>';

        if ($plugin_companion_exists) {
            if ($plugin_companion_installed) {
                echo '<button class="button button-primary" id="go-to-starter-sites" data-slug="' . esc_attr($plugin_pro_slug) . '">' . esc_html__('Go to Starter Sites', 'th-shop-mania') . '<span class="dashicons dashicons-update loader"></span></button>';
            } else {
                echo '<button class="button button-primary" id="activate-hunk-companion" data-slug="' . esc_attr($plugin_companion_slug) . '"><span>' . esc_html__('Activate', 'th-shop-mania') . '</span><span class="dashicons dashicons-update loader"></span></button>';
            }
        } else {
            echo '<button class="button button-primary" id="install-hunk-companion" data-slug="' . esc_attr($plugin_companion_slug) . '"><span>' . esc_html__('Install', 'th-shop-mania') . '</span><span class="dashicons dashicons-update loader"></span></button>';
        }

        echo '</div>
            <div class="right">
                <img src="' . esc_url(get_template_directory_uri() . '/notification/banner.png') . '" />
            </div>
        </div>';
    }
}

// Custom function to check if a plugin is installed
function th_shop_mania_is_plugin_installed($plugin_slug) {
    $plugin_dir = WP_PLUGIN_DIR . '/' . $plugin_slug;
    return is_dir($plugin_dir);
}

function th_shop_mania_install_custom_plugin($plugin_slug) {
    require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

    $plugin_info = plugins_api('plugin_information', array('slug' => $plugin_slug));

    if (is_wp_error($plugin_info)) {
        return $plugin_info->get_error_message();
    }

    $upgrader = new Plugin_Upgrader(new Plugin_Installer_Skin(array(
        'api' => $plugin_info,
    )));

    $result = $upgrader->install($plugin_info->download_link);

    if (is_wp_error($result)) {
        return $result->get_error_message();
    }

    return "success";
}

// AJAX handler for installing and activating plugins
add_action('wp_ajax_th_shop_mania_install_and_activate_callback', 'th_shop_mania_install_and_activate_callback');
add_action('wp_ajax_nopriv_th_shop_mania_install_and_activate_callback', 'th_shop_mania_install_and_activate_callback');

// Callback function to install and activate plugin
function th_shop_mania_install_and_activate_callback() {
    // Check nonce for security
    check_ajax_referer('vayunonce', 'security');

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


function th_shop_mania_admin_script() {
    wp_enqueue_style('th-shop-mania-admin-css', get_template_directory_uri() . '/notification/css/admin.css', array(), '1.0.0', 'all');
    wp_enqueue_script('th-shop-mania-notifyjs', get_template_directory_uri() . '/notification/js/notify.js', array('jquery'), '1.0', true);

    // Pass AJAX URL to the script
    wp_localize_script('th-shop-mania-notifyjs', 'theme_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('vayunonce'), // Create nonce for security
        'redirectUrl' => esc_url(admin_url('themes.php?page=themehunk-site-library&template=step')) // Generate dynamic URL
    ));
}
add_action('admin_enqueue_scripts', 'th_shop_mania_admin_script');

function th_shop_mania_check_plugin_status() {
    $plugin_slug = isset($_POST['plugin_slug']) ? sanitize_text_field($_POST['plugin_slug']) : '';
    $status = '';

    // Check if the plugin slug is provided
    if (empty($plugin_slug)) {
        wp_send_json_error('Plugin slug is missing.');
    }

    // Check if the plugin is installed
    if (th_shop_mania_is_plugin_installed($plugin_slug)) {
        // Check if the plugin is activated
        if (is_plugin_active($plugin_slug . '/' . $plugin_slug . '.php')) {
            $status = 'activated';
        } else {
            $status = 'installed';
        }
    } else {
        $status = 'notinstalled';
    }

    // Send the status as a JSON object
    wp_send_json_success(array('status' => $status));
}

add_action('wp_ajax_th_shop_mania_check_plugin_status', 'th_shop_mania_check_plugin_status');
add_action('wp_ajax_nopriv_th_shop_mania_check_plugin_status', 'th_shop_mania_check_plugin_status');
?>
