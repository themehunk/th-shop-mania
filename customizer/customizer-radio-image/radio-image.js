jQuery(document).ready(function ($) {

    const control = $('.customize-control-radio-image');

    /* ------------------------------------
     * 1. Make label clickable (important for SVG)
     * ------------------------------------ */
    control.on('click', 'label', function () {
        const radio = $('#' + $(this).attr('for'));
        radio.prop('checked', true).trigger('change');
    });

    /* ------------------------------------
     * 2. Active class styling (works for svg + img)
     * ------------------------------------ */
    function refreshActiveState(container) {
        container.find('label').removeClass('active');
        container.find('input:checked').each(function () {
            $('label[for="' + $(this).attr('id') + '"]').addClass('active');
        });
    }

    refreshActiveState(control);

    control.on('change', 'input:radio', function () {

        const setting = $(this).attr('data-customize-setting-link');
        const value   = $(this).val();

        // Update UI state
        refreshActiveState($(this).closest('.customize-control-radio-image'));

        // Update Customizer value
        wp.customize(setting, function (obj) {
            obj.set(value);
        });
    });

});