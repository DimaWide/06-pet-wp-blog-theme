<?php




/**
 * categories_page_load_post
 */
function categories_page_load_post() {
    $page_items = isset($_POST['page_items']) ? $_POST['page_items'] : 3;
    $page       = isset($_POST['page']) ? $_POST['page'] : 1;
    $category   = isset($_POST['category']) ? $_POST['category'] : '';
    $offset     = ($page - 1) * $page_items;

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $page_items,
        'paged'          => $page,
    );

    if (!empty($category) && $category !== 'all') {
        $args['tax_query'] = [
            'relation' => 'AND',
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        ];
    };

    $query_obj   = new WP_Query($args);
    $post_count  = $query_obj->post_count;
    $total_pages = $query_obj->max_num_pages;
    $total_count = $query_obj->found_posts;
    $has_more    = ($page < $total_pages) ? true : false;
    ob_start();
?>
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
    <?php
    $output['posts'] = ob_get_clean();
    ?>
    <?php
    ob_start();

    blog_page_pagination($query_obj, $page, $category);

    $output['pagination'] = ob_get_clean();
    ?>
<?php
    $output['total_pages'] = $total_pages;
    $output['count_pages'] = $total_count / $page_items;

    echo json_encode($output);
    wp_die();
}
add_action('wp_ajax_categories_page_load_post', 'categories_page_load_post');
add_action('wp_ajax_nopriv_categories_page_load_post', 'categories_page_load_post');









/**
 * blog_page_load_posts
 */
function blog_page_load_posts() {
    $page_items = isset($_POST['page_items']) ? $_POST['page_items'] : 9;
    $page       = isset($_POST['page']) ? $_POST['page'] : 1;
    $category   = isset($_POST['category']) ? $_POST['category'] : '';

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $page_items,
        'paged'          => $page,
    );

    if (!empty($category) && $category !== 'all') {
        $args['tax_query'] = [
            'relation' => 'AND',
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => $category,
            ),
        ];
    };

    $query_obj   = new WP_Query($args);
    $post_count  = $query_obj->post_count;
    $total_pages = $query_obj->max_num_pages;
    $has_more    = ($page < $total_pages) ? true : false;
    ob_start();
?>
    <?php if ($query_obj->have_posts()) : ?>
        <?php while ($query_obj->have_posts()) : $query_obj->the_post(); ?>
            <div class="data-item">
                <?php get_template_part('template-parts/components/cmp-2-post'); ?>
            </div>
        <?php endwhile;
        wp_reset_postdata(); ?>
    <?php else : ?>
        <div class="data-list-empty">
            No found
        </div>
    <?php endif; ?>
    <?php
    $output['posts'] = ob_get_clean();

    ob_start();
    ?>
    <?php if ($has_more) : ?>
        <button class="data-load-more-btn cmp-button" data-page="<?php echo $page; ?>">
            Load more
        </button>
    <?php else : ?>
        <button class="data-load-more-btn cmp-button" data-page="<?php echo $page; ?>" disabled="true">
            All viewed
        </button>
    <?php endif; ?>
<?php
    $output['button'] = ob_get_clean();
    $output['total_pages'] = $total_pages;

    echo json_encode($output);
    wp_die();
}
add_action('wp_ajax_blog_page_load_posts', 'blog_page_load_posts');
add_action('wp_ajax_nopriv_blog_page_load_posts', 'blog_page_load_posts');
