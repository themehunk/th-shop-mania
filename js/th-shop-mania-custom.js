/**************/
// th_shop_mania_Lib
/**************/
(function ($) {
    var th_shop_mania_Lib = {
        init: function (){
            this.bindEvents();
        },
        bindEvents: function (){
              
             var $this = this;
             $this.PreLoader();
             $this.SidebarToggle();
             $this.CatMenu();
             $this.DefaultMenu();
             $this.MainMenu();
             if(jQuery('#th-shop-mania-stick-menu').length){   
             $this.StickMenu();
           }
             // $this.AboveMenu();
             $this.MobileMenuFunction();
             $this.mobile_menu_with_woocat(); 
              if (jQuery('.theme-th-shop-mania-pro').length && th_shop_mania.th_shop_mania_move_to_top_optn ) {
                $this.MoveToTop();
              }
              else if(!jQuery('.theme-th-shop-mania-pro').length){
             $this.MoveToTop();
           }
        },    
          PreLoader : function (){
                               if(!$('body').hasClass('elementor-editor-active')){
                                const myTimeout = setTimeout(removeLoader, 10000);

                                  function myStopFunction() {
                                    clearTimeout(myTimeout);
                                  }
                                $(window).on('load', function(){
                                  var loadTime = window.performance.timing.domContentLoadedEventEnd - window.performance.timing.navigationStart; 
                                  // console.log(loadTime);
                                  if (loadTime <= 10000) { myStopFunction(); }
                                setTimeout(removeLoader); //wait for page load PLUS two seconds.
                                });
                                function removeLoader(){
                                    $( ".th_shop_mania_overlayloader" ).fadeOut(700, function(){
                                      // fadeOut complete. Remove the loading div
                                   if ($("th-shop-mania-pre-loader img").length) {
                                   $(".th-shop-mania-pre-loader img" ).hide(); //makes page more lightweight
                                    }
                                    else{
                                      $(".th-shop-mania-pre-loader .th-loader" ).hide();
                                    }
                                    });  
                                  }
                                }

          },

          SidebarToggle: function () {
                    $(document).ready(function() {
                          if ($(window).width() <= 990) { 
                          $('.sidebar-content-area .widget-title, .sidebar-content-area .wp-block-group h4,.sidebar-main,.wp-block-group__inner-container > :first-child').click(function() {
                          $(this).next().slideToggle();
                          $(this).toggleClass("open");
                          });
                         
                          }     
                });
                         
        },
  
         CatMenu : function () {
                 // category toggle
                              $(".cat-toggle").on("click keypress",function(e){
                              $(".product-cat-list").slideToggle();
                              $(".toggle-icon", this).toggleClass("icon-circle-arrow-down");
                               e.stopPropagation();
                              });

                              $(".product-cat-list").click(function(e){
                                  e.stopPropagation();
                              });
                              
                              $(document).on('click', function (e) {
                          if ($(e.target).closest(".cat-toggle").length === 0) {
                              $(".product-cat-list").slideUp();
                              $(".toggle-icon").removeClass("icon-circle-arrow-down");
                          }
});
                           
                            $("#mobile-nav-tab-category .mobile").ThunkCatMenu({
                                 resizeWidth:'1024', // Set the same in Media query       
                                 animationSpeed:'fast', //slow, medium, fast
                                 accoridonExpAll:true//Expands all the accordion menu on click
                             });
                             
                             $(".product-cat-list").ThunkCatMenu({
                                 resizeWidth:'767', // Set the same in Media query       
                                 animationSpeed:'fast', //slow, medium, fast
                                 accoridonExpAll:true//Expands all the accordion menu on click
                             });
                              $(".thunk-product-cat-list.slider").ThunkCatMenu({
                                 resizeWidth:'767', // Set the same in Media query       
                                 animationSpeed:'fast', //slow, medium, fast
                                 accoridonExpAll:true//Expands all the accordion menu on click
                             });
        },
        DefaultMenu: function(){
                 $("#menu-all-pages.th-shop-mania-menu").th_shop_mania_ResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
             });
                 $(".menu ul.th-shop-mania-menu").th_shop_mania_ResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
             });
                  $("#mobile-nav-tab-menu #menu-all-pages.th-shop-mania-menu").th_shop_mania_ResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
             });
                  $("#mobile-nav-tab-menu .menu ul.th-shop-mania-menu").th_shop_mania_ResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
             });
        },
        MainMenu : function(){
                $("#th-shop-mania-menu").th_shop_mania_ResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
            });
                $("#mobile-nav-tab-menu #th-shop-mania-menu").th_shop_mania_ResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
            });
        },
        StickMenu : function(){
                $("#th-shop-mania-stick-menu").th_shop_mania_ResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
            });
        },
        AboveMenu : function(){
          if(jQuery('#open-above-menu').length){   
                $("#open-above-menu").th_shop_mania_ResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
             });    
             $("#mobile-nav-tab-menu #open-above-menu").th_shop_mania_ResponsiveMenu({
                 resizeWidth:'1024', // Set the same in Media query       
                 animationSpeed:'medium', //slow, medium, fast
                 accoridonExpAll:true//Expands all the accordion menu on click
            }); 
          }
        },
        
        MobileMenuFunction : function(){
                 // close-button-active
                   $('body').find('.sider').prepend('<div class="menu-close"><a href="#" class="menu-close-btn">'+thsmcustjs.menu_close+'</a></div>');
                        $('.menu-close-btn').removeAttr("href");
                        //Menu close
                        $('.menu-close-btn,.th-shop-mania-menu li a span.th-shop-mania-menu-link').click(function(){
                        $('body').removeClass('mobile-menu-active');
                        $('body').removeClass('sticky-mobile-menu-active');
                        });
                         $('.menu-close-btn,.th-shop-mania-menu li a span.th-shop-mania-menu-link').keypress(function(){
                        $('body').removeClass('mobile-menu-active');
                        $('body').removeClass('sticky-mobile-menu-active');
                        });
                        // Esc key close menu
                      document.addEventListener( 'keydown', function( event ) {
                      if ( event.keyCode === 27 ) {
                        event.preventDefault();
                        document.querySelectorAll( '.mobile-menu-active' ).forEach( function( element ) {
                          jQuery('body').removeClass('mobile-menu-active');
                        }.bind( this ) );
                      
                      }
                    }.bind( this ) );
                    //ToggleBtn above Click
                    $('#menu-btn-abv').click(function (e){
                       e.preventDefault();
                       $('body').addClass('mobile-above-menu-active');
                       $('#open-above-menu').removeClass('hide-menu'); 
                       $('.sider.above').removeClass('th-shop-mania-menu-hide');
                       $('.sider.main').addClass('th-shop-mania-menu-hide');
                       th_shop_mania_menu.modalMenu.init(); 
                    });
                    //ToggleBtn main menu Click
                    $('#menu-btn,#mob-menu-btn').click(function (e){
                       e.preventDefault();
                       $('body').addClass('mobile-menu-active');
                       $('#th-shop-mania-menu').removeClass('hide-menu');
                       $('.sider.above').addClass('th-shop-mania-menu-hide');  
                       $('.sider.main').removeClass('th-shop-mania-menu-hide');
                       th_shop_mania_menu.modalMenu.init();     
                    });
                     
                    //sticky
                    $('#menu-btn-stk').click(function (e){
                       e.preventDefault();
                       $('body').addClass('sticky-mobile-menu-active');
                       $('.sider.main').addClass('th-shop-mania-menu-hide');
                       th_shop_mania_menu.modalMenu.init(); 
                      });
                    // default page
                    $('#menu-btn,#mob-menu-btn').click(function (e){
                       e.preventDefault();
                       $('body').addClass('mobile-menu-active');
                       $('#menu-all-pages').removeClass('hide-menu');  
                       th_shop_mania_menu.modalMenu.init();   
                    });

                   
        },
          mobile_menu_with_woocat: function () {
                    $(document).ready(function() {
                        $('.mobile-nav-tabs li a').click(function(){
                         $('.panel').hide();
                         $('.mobile-nav-tabs li a.active').removeClass('active');
                         $(this).addClass('active');
                         var panel = $(this).attr('href');
                         $(panel).fadeIn(1000);
                         return false;  // prevents link action
                          });  // end click
                         $('.mobile-nav-tabs li:first a').click();
                });
        },
            MoveToTop:function(){
                      /**************************************************/
                      // Show-hide Scroll to top & move-to-top arrow
                      /**************************************************/
                        jQuery("body").prepend("<a id='move-to-top' class='animate' href='#'><span class='th-icon th-icon-chevron-up-thin-converted'></span></a>"); 
                        var scrollDes = 'html,body';  
                        /*Opera does a strange thing if we use 'html' and 'body' together so my solution is to do the UA sniffing thing*/
                        if(navigator.userAgent.match(/opera/i)){
                          scrollDes = 'html';
                        }
                        //show ,hide
                        jQuery(window).scroll(function (){
                          if(jQuery(this).scrollTop() > 160){
                            jQuery('#move-to-top').addClass('filling').removeClass('hiding');
                          }else{
                            jQuery('#move-to-top').removeClass('filling').addClass('hiding');
                          }
                        });
                        jQuery('#move-to-top').click(function(){
                            jQuery("html, body").animate({ scrollTop: 0 }, 600);
                            return false;
                        });
                     // Below Footer 
                     if (!(jQuery('.th-shop-mania-pro').length )) {
                     jQuery('.below-footer').attr('style', 'display: block !important');
                     jQuery('.below-footer *').attr('style', 'display: inline-block !important');

                     if (!(jQuery('.footer-copyright').length )) {
                      jQuery('footer div').hide();
                     }

                     // Select the anchor tag
                    var anchor = jQuery('.footer-copyright a');
                    if (jQuery.trim(anchor.text()) === '' || anchor.text() !== 'ThemeHunk') {
                        anchor.text('ThemeHunk WordPress Theme');
                    }


                   }
                },
                     
    }
