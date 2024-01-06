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
		

	/***
	 ***** 
	 * Product filer ajax call 
	 */

	// $('.tax_perforance').on('change', function () {
	// 	$('.tax_perforance').not(this).prop('checked', false);
	// });

	// $('.tax_cat').on('change', function () {
	// 	$('.tax_cat').not(this).prop('checked', false);
	// });

	// Get the Selected Topic
	function getSelectedPerform() {
		return $('.tax_perforance:checked').val();
		// return topic_name;
	}

	// Get the Selected Cat
	function getSelectedStyles() {
		let styles_name = [];
			$('.tax_styles:checked').each(function () {
				styles_name.push($(this).val());
		});
		return styles_name;
	}

	// Get the Selected Cat
		function getSelectedFrame() {
			let tax_frames = [];
			$('.tax_frames:checked').each(function () {
				tax_frames.push($(this).val());
		});
			return tax_frames;
	}

		$(document).on('change', '.filter_class', function (e) {
			$.ajax({
				type: "POST",
				url: fil_ajax.url,
				data: {
					action: "wc_product_filter",
					nonce: fil_ajax.nonce,
					perforance: getSelectedPerform,
					styles: getSelectedStyles,
					frame: getSelectedFrame
				},
				beforeSend: function () {
					$('.filter-loader').show();
				},
				success: function (res) {

					var content_wrapper = $('.filtered_data');
					if ($.trim(res.posts)) {
						content_wrapper.html(res.posts);
					}
					console.log(res);

				}
			});
		});

	});
})( jQuery );
