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
                    $('.left .loader').hide();
                    $('#go-to-starter-sites').prop('disabled', false);
                     $('p + button').text('Activated').prop('disabled', true);
                     // window.location.href = theme_data.redirectUrl;
                             // setTimeout(function() {
                             //        $('.left .loader').hide();
                             //    }, 2000);
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

    $('.notice-dismiss').on('click', function(e) {
        e.preventDefault();

        var confirmation = confirm('Are you sure you want to close the banner?');
        if (confirmation) {
            var link = $(this).attr('href');
            if (link) {

                // Set the cookie to prevent the notice from showing again for 12 days
                var date = new Date();
                date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
                document.cookie = "th_shop_mania_thms_time=" + date.getTime() + "; expires=" + date.toUTCString() + "; path=/";

                // Redirect to set the cookie
                window.location.href = link;
            }
        }
    });

});


