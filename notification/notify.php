<?php
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

// Define the plugins to check
$plugin_pro_slug = 'th-shop-mania-pro';
$plugin_pro_file = 'th-shop-mania-pro/th-shop-mania-pro.php';
$plugin_companion_slug = 'hunk-companion';
$plugin_companion_file = 'hunk-companion/hunk-companion.php';

// Show admin notice to install or activate the secondary plugin
add_action('admin_notices', 'vayu_x_display_admin_notice');

// Display admin notice
function vayu_x_display_admin_notice() {
    global $plugin_pro_file, $plugin_pro_slug, $plugin_companion_file, $plugin_companion_slug;

    $plugin_pro_installed = file_exists(WP_PLUGIN_DIR . '/' . $plugin_pro_file);
    $plugin_pro_active = is_plugin_active($plugin_pro_file);

    if ($plugin_pro_installed) {
        if ($plugin_pro_active) {
            echo '<div class="notice notice-info vayu-wrapper-banner is-dismissible">
                <div class="left">
                    <h2 class="title">' . esc_html__('Thank you for installing "th-shop-mania-pro"', 'vayu-x') . '</h2>
                    <p>' . esc_html__('The plugin is active. You can go to starter sites now.', 'vayu-x') . '</p>
                    <a href="' . esc_url(admin_url('admin.php?page=starter-sites')) . '" class="button button-primary" id="go-to-starter-sites">' . esc_html__('Go to Starter Sites', 'vayu-x') . '</a>
                </div>
                <div class="right">
                    <img src="' . esc_url(get_template_directory_uri() . '/notification/banner.png') . '" />
                </div>
            </div>';
        } else {
            echo '<div class="notice notice-info vayu-wrapper-banner is-dismissible">
                <div class="left">
                    <h2 class="title">' . esc_html__('Please Activate "th-shop-mania-pro"', 'vayu-x') . '</h2>
                    <p>' . esc_html__('The plugin is installed but not activated. Please activate it to continue.', 'vayu-x') . '</p>
                    <button class="button button-primary" id="activate-th-shop-mania-pro">' . esc_html__('Activate', 'vayu-x') . '</button>
                </div>
                <div class="right">
                    <img src="' . esc_url(get_template_directory_uri() . '/notification/banner.png') . '" />
                </div>
            </div>';
        }
    } else {
        $plugin_companion_installed = file_exists(WP_PLUGIN_DIR . '/' . $plugin_companion_file);
        $plugin_companion_active = is_plugin_active($plugin_companion_file);

        echo '<div class="notice notice-info vayu-wrapper-banner is-dismissible">
            <div class="left">
                <h2 class="title">' . esc_html__('Import Demo Content', 'vayu-x') . '</h2>
                <p>' . esc_html__('Install "Starter site plugin" mentioned below to activate import demo button.', 'vayu-x') . '</p>';

        if ($plugin_companion_installed) {
            if ($plugin_companion_active) {
                echo '<button class="button button-primary" id="go-to-starter-sites">' . esc_html__('Go to Starter Sites', 'vayu-x') . '</button>';
            } else {
                echo '<button class="button button-primary" id="activate-hunk-companion" data-slug="' . esc_attr($plugin_companion_slug) . '">' . esc_html__('Activate', 'vayu-x') . '</button>';
            }
        } else {
            echo '<button class="button button-primary" id="install-hunk-companion" data-slug="' . esc_attr($plugin_companion_slug) . '">' . esc_html__('Install', 'vayu-x') . '</button>';
        }

        echo '</div>
            <div class="right">
                <img src="' . esc_url(get_template_directory_uri() . '/notification/banner.png') . '" />
            </div>
        </div>';
    }
}

// Custom function to check if a plugin is installed
function vayu_x_is_plugin_installed($plugin_slug) {
    $plugin_dir = WP_PLUGIN_DIR . '/' . $plugin_slug;
    return is_dir($plugin_dir);
}

function vayu_install_custom_plugin($plugin_slug) {
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
add_action('wp_ajax_vayu_blocks_install_and_activate_callback', 'vayu_blocks_install_and_activate_callback');
add_action('wp_ajax_nopriv_vayu_blocks_install_and_activate_callback', 'vayu_blocks_install_and_activate_callback');

// Callback function to install and activate plugin
// Callback function to install and activate plugin
function vayu_blocks_install_and_activate_callback() {
    // Check nonce for security
    check_ajax_referer('vayunonce', 'security');

    // Retrieve plugin slug from AJAX request
    $plugin_slug = isset($_POST['plugin_slug']) ? sanitize_text_field($_POST['plugin_slug']) : '';

    if (empty($plugin_slug)) {
        wp_send_json_error(array('message' => 'Plugin slug is missing.'));
    }

    // Get the full path to the main plugin file
    $plugin_file = WP_PLUGIN_DIR . '/' . $plugin_slug . '/' . $plugin_slug . '.php';

    // Check if the plugin is installed but not activated
    if (vayu_x_is_plugin_installed($plugin_slug) && !is_plugin_active($plugin_file)) {
        // Activate the plugin
        $status = activate_plugin($plugin_file);
        if (is_wp_error($status)) {
            wp_send_json_error(array('message' => $status->get_error_message()));
        }
    } else {
        // Install the plugin
        $status = vayu_install_custom_plugin($plugin_slug);
        if (is_wp_error($status)) {
            wp_send_json_error(array('message' => $status->get_error_message()));
        }

        // Activate the plugin
        $status = activate_plugin($plugin_file);
        if (is_wp_error($status)) {
            wp_send_json_error(array('message' => $status->get_error_message()));
        }
    }

    // Return success response
    wp_send_json_success(array('message' => 'Plugin installed and activated successfully.'));
}


function vayu_x_admin_script() {
    wp_enqueue_style('vayu-x-admin-css', get_template_directory_uri() . '/notification/css/admin.css', array(), '1.0.0', 'all');
    wp_enqueue_script('vayu-x-notifyjs', get_template_directory_uri() . '/notification/js/notify.js', array('jquery'), '1.0', true);

    // Pass AJAX URL to the script
    wp_localize_script('vayu-x-notifyjs', 'theme_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('vayunonce'), // Create nonce for security
        'redirectUrl' => admin_url('admin.php?page=themehunk-site-library&template=step') // Generate dynamic URL
    ));
}
add_action('admin_enqueue_scripts', 'vayu_x_admin_script');

function vayu_check_plugin_status() {
    $plugin_slug = isset($_POST['plugin_slug']) ? sanitize_text_field($_POST['plugin_slug']) : '';
    $status = '';

    // Check if the plugin slug is provided
    if (empty($plugin_slug)) {
        wp_send_json_error('Plugin slug is missing.');
    }

    // Check if the plugin is installed
    if (vayu_x_is_plugin_installed($plugin_slug)) {
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

add_action('wp_ajax_vayu_check_plugin_status', 'vayu_check_plugin_status');
add_action('wp_ajax_nopriv_vayu_check_plugin_status', 'vayu_check_plugin_status');
?>
