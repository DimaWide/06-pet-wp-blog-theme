<?php

$term_id = get_field('category');
$term    = get_term($term_id);

if (is_wp_error($term)) {
    return;
}

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 10,
);

$args['tax_query'] = [
    array(
        'taxonomy' => 'category',
        'field'    => 'id',
        'terms'    => $term_id,
    ),
];

$query_obj = new WP_Query($args);
$post_count = $query_obj->post_count;

if (empty($post_count)) {
    return;
}
?>
<!-- acf-2-category -->
<div class="acf-2-category">
    <div class="data-container wcl-container">
        <div class="data-line"></div>
        <?php if (! empty($term)): ?>
            <h2 class="data-title">
                <?php echo $term->name; ?>
            </h2>
        <?php endif; ?>

        <?php if ($query_obj->have_posts()) : ?>
            <div class="data-slider swiper">
                <div class="data-slider-inner swiper-wrapper">
                    <?php while ($query_obj->have_posts()) : $query_obj->the_post(); ?>
                        <div class="data-slider-item swiper-slide">
                            <?php get_template_part('template-parts/components/cmp-1-post'); ?>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>