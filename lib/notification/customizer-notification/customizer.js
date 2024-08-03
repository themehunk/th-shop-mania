jQuery(document).ready(function($) {
    function handlePluginAction(pluginSlug, action) {
        $('.th-shop-mania-custom-control .loader').show();
        $.ajax({
            url: theme_data_customizer.ajax_url,
            type: 'POST',
            data: {
                action: 'th_shop_mania_install_and_activate_callback',
                security: theme_data_customizer.security,
                plugin_slug: pluginSlug
            },
            success: function(response) {
                $('.th-shop-mania-custom-control .loader').hide();
                if (response) {
                    $('#go-to-starter-sites').prop('disabled', false);
                } else {
                    alert('Error: ' + response.data.message);
                }
            },
            error: function(xhr, status, error) {
                $('.th-shop-mania-custom-control .loader').hide();
                console.error('Error:', error);
            }
        });
    }

    $('#activate-th-shop-mania-pro').on('click', function(event) {
        event.preventDefault();
        var pluginSlug = 'th-shop-mania-pro';
        handlePluginAction(pluginSlug, 'activate');
    });

    $('#activate-hunk-companion').on('click', function(event) {
        event.preventDefault();
        var pluginSlug = 'hunk-companion';
        handlePluginAction(pluginSlug, 'activate');
    });

    $('#install-hunk-companion').on('click', function(event) {
        event.preventDefault();
        var pluginSlug = 'hunk-companion';
        handlePluginAction(pluginSlug, 'install');
    });

    $('#go-to-starter-sites').on('click', function(event) {
        event.preventDefault();
        window.location.href = theme_data_customizer.redirectUrl;
    });
});


