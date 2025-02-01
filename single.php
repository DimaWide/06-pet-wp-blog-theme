<?php

get_header();


?>

<!-- MAIN CONTENT -->
<main id="wcl-page-content" class="wcl-page-content">
    <div class="wcl-single">
        <?php get_template_part('template-parts/single/single-hero'); ?>

        <?php get_template_part('template-parts/single/single-content'); ?>

        <?php get_template_part('template-parts/single/latest-posts'); ?>
    </div>
</main> <!-- #wcl-page-content -->


<?php
if (post_password_required()) {
    return;
}
?>

<?php

get_footer();

?>