jQuery(document).ready(function($) {
    function handlePluginAction(pluginSlug, action) {
        let activetext = '';
        if (action == 'install') {
            activetext = 'Installing...';
        }
        else{
            activetext = 'Activating...';
        }
        $('.th-shop-mania-custom-section span.text').text(activetext);
        $('.th-shop-mania-custom-section .th-loader').css("display", "inline-block");
        $.ajax({
            url: theme_data_customizer.ajax_url,
            type: 'POST',
            data: {
                action: 'th_shop_mania_install_and_activate_callback',
                security: theme_data_customizer.security,
                plugin_slug: pluginSlug
            },
            success: function(response) {
                if (response) {
                    $('#go-to-starter-sites').prop('disabled', false);
                     // $('#go-to-starter-sites').show();
                     // $('.th-shop-mania-custom-section button:nth-of-type(1)').prop('disabled', true).hide();
                     window.location.href = theme_data_customizer.redirectUrl;
                     $('.th-shop-mania-custom-section .th-loader').hide();
                } else {
                    alert('Error: ' + response.data.message);
                }
            },
            error: function(xhr, status, error) {
                $('.th-shop-mania-custom-section .th-loader').hide();
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


