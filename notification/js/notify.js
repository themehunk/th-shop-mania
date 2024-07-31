jQuery(document).ready(function($) {
    // Handle button clicks for activating plugins
    $('#activate-th-shop-mania-pro').on('click', function() {
        var pluginSlug = $(this).data('slug');
        handlePluginAction(pluginSlug, 'activate');
    });

    $('#activate-hunk-companion').on('click', function() {
        var pluginSlug = $(this).data('slug');
        handlePluginAction(pluginSlug, 'activate');
    });

    $('#install-hunk-companion').on('click', function() {
        var pluginSlug = $(this).data('slug');
        handlePluginAction(pluginSlug, 'install');
    });

    $('#go-to-starter-sites').on('click', function() {
        window.location.href = theme_data.redirectUrl;
    });

    function handlePluginAction(pluginSlug, action) {
        $.ajax({
            url: theme_data.ajax_url,
             method: 'POST',
            dataType: 'html',
            data: {
                action: 'th_shop_mania_install_and_activate_callback',
                security: theme_data.security,
                plugin_slug: pluginSlug
            },
            success: function(response) {
                if (response) {
                    if (action === 'install') {
                        // If install was successful, attempt activation
                        $('#activate-' + pluginSlug).click();
                    } else {
                        // If activation was successful, reload page or handle success
                        location.reload();
                    }
                } else {
                    alert(response.data.message);
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX error: ' + error);
            }
        });
    }
});
