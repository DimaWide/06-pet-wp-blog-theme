<?php

$categories = get_the_category();
$image = get_the_post_thumbnail($post->ID, 'full');
?>
<div class="cmp-2-post <?php echo empty($image) ? 'mod-empty-img' : ''; ?>">
    <div class="cmp2-inner">
        <div class="cmp2-image featured-image">
        <a href="<?php echo get_permalink(); ?>">
            <?php if (! empty($image)): ?>
                <?php echo $image; ?>
            <?php endif; ?>
            </a>
        </div>

        <div class="cmp2-info">
            <div class="cmp2-meta">
                <span class="cmp2-cat-links">
                    <a href="<?php echo esc_url(get_category_link(get_the_category()[0]->term_id)); ?>" rel="category">
                        <?php echo esc_html(get_the_category()[0]->name); ?>
                    </a>
                </span>

                <span class="cmp2-posted-on">
                    Posted on:
                    <time class="cmp2-date published" datetime="<?php echo get_the_date('c'); ?>">
                        <?php echo get_the_date('M j Y'); ?>
                    </time>
                </span>

                <span class="cmp2-time-read">
                    <?php echo reading_time($post->ID) . ' Read'; ?>
                </span>
            </div><!-- .cmp2-meta -->

            <h2 class="cmp2-title">
                <a href="<?php echo get_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>

            <div class="cmp2-desc">
                <?php if (!empty(get_the_excerpt())): ?>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                <?php else: ?>
                    <p><?php echo wp_trim_words(get_the_content(), 20, '...'); ?></p>
                <?php endif; ?>
            </div>

            <div class="cmp2-link">
                <a href="<?php the_permalink(); ?>" class="cmp-button">Read More</a>
            </div>
        </div>
    </div>
</div>