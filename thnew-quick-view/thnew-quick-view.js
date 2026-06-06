jQuery(function ($) {

    'use strict';

    /**
     * Open popup.
     */
    $(document).on(
        'click',
        '.opn-quick-view-text',
        function (e) {

            e.preventDefault();

            let productID =
                $(this).data('product_id');

            $('.thnew-popup').fadeIn(200);

            $.ajax({

                url: thnewQuickView.ajaxurl,

                type: 'POST',

                dataType: 'json',

                data: {

                    action: 'thnew_quick_view',

                    nonce: thnewQuickView.nonce,

                    product_id: productID
                },

                beforeSend: function () {

                    $('.thnew-popup-content').html(
                        '<div class="thnew-qv-loader"></div>'
                    );
                },

                success: function (response) {

                    if (!response.success) {
                        return;
                    }

                    $('.thnew-popup-content').html(
                        response.data.html
                    );

                    initFlexSlider();

                    initVariationForm();

                    initVariationEvents();
                }
            });
        }
    );

    /**
     * FlexSlider.
     */
    function initFlexSlider() {

        let galleryLength =
            $('.thnew-qv-gallery .slides li').length;

        $('.thnew-qv-gallery').flexslider({

            animation: 'slide',

            controlNav: false,

            animationLoop: false,

            slideshow: false,

            directionNav: galleryLength > 1,

            sync:
                galleryLength > 1
                    ? '.thnew-qv-thumbs'
                    : ''
        });

        if (galleryLength > 1) {

            $('.thnew-qv-thumbs').flexslider({

                animation: 'slide',

                controlNav: false,

                animationLoop: false,

                slideshow: false,

                itemWidth: 90,

                itemMargin: 12,

                asNavFor: '.thnew-qv-gallery'
            });
        }
    }

    /**
     * Variation Form.
     */
    function initVariationForm() {

        if ($('.variations_form').length) {

            $('.variations_form').each(function () {

                $(this).wc_variation_form();
            });

            $('#th-custom-add-to-cart')
                .addClass('disabled')
                .prop('disabled', true);
        }
    }

    /**
     * Variation Events.
     */
    function initVariationEvents() {

        let defaultPrice =
            $('#th-dynamic-price').html();

        let defaultDesc =
            $('#th-dynamic-desc').html();

        $(document)
            .off('found_variation')
            .on(
                'found_variation',
                '.variations_form',
                function (event, variation) {

                    $('#th-custom-add-to-cart')
                        .attr(
                            'data-variation_id',
                            variation.variation_id
                        )
                        .removeClass('disabled')
                        .prop('disabled', false);

                    if (variation.price_html) {

                        $('#th-dynamic-price').html(
                            variation.price_html
                        );
                    }

                    if (
                        variation.variation_description
                    ) {

                        $('#th-dynamic-desc').html(
                            variation.variation_description
                        );

                    } else {

                        $('#th-dynamic-desc').html(
                            defaultDesc
                        );
                    }

                    /**
                     * Variation image.
                     */
                    if (
                        variation.image &&
                        variation.image.src
                    ) {

                        $('.th-gallery-image')
                            .first()
                            .attr(
                                'src',
                                variation.image.src
                            );
                    }
                }
            );

        $(document)
            .off('reset_data')
            .on(
                'reset_data',
                '.variations_form',
                function () {

                    $('#th-custom-add-to-cart')
                        .attr(
                            'data-variation_id',
                            0
                        )
                        .addClass('disabled')
                        .prop('disabled', true);

                    $('#th-dynamic-price').html(
                        defaultPrice
                    );

                    $('#th-dynamic-desc').html(
                        defaultDesc
                    );
                }
            );
    }

    /**
     * Quantity Plus.
     */
    $(document).on(
        'click',
        '.thnew-qv-plus',
        function () {

            let input =
                $(this)
                    .siblings('.custom-th-qty');

            let value =
                parseInt(input.val(), 10) || 1;

            input.val(value + 1);

            $('#th-custom-add-to-cart').attr(
                'data-quantity',
                value + 1
            );

            $('.variations_form')
                .find('input.qty')
                .val(value + 1);
        }
    );

    /**
     * Quantity Minus.
     */
    $(document).on(
        'click',
        '.thnew-qv-minus',
        function () {

            let input =
                $(this)
                    .siblings('.custom-th-qty');

            let value =
                parseInt(input.val(), 10) || 1;

            if (value <= 1) {
                return;
            }

            input.val(value - 1);

            $('#th-custom-add-to-cart').attr(
                'data-quantity',
                value - 1
            );

            $('.variations_form')
                .find('input.qty')
                .val(value - 1);
        }
    );

    /**
     * Add To Cart.
     */
    $(document)
        .off('click', '#th-custom-add-to-cart')
        .on(
            'click',
            '#th-custom-add-to-cart',
            function (e) {

                e.preventDefault();

                let button = $(this);

                if (
                    button.hasClass('disabled')
                ) {
                    return false;
                }

                button
                    .addClass('loading')
                    .text('Adding...');

                let isVariable =
                    $('.variations_form').length > 0;

                /**
                 * Variable.
                 */
                if (isVariable) {

                    let form =
                        $('.variations_form');

                    let formData =
                        form.serializeArray();

                    formData.push({
                        name: 'add-to-cart',
                        value:
                            button.attr(
                                'data-product_id'
                            )
                    });

                    formData.push({
                        name: 'product_id',
                        value:
                            button.attr(
                                'data-product_id'
                            )
                    });

                    formData.push({
                        name: 'variation_id',
                        value:
                            button.attr(
                                'data-variation_id'
                            )
                    });

                    $.ajax({

                        type: 'POST',

                        url: window.location.href,

                        data: $.param(formData),

                        success: function () {

                            $(document.body)
                                .trigger(
                                    'wc_fragment_refresh'
                                );

                            $(document.body)
                                .trigger(
                                    'added_to_cart'
                                );

                            button
                                .removeClass(
                                    'loading'
                                )
                                .text('Added ✓');

                            setTimeout(function () {

                                button.text(
                                    'Add To Cart'
                                );

                            }, 2000);
                        },

                        error: function () {

                            button
                                .removeClass(
                                    'loading'
                                )
                                .text('Add To Cart');
                        }
                    });

                } else {

                    /**
                     * Simple Product.
                     */
                    $.ajax({

                        type: 'POST',

                        url:
                            wc_add_to_cart_params
                                .wc_ajax_url
                                .replace(
                                    '%%endpoint%%',
                                    'add_to_cart'
                                ),

                        data: {

                            product_id:
                                button.attr(
                                    'data-product_id'
                                ),

                            quantity:
                                button.attr(
                                    'data-quantity'
                                )
                        },

                        success: function (
                            response
                        ) {

                            $(document.body)
                                .trigger(
                                    'added_to_cart',
                                    [
                                        response.fragments,
                                        response.cart_hash,
                                        button
                                    ]
                                );

                            button
                                .removeClass(
                                    'loading'
                                )
                                .text('Added ✓');

                            setTimeout(function () {

                                button.text(
                                    'Add To Cart'
                                );

                            }, 2000);
                        }
                    });
                }
            }
        );

    /**
     * Close Popup.
     */
    function closePopup() {

        $('.thnew-popup').fadeOut(200);

        setTimeout(function () {

            $('.thnew-popup-content').html('');

        }, 300);
    }

    /**
     * Overlay Close.
     */
    $(document).on(
        'click',
        '.thnew-popup-overlay',
        function () {

            closePopup();
        }
    );

    /**
     * Button Close.
     */
    $(document).on(
        'click',
        '.thnew-popup-close',
        function () {

            closePopup();
        }
    );
});