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
            type: 'POST',
            data: {
                action: 'vayu_blocks_install_and_activate_callback',
                security: theme_data.security,
                plugin_slug: pluginSlug
            },
            success: function(response) {
                if (response.success) {
                    // Update the UI based on the action
                    if (action === 'install') {
                        updateUIAfterInstall(pluginSlug);
                    } else {
                        // If activation was successful, reload page or handle success
                        location.reload();
                    }
                } else {
                    // Check if the response data has 'message' property
                    var message = response.data && response.data.message ? response.data.message : 'Unknown error';
                    alert(message);
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX error: ' + error);
            }
        });
    }

    function updateUIAfterInstall(pluginSlug) {
        // Replace the install button with the go to starter sites button
        $('#install-' + pluginSlug).hide();
        $('#activate-' + pluginSlug).show();
        $('#go-to-starter-sites').show();
    }
});
