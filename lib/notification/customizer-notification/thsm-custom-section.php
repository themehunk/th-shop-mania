<?php
if (class_exists('WP_Customize_Section')) {

    class TH_Shop_Mania_Custom_Section extends WP_Customize_Section {
        public $type = 'th_shop_mania_custom_section';

        protected function render_template() {
            ?>
            <# if (data.title) { #>
            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <h3 class="accordion-section-title">
                    <span class="section-title">
                        {{ data.title }}
                    </span>
                </h3>
                <div class="th-shop-mania-custom-section">
                    <?php
                    // Add your buttons here based on the plugin status
                    $plugin_pro_file = 'th-shop-mania-pro/th-shop-mania-pro.php';
                    $plugin_companion_file = 'hunk-companion/hunk-companion.php';

                    $plugin_pro_installed = is_plugin_active($plugin_pro_file);
                    $plugin_pro_exists = file_exists(WP_PLUGIN_DIR . '/' . $plugin_pro_file);
                    $plugin_companion_installed = is_plugin_active($plugin_companion_file);
                    $plugin_companion_exists = file_exists(WP_PLUGIN_DIR . '/' . $plugin_companion_file);

                    $go_to_starter_sites_disabled = true;

                    if ($plugin_pro_exists) {
                        if ($plugin_pro_installed) {
                            $go_to_starter_sites_disabled = false;
                        } else {
                            echo '<p>'. esc_html__('To take full advantage of all the features this theme has to offer, please install and activate the TH Shop Mania Pro', 'th-shop-mania') .'</p><button class="button button-primary" id="activate-th-shop-mania-pro"><span class="text">'. esc_html__('Activate', 'th-shop-mania') .'</span><span class="icon dashicons dashicons-update th-loader"></span></button>';
                        }
                    } elseif ($plugin_companion_exists) {
                        if ($plugin_companion_installed) {
                            $go_to_starter_sites_disabled = false;
                        } else {
                            echo '<p>'. esc_html__('To take full advantage of all the features this theme has to offer, please install and activate the Hunk Companion', 'th-shop-mania') .'</p><button class="button button-primary" id="activate-hunk-companion"><span class="text">'. esc_html__('Activate', 'th-shop-mania') .'</span><span class="icon dashicons dashicons-update th-loader"></span></button>';
                        }
                    } else {
                        echo '<p>'. esc_html__('To take full advantage of all the features this theme has to offer, please install and activate the Hunk Companion', 'th-shop-mania') .'</p><button class="button button-primary" id="install-hunk-companion"><span class="text">'. esc_html__('Install Now', 'th-shop-mania') .'</span><span class="icon dashicons dashicons-update th-loader"></span></button>';
                    }

                    // Go to Starter Sites button (always present, conditionally enabled/disabled)
                    echo '<button class="button button-primary" id="go-to-starter-sites" ' . ($go_to_starter_sites_disabled ? 'disabled' : '') . '>' . esc_html__('Go to Starter Sites', 'th-shop-mania') . '</button>';
                    ?>
                </div>
            </li>
            <# } #>
            <?php
        }
    }
}

function th_shop_mania_customize_install_register($wp_customize) {
    $wp_customize->register_section_type('TH_Shop_Mania_Custom_Section');

    $wp_customize->add_section(
        new TH_Shop_Mania_Custom_Section(
            $wp_customize,
            'th_shop_mania_custom_section',
            array(
                'title' => __('Thank You for installing Shop Mania Theme', 'th-shop-mania'),
                'priority' => 1,
            )
        )
    );
}
add_action('customize_register', 'th_shop_mania_customize_install_register' , 1);
