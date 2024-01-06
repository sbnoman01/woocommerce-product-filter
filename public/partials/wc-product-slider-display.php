<?php

function wc_proudct_slider_display($vars){
    ob_start();
    
    ?>
	<div class="wpn-product-slider-wrpp">
		<!-- navigation start -->
        <div class="wcproduct-navigation">
            <div class="wcproduct-next wcproduct-nav-icon">
                
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"> <circle cx="32" cy="32" r="32" transform="rotate(180 32 32)" fill="#001A70"></circle> <path d="M16 31.9035L48 31.9035M48 31.9035L38.734 42M48 31.9035L38.734 21.8071" stroke="#A4D5EE" stroke-width="2"></path> </svg>
            </div>
            <div class="wcproduct-prev wcproduct-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" fill="none"><g clip-path="url(#clip0_1796_17662)"><circle cx="32" cy="32" r="32" fill="#001A70"></circle><path d="M48 32.0965L16 32.0965M16 32.0965L25.266 22M16 32.0965L25.266 42.1929" stroke="#A4D5EE" stroke-width="2"></path></g><defs><clipPath id="clip0_1796_17662"><rect width="64" height="64" fill="white" transform="matrix(1 0 0 -1 0 64)"></rect></clipPath></defs></svg>
            </div>
        </div>
        <!-- navigation end -->
		
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">

            <?php
                $args = array(
                    'post_type'      => 'product', // Specify the post type as 'product'
                    'posts_per_page' => -1,        // Retrieve all products (use -1 for all, or a specific number)
                    'post_status' => 'publish',
                    'tax_query'     => [
                        [
                            'taxonomy' => 'item-type',
                            'field'     => 'slug',
                            'terms' => $vars['type']
                        ]
                    ]
                );

                $woocommerce_query = new WP_Query($args);

                // Check if there are any products
                if ($woocommerce_query->have_posts()) {
                    while ($woocommerce_query->have_posts()) {
                        $woocommerce_query->the_post(); ?>
                        <div class="swiper-slide">
                            <div class="wcproduct-thumb">
                                <a href="<?php echo esc_url( get_the_permalink() ) ?>">
                                    <?php echo get_the_post_thumbnail(); ?>
                                </a>
                            </div>
                            <div class="wcproduct-inner-content">
                                <a href="<?php echo esc_url( get_the_permalink() ) ?>">
                                    <h3>
                                        <?php the_title(); ?>
                                    </h3>
                                </a>
                            </div>
                        </div>
                        <?php
                    }

                    // Restore original post data
                    wp_reset_postdata();
                } else {
                    echo 'No products found';
                }
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
		</div>
    <?php
    
    return ob_get_clean();
}