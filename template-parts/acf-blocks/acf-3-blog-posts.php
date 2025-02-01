<?php

$current_category = '';

if (is_category()) {
    $current_category = get_queried_object()->slug;
}

$pages         = get_field('pages', 'option');
$blog_page     = 41;
$page_slug     = get_post_field('post_name', $blog_page);
$category_slug = 'category';

$terms = get_terms([
    'taxonomy'   => 'category',
    'hide_empty' => true,      
    'exclude'    => [1],       
    'number'     => 6,         
    'orderby'    => 'count',   
    'order'      => 'DESC',    
]);



// Main Query
$page       = !empty(get_query_var('paged')) ? get_query_var('paged') : 1;
$page_items = 3;
$offset     = ($page - 1) * $page_items;

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => $page_items,
    'paged'          => $page,
);

if (!empty($current_category)) {
    $args['tax_query'] = [
        'relation' => 'AND',
        array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => $current_category,
        ),
    ];
};

$query_obj   = new WP_Query($args);
$total_pages = $query_obj->max_num_pages;
$has_more    = ($page < $total_pages) ? true : false;
$post_count  = $query_obj->post_count;

$total_count = $query_obj->found_posts;
$pages_elem  = ceil(($total_count - $offset) / $page_items);
?>
<!-- Acf Block #6 – posts List -->
<div class="acf-3-blog-posts" data-slug-page="<?php echo $page_slug; ?>" data-slug-category="<?php echo $category_slug; ?>">
    <div class="decor-rounded-triangle"></div>

    <div class="data-container wcl-container">
        <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
            <div class="data-cats">
                <ul class="data-cats-list">
                    <li class="data-cats-item">
                        <a href="<?php echo get_permalink($blog_page); ?>" class="<?php echo empty($current_category) ? 'active' : ''; ?>" data-slug="all" data-id="all">
                            All
                        </a>
                    </li>

                    <?php foreach ($terms as $term) : ?>
                        <?php
                        $active = '';

                        if ($term->slug == $current_category) {
                            $active = 'active';
                        }
                        ?>
                        <li class="data-cats-item">
                            <a href="<?php echo get_term_link((int)$term->term_id); ?>" class="<?php echo $active; ?>" data-id="<?php echo $term->slug; ?>" data-slug="<?php echo $term->slug; ?>">
                                <?php echo $term->name; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="data-list-out">
            <div class="data-list">
                <?php if ($query_obj->have_posts()) : ?>
                    <?php while ($query_obj->have_posts()) : $query_obj->the_post(); ?>
                        <div class="data-item">
                            <?php get_template_part('template-parts/components/cmp-1-post'); ?>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                <?php else : ?>
                    <div class="data-list-empty">
                        No found
                    </div>
                <?php endif; ?>
            </div>
        </div>


        <?php
		$class_pagination = '';
		if (($total_count / $page_items)  > 1) {
			$class_pagination = 'active';
		}
		?>
		<div class="data-pagination <?php echo $class_pagination; ?>">
			<div class="data-pagination-inner">
				<?php
				blog_page_pagination($query_obj, '', $current_category);
				?>
			</div>
		</div>
    </div>
</div>

