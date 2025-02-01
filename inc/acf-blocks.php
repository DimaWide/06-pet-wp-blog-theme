<?php


/** Create custom block category */
function wcl_custom_block_category($categories) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'webcomplete',
                'title' => 'WebComplete',
            ),
        )
    );
}

add_filter('block_categories_all', 'wcl_custom_block_category', 10, 2);





/** Registration Blocks */
function wcl_acf_blocks_init() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'            => 'acf-block-1',
            'title'           => __('#01 Hero'),
            'description'     => __('#01 Hero Block'),
            'render_template' => 'template-parts/acf-blocks/acf-1-hero.php',
            'category'        => 'wcl-category',
            'render_callback' => 'render_block_1',
            'mode'            => 'edit',
            '__graphql'         => true,
            'example'         => array(
                'attributes' => array(
                    'mode' => 'preview',
                ),
            ),
        ));

        function render_block_1($block, $content = '', $is_preview = false) {
            if ($is_preview) {
?>
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/acf_block_1.jpg'; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="img">
            <?php
                return;
            } else {
                get_template_part('template-parts/acf-blocks/acf-1-hero');
            }
        }
    }


    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'            => 'acf-block-2',
            'title'           => __('#02 Category'),
            'description'     => __('#02 Category Block'),
            'render_template' => 'template-parts/acf-blocks/acf-2-category.php',
            'category'        => 'wcl-category',
            'render_callback' => 'render_block_2',
            'mode'            => 'edit',
            'example'         => array(
                'attributes' => array(
                    'mode' => 'preview',
                ),
            ),
        ));

        function render_block_2($block, $content = '', $is_preview = false) {
            if ($is_preview) {
            ?>
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/acf_block_2.jpg'; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="img">
            <?php
                return;
            } else {
                get_template_part('template-parts/acf-blocks/acf-2-category');
            }
        }
    }



    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'            => 'acf-block-3',
            'title'           => __('#03 Blog Posts'),
            'description'     => __('#03 Blog Posts Block'),
            'render_template' => 'template-parts/acf-blocks/acf-3-blog-posts.php',
            'category'        => 'wcl-category',
            'render_callback' => 'render_block_3',
            'mode'            => 'edit',
            'example'         => array(
                'attributes' => array(
                    'mode' => 'preview',
                ),
            ),
        ));

        function render_block_3($block, $content = '', $is_preview = false) {
            if ($is_preview) {
            ?>
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/acf_block_3.jpg'; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="img">
            <?php
                return;
            } else {
                get_template_part('template-parts/acf-blocks/acf-3-blog-posts');
            }
        }
    }




    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'            => 'acf-block-4',
            'title'           => __('#04 Together'),
            'description'     => __('#04 Together Block'),
            'render_template' => 'template-parts/acf-blocks/acf-4-together.php',
            'category'        => 'wcl-category',
            'render_callback' => 'render_block_4',
            'mode'            => 'edit',
            'example'         => array(
                'attributes' => array(
                    'mode' => 'preview',
                ),
            ),
        ));

        function render_block_4($block, $content = '', $is_preview = false) {
            if ($is_preview) {
            ?>
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/acf_block_4.jpg'; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="img">
            <?php
                return;
            } else {
                get_template_part('template-parts/acf-blocks/acf-4-together');
            }
        }
    }




    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'            => 'acf-block-5',
            'title'           => __('#05 Contact Us'),
            'description'     => __('#05 Contact Us Block'),
            'render_template' => 'template-parts/acf-blocks/acf-5-contact-us.php',
            'category'        => 'wcl-category',
            'render_callback' => 'render_block_5',
            'mode'            => 'edit',
            'example'         => array(
                'attributes' => array(
                    'mode' => 'preview',
                ),
            ),
        ));

        function render_block_5($block, $content = '', $is_preview = false) {
            if ($is_preview) {
            ?>
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/acf_block_5.jpg'; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="img">
            <?php
                return;
            } else {
                get_template_part('template-parts/acf-blocks/acf-5-contact-us');
            }
        }
    }




    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'            => 'acf-block-6',
            'title'           => __('#06 Blog'),
            'description'     => __('#06 Blog Block'),
            'render_template' => 'template-parts/acf-blocks/acf-6-blog.php',
            'category'        => 'wcl-category',
            'render_callback' => 'render_block_6',
            'mode'            => 'edit',
            'example'         => array(
                'attributes' => array(
                    'mode' => 'preview',
                ),
            ),
        ));

        function render_block_6($block, $content = '', $is_preview = false) {
            if ($is_preview) {
            ?>
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/acf_block_6.jpg'; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="img">
<?php
                return;
            } else {
                get_template_part('template-parts/acf-blocks/acf-6-blog');
            }
        }
    }
}

add_action('acf/init', 'wcl_acf_blocks_init');
