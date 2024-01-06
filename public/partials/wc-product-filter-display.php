<?php

function wc_proudct_filter_display($vars)
{
    ob_start();
?>
    <div class="filter-container">
        <div class="filter-rows">
            <div class="filter-col-3">
                <div class="filter-boxes">
                    <?= $vars['type'] ?>
                    <!-- perfomace filter start -->
                    <div class="filter-item">
                        <div class="filter-heading">
                            <h4>Performance</h4>
                            <div class="filter-fieds">
                                <?php
                                    $topic_tax_args = [
                                        'taxonomy' => 'performance',
                                        'hide_empty' => false
                                    ];
                                    $get_topic_tax = get_terms($topic_tax_args);

                                    foreach ($get_topic_tax as $key => $topic) : ?>
                                        <div class="filter-fieds-single">
                                            <input type="checkbox" name="<?php echo esc_attr($topic->slug) ?>" id="<?php echo esc_attr($topic->slug) ?>" class="tax_topic filter_class term-id-<?php echo esc_attr($topic->term_id) ?>  d-none" value="<?php echo esc_attr($topic->slug) ?>">
                                            <label for="<?php echo esc_attr($topic->slug) ?>"><?php echo esc_html($topic->name) ?></label>
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
                                        'object_ids'  => [295]
                                    ];
                                    $get_topic_tax = get_terms($topic_tax_args);

                                    foreach ($get_topic_tax as $key => $topic) : ?>
                                        <div class="filter-fieds-single">
                                            <input type="checkbox" name="<?php echo esc_attr($topic->slug) ?>" id="<?php echo esc_attr($topic->slug) ?>" class="tax_topic filter_class term-id-<?php echo esc_attr($topic->term_id) ?>  d-none" value="<?php echo esc_attr($topic->slug) ?>">
                                            <label for="<?php echo esc_attr($topic->slug) ?>"><?php echo esc_html($topic->name) ?></label>
                                        </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <!-- style filter end -->

                </div>
            </div>
            <div class="filter-col-9">
                <div class="filter-products">
                    filter products
                </div>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
