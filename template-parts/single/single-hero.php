<?php

$image             = get_the_post_thumbnail($post->ID, 'image-size-1');
$terms             = ordered_categories();
$class_empty_image = empty($image) ? 'mod-empty-image' : '';
?>
<div class="sct-single-hero <?php echo $class_empty_image; ?>" data-permalink="<?php echo get_permalink(); ?>">
    <div class="data-container wcl-container">
        <div class="data-row">
            <div class="data-col">
                <?php if (!empty($terms)) : ?>
                    <div class="data-cats">
                        <?php foreach ($terms as $term_id => $count) : ?>
                            <?php
                            $term = get_category($term_id);
                            ?>
                            <div class="data-cats-item cmp-category">
                                <?php echo $term->name; ?>
                            </div>
                            <?php
                            break;
                            ?>
                        <?php endforeach ?>
                    </div>
                <?php endif; ?>

                <h1 class="data-title">
                    <?php the_title(); ?>
                </h1>
            </div>

            <div class="data-col">
                <div class="data-img">
                    <?php if (!empty($image)) : ?>
                        <?php echo $image; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>