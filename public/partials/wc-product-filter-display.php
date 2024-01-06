<?php

function wc_proudct_filter_display($vars)
{
    ob_start();

    //get posts ID for specific type
    $args = [
        'post_type' => 'product',
        'fields'         => 'ids',
    ];

    if (!empty($vars['type'])) {
        $args['tax_query'] =  array(
            array(
                'taxonomy' => 'item-type',
                'field'    => 'slug',
                'terms'    => $vars['type'],
            ),
        );
    }
    $post_ids = get_posts($args);

?>
<div class="filter-container" id="product_filter" data-product-type="<?php echo esc_attr( $vars['type'] ) ?>">
    <div class="filter-rows">
        <div class="filter-col-3">
            <div class="filter-boxes">
                <h5>Filters:</h5>
                <!-- perfomace filter start -->
                <div class="filter-item">
                    <div class="filter-heading">
                        <h4>Performance</h4>
                        <div class="filter-fieds">
                            <?php
                                $topic_tax_args = [
                                    'taxonomy' => 'performance',
                                    'hide_empty' => true,
                                    'object_ids'  => $post_ids
                                ];
                                $get_topic_tax = get_terms($topic_tax_args);

                                foreach ($get_topic_tax as $key => $topic) : ?>
                            <div class="filter-fieds-single">
                                <input type="checkbox" name="<?php echo esc_attr($topic->slug) ?>"
                                    id="<?php echo esc_attr($topic->slug) ?>"
                                    class="tax_perforance filter_class term-id-<?php echo esc_attr($topic->term_id) ?>  d-none"
                                    value="<?php echo esc_attr($topic->slug) ?>">
                                <label
                                    for="<?php echo esc_attr($topic->slug) ?>"><?php echo esc_html($topic->name) ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- perfomance filter end -->

                <!-- style filter -->
                <div class="filter-item">
                    <div class="filter-heading">
                        <h4>Styles</h4>
                        <div class="filter-fieds">
                            <?php
                                $topic_tax_args = [
                                    'taxonomy' => 'styles',
                                    'hide_empty' => true,
                                    'object_ids'  => $post_ids
                                ];
                                $get_topic_tax = get_terms($topic_tax_args);

                                foreach ($get_topic_tax as $key => $topic) : ?>
                            <div class="filter-fieds-single">
                                <input type="checkbox" name="<?php echo esc_attr($topic->slug) ?>"
                                    id="<?php echo esc_attr($topic->slug) ?>"
                                    class="tax_styles filter_class term-id-<?php echo esc_attr($topic->term_id) ?>  d-none"
                                    value="<?php echo esc_attr($topic->slug) ?>">
                                <label
                                    for="<?php echo esc_attr($topic->slug) ?>"><?php echo esc_html($topic->name) ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- style filter end -->

                <!-- Frame filter -->
                <div class="filter-item">
                    <div class="filter-heading">
                        <h4>Frame</h4>
                        <div class="filter-fieds">
                            <?php
                                $topic_tax_args = [
                                    'taxonomy' => 'frames',
                                    'hide_empty' => true,
                                    'object_ids'  => $post_ids
                                ];
                                $get_topic_tax = get_terms($topic_tax_args);

                                foreach ($get_topic_tax as $key => $topic) : ?>
                            <div class="filter-fieds-single">
                                <input type="checkbox" name="<?php echo esc_attr($topic->slug) ?>"
                                    id="<?php echo esc_attr($topic->slug) ?>"
                                    class="tax_frames filter_class term-id-<?php echo esc_attr($topic->term_id) ?>  d-none"
                                    value="<?php echo esc_attr($topic->slug) ?>">
                                <label
                                    for="<?php echo esc_attr($topic->slug) ?>"><?php echo esc_html($topic->name) ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- Frame filter end -->


                <!-- Clear Filter buttons -->
                <button class="clear__filter rounded" onclick="location.reload();">Clear filter</button>
                <!-- Clear filter button end -->
            </div>
        </div>

        <!-- products area -->
        <div class="filter-col-9">
            <div class="filter-products">
                <?php
                    $products_args = [
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'post__in'       => $post_ids,
                        'posts_per_page' => -1, //get_option( 'posts_per_page' )
                        // 'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                        'order'             => 'ASC'
                    ];
                    $product_query_on = new WP_Query($products_args);

                    if ($product_query_on->have_posts()) {
                        // global $wp_query;
                        echo '<div class="filter-rows filtered_data">';
                        while ($product_query_on->have_posts()) {
                            $product_query_on->the_post();
                            $max_num_page = $product_query_on->max_num_pages;
                        ?>
                        <div class="filter-col-4">
                            <div class="filter-single-item">
                                <div class="wcproduct-thumb">
                                    <a href="<?php echo esc_url(get_the_permalink()) ?>">
                                        <?php echo get_the_post_thumbnail(); ?>
                                    </a>
                                </div>
                                <div class="wcproduct-inner-content">
                                    <a href="<?php echo esc_url(get_the_permalink()) ?>">
                                        <h3>
                                            <?php the_title(); ?>
                                        </h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                <?php
                        }
                        echo '</div>';
                        ?>
                <?php
                    }
                    wp_reset_postdata();
                    ?>
            </div>
        </div>
        <!-- products area ends -->
    </div>
</div>
<?php
    return ob_get_clean();
}