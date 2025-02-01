<?php


// Rest Api
add_filter('rest_prepare_user', function ($response, $user, $request) {
    $data = $response->get_data();
    $data['email'] = $user->user_email;
    return rest_ensure_response($data);
}, 10, 3);


function add_cors_http_header() {
    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");
}

add_action('init', 'add_cors_http_header');


add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/users/register', [
        'methods' => 'POST',
        'callback' => 'custom_user_registration',
        'permission_callback' => '__return_true',
    ]);
});

function custom_user_registration($request) {
    $username = sanitize_text_field($request['username']);
    $email = sanitize_email($request['email']);
    $password = $request['password'];

    // Проверка на пустые значения
    if (empty($username) || empty($email) || empty($password)) {
        return new WP_Error('missing_fields', 'Все поля обязательны для заполнения.', ['status' => 400]);
    }

    // Проверка существования пользователя с таким именем или email
    if (username_exists($username)) {
        return new WP_Error('username_exists', 'Имя пользователя уже занято. Пожалуйста, выберите другое.', ['status' => 400]);
    }

    if (email_exists($email)) {
        return new WP_Error('email_exists', 'Этот email уже зарегистрирован. Попробуйте войти.', ['status' => 400]);
    }

    // Создание пользователя
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        return new WP_Error('registration_failed', 'Ошибка при регистрации пользователя. ' . $user_id->get_error_message(), ['status' => 500]);
    }

    // Успешная регистрация
    return new WP_REST_Response(['message' => 'Пользователь успешно зарегистрирован.'], 201);
}


add_filter('rest_allow_anonymous_comments', '__return_true');









// Rest Api


function check_user_permissions() {
    return current_user_can('edit_posts');
}


add_action('rest_api_init', function () {
    $namespace = 'myapi/v1';

    register_rest_route($namespace, '/news', [
        'methods' => 'GET',
        'callback' => 'get_news_posts',
    ]);

    register_rest_route($namespace, '/news/(?P<id>\d+)', [
        'methods' => 'GET',
        'callback' => 'get_news_post',
        'args' => ['id']
    ]);

    register_rest_route($namespace, '/news', [
        'methods' => 'POST',
        'callback' => 'create_news_post',
        'permission_callback' => 'check_user_permissions',
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        },
    ]);

    register_rest_route($namespace, '/news/(?P<id>\d+)', [
        'methods' => 'PUT',
        'callback' => 'update_news_post',
        'permission_callback' => 'check_user_permissions',
        'args' => ['id']
    ]);

    register_rest_route($namespace, '/news/(?P<id>\d+)', [
        'methods' => 'DELETE',
        'callback' => 'delete_news_post',
        'permission_callback' => 'check_user_permissions',
        'args' => ['id']
    ]);
});


function get_news_posts($request) {
    $posts_per_page = $request->get_param('per_page') ?: 10;
    $paged = $request->get_param('page') ?: 1;

    $args = [
        'post_type' => 'news',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
    ];

    $query = new WP_Query($args);
    $posts = [];

    $total_posts = $query->found_posts;
    $total_pages = $query->max_num_pages;

    return rest_ensure_response([
        'data' => $query->posts,
        'total' => $total_posts,
        'total_pages' => $total_pages,
        'current_page' => $paged,
    ]);
}

function get_news_post($request) {
    $post_id = $request['id'];
    $post = get_post($post_id);

    if ($post && $post->post_type === 'news') {
        return rest_ensure_response(['data' => $post]);
    }

    return new WP_Error('post_not_found', 'Запись не найдена', ['status' => 404]);
}

function create_news_post($request) {
    $post_data = [
        'post_type' => 'news',
        'post_title' => sanitize_text_field($request->get_param('title')),
        'post_content' => $request->get_param('content'),
        'post_status' => 'publish',
    ];

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id)) {
        return $post_id;
    }

    return rest_ensure_response(['id' => $post_id, 'message' => 'Запись создана']);
}


function create_custom_post_type_news() {
    register_post_type(
        'news',
        array(
            'labels' => array(
                'name' => __('News'),
                'singular_name' => __('News'),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'news'),
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields')
        )
    );
}
add_action('init', 'create_custom_post_type_news');


function update_news_post($request) {
    $post_id = $request['id'];
    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'news') {
        return new WP_Error('post_not_found', 'Запись не найдена', ['status' => 404]);
    }

    $post_data = [
        'ID' => $post_id,
        'post_title' => sanitize_text_field($request->get_param('title')),
        'post_content' => $request->get_param('content'),
    ];

    $updated_post_id = wp_update_post($post_data);

    if (is_wp_error($updated_post_id)) {
        return $updated_post_id;
    }

    return rest_ensure_response(['id' => $updated_post_id, 'message' => 'Запись обновлена']);
}

function delete_news_post($request) {
    $post_id = $request['id'];
    $post = get_post($post_id);

    if (!$post || $post->post_type !== 'news') {
        return new WP_Error('post_not_found', 'Запись не найдена', ['status' => 404]);
    }

    $deleted = wp_delete_post($post_id, true);

    if ($deleted) {
        return rest_ensure_response(['id' => $post_id, 'message' => 'Запись удалена']);
    }

    return new WP_Error('post_not_deleted', 'Не удалось удалить запись', ['status' => 500]);
}


add_action('rest_api_init', function () {
    register_rest_route('myapi/v1', '/news/search', [
        'methods' => 'GET',
        'callback' => 'search_news',
    ]);
});

function search_news(WP_REST_Request $request) {
    $query = $request->get_param('query');
    $args = [
        's' => $query,
        'post_type' => 'news',
        'posts_per_page' => 10,
        'post_status' => 'publish',
    ];
    $posts = get_posts($args);
    return rest_ensure_response(['data' => $posts]);
}



























