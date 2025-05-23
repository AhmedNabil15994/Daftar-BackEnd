(function ($) {
    "use strict";

    $("#libraries-list").owlCarousel({
        navigation: true,
        pagination: true,
        nav: true,
        dots: true,
        loop: false,
        autoplay: false,
        margin: 0,
        items: 4,
        navText: ['<span class="ti-angle-left"></span>', '<span class="ti-angle-right"></span>'],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });
    $("#library-products").owlCarousel({
        navigation: true,
        pagination: true,
        nav: true,
        dots: true,
        loop: false,
        autoplay: false,
        margin: 15,
        items: 4,
        navText: ['<span class="ti-angle-left"></span>', '<span class="ti-angle-right"></span>'],
        responsive: {
            0: {
                items: 2
            },
            480: {
                items: 2
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            }
        }
    });
    $(".library_categories").owlCarousel({
        navigation: true,
        pagination: true,
        nav: true,
        dots: true,
        loop: false,
        autoplay: false,
        margin: 10,
        items: 8,
        navText: ['<span class="ti-angle-left"></span>', '<span class="ti-angle-right"></span>'],
        responsive: {
            0: {
                items: 3
            },
            480: {
                items: 5
            },
            768: {
                items: 6
            },
            992: {
                items: 7
            },
            1200: {
                items: 8
            }
        }
    });
    $(document).on('click', '.quantity .plus, .quantity .minus', function (e) {
        // Get values
        var $qty = $(this).closest('.quantity').find('.qty'),
            currentVal = parseFloat($qty.val()),
            max = parseFloat($qty.attr('max')),
            min = parseFloat($qty.attr('min')),
            step = $qty.attr('step');
        // Format values
        if (!currentVal || currentVal === '' || currentVal === 'NaN')
            currentVal = 0;
        if (max === '' || max === 'NaN')
            max = '';
        if (min === '' || min === 'NaN')
            min = 0;
        if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN')
            step = 1;
        // Change the value
        if ($(this).is('.plus')) {
            if (max && (max == currentVal || currentVal > max)) {
                $qty.val(max);
            } else {
                $qty.val(currentVal + parseFloat(step));
            }
        } else {
            if (min && (min == currentVal || currentVal < min)) {
                $qty.val(min);
            } else if (currentVal > 0) {
                $qty.val(currentVal - parseFloat(step));
            }
        }
        // Trigger change event
        $qty.trigger('change');
        e.preventDefault();
    });
    $('.slider-range-price').each(function () {
        var min = parseInt($(this).data('min'));
        var max = parseInt($(this).data('max'));
        var unit = $(this).data('unit');
        var value_min = parseInt($(this).data('value-min'));
        var value_max = parseInt($(this).data('value-max'));
        var label_reasult = $(this).data('label-reasult');
        var t = $(this);
        $(this).slider({
            range: true,
            min: min,
            max: max,
            values: [value_min, value_max],
            slide: function (event, ui) {
                var result = label_reasult + " <span>" + unit + ui.values[0] + ' </span> - <span> ' + unit + ui.values[1] + '</span>';
                t.closest('.price_slider_wrapper').find('.price_slider_amount').html(result);
            }
        });
    });
    function init_carousel() {
        $('.owl-product').owlCarousel({
            items: 1,
            thumbs: true,
            thumbsPrerendered: true,
        });
        $(".owl-carousel").each(function (index, el) {
            var config = $(this).data();
            var animateOut = $(this).data('animateout');
            var animateIn = $(this).data('animatein');
            var slidespeed = $(this).data('slidespeed');
            if (typeof animateOut != 'undefined') {
                config.animateOut = animateOut;
            }
            if (typeof animateIn != 'undefined') {
                config.animateIn = animateIn;
            }
            if (typeof (slidespeed) != 'undefined') {
                config.smartSpeed = slidespeed;
            }
            var owl = $(this);
            owl.on('initialized.owl.carousel', function (event) {
                var total_active = owl.find('.owl-item.active').length;
                var i = 0;
                owl.find('.owl-item').removeClass('item-first item-last');
                setTimeout(function () {
                    owl.find('.owl-item.active').each(function () {
                        i++;
                        if (i == 1) {
                            $(this).addClass('item-first');
                        }
                        if (i == total_active) {
                            $(this).addClass('item-last');
                        }
                    });
                }, 100);
            })
            owl.on('refreshed.owl.carousel', function (event) {
                var total_active = owl.find('.owl-item.active').length;
                var i = 0;
                owl.find('.owl-item').removeClass('item-first item-last');
                setTimeout(function () {
                    owl.find('.owl-item.active').each(function () {
                        i++;
                        if (i == 1) {
                            $(this).addClass('item-first');
                        }
                        if (i == total_active) {
                            $(this).addClass('item-last');
                        }
                    });
                }, 100);
            })
            owl.on('change.owl.carousel', function (event) {
                var total_active = owl.find('.owl-item.active').length;
                var i = 0;
                owl.find('.owl-item').removeClass('item-first item-last');
                setTimeout(function () {
                    owl.find('.owl-item.active').each(function () {
                        i++;
                        if (i == 1) {
                            $(this).addClass('item-first');
                        }
                        if (i == total_active) {
                            $(this).addClass('item-last');
                        }
                    });
                }, 100);
                owl.addClass('owl-changed');
                setTimeout(function () {
                    owl.removeClass('owl-changed');
                }, config.smartSpeed)
            })
            owl.on('drag.owl.carousel', function (event) {
                owl.addClass('owl-changed');
                setTimeout(function () {
                    owl.removeClass('owl-changed');
                }, config.smartSpeed)
            })
            owl.owlCarousel(config);
        });
    }
    $(document).ready(function () {
        //Wow animate
        new WOW().init();

        // OWL CAROUSEL
        init_carousel();
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#scrollup').fadeIn();
            } else {
                $('#scrollup').fadeOut();
            }
        });
        $('#scrollup').on('click', function () {
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            return false;
        });

        // menu on mobile
        $(".header-nav .toggle-submenu").on('click', function () {
            $(this).parent().toggleClass('open-submenu');
            return false;
        });

        $("[data-action='toggle-nav']").on('click', function () {
            $(this).toggleClass('active');
            $(".header-nav").toggleClass("has-open");
            return false;
        });
        $(".header-menu .btn-close").on('click', function () {
            $('.header-nav').removeClass('has-open');
            return false;
        });

        //chosen-select
        if ($('.chosen-select').length > 0) {
            $('.chosen-select').chosen();
        }
        //categories click

        $(".scroll-pane").mCustomScrollbar({
            advanced: {
                updateOnContentResize: true

            },
            scrollButtons: {
                enable: false
            },
            mouseWheelPixels: "200",
            theme: "dark-2"

        });
        $(".smoothscroll").mCustomScrollbar({
            advanced: {
                updateOnContentResize: true

            },
            scrollButtons: {
                enable: false
            },
            mouseWheelPixels: "100",
            theme: "dark-2"

        });
        $('.collapseWill').on('click', function (e) {
            $(this).toggleClass("pressed"); //you can list several class names
            e.preventDefault();
        });
        $('.sp-wrap').smoothproducts();
    });
    $('.masterKeynet').on('click', function (e) {
        $(this).addClass("cut-radio-style");
        $('.masterCard').removeClass("cut-radio-style");
    });
    $('.masterCard').on('click', function (e) {
        $(this).addClass("cut-radio-style");
        $('.masterKeynet').removeClass("cut-radio-style");
    });
    $('.select-detail').select2();
})(jQuery); // End of use strict
