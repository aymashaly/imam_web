(function($){
    (function($) {
        "use strict";

        // Preloader
        $(window).on('load', function() {
            $('.preloader').addClass('preloader-deactivate');
        }) 

        // Sticky, Go To Top JS
        $(window).on('scroll', function() {
            // Header Sticky JS
            if ($(this).scrollTop() >150){  
                $('.navbar-area').addClass("is-sticky");
            }
            else{
                $('.navbar-area').removeClass("is-sticky");
            };

            // Go To Top JS
            var scrolled = $(window).scrollTop();
            if (scrolled > 300) $('.go-top').addClass('active');
            if (scrolled < 300) $('.go-top').removeClass('active');
        });

		// Support Moodle MultiLang
        var langValue = $("html").attr("lang");
        $('.multilang').each(function(){
            var currentLangValue = $(this).attr("lang");
            if(langValue != currentLangValue) {
                $(this).addClass('d-none');
            }
        });

        $(document).ready(function() {

			var current_site_url = $(".desktop-nav .navbar .navbar-brand").attr("href");
			if (current_site_url) {
				var local_urls = [
					'http://localhost/moodle/edma/',
					'http://localhost:8888/moodle/edma/',
					'http://localhost:8888/moodle/edma-4.4/',
					'http://localhost:8888/moodle/edma-4.3/',
					'http://localhost:8888/moodle/edma-4.5/',
				];

				// Function to replace old URLs with the current site URL
				function replaceUrls(element, attribute) {
					$(element).each(function () {
						var url = $(this).attr(attribute);
						if (url) {
							local_urls.forEach(function (local_url) {
								if (url.includes(local_url)) {
									url = url.replace(local_url, current_site_url);
									$(this).attr(attribute, url);
								}
							}, this);
						}
					});
				}

				// Replace URLs for 'a' and 'img' elements
				replaceUrls('a', 'href');
				replaceUrls('img', 'src');
			}

            
            $("body.role-standard:not(.path-contentbank):not(#page-contentbank) .bottom-region-main-box").each(function() {
                if (!$(this).find(".block").length && !$(this).find(".edma-main").text().trim().length) {
                $(".bottom-region-main-box, .bottom-region-main-box #page-content").css({
                    'padding-top': '0',
                    'margin-top': '0',
                    'padding-bottom': '0px !important',
                });
                $(".edma-main").remove();
                }
            });

            $(".dashbord_nav_list > a:first-child").prepend("<i class='bx bxs-dashboard' ></i>");
            $(".dashbord_nav_list > a:nth-child(2)").prepend("<i class='bx bx-user' ></i>");
            $(".dashbord_nav_list > a:nth-child(3)").prepend("<i class='bx bxs-graduation' ></i>");
            $(".dashbord_nav_list > a:nth-child(4)").prepend("<i class='bx bx-chat' ></i>");
            $(".dashbord_nav_list > a:nth-child(5)").prepend("<i class='bx bx-cog' ></i>");
            $(".dashbord_nav_list > a:nth-child(6)").prepend("<i class='bx bx-log-out' ></i>");
            $(".dashbord_nav_list > a:nth-child(7)").prepend("<i class='bx bx-user-plus' ></i>");
            $(".dashbord_nav_list > a:nth-child(8)").prepend("<i class='bx bx-log-out'></i>");
            $(".dashbord_nav_list > a").each(function() {
            $(this).removeClass("dropdown-item").wrap("<li></li>");
            });
            $(".dashbord_nav_list > li").wrapAll("<ul></ul>");


            // Popup Video JS
            $('.popup-youtube, .popup-vimeo').magnificPopup({
                disableOn: 300,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false,
            });

			
			// Click Event JS
			$('.go-top').on('click', function() {
				$("html, body").animate({ scrollTop: "0" }, 100);
			});
			// Others Option For Responsive JS
			$(".others-option-for-responsive .dot-menu").on("click", function(){
				$(".others-option-for-responsive .container .container").toggleClass("active");
			});

			// Mean Menu
			$('.mean-menu').meanmenu({
				meanScreenWidth: "991"
			});
			
			$(".popover-region-notifications").click(function() {
				$(".popover-region-notifications").toggleClass('collapsed');
			});

			$(".mobile-responsive-menu .meanmenu-reveal").on("click", function(){
				$(".others-option-for-responsive .container .container").removeClass("active");
			});
        });

        // Feature Courses Slide JS
		$('.feature-courses-slide').owlCarousel({
			loop:false,
			margin: 15,
			nav: true,
			dots: false,
			autoplay: false,
			smartSpeed: 1000,
			autoplayHoverPause: true,
			navText: [
				"<i class='ri-arrow-left-s-line'></i>",
				"<i class='ri-arrow-right-s-line'></i>",
			],
			responsive: {
				0: {
					items: 1,
				},
				414: {
					items: 1,
				},
				576: {
					items: 2,
				},
				768: {
					items: 2,
				},
				992: {
					items: 3,
				},
				1200: {
					items: 5,
				},
			},
		});

		// Viewed Courses Slide JS
		$('.viewed-courses-slide').owlCarousel({
			loop: true,
			margin: 15,
			nav: true,
			dots: false,
			autoplay: false,
			smartSpeed: 1000,
			autoplayHoverPause: true,
			navText: [
				"<i class='ri-arrow-left-s-line'></i>",
				"<i class='ri-arrow-right-s-line'></i>",
			],
			responsive: {
				0: {
					items: 1,
				},
				414: {
					items: 1,
				},
				576: {
					items: 2,
				},
				768: {
					items: 2,
				},
				992: {
					items: 3,
				},
				1200: {
					items: 5,
				},
			},
		});

		// Testimonials Slide JS
		$('.testimonials-slide').owlCarousel({
			items: 1,
			loop: true,
			margin: 30,
			nav: true,
			dots: false,
			autoplay: true,
			smartSpeed: 1000,
			autoplayHoverPause: true,
			animateOut: 'animate__slideOutUp',
			animateIn: 'animate__slideInUp',
			navText: [
				"<i class='ri-arrow-up-s-line'></i>",
				"<i class='ri-arrow-down-s-line'></i>",
			],
		});

		// Testimonials Slide JS
		$('.testimonials-slide-list-one').owlCarousel({
			items: 1,
			loop: true,
			margin: 30,
			nav: false,
			dots: false,
			autoplay: true,
			smartSpeed: 1000,
			autoplayHoverPause: true,
			stagePadding: 100,
			responsive: {
				0: {
					items: 1,
					stagePadding: 0,
				},
				414: {
					items: 1,
					stagePadding: 0,
				},
				576: {
					items: 1,
					stagePadding: 0,
				},
				768: {
					items: 2,
					stagePadding: 0,
				},
				992: {
					items: 2,
				},
				1200: {
					items: 3,
				},
			},
		});

		// Testimonials Slide JS
		$('.testimonials-slide-list-two').owlCarousel({
			items: 1,
			loop: true,
			margin: 30,
			nav: false,
			dots: false,
			autoplay: true,
			smartSpeed: 1000,
			autoplayHoverPause: true,
			rtl:true,
			stagePadding: 200,
			responsive: {
				0: {
					items: 1,
					stagePadding: 0,
					rtl: false,
				},
				414: {
					items: 1,
					stagePadding: 0,
					rtl: false,
				},
				576: {
					items: 2,
					stagePadding: 0,
					rtl: false,
				},
				768: {
					items: 2,
					stagePadding: 0,
					rtl: false,
				},
				992: {
					items: 2,
				},
				1200: {
					items: 3,
				},
			},
		});
		
		// Partner Slide JS
		$('.partner-slide').owlCarousel({
			loop: true,
			margin: 30,
			nav: false,
			dots: false,
			autoplay: true,
			autoplayHoverPause: true,
			responsive: {
				0: {
					items: 2,
				},
				414: {
					items: 3,
				},
				576: {
					items: 3,
				},
				768: {
					items: 4,
				},
				992: {
					items: 5,
				},
				1200: {
					items: 6,
				},
			},
		});

		// WOW Animation
		if ($('.wow').length) {
			var wow = new WOW({
				boxClass: 'wow',
				animateClass: 'animated', 
				offset: 0, 
				mobile: false, 
				live: true, 
			});
			wow.init();
		}
		})(window.jQuery);
}(jQuery));

$(function () {
	var langValue = $("html").attr("lang");
	$('.multilang').each(function(){
		var currentLangValue = $(this).attr("lang");
		if(langValue !== currentLangValue) {
			$(this).addClass('d-none');
		}
	});
});