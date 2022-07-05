/*
Author       : Syed Ekram.
Template Name: Future - Multipurpose HTML Template.
Version      : 1.0
*/

(function($) {
	"use strict";
	
	jQuery(document).ready(function(){
	
		/*preloader js*/
		$(window).load(function() { 
			$('.status').fadeOut();
			$('.preloader').delay(350).fadeOut('slow'); 
		}); 
		/*End preloader js*/

		/*menu*/
		$(window).scroll(function() {
		  if ($(this).scrollTop() > 100) {
			$('.menu-top').addClass('menu-shrink');
		  } else {
			$('.menu-top').removeClass('menu-shrink');
		  }
		});
		
		/*End menu*/ 

		/*START SLIDER JS*/
           $('.flexslider').flexslider({
               animation: "slide"
           });
		/*END SLIDER JS*/
		
		
		/*START PROGRESS-BAR JS*/
	    $('.progress-bar > span').each(function(){
			var $this = $(this);
			var width = $(this).data('percent');
			$this.css({
				'transition' : 'width 2s'
			});
			
			setTimeout(function() {
				$this.appear(function() {
						$this.css('width', width + '%');
				});
			}, 500);
		});
		/*END PROGRESS-BAR JS*/
		
		/* Countdown js*/
		$('.counter_feature').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
			if (visible) {
				$(this).find('.timer').each(function () {
					var $this = $(this);
					$({ Counter: 0 }).animate({ Counter: $this.text() }, {
						duration: 2000,
						easing: 'swing',
						step: function () {
							$this.text(Math.ceil(this.Counter));
						}
					});
				});
				$(this).unbind('inview');
			}
		});
		/* End Countdown js */
		

		/*testimonial carousel js*/
		$('.carousel').carousel({
			interval:5000,
			pause:"false",
		});
		/*End testimonial carousel js*/
	
	
	}); 	
		
		/* START MENU TAB JS */
		jQuery('.tab-buttons li a').click(function(){

			var handler = jQuery(this);
			var rel = handler.data('rel');
			var parent = handler.parent();

			if(parent.hasClass('selected')){
			}else{
				
				jQuery('.tab-buttons li').removeClass('selected');
				parent.addClass('selected');

				jQuery('.tab-container > div').hide();
				jQuery('.tab-container #'+rel).show();
			}

			return false;

		});	
		/* END MENU TAB JS */
		
		/*START MIXITUP JS*/
			$('.work_all_item').mixItUp();
			
			// jQuery Lightbox
			$('.lightbox').venobox({
				numeratio: true,
				infinigall: true
			});	
		/*END MIXITUP JS*/
	
		/*wow animation js*/
	    	new WOW().init();	
	    /*End wow animation js*/	
		
		
				
})(jQuery);

