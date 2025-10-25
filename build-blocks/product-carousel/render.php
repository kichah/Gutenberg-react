<?php
$heading = isset($attributes['heading']) ? $attributes['heading'] : 'Discover Our Collection';
$product_source = isset($attributes['productSource']) ? $attributes['productSource'] : 'recent';
$category = isset($attributes['category']) ? $attributes['category'] : 0;
$product_count = isset($attributes['productCount']) ? $attributes['productCount'] : 6;
$loop = isset($attributes['loop']) ? $attributes['loop'] : true;
$autoplay = isset($attributes['autoplay']) ? $attributes['autoplay'] : false;
$order_by = isset($attributes['orderBy']) ? $attributes['orderBy'] : 'date';


// Query args
$args = array(
    'post_type' => 'product',
    'posts_per_page' => $product_count,
    'orderby' => $order_by,
);

// Filter by category
if ($category && $category !== 0) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $category,
        ),
    );
}

// Filter by product source
if ($product_source === 'featured') {
    $args['tax_query'][] = array(
        'taxonomy' => 'product_visibility',
        'field' => 'name',
        'terms' => 'featured',
    );
} elseif ($product_source === 'sale') {
    $args['meta_query'] = array(
        array(
            'key' => '_sale_price',
            'value' => 0,
            'compare' => '>',
            'type' => 'NUMERIC',
        ),
    );
}

$products = new WP_Query($args);

$wrapper_attributes = get_block_wrapper_attributes(array(
    'class' => 'wc-product-carousel-block',
));
?>

<section <?php echo $wrapper_attributes; ?>>
    <div class="container">
        <?php if (!empty($heading)) : ?>
            <h2><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        
        <div class="embla" data-loop="<?php echo esc_attr($loop ? 'true' : 'false'); ?>" data-autoplay="<?php echo esc_attr($autoplay ? 'true' : 'false'); ?>">
            <div class="embla__container">
                <?php
                if ($products->have_posts()) :
                    while ($products->have_posts()) : $products->the_post();
                        global $product;
                        ?>
                       <div class="embla__slide">
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="card-link">
                            <article class="card" id="product-<?php echo esc_attr($product->get_id()); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
                                <?php endif; ?>
                                
                                <h3><?php the_title(); ?></h3>
                                
                                <p><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                                
                                <div class="product-price">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                            </article>
                        </a>
                    </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>

        <?php if ($products->have_posts() ) : ?>
            <div class="carousel-navigation">
                <button class="embla__prev" aria-label="Previous products">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </button>
                <button class="embla__next" aria-label="Next products">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>