/* -----------------------------------------------------------------------------------------------
  Modal Menu
--------------------------------------------------------------------------------------------------- */
var th_shop_mania_menu = th_shop_mania_menu || {};
th_shop_mania_menu.modalMenu = {
  init: function(){
    this.keepFocusInModal();
  },
    keepFocusInModal: function(){
    var _doc = document;
    _doc.addEventListener( 'keydown', function( event ){
      var toggleTarget, modal, selectors, elements, menuType, bottomMenu, activeEl, lastEl, firstEl, tabKey, shiftKey,
        toggleTarget = '.mobile-nav-bar.sider';
        if(jQuery('.mobile-menu-active').length!=''){   
        selectors = 'a,.arrow';
        modal = _doc.querySelector( toggleTarget );
        elements = modal.querySelectorAll( selectors );
        elements = Array.prototype.slice.call( elements );
        if ( '.mobile-nav-bar.sider' === toggleTarget ){
          menuType = window.matchMedia( '(min-width: 1024px)' ).matches;
          menuType = menuType ? '.expanded-menu' : '.mobile-nav-tab-menu .th-shop-mania-menu';
          elements = elements.filter( function( element ) {
            return null !== element.closest( menuType ) && null !== element.offsetParent;
          } );
          elements.unshift( _doc.querySelector( '.mobile-nav-bar .menu-close-btn' ) );
           $('.mobile-nav-tab-menu .th-shop-mania-menu a,.mobile-nav-bar .menu-close-btn,.mobile-nav-bar .arrow').attr('tabindex',0); 
        }
        lastEl = elements[ elements.length - 1 ];
        firstEl = elements[0];
        activeEl = _doc.activeElement;
        tabKey = event.keyCode === 9;
        shiftKey = event.shiftKey;

        if ( ! shiftKey && tabKey && lastEl === activeEl ) {
          event.preventDefault();
          firstEl.focus();
        }

        if ( shiftKey && tabKey && firstEl === activeEl ) {
          event.preventDefault();
          lastEl.focus();
        }
      }

    } );
  }
}; // th_shop_mania_menu.modalMenu   
   
th_shop_mania_Lib.init();
  $(".menu-close-btn").click(function(){
    // focus and select
   $('.menu-toggle .menu-btn').focus().select();
   $('.th-shop-mania-menu a,.menu-close,.arrow').attr('tabindex',-1);
});
$(".menu-close-btn").keypress(function(){
   
    // focus and select
   $('.menu-toggle .menu-btn').focus().select();
   $('.th-shop-mania-menu a,.menu-close,.arrow').attr('tabindex',-1);
});
})(jQuery);