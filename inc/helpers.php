<?php



/* 
ordered_categories
 */
function ordered_categories($type = 'single') {
    $post_id = get_the_ID();

    if ($type == 'all') {
        $terms = get_terms([
            'taxonomy'   => 'category',
            'hide_empty' => true,
            'parent'     => 0,
        ]);
    } else {
        $terms = get_the_terms($post_id, 'category');
    }

    $category_counts = [];

    if ($terms && !is_wp_error($terms)) {
        $category_counts = array();

        foreach ($terms as $term) {
            if ($term->slug !== 'uncategorized') {
                $category_count = $term->count;
                $category_counts[$term->term_id] = $category_count;
            }
        }

        arsort($category_counts);
    }

    return $category_counts;
}








// generate_post_table_of_contents
function generate_post_table_of_contents($post_content) {
    // Match all H2 and H3 headings in the post content
    preg_match_all('/<(h[23]).*?>(.*?)<\/\1>/', $post_content, $matches);

    // Check if there are any matches
    if (!empty($matches[2])) {
        // Start building the HTML
        $html = '<ul>';
        foreach ($matches[2] as $index => $heading) {
            // Create an anchor link
            $anchor_link = sanitize_title_with_dashes($heading);

            // Add a nested list for H3 inside H2
            if ($matches[1][$index] === 'h2') {
                $html .= '<li><a href="#' . $anchor_link . '">' . strip_tags($heading) . '</a>';
                $html .= '<ul>'; // Prepare for possible nested H3s
            } elseif ($matches[1][$index] === 'h3') {
                $html .= '<li><a href="#' . $anchor_link . '">' . strip_tags($heading) . '</a></li>';
            }

            // Close the nested list if the next heading is not H3
            if (isset($matches[1][$index + 1]) && $matches[1][$index + 1] !== 'h3') {
                $html .= '</ul></li>';
            }
        }
        $html .= '</ul>';

        // Return the generated HTML
        return $html;
    }

    // Return an empty string if no headings are found
    return '';
}






/*
add_ids_to_headings
*/
function add_ids_to_headings($content) {
    if (is_single()) {
        // Match all H2 and H3 headings in the content
        preg_match_all('/<(h[23])(.*?)>(.*?)<\/\1>/', $content, $matches);

        // Check if there are any matches
        if (!empty($matches[3])) {
            foreach ($matches[3] as $index => $heading) {
                // Remove existing id attribute if present
                $attributes = preg_replace('/\bid=[\'"](.*?)[\'"]/', '', $matches[2][$index]);

                // Create a slug (anchor) from the heading title
                $anchor_link = sanitize_title_with_dashes($heading);

                // Add the ID to the tag in the content
                $replacement = '<' . $matches[1][$index] . $attributes . ' id="' . $anchor_link . '">' . $heading . '</' . $matches[1][$index] . '>';
                $content = str_replace($matches[0][$index], $replacement, $content);
            }
        }
    }

    return $content;
}
add_filter('the_content', 'add_ids_to_headings');






/* 
open_external_links_in_new_tab
 */
function open_external_links_in_new_tab($content) {
    if (is_admin()) {
        return $content;
    }

    if (is_single() && !empty($content)) {
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

        $dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($content);

        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            if (filter_var($href, FILTER_VALIDATE_URL) && parse_url(home_url(), PHP_URL_HOST) != parse_url($href, PHP_URL_HOST)) {
                $link->setAttribute('target', '_blank');
            }
        }

        $content = $dom->saveHTML();
    }

    return $content;
}

add_filter('the_content', 'open_external_links_in_new_tab');






/* 
custom_get_blog_pagenum_link
 */
function custom_get_blog_pagenum_link($pagenum = 1, $categories = '') {
    $pagenum = (int)$pagenum;

    $blog_page = 'blog';

    $link = site_url() . '/' . $blog_page;

    if (!empty($categories)) {
        $categories = trim($categories);

        $categories_array = explode(',', $categories);
        if (count($categories_array) == 1) {
            $link = site_url('/category/') . $categories;
        } else {
            $link = site_url() . '/' . $blog_page . '/' . $categories;
        }
    }

    if ($pagenum != 1) {
        $link .= '/page/' . $pagenum . '/';
    }

    return $link;
}





