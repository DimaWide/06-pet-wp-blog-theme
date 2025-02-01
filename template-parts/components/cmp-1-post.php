<?php

$categories = get_the_category();
$image = get_the_post_thumbnail($post->ID, 'image-size-4');
?>
<div class="cmp-1-post <?php echo empty($image) ? 'mod-empty-img' : ''; ?>">
    <a href="<?php the_permalink(); ?>" class="cmp1-inner">
        <div class="cmp1-image featured-image">
            <div class="cmp1-cat">
                <?php if (! empty($image)): ?>
                    <span class="category">
                        <?php
                        echo $categories[0]->name;
                        ?>
                    </span>
                <?php endif; ?>
            </div>

            <?php if (! empty($image)): ?>
                <?php echo $image; ?>
            <?php endif; ?>
        </div>

        <div class="cmp1-info">
            <h2 class="cmp1-title">
                <?php the_title(); ?>
            </h2>

            <div class="cmp1-desc">
                <?php the_excerpt(); ?>
            </div>

            <div class="cmp1-meta">
                <div class="cmp1-date">
                    <?php echo get_the_date('M j Y'); ?>
                </div>

                <div class="cmp1-time-read">
                    <?php echo reading_time($post->ID) . ' Read'; ?>
                </div>
            </div>
        </div>
    </a>
</div>