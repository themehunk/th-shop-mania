(function ($) {

    'use strict';

    var THNEWQuickView = {

        /**
         * Init.
         */
        init: function () {

            this.cacheDom();

            this.bindEvents();
        },

        /**
         * Cache DOM.
         */
        cacheDom: function () {

            this.$body =
                $('body');

            this.$popup =
                $('.thnew-popup');

            this.$content =
                $('.thnew-popup-content');
        },

        /**
         * Bind Events.
         */
        bindEvents: function () {

            let self = this;

            /**
             * Open Popup.
             */
            $(document).on(
                'click',
                '.opn-quick-view-text',
                function (e) {

                    self.openPopup(e, $(this));
                }
            );

            /**
             * Close Popup.
             */
            $(document).on(
                'click',
                '.thnew-popup-overlay, .thnew-popup-close',
                function () {

                    self.closePopup();
                }
            );

            /**
             * Quantity.
             */
            $(document).on(
                'click',
                '.thnew-qv-plus',
                function () {

                    self.quantityPlus($(this));
                }
            );

            $(document).on(
                'click',
                '.thnew-qv-minus',
                function () {

                    self.quantityMinus($(this));
                }
            );

            /**
             * Add To Cart.
             */
            $(document).on(
                'click',
                '#th-custom-add-to-cart',
                function (e) {

                    self.addToCart(e, $(this));
                }
            );

            self.descriptionAccordion();
        },

        /**
         * Open Popup.
         */
        openPopup: function (e, button) {

            e.preventDefault();

            let self = this;

            let productID =
                button.data('product_id');

            if (!productID) {
                return;
            }

            self.$popup.fadeIn(200);

            $('body').addClass(
                'thnew-qv-open'
            );

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

                    self.renderSkeleton();
                },

                success: function (response) {

                    if (
                        !response.success
                    ) {
                        return;
                    }

                    self.$content.html(
                        response.data.html
                    );

                    self.initModules();
                }
            });
        },

        /**
         * Init Modules.
         */
        initModules: function () {

            this.initFlexSlider();

            this.initVariationForm();

            this.initVariationEvents();
        },

        /**
         * Skeleton.
         */
        renderSkeleton: function () {

            this.$content.html(`

                <div class="thnew-qv-grid thnew-qv-skeleton">

                    <div class="thnew-qv-left">

                        <div class="thnew-sk-image shimmer"></div>



                    </div>

                    <div class="thnew-qv-right">

                        <div class="thnew-sk-meta shimmer"></div>

                        <div class="thnew-sk-title shimmer"></div>

                        <div class="thnew-sk-price shimmer"></div>

                        <div class="thnew-sk-variation shimmer"></div>

                        <div class="thnew-sk-desc shimmer"></div>

                        <div class="thnew-sk-cart">

                            <div class="thnew-sk-qty shimmer"></div>

                            <div class="thnew-sk-button shimmer"></div>

                        </div>

                    </div>

                </div>

            `);
        },

        /**
         * FlexSlider.
         */
      initFlexSlider: function () {

    let galleryLength =
        $('.thnew-qv-gallery .slides li').length;

    /**
     * MAIN GALLERY
     */
    $('.thnew-qv-gallery').flexslider({

    animation: 'slide',

    controlNav: galleryLength > 1,

    animationLoop: galleryLength > 1,

    slideshow: false,

    directionNav: galleryLength > 1,

    smoothHeight: false,

    sync:
        galleryLength > 1
            ? '.thnew-qv-thumbs'
            : ''
});

    /**
     * THUMBNAILS
     */
    if (galleryLength > 1) {

        $('.thnew-qv-thumbs').flexslider({

    animation: 'slide',

    controlNav: false,

    animationLoop: galleryLength > 1,

    slideshow: false,

    directionNav: false,

    itemWidth: 90,

    itemMargin: 12,

    asNavFor: '.thnew-qv-gallery'
});
    }
},

        /**
         * Variation Form.
         */
        /**
 * Variation Form.
 */
initVariationForm: function () {

    $('.thnew-popup .variations_form').each(
        function () {

            $(this)
                .wc_variation_form();

        }
    );

},


       
        /**
 * Variation Events.
 */