// blog_page_pagination
function blog_page_pagination($query, $ajax_current_page = '', $categories = '') {

    $total_pages = $query->max_num_pages;
    if ($total_pages > 1) {
        $current_page = max(1, get_query_var('paged'));

        if (!empty($ajax_current_page)) {
            $current_page = $ajax_current_page;
        }

        $visible_links = 3; // Количество видимых ссылок в пагинации
?>

        <div class="data-pagination-mobile">
            <?php if ($current_page > 1) : ?>
                <div class="data-pagination-mobile-prev data-pagination-mobile-b1">
                    <a href="<?php echo custom_get_blog_pagenum_link($current_page - 1, $categories); ?>" data-page="<?php echo ($current_page - 1); ?>">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/a1-arrow-left.svg'; ?>" alt="img">
                    </a>
                </div>
            <?php endif; ?>

            <div class="data-pagination-mobile-text">
                <?php
                echo 'Page ' . '<span>' . $current_page . '</span>' . ' of ' . '<span>' . $total_pages . '</span>';
                ?>
            </div>

            <?php if ($current_page < $total_pages) : ?>
                <div class="data-pagination-mobile-next data-pagination-mobile-b1">
                    <a href="<?php echo custom_get_blog_pagenum_link($current_page + 1, $categories); ?>" data-page="<?php echo ($current_page + 1); ?>">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/a1-arrow-left.svg'; ?>" alt="img">
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="data-pagination-desktop">
            <?php
            if ($current_page > 1) {
            ?>
                <div class="data-pagination-prev data-pagination-b1">
                    <a href="<?php echo custom_get_blog_pagenum_link($current_page - 1, $categories); ?>" data-page="<?php echo ($current_page - 1); ?>">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/a1-arrow-left.svg'; ?>" alt="img">
                        Previous
                    </a>
                </div>
            <?php
            }

            // Вычисляем начало и конец диапазона отображения ссылок
            $start = max(1, $current_page - floor($visible_links / 2));
            $end = min($total_pages, $start + $visible_links - 1);

            // Учитываем, если количество ссылок меньше видимого диапазона
            if ($end - $start + 1 < $visible_links) {
                $start = max(1, $end - $visible_links + 1);
            }
            ?>

            <div class="data-pagination-links">
                <?php
                // Всего отображается 5 ссылок, включая первую и последнюю
                $max_visible_links = 5;

                // Добавляем ссылку на первую страницу, если текущая страница больше 2
                if ($current_page > 2) {
                    echo '<a href="' . custom_get_blog_pagenum_link(1, $categories) . '" class="data-pagination-item" data-page="1">1</a>';
                    if ($current_page > 2) {
                        echo '<span class="data-pagination-item data-pagination-dots">&hellip;</span>';
                    }
                }

                // Вычисляем диапазон отображаемых страниц
                $start = max(1, $current_page - floor(($max_visible_links - 2) / 2));
                $end = min($total_pages, $start + $max_visible_links - 3);

                // Корректируем диапазон, если не хватает страниц
                if ($end - $start + 1 < $max_visible_links - 2) {
                    $start = max(1, $end - ($max_visible_links - 3));
                }

                // Выводим ссылки на текущий диапазон
                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $current_page) {
                        echo '<span class="data-pagination-item mod-current" data-page="' . $current_page . '">' . $i . '</span>';
                    } else {
                        echo '<a href="' . custom_get_blog_pagenum_link($i, $categories) . '" class="data-pagination-item" data-page="' . $i . '">' . $i . '</a>';
                    }
                }

                // Добавляем ссылку на последнюю страницу, если текущая страница меньше total_pages - 1
                if ($current_page < $total_pages - 1) {
                    if ($total_pages > 5) {
                        if ($current_page < $total_pages - 2) {
                            echo '<span class="data-pagination-item data-pagination-dots">&hellip;</span>';
                        }
                    } else {
                        if ($current_page < $total_pages - 2) {
                            echo '<span class="data-pagination-item data-pagination-dots">&hellip;</span>';
                        }
                    }

                    echo '<a href="' . custom_get_blog_pagenum_link($total_pages, $categories) . '" class="data-pagination-item" data-page="' . $total_pages . '">' . $total_pages . '</a>';
                }
                ?>
            </div>


            <?php

            // Добавляем ссылку "Вперед", если не последняя страница

            if ($current_page < $total_pages) {
            ?>
                <div class="data-pagination-next data-pagination-b1">
                    <a href="<?php echo custom_get_blog_pagenum_link($current_page + 1, $categories); ?>" data-page="<?php echo ($current_page + 1); ?>">
                        Next
                        <img src="<?php echo get_stylesheet_directory_uri() . '/img/a1-arrow-left.svg'; ?>" alt="img">
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
<?php
    }
}





/*
* Plug for VS
*/
if (false) {
    function get_field() {
    }
    function acf_add_options_page() {
    }
    function get_sub_field() {
    }
    function have_rows() {
    }
    function the_row() {
    }
    function get_row_layout() {
    }
    function get_field_object() {
    }
    function update_field() {
    }
    function acf_register_block_type() {
    }
}





// reading_time
function reading_time($post_id) {
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $readingtime = ceil($word_count / 200);

    $timer = "min";

    $totalreadingtime = $readingtime . $timer;

    return $totalreadingtime;
}




function wcl_debug_arr($arr) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}


function wcl_clean_phone_number($phone_number) {
    $phone_number = preg_replace('/\s+/', '', $phone_number);
    $phone_number = preg_replace('/\(|\)|\-|\\+/', '', $phone_number);

    return $phone_number;
}


function wcl_send_error_message_to_admin($subject, $message) {
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . SITE_NAME . ' <' . EMAIL_SENDER . '>'
    );

    return wp_mail(CONTACT_ERROR_EMAIL, $subject, $message, $headers);
}


function wcl_curl_get($url) {
    $request = wp_remote_get($url, array(
        'timeout' => 60,
        'sslverify' => false,
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:108.0) Gecko/20100101 Firefox/108.0',
    ));

    if (is_array($request) && ! is_wp_error($request)) {
        return $request['body'];
    }

    return false;
}


function wcl_captcha_validation($action) {
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = RECAPTCHA_SECRET_KEY;
    $recaptcha_response = sanitize_text_field($_REQUEST['token']);

    $recaptcha = wcl_curl_get($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    return ($recaptcha->success == true && $recaptcha->score >= 0.5 && $recaptcha->action == $action);
}


function wcl_curl_multi_get($urls) {
    $requests = Requests::request_multiple($urls, array(
        'timeout' => 60,
        'verify' => false,
        'verifyname' => false,
        'data_format' => 'body',
        'useragent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:108.0) Gecko/20100101 Firefox/108.0',
    ));

    return $requests;
}


function wcl_curl_post($url, $body = array(), $headers = array()) {
    $request = wp_remote_post($url, array(
        'body' => $body,
        'headers' => $headers,
        'timeout' => 60,
        'sslverify' => false,
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:108.0) Gecko/20100101 Firefox/108.0',
    ));

    if (is_array($request) && ! is_wp_error($request)) {
        return $request['body'];
    }

    return false;
}
