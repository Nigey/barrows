;(function($) {

  $.fn.unveil = function(threshold, callback) {

    var $w = $(window),
        th = threshold || 0,
        retina = window.devicePixelRatio > 1,
        attrib = retina? "data-src-retina" : "data-src",
        images = this,
        loaded;

    this.one("unveil", function() {
      var source = this.getAttribute(attrib);
      source = source || this.getAttribute("data-src");
      if (source) {
        this.setAttribute("src", source);
        if (typeof callback === "function") callback.call(this);
      }
    });

    function unveil() {
      var inview = images.filter(function() {
        var $e = $(this);
        if ($e.is(":hidden")) return;

        var wt = $w.scrollTop(),
            wb = wt + $w.height(),
            et = $e.offset().top,
            eb = et + $e.height();

        return eb >= wt - th && et <= wb + th;
      });

      loaded = inview.trigger("unveil");
      images = images.not(loaded);
    }

    $w.on("scroll.unveil resize.unveil lookup.unveil", unveil);

    unveil();

    return this;

  };

})(window.jQuery || window.Zepto);
(function($, window) {
    var $window = $(window);

    $.fn.lazyload = function(options) {
        var elements = this;
        var $container;
        var settings = {
            threshold       : 0,
            failure_limit   : 0,
            event           : "scroll",
            effect          : "show",
            container       : window,
            data_attribute  : "original",
            skip_invisible  : true,
            appear          : null,
            load            : null
        };

        function update() {
            var counter = 0;
      
            elements.each(function() {
                var $this = $(this);
                if (settings.skip_invisible && !$this.is(":visible")) {
                    return;
                }
                if ($.abovethetop(this, settings) ||
                    $.leftofbegin(this, settings)) {
                        /* Nothing. */
                } else if (!$.belowthefold(this, settings) &&
                    !$.rightoffold(this, settings)) {
                        $this.trigger("appear");
                } else {
                    if (++counter > settings.failure_limit) {
                        return false;
                    }
                }
            });

        }

        if(options) {
            /* Maintain BC for a couple of versions. */
            if (undefined !== options.failurelimit) {
                options.failure_limit = options.failurelimit; 
                delete options.failurelimit;
            }
            if (undefined !== options.effectspeed) {
                options.effect_speed = options.effectspeed; 
                delete options.effectspeed;
            }

            $.extend(settings, options);
        }

        /* Cache container as jQuery as object. */
        $container = (settings.container === undefined ||
                      settings.container === window) ? $window : $(settings.container);

        /* Fire one scroll event per scroll. Not one scroll event per image. */
        if (0 === settings.event.indexOf("scroll")) {
            $container.bind(settings.event, function(event) {
                return update();
            });
        }

        this.each(function() {
            var self = this;
            var $self = $(self);

            self.loaded = false;

            /* When appear is triggered load original image. */
            $self.one("appear", function() {
                if (!this.loaded) {
                    if (settings.appear) {
                        var elements_left = elements.length;
                        settings.appear.call(self, elements_left, settings);
                    }
                    var loadImgUri;
                    if($self.data("background"))
                        loadImgUri = $self.data("background");
                    else
                        loadImgUri  = $self.data(settings.data_attribute);
                    
                    $("<img />")
                        .bind("load", function() {
                            $self
                                .hide();
                            if($self.data("background")){
                                $self.css('backgroundImage', 'url('+$self.data("background")+')');
                            }else
                                $self.attr("src", $self.data(settings.data_attribute));
                                
                            $self[settings.effect](settings.effect_speed);
                            
                            self.loaded = true;
    
                            /* Remove image from array so it is not looped next time. */
                            var temp = $.grep(elements, function(element) {
                                return !element.loaded;
                            });
                            elements = $(temp);
    
                            if (settings.load) {
                                var elements_left = elements.length;
                                settings.load.call(self, elements_left, settings);
                            }
                        })
                        .attr("src", loadImgUri );
                }
                
            });

            /* When wanted event is triggered load original image */
            /* by triggering appear.                              */
            if (0 !== settings.event.indexOf("scroll")) {
                $self.bind(settings.event, function(event) {
                    if (!self.loaded) {
                        $self.trigger("appear");
                    }
                });
            }
        });

        /* Check if something appears when window is resized. */
        $window.bind("resize", function(event) {
            update();
        });

        /* Force initial check if images should appear. */
        update();
        
        return this;
    };

     // Convenience methods in jQuery namespace.           
    /* Use as  $.belowthefold(element, {threshold : 100, container : window}) */

    $.belowthefold = function(element, settings) {
        var fold;
        
        if (settings.container === undefined || settings.container === window) {
            fold = $window.height() + $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top + $(settings.container).height();
        }

        return fold <= $(element).offset().top - settings.threshold;
    };
    
    $.rightoffold = function(element, settings) {
        var fold;

        if (settings.container === undefined || settings.container === window) {
            fold = $window.width() + $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left + $(settings.container).width();
        }

        return fold <= $(element).offset().left - settings.threshold;
    };
        
    $.abovethetop = function(element, settings) {
        var fold;
        
        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollTop();
        } else {
            fold = $(settings.container).offset().top;
        }

        return fold >= $(element).offset().top + settings.threshold  + $(element).height();
    };
    
    $.leftofbegin = function(element, settings) {
        var fold;
        
        if (settings.container === undefined || settings.container === window) {
            fold = $window.scrollLeft();
        } else {
            fold = $(settings.container).offset().left;
        }

        return fold >= $(element).offset().left + settings.threshold + $(element).width();
    };

    $.inviewport = function(element, settings) {
         return !$.rightofscreen(element, settings) && !$.leftofscreen(element, settings) && 
                !$.belowthefold(element, settings) && !$.abovethetop(element, settings);
     };

    /* Custom selectors for your convenience.   */
    /* Use as $("img:below-the-fold").something() */

    $.extend($.expr[':'], {
        "below-the-fold" : function(a) { return $.belowthefold(a, {threshold : 0}); },
        "above-the-top"  : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-screen": function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-screen" : function(a) { return !$.rightoffold(a, {threshold : 0}); },
        "in-viewport"    : function(a) { return !$.inviewport(a, {threshold : 0}); },
        /* Maintain BC for couple of versions. */
        "above-the-fold" : function(a) { return !$.belowthefold(a, {threshold : 0}); },
        "right-of-fold"  : function(a) { return $.rightoffold(a, {threshold : 0}); },
        "left-of-fold"   : function(a) { return !$.rightoffold(a, {threshold : 0}); }
    });

})(jQuery, window);
jQuery(document).ready(function($) {
    $('.sale_rent').on('click', function(){
        var $id_ = $(this).attr('data-type');
        // console.log($id_);
        if ($id_ == "sale") {
            console.log('sale-');
            $('.rent-prices').addClass('hide');
            $('.sale-prices').removeClass('hide');
        } else {
            console.log('rent-');
            $('.rent-prices').removeClass('hide');
            $('.sale-prices').addClass('hide');
        }
    });


    if ($('.search_enabled').hasClass("enabled")) {
        $('.property-search_container').slideToggle();
    }
    $('.button-text').click(function(){
        $('.popup_login').toggleClass('active');
    });

    $('.advanced_search_btn').on('click',function(){
        $('.property-search_container').slideToggle();
    });
    $('.page-property-details .property_images').slick({
        prevArrow: $('.previous'),
        nextArrow: $('.next')
    });
     $('.page-property-details div[data-slide]').click(function(e) {
        e.preventDefault();
        var slideno = $(this).data('slide');
        // $('.property_images').slick('slickGoTo', slideno );
     });
     function loop(){

         setTimeout(function(){
            if ($(".page-property-details .big-image").height() < 10) {
                //loop();
            } else {
                //$('.page-property-details .thumbnails').css( 'max-height' , $(".page-property-details .big-image").height() );
            }
         },700);
     }
     loop();
    $('select').niceSelect();
    $('.contact-locations-box').css("height", $('.contact-locations-box').width());
    $('.card-box').css("height", $('.card-box').width() / 4 * 3);
      $('.introduction').slick({
        slidesToShow: 1,
        vertical: true,
        verticalSwiping: true,
        dots: true,
        arrows: false,
        touchMove: false,
        lazyLoad: 'ondemand',
        lazyLoadBuffer: 0,
        autoplay: true, 
        autoplaySpeed: 4000,
        responsive: [
        {
          breakpoint: 980,
          settings: {   
            slidesToShow: 1,
            vertical: false,
            verticalSwiping: false,
            dots: true,
            arrows: false,
            touchMove: false,
            autoplay: true, 
            autoplaySpeed: 4000,
            swipeToSlide: false
          }
        }
        ]
      });
      $('.five-step-slide').slick({
        slidesToShow: 1,
        dots: false,
        arrows: true,
        prevArrow: $('.prev'),
        nextArrow: $('.next'),
        lazyLoad: 'ondemand',
        lazyLoadBuffer: 0,
        adaptiveHeight: true
      });
      
     $('a[data-slide]').click(function(e) {
       e.preventDefault();
       var slideno = $(this).data('slide');
       $('.five-step-slide').slick('slickGoTo', slideno - 1);
     });

      $('.slick-images').slick({
        slidesToShow: 1,
        dots: false,
        arrows: true,
        lazyLoad: 'ondemand',
        lazyLoadBuffer: 0,
        adaptiveHeight: true
      });
      
     $('a[data-slide]').click(function(e) {
       e.preventDefault();
       var slideno = $(this).data('slide');
       $('.slick-images').slick('slickGoTo', slideno);
     });
	$(".divToLoad").lazyload();
    $(".imgToLoad").unveil(300);
    $('.five-step-slide').on('afterChange', function(event, slick, currentSlide, nextSlide){
        icon_id = $(slick.$slides.get(currentSlide)).attr('id');
        console.log("."+icon_id);
        $(".icon").removeClass('active');
        $("."+icon_id).addClass('active');
    });
    $('.icon').hover(function(){
        $(this).addClass('hover-active');

    }, function(){
        $(this).removeClass('hover-active');
    });
    $( ".icon" ).click(function() {
      $(this).addClass('active');
    });
    $('.contact-details').css('height',$('.form-box').height());
   
    $('.btn_tab').on('click',function(){
        var $tab_active = $(this).data('tab');
        var $tab_selected = $('.tab_container').find('.' + $tab_active);
        console.log($tab_selected);
        $('.tab_active').removeClass('tab_active');
        $tab_selected.addClass('tab_active');
        // ('.tab_active').removeClass('tab_active');
        // $($tab_active).addClass('tab_active');
    });

});