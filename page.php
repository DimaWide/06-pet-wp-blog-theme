<?php

get_header();


$is_default_page = get_field('is_default_page');
$is_default_page =  isset($is_default_page) ? $is_default_page : true;
?>

<!-- MAIN CONTENT -->
<main id="wcl-page-content" class="wcl-page-content">

    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php if ($is_default_page === true) : ?>
                <div class="wcl-page mod-default">
                    <div class="page-container wcl-container">
                        <h1 class="page-title">
                            <?php echo get_the_title(); ?>
                        </h1>

                        <div class="page-content cmp-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="wcl-page">
                    <div class="data-container">
                        <div class="data-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>

</main> <!-- #wcl-page-content -->

<?php

get_footer();

?>