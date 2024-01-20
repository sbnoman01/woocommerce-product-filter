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
