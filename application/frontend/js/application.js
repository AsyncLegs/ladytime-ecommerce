let $ = require('jquery');

jQuery.fn.load = function(callback){ $(window).on("load", callback) };

window.jQueryFlexSlider = require('flexslider');
const bootstrap = require('bootstrap');



require('magnific-popup');
require('bootstrap-validator');

require('jquery-inputmask');

require('./store.js');


$(window).load(function() {
    $(document).ajaxStart(() => {
        $('#preloader').toggleClass('hidden');
    });
    $(document).ajaxStop(() => {
        $('#preloader').toggleClass('hidden');
    });
    $.mask.definitions['d'] = "((0[1-9]|1[0-2])/([01][1-9]|10|2[0-8]))|((0[13-9]|1[0-2])/(29|30))|((0[13578]|1[0-2])/31)";
    $.mask.definitions['month'] = "[1-12]";
    $.mask.definitions['year'] = "[1999]";

    $(".mobile-phone").mask("+380999999999");


    $(".scroll").click((event) => {
        event.preventDefault();
        $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
    });

    $('#horizontalTab').easyResponsiveTabs({
        type: 'default', //Types: default, vertical, accordion
        width: 'auto', //auto or any width like 600px
        fit: true   // 100% fit in a container
    });


    $('.popup-with-zoom-anim').magnificPopup({
        type: 'inline',
        fixedContentPos: false,
        fixedBgPos: true,
        overflowY: 'auto',
        closeBtnInside: true,
        preloader: true,
        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in'
    });

    $('.example1').wmuSlider();

    $("#flexiselDemo1").flexisel({
        visibleItems: 4,
        animationSpeed: 1000,
        autoPlay: true,
        autoPlaySpeed: 3000,
        pauseOnHover: true,
        enableResponsiveBreakpoints: true,
        responsiveBreakpoints: {
            portrait: {
                changePoint:480,
                visibleItems: 1
            },
            landscape: {
                changePoint:640,
                visibleItems:2
            },
            tablet: {
                changePoint:768,
                visibleItems: 3
            }
        }
    });

    $('.openProductModal').on('click', (e) => {
        e.preventDefault();
        let id = $(e.currentTarget).data('product');
        $.ajax({
            url:  '/api/v1/product/' + id,
            type: 'GET',
            success: (data) => {
                console.log(data);
                $('#productModalImage').attr('src', '/uploads/products/images/'+data.images[0]);
                $('#productPopupShortDescription').text(data.short_description);
                $('#productPopupFullDescription').text(data.full_description);
                $('#productPopupPrice').text(data.prices[0].amount);
                $('#productPopupPriceOld').text(data.prices[0].previous_amount);
                $("#productModal").modal('show');
            },
            error: () => {
                alert("error");
            }
        });
    });
    $("#productModal").on('show.bs.modal', () => {
        console.log('1111');
    });



    /* ---- Countdown timer ---- */

	$('#counter').countdown({
		timestamp : (new Date()).getTime() + 11*24*60*60*1000
	});


	/* ---- Animations ---- */

	$('#links a').hover(
		function(){ $(this).animate({ left: 3 }, 'fast'); },
		function(){ $(this).animate({ left: 0 }, 'fast'); }
	);

	$('footer a').hover(
		function(){ $(this).animate({ top: 3 }, 'fast'); },
		function(){ $(this).animate({ top: 0 }, 'fast'); }
	);


	/* ---- Using Modernizr to check if the "required" and "placeholder" attributes are supported ---- */
    let emails = $('.email');
	if (!Modernizr.input.placeholder) {
        emails.val('Input your e-mail address here...');
        emails.focus(() => {
			if($(this).val() === 'Input your e-mail address here...') {
				$(this).val('');
			}
		});
	}

	// for detecting if the browser is Safari
	let browser = navigator.userAgent.toLowerCase();

	if(!Modernizr.input.required || (browser.indexOf("safari") !== -1 && browser.indexOf("chrome") === -1)) {
		$('form').submit(function() {
			$('.popup').remove();
			if(!emails.val() || $('.email').val() === 'Input your e-mail address here...') {
				$('form').append('<p class="popup">Please fill out this field.</p>');
                emails.focus();
				return false;
			}
		});
        emails.keydown(function() {
			$('.popup').remove();
		});
        emails.blur(function() {
			$('.popup').remove();
		});
	}


});
