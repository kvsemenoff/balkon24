<?

remove_filter('the_content', 'wptexturize'); 

  if (function_exists('register_sidebar'))
	register_sidebar(array('name' => 'Sidebar'));




register_nav_menus(array(
	'top' => 'Верхнее меню',            
	'bottom' => 'Нижнее меню'   
));

add_theme_support('menus');

add_theme_support( 'post-thumbnails' );

function my_function_admin_bar(){
return false;
}
add_filter( 'show_admin_bar' , 'my_function_admin_bar');

add_action('init', 'remove_else_link');

add_image_size('squareThumb', 292, 278, true);

function remove_else_link()
{

remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head');
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); 
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'feed_links_extra', 3 ); 

remove_action('wp_head','feed_links_extra', 3); // ссылки на дополнительные rss категорий
remove_action('wp_head','feed_links', 2); //ссылки на основной rss и комментарии
remove_action('wp_head','rsd_link');  // для сервиса Really Simple Discovery
remove_action('wp_head','wlwmanifest_link'); // для Windows Live Writer
remove_action('wp_head','wp_generator');  // убирает версию wordpress
 
// убираем разные ссылки при отображении поста - следующая, предыдущая запись, оригинальный url и т.п.
remove_action('wp_head','start_post_rel_link',10,0);
remove_action('wp_head','index_rel_link');
remove_action('wp_head','rel_canonical');
remove_action( 'wp_head','adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head','wp_shortlink_wp_head', 10, 0 );
}

function repl_mon( $str ){
	$mon = array('01',  '02', '03', '04','05','06','07','08','09','10','11','12');
	$mon_str   = array('января', 'февраля', 'марта','апреля', 'мая', 'июня','июля','августа.','сентября','октября','ноября','декабря.');
	$rt = str_replace($mon, $mon_str, $str);
	return $rt;
}


/*
 * Функция создает дубликат поста в виде черновика и редиректит на его страницу редактирования
 */
function true_duplicate_post_as_draft(){
    global $wpdb;
    if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'true_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
        wp_die('Нечего дублировать!');
    }
 
    /*
     * получаем ID оригинального поста
     */
    $post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
    /*
     * а затем и все его данные
     */
    $post = get_post( $post_id );
 
    /*
     * если вы не хотите, чтобы текущий автор был автором нового поста
     * тогда замените следующие две строчки на: $new_post_author = $post->post_author;
     * при замене этих строк автор будет копироваться из оригинального поста
     */
    $current_user = wp_get_current_user();
    $new_post_author = $current_user->ID;
 
    /*
     * если пост существует, создаем его дубликат
     */
    if (isset( $post ) && $post != null) {
 
        /*
         * массив данных нового поста
         */
        $args = array(
            'comment_status' => $post->comment_status,
            'ping_status'    => $post->ping_status,
            'post_author'    => $new_post_author,
            'post_content'   => $post->post_content,
            'post_excerpt'   => $post->post_excerpt,
            'post_name'      => $post->post_name,
            'post_parent'    => $post->post_parent,
            'post_password'  => $post->post_password,
            'post_status'    => 'draft', // черновик, если хотите сразу публиковать - замените на publish
            'post_title'     => $post->post_title,
            'post_type'      => $post->post_type,
            'to_ping'        => $post->to_ping,
            'menu_order'     => $post->menu_order
        );
 
        /*
         * создаем пост при помощи функции wp_insert_post()
         */
        $new_post_id = wp_insert_post( $args );
 
        /*
         * присваиваем новому посту все элементы таксономий (рубрики, метки и т.д.) старого
         */
        $taxonomies = get_object_taxonomies($post->post_type); // возвращает массив названий таксономий, используемых для указанного типа поста, например array("category", "post_tag");
        foreach ($taxonomies as $taxonomy) {
            $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
            wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
        }
 
        /*
         * дублируем все произвольные поля
         */
        $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
        if (count($post_meta_infos)!=0) {
            $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
            foreach ($post_meta_infos as $meta_info) {
                $meta_key = $meta_info->meta_key;
                $meta_value = addslashes($meta_info->meta_value);
                $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
            }
            $sql_query.= implode(" UNION ALL ", $sql_query_sel);
            $wpdb->query($sql_query);
        }
 
 
        /*
         * и наконец, перенаправляем пользователя на страницу редактирования нового поста
         */
        wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
        exit;
    } else {
        wp_die('Ошибка создания поста, не могу найти оригинальный пост с ID=: ' . $post_id);
    }
}
add_action( 'admin_action_true_duplicate_post_as_draft', 'true_duplicate_post_as_draft' );
 
