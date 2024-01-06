(function( $ ) {
	'use strict';
	$(document).ready(function () {
		var blog_Slider_One = new Swiper('.mySwiper', {
			 breakpoints: {
			  480:{
				slidesPerView: 1
			  },
			  575:{
				slidesPerView: 2
			  },
			  992:{    
				slidesPerView: 4
			  }
			},
			spaceBetween: 30,
			navigation: {
				nextEl: '.wcproduct-next',
				prevEl: '.wcproduct-prev',
			},
		});

		$('table.variations .label').click(function(e) {
		console.log('ff')
			e.preventDefault();

			let $this = $(this);

			if ($this.next().hasClass('show')) {
				$this.next().removeClass('show');
				$this.next().hide(350);
			} else {
				$this.parent().parent().find('tr .woo-variation-items-wrapper').removeClass('show');
				$this.parent().parent().find('tr .woo-variation-items-wrapper').slideUp(350);
				$this.next().toggleClass('show');
				$this.next().css('display', 'block').animate({ opacity: 1 }, 500);
			}
		});
		$.fn.wc_variation_form = function() {
			return this;
		};
		

	});
				  
	
})( jQuery );