initVariationEvents: function () {

    $(document)
        .off(
            'found_variation.thQuickView',
            '.thnew-popup .variations_form'
        )
        .on(
            'found_variation.thQuickView',
            '.thnew-popup .variations_form',
            function (
                event,
                variation
            ) {

                const $form =
                    $(this);

                const $qv =
                    $form.closest(
                        '.thnew-qv-grid'
                    );

                const $button =
                    $qv.find(
                        '.thnew-qv-add-to-cart'
                    );

                /*
                 * Enable custom Add To Cart.
                 */
                $button
                    .attr(
                        'data-variation_id',
                        variation.variation_id
                    )
                    .removeClass('disabled')
                    .prop(
                        'disabled',
                        false
                    );

                /*
                 * Price.
                 */
                if (
                    variation.price_html
                ) {

                    $qv
                        .find(
                            '#th-dynamic-price'
                        )
                        .html(
                            variation.price_html
                        );
                }

                /*
                 * Description.
                 */
                if (
                    variation.variation_description
                ) {

                    $qv
                        .find(
                            '#th-dynamic-desc'
                        )
                        .html(
                            variation.variation_description
                        );

                } else {

                    $qv
                        .find(
                            '#th-dynamic-desc'
                        )
                        .html(
                            ''
                        );
                }

                /*
                 * Image.
                 */
                            if (
                variation.image &&
                variation.image.src
            ) {

                $qv
                    .find('.flex-active-slide .th-gallery-image')
                    .attr(
                        'src',
                        variation.image.src
                    );
            }

            }
        );


    /*
     * Reset Variation.
     */
    $(document)
        .off(
            'reset_data.thQuickView',
            '.thnew-popup .variations_form'
        )
        .on(
            'reset_data.thQuickView',
            '.thnew-popup .variations_form',
            function () {

                const $form =
                    $(this);

                const $qv =
                    $form.closest(
                        '.thnew-qv-grid'
                    );

                $qv
                    .find(
                        '.thnew-qv-add-to-cart'
                    )
                    .attr(
                        'data-variation_id',
                        0
                    )
                    .addClass('disabled')
                    .prop(
                        'disabled',
                        true
                    );

            }
        );
},

        /**
         * Quantity Plus.
         */
        quantityPlus: function (button) {

            let input =
                button.siblings(
                    '.custom-th-qty'
                );

            let value =
                parseInt(
                    input.val(),
                    10
                ) || 1;

            value++;

            this.updateQuantity(
                input,
                value
            );
        },

        /**
         * Quantity Minus.
         */
        quantityMinus: function (button) {

            let input =
                button.siblings(
                    '.custom-th-qty'
                );

            let value =
                parseInt(
                    input.val(),
                    10
                ) || 1;

            if (value <= 1) {
                return;
            }

            value--;

            this.updateQuantity(
                input,
                value
            );
        },

        /**
         * Update Quantity.
         */
        updateQuantity: function (
            input,
            value
        ) {

            input.val(value);

            $('#th-custom-add-to-cart')
                .attr(
                    'data-quantity',
                    value
                );

            $('.variations_form')
                .find('input.qty')
                .val(value);
        },

        /**
         * Add To Cart.
         */
        addToCart: function (
            e,
            button
        ) {

            e.preventDefault();

            if (
                button.hasClass('disabled')
            ) {
                return false;
            }

            button
                .addClass('loading');

            if (
                $('.variations_form').length
            ) {

                this.variableProductCart(
                    button
                );

            } else {

                this.simpleProductCart(
                    button
                );
            }
        },

        /**
         * Variable Product.
         */
        variableProductCart: function (
            button
        ) {

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

                    THNEWQuickView.cartSuccess(
                        button
                    );
                },

                error: function () {

                    THNEWQuickView.cartError(
                        button
                    );
                }
            });
        },

        /**
         * Simple Product.
         */
        simpleProductCart: function (
            button
        ) {

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

                    THNEWQuickView.cartSuccess(
                        button
                    );
                }
            });
        },

        /**
         * Cart Success.
         */
        cartSuccess: function (
            button
        ) {

            $(document.body)
                .trigger(
                    'wc_fragment_refresh'
                );

            $(document.body)
                .trigger(
                    'added_to_cart'
                );

            button
                .removeClass('loading')
                
        },

        /**
         * Cart Error.
         */
        cartError: function (
            button
        ) {

            button
                .removeClass('loading')
                .text('Add To Cart');
        },

/**
 * Description Toggle.
 */
/**
 * Description Accordion.
 */
descriptionAccordion: function () {

    $(document).on(
        'click',
        '.thnew-qv-accordion-title',
        function () {

            let button =
                $(this);

            let wrapper =
                button.closest(
                    '.thnew-qv-accordion'
                );

            let content =
                wrapper.find(
                    '.thnew-qv-accordion-content'
                );

            wrapper.toggleClass(
                'active'
            );

            content
                .stop(true, true)
                .slideToggle(250);

            /**
             * Icon.
             */
            let icon =
                button.find(
                    '.thnew-qv-accordion-icon'
                );

            icon.text(
                wrapper.hasClass('active')
                    ? '−'
                    : '+'
            );
        }
    );
},
        /**
         * Close Popup.
         */
        closePopup: function () {

            $('body').removeClass(
                'thnew-qv-open'
            );

            this.$popup.fadeOut(200);

            setTimeout(function () {

                $('.thnew-popup-content')
                    .html('');

            }, 300);
        }


    };

    /**
     * Init.
     */
    THNEWQuickView.init();

})(jQuery);



