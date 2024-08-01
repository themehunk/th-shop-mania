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
         $('.left .loader').show();
        $.ajax({
            url: theme_data.ajax_url,
            type: 'POST',
             dataType: 'html',
            data: {
                action: 'th_shop_mania_install_and_activate_callback',
                security: theme_data.security,
                plugin_slug: pluginSlug
            },
          success: function(response) {
                // Check if the request was successful
                if (response) {
                    // location.reload();
                     window.location.href = theme_data.redirectUrl;
                             setTimeout(function() {
                                    $('.left .loader').hide();
                                }, 2000);
                } else {
                    // Error occurred during installation and activation
                    alert('Error: ' + response.data.message);
                }
            },
            error: function(xhr, status, error) {
                 $('.left .loader').hide();
                // Error occurred during AJAX request
                console.error('Error:', error);
            }
        });
    }



});


