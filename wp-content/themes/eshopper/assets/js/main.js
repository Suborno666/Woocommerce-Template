(function ($) {
    "use strict";
    
    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Vendor carousel
    $('.vendor-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0:{
                items:2
            },
            576:{
                items:3
            },
            768:{
                items:4
            },
            992:{
                items:5
            },
            1200:{
                items:6
            }
        }
    });


    // Related carousel
    $('.related-carousel').owlCarousel({
        loop: true,
        margin: 29,
        nav: false,
        autoplay: true,
        smartSpeed: 1000,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:2
            },
            768:{
                items:3
            },
            992:{
                items:4
            }
        }
    });


    // Product Quantity
    $('.quantity button').on('click', function () {
        var button = $(this);
        var oldValue = button.parent().parent().find('input').val();
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        button.parent().parent().find('input').val(newVal);
    });


	$(document).ready(function() {
		function performSearch() {
			var WoofText = $('#search_by_string').val();
			var currentWindow = window.location.href.split('?')[0];
            
            var basePath = currentWindow.includes("/shop") ? currentWindow : currentWindow + "shop/";
            
			var redirectURL = basePath + "?swoof=1";

			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);
			
			var paTextValue = urlParams.get('woof_text') || '';
			var paColor = urlParams.get('pa_color') || '';

			if (WoofText) {
				redirectURL += "&woof_text=" + encodeURIComponent(WoofText);
			} else if (paTextValue) {
				redirectURL += "&woof_text=" + encodeURIComponent(paTextValue);
			}
			
			if (paColor) {
				redirectURL += "&pa_color=" + encodeURIComponent(paColor);
			}

			window.location.href = redirectURL;
		}

		$('#search_item').on('click', function() {
			performSearch();
		});

		$('#search_by_string').on('keypress', function(e) {
			if (e.which == 13) {
				performSearch();
				e.preventDefault(); 
			}
		});
	});
})(jQuery);

