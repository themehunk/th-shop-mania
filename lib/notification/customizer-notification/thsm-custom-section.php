<?php
if ( ! class_exists( 'WP_Customize_Control' ) ) {
    return;
}
class TH_Shop_Mania_Customizer_Notice_Section extends WP_Customize_Section {
    public $type = 'customizer-plugin-notice-section';
    public $recommended_plugins = '';

    public function check_active($slug) {
        if (file_exists(WP_PLUGIN_DIR . '/' . $slug . '/' . $slug . '.php')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
            $needs = is_plugin_active($slug . '/' . $slug . '.php') ? 'deactivate' : 'activate';
            return array('status' => is_plugin_active($slug . '/' . $slug . '.php'), 'needs' => $needs);
        }
        return array('status' => false, 'needs' => 'install');
    }

    public function create_action_link($state, $slug) {
        switch ($state) {
            case 'install':
                return wp_nonce_url(
                    add_query_arg(
                        array('action' => 'install-plugin', 'plugin' => $slug),
                        network_admin_url('update.php')
                    ),
                    'install-plugin_' . $slug
                );
            case 'deactivate':
                return add_query_arg(
                    array(
                        'action' => 'deactivate',
                        'plugin' => rawurlencode($slug . '/' . $slug . '.php'),
                        'plugin_status' => 'all',
                        'paged' => '1',
                        '_wpnonce' => wp_create_nonce('deactivate-plugin_' . $slug . '/' . $slug . '.php'),
                    ),
                    network_admin_url('plugins.php')
                );
            case 'activate':
                return add_query_arg(
                    array(
                        'action' => 'activate',
                        'plugin' => rawurlencode($slug . '/' . $slug . '.php'),
                        'plugin_status' => 'all',
                        'paged' => '1',
                        '_wpnonce' => wp_create_nonce('activate-plugin_' . $slug . '/' . $slug . '.php'),
                    ),
                    network_admin_url('plugins.php')
                );
        }
    }

    public function json() {
        $json = parent::json();
        $customize_plugins = array();

        $plugins = array(
            'th-shop-mania-pro' => 'TH Shop Mania Pro',
            'hunk-companion' => 'Hunk Companion',
        );

        foreach ($plugins as $slug => $name) {
            $active = $this->check_active($slug);
            $plugin = array(
                'url' => $this->create_action_link($active['needs'], $slug),
                'class' => $active['needs'] !== 'install' && $active['status'] ? 'active' : '',
                'button_class' => $active['needs'] . '-now button' . ($active['needs'] === 'activate' ? ' button-primary' : ''),
                'button_label' => ucfirst($active['needs']),
                'title' => $name,
                'plugin_slug' => $slug,
            );
            $customize_plugins[] = $plugin;
        }

        $json['recommended_plugins'] = $customize_plugins;
        return $json;
    }

    protected function render_template() {
        ?>
        <# if (data.recommended_plugins.length > 0) { #>
        <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
            <h3 class="accordion-section-title">
                <span class="section-title">
                    {{ data.title }}
                </span>
            </h3>
            <div class="recommended-actions_container" id="plugin-filter">
                <# for (var action in data.recommended_plugins) { #>
                <div class="recommended-actions">
                    <p class="title">{{ data.recommended_plugins[action].title }}</p>
                    <div class="description">
                        <p>Click the button below to {{ data.recommended_plugins[action].button_label }} the plugin.</p>
                    </div>
                    <div class="custom-action">
                        <p class="plugin-card-{{ data.recommended_plugins[action].plugin_slug }} action_button {{ data.recommended_plugins[action].class }}">
                            <a data-slug="{{ data.recommended_plugins[action].plugin_slug }}"
                               class="{{ data.recommended_plugins[action].button_class }}"
                               href="{{ data.recommended_plugins[action].url }}">{{ data.recommended_plugins[action].button_label }}</a>
                        </p>
                    </div>
                </div>
                <# } #>
            </div>
        </li>
        <# } #>
        <?php
    }
}