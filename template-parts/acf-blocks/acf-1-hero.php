<?php

?>
<!-- acf-1-hero -->
<div class="acf-1-hero">
    <div class="data-container wcl-container">
        <div class="data-row">
            <?php
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 1,
            );

            $query_obj   = new WP_Query($args);
            $post_count  = $query_obj->post_count;
            ?>
            <?php if ($query_obj->have_posts()) : ?>
                <?php while ($query_obj->have_posts()) : $query_obj->the_post(); ?>
                    <?php
                    $image = get_the_post_thumbnail($post->ID, 'image-size-3');
                    ?>
                    <div class="data-item featured-post">
                        <a href="<?php the_permalink(); ?>" class="data-item-inner">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="data-item-image featured-image">
                                    <?php if (! empty($image)): ?>
                                        <?php echo $image; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="data-item-info">
                                <div class="data-item-cat">
                                    <span class="category">
                                        <?php
                                        $categories = get_the_category();
                                        if (! empty($categories)) {
                                            echo $categories[0]->name;
                                        }
                                        ?>
                                    </span>
                                </div>

                                <h2 class="data-item-title">
                                    <?php the_title(); ?>
                                </h2>

                                <div class="data-item-desc">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            <?php endif; ?>

            <?php
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 2,
                'offset'         => 1,
            );

            $query_obj = new WP_Query($args);
            $post_count = $query_obj->post_count;
            ?>
            <?php if ($query_obj->have_posts()) : ?>
                <div class="data-grid grid">
                    <?php while ($query_obj->have_posts()) : $query_obj->the_post(); ?>
                        <?php
                        $image = get_the_post_thumbnail($post->ID, 'full');
                        ?>
                        <div class="data-item">
                            <a href="<?php the_permalink(); ?>" class="data-item-inner">
                                <div class="data-item-image featured-image">
                                    <?php if (! empty($image)): ?>
                                        <?php echo $image; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="data-item-info">
                                    <?php
                                    $categories = get_the_category();
                                    if (! empty($categories)) {
                                        if ($categories[0]->name != 'Uncategorized') {
                                        }
                                    }
                                    ?>
                                    <?php if ($categories[0]->name != 'Uncategorized'): ?>
                                        <div class="data-item-cat">
                                            <span class="category">
                                                <?php echo $categories[0]->name; ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <h2 class="data-item-title">
                                        <?php the_title(); ?>
                                    </h2>

                                    <div class="data-item-desc">
                                        <?php the_excerpt(); ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>