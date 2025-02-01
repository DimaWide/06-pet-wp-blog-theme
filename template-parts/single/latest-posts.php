<?php

$terms = get_terms([
    'taxonomy'   => 'category',
    'hide_empty' => true,
    'parent'     => 0,
]);


$group       = get_field('latest_posts', 'option');
$tagline     = 'Blog';
$title       = 'Lastest Newsletter & Case Study';
$subtitle    = 'Gaining Perspective: In-Depth Analyses and Latest Updates';
$button_text = 'View all posts';

if (is_404()) {
    $title = $group['title_for_404'];
}

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => array(get_the_ID()),
);

if (is_single()) {
    $terms = ordered_categories();
    $categorie_slugs = [];

    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term_id => $count) {
            $term = get_category($term_id);

            $categorie_slugs[] = $term->slug;
        }
    } else {
        return;
    }

    $args['tax_query'] = [
        'relation' => 'AND',
        array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $categorie_slugs,
        ),
    ];
}


$query_obj   = new WP_Query($args);
$post_count = $query_obj->post_count;
?>
<?php if (!empty($post_count)) : ?>
    <div class="wcl-latest-posts">
        <div class="data-container wcl-container">
            <div class="data-inner">
                <div class="data-row">
                    <div class="data-col">
                        <?php if (!empty($tagline)) : ?>
                            <div class="data-label">
                                <?php echo $tagline; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($title)) : ?>
                            <h2 class="data-title">
                                <?php echo $title; ?>
                            </h2>
                        <?php endif; ?>

                        <?php if (!empty($subtitle)) : ?>
                            <div class="data-subtitle">
                                <?php echo $subtitle; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="data-col">
                        <?php if (!empty($button_text)) : ?>
                            <?php
                            $pages     = get_field('pages', 'option');
                            $blog_page = $pages['blog'];
                            ?>
                            <div class="data-button">
                                <a href="<?php echo site_url('/') . 'blog'; ?>" class="cmp-button">
                                    <?php echo $button_text; ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($query_obj->have_posts()) : ?>
                    <div class="data-list">
                        <?php while ($query_obj->have_posts()) : $query_obj->the_post(); ?>
                            <div class="data-item">
                                <?php get_template_part('template-parts/components/cmp-1-post'); ?>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>