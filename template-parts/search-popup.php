<?php


?>
<div class="cmp-4-popup mod-search-popup" data-id="search-popup">
    <div class="cmp4-overlay"></div>
    <div class="cmp4-inner-out">
        <div class="cmp4-inner" id="search-popup">
            <div class="cmp4-close js-close">
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/menu-btn-close.svg'; ?>" alt="img">
            </div>

            <div class="cmp-search-popup">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <label>
                        <span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'your-textdomain'); ?></span>
                        <input type="search" class="search-field"
                            placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'your-textdomain'); ?>"
                            value="<?php echo get_search_query(); ?>" name="s" />
                    </label>

                    <button type="submit" class=" search-submit cmp-button ">
                        <?php echo esc_html_x('Search', 'submit button', 'your-textdomain'); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>