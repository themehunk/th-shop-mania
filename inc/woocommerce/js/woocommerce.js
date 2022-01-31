/********************************/
// ThShopManiaWooLib Custom Function
/********************************/
(function ($) {
    var ThShopManiaWooLib = {
        init: function (){
            this.bindEvents();
        },
        bindEvents: function (){
            var $this = this;
            $this.AddtoCartQuanty();
            if ($('body.single-product').length) {
             $this.woccomerce_tab();
           }
          },
          woccomerce_tab: function (){
                 $( document ).ready( function() {
                 if($( '.description_tab' ).hasClass('active')){
                       $('.woocommerce-Tabs-panel.woocommerce-Tabs-panel--description').css('display','block');
                    }
                });

           },
         AddtoCartQuanty: function (){
                $('form.cart').on( 'click', 'button.plus, button.minus', function(){
                // Get current quantity values
                var qty = $( this ).siblings('.quantity').find( '.qty' );
                var val = parseFloat(qty.val()) ? parseFloat(qty.val()) : '0';
                var max = parseFloat(qty.attr( 'max' ));
                var min = parseFloat(qty.attr( 'min' ));
                var step = parseFloat(qty.attr( 'step' ));
                // Change the value if plus or minus
                if ( $(this).is( '.plus' ) ) {
                    if ( max && ( max <= val ) ) {
                        qty.val( max );
                    } else {
                        qty.val( val + step );
                    }
                } else {
                    if ( min && ( min >= val ) ) {
                        qty.val( min );
                    } else if ( val > 1 ) {
                        qty.val( val - step );
                    }
                }
                 
            });

        },
      
    
      }
    ThShopManiaWooLib.init();
})(jQuery);