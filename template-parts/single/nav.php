<?php

$prev_post = get_previous_post();
$next_post = get_next_post();
?>
<div class="data-nav">
    <div class="data-nav-item">
        <?php if (!empty($prev_post)) : ?>
            <a href="<?php echo get_permalink($prev_post->ID); ?>" class="data-nav-link mod-prev">
                <?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/arrow-long-right.svg', false); ?>

                <span class="data-nav-link-label">Prev</span>

                <span class="data-nav-link-title"><?php echo get_the_title($prev_post->ID); ?></span>
            </a>
        <?php endif; ?>
    </div>

    <div class="data-nav-item">
        <?php if (!empty($next_post)) : ?>
            <a href="<?php echo get_permalink($next_post->ID); ?>" class="data-nav-link mod-next">
                <span class="data-nav-link-title"><?php echo get_the_title($next_post->ID); ?></span>

                <span class="data-nav-link-label">Next</span>

                <?php echo file_get_contents(get_stylesheet_directory_uri() . '/img/arrow-long-right.svg', false); ?>
            </a>
        <?php endif; ?>
    </div>
</div>