/*
 * Добавляем ссылку дублирования поста для post_row_actions
 */
function true_duplicate_post_link( $actions, $post ) {
    if (current_user_can('edit_posts')) {
        $actions['duplicate'] = '<a href="admin.php?action=true_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Дублировать этот пост" rel="permalink">Дублировать</a>';
    }
    return $actions;
}
 
add_filter( 'post_row_actions', 'true_duplicate_post_link', 10, 2 );
add_filter( 'page_row_actions', 'true_duplicate_post_link', 10, 2);

// Валерий 28.01.2017 13:55
// Custom functions
// Отзывы
add_action('init', 'testimonials_register');
function testimonials_register() {
    $args = array(
        'label'               => __('Отзывы'),
        'labels'              => array(
            'name'               => __('Отзывы'),
            'singular_name'      => __('Отзывы'),
            'menu_name'          => __('Отзывы'),
            'all_items'          => __('Все отзывы'),
            'add_new'            => _x('Добавить отзыв', 'product'),
            'add_new_item'       => __('Новый отзыв'),
            'edit_item'          => __('Редактировать отзыв'),
            'new_item'           => __('Новый отзыв'),
            'view_item'          => __('Отзывы'),
            'not_found'          => __('Отзыв не найден'),
            'not_found_in_trash' => __('Удаленных отзывов нет'),
            'search_items'       => __('Найти отзыв')
        ),
        'description'         => __('Отзывы'),
        'public'              => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array(
            'title'
            
   
        ),
        'has_archive'         => false,
        'rewrite'             => array(
            'slug'       => '',
            'with_front' => false
        )
    );
    register_post_type('testimonials', $args);
}
// акции
add_action('init', 'events_register');
function events_register() {
    $args = array(
        'label'               => __('Акции'),
        'labels'              => array(
            'name'               => __('Акции'),
            'singular_name'      => __('Акции'),
            'menu_name'          => __('Акции'),
            'all_items'          => __('Все акции'),
            'add_new'            => _x('Добавить акцию', 'product'),
            'add_new_item'       => __('Новая акция'),
            'edit_item'          => __('Редактировать акцию'),
            'new_item'           => __('Новая акция'),
            'view_item'          => __('Акции'),
            'not_found'          => __('Акция не найдена'),
            'not_found_in_trash' => __('Удаленных акций нет'),
            'search_items'       => __('Найти акцию')
        ),
        'description'         => __('Акции'),
        'public'              => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array(
            'title'
            
   
        ),
        'has_archive'         => false,
        'rewrite'             => array(
            'slug'       => '',
            'with_front' => false
        )
    );
    register_post_type('events', $args);
}
// Статьи
add_action('init', 'articles_register');
function articles_register() {
    $args = array(
        'label'               => __('Статьи'),
        'labels'              => array(
            'name'               => __('Статьи'),
            'singular_name'      => __('Статьи'),
            'menu_name'          => __('Статьи'),
            'all_items'          => __('Все статьи'),
            'add_new'            => _x('Добавить статью', 'product'),
            'add_new_item'       => __('Новая статья'),
            'edit_item'          => __('Редактировать статью'),
            'new_item'           => __('Новая статья'),
            'view_item'          => __('Статьи'),
            'not_found'          => __('Статья не найдена'),
            'not_found_in_trash' => __('Удаленных статей нет'),
            'search_items'       => __('Найти статью')
        ),
        'description'         => __('Статьи'),
        'public'              => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array(
            'title'
            
   
        ),
        'has_archive'         => false,
        'rewrite'             => array(
            'slug'       => '',
            'with_front' => false
        )
    );
    register_post_type('articles', $args);
}
//Работа
add_action('init', 'works_register');
function works_register() {
    $args = array(
        'label'               => __('Работа'),
        'labels'              => array(
            'name'               => __('Работа'),
            'singular_name'      => __('Работа'),
            'menu_name'          => __('Работа'),
            'all_items'          => __('Все работы'),
            'add_new'            => _x('Добавить работу', 'product'),
            'add_new_item'       => __('Новая работа'),
            'edit_item'          => __('Редактировать работу'),
            'new_item'           => __('Новая работа'),
            'view_item'          => __('Работы'),
            'not_found'          => __('Работа не найдена'),
            'not_found_in_trash' => __('Удаленных работ нет'),
            'search_items'       => __('Найти работу')
        ),
        'description'         => __('Работа'),
        'public'              => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array(
            'title'
            
   
        ),
        'has_archive'         => false,
        'rewrite'             => array(
            'slug'       => '',
            'with_front' => false
        )
    );
    register_post_type('works', $args);
}
?>