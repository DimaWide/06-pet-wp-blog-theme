<?php


$logo = ! empty($logo) ?: 'Blog';
$phone = get_field('phone', 'option');
?>

<?php get_template_part('template-parts/search-popup'); ?>

<?php get_template_part('template-parts/subscribe-popup'); ?>
<!-- FOOTER -->

<footer class="sct-footer" id="wcl-main-footer">
    <div class="data-container wcl-container">
        <div class="data-row">
            <div class="data-col">
                <?php if (!empty($logo)) : ?>
                    <div class="data-logo">
                        <a href="<?php echo site_url(); ?>">
                            <?php echo $logo; ?>
                        </a>
                    </div>

                    <div class="data-desc">
                        Our blog is where technology meets inspiration. Subscribe and stay updated!
                    </div>
                <?php endif; ?>
            </div>

            <div class="data-col">
                <div class="data-widget">
                    <h3 class="data-widget-title">
                        Navigation
                    </h3>

                    <?php wp_nav_menu(array(
                        'theme_location' => 'main-menu',
                        'container'      => 'false',
                        'menu_class'     => 'data-menu',
                        'depth'          => 2,
                    )); ?>
                </div>
            </div>

            <div class="data-col">
                <div class="data-widget">
                    <h3 class="data-widget-title">
                        Subscribe to news
                    </h3>

                    <div class="data-widget-subtitle">
                        Subscribe to our newsletter to receive the latest news.
                    </div>

                    <div class="cmp-search-popup">
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="email" class="search-field" placeholder="Enter email" value="" name="email" required/>

                            <button type="submit" class="search-submit cmp-button ">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="data-copyright">
            <div class="data-copyright-text">
                © 2024 Blog.
            </div>
        </div>
    </div>
</footer> <!-- #wcl-main-footer -->




</div> <!-- .wcl-body-inner -->

<?php wp_footer(); ?>

</body>

</html>