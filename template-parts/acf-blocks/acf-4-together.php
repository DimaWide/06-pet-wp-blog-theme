<?php

$bg_image = get_field('bg_image');
$bg_image = wp_get_attachment_image($bg_image, 'full');
?>
<div class="acf-4-together">
    <div class="data-container wcl-container">
        
    <div class="data-line"></div>

        <div class="data-inner">
            <?php if (!empty($bg_image)) : ?>
                <div class="data-bg-image">
                    <?php echo $bg_image; ?>
                </div>
            <?php endif; ?>

            <div class="data-tagline">
                Together
            </div>

            <h2 class="data-title">
                Read us and get ready for the future
            </h2>

            <div class="data-subtitle">
                By reading us, you will discover fresh ideas and promising approaches, stay up to date with the latest global trends, and be ready to adapt to global changes and use them to your advantage
            </div>

            <div class="data-link">
                <a href="<?php echo site_url('/') . 'blog'; ?> " class="cmp-button">
                    Read More
                </a>
            </div>
        </div>
    </div>
</div>