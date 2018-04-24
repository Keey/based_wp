<?php

//Auto-install recommended plugins
require_once('installer/installer.php');

//shortcodes functions
require_once('shortcodes.php');

//uncomment if need CPT
//require_once('custom-cpt.php');

remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head' );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head' );
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rel_canonical');
add_action('widgets_init', 'my_remove_recent_comments_style');
function my_remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
update_option('image_default_link_type','none');
update_option('uploads_use_yearmonth_folders', 0);

add_filter( 'show_admin_bar', '__return_false' );


function my_acf_init() {
//    acf_update_setting('google_api_key', 'xxx');
}
add_action( 'acf/init', 'my_acf_init' );

//remove auto-top cf7
if ( defined( 'WPCF7_VERSION' ) ) {
	function maybe_reset_autop( $form ) {
		$form_instance = WPCF7_ContactForm::get_current();
		$manager       = WPCF7_FormTagsManager::get_instance();
		$form_meta     = get_post_meta( $form_instance->id(), '_form', true );
		$form          = $manager->replace_all( $form_meta );
		$form_instance->set_properties( array(
			'form' => $form
		) );
		return $form;
	}
	add_filter( 'wpcf7_form_elements', 'maybe_reset_autop' );
}
/* BEGIN: Theme config params*/
define ('HOME_PAGE_ID', get_option('page_on_front'));
define ('BLOG_ID', get_option('page_for_posts'));
define ('POSTS_PER_PAGE', get_option('posts_per_page'));
if(class_exists('Woocommerce')) :
    define ('SHOP_ID', get_option('woocommerce_shop_page_id'));
    define ('ACCOUNT_ID', get_option('woocommerce_myaccount_page_id'));
endif;
/* END: Theme config params */

//Thumbnails theme support
add_theme_support( 'post-thumbnails' );

//custom theme url
function theme($filepath = NULL){
    return preg_replace( '(https?://)', '//', get_stylesheet_directory_uri() . ($filepath?'/' . $filepath:'') );
}

//Body class
function new_body_classes( $classes ){
    if( is_page() ){
        $temp = get_page_template();
        if ( $temp != null ) {
            $path = pathinfo($temp);
            $tmp = $path['filename'] . "." . $path['extension'];
            $tn= str_replace(".php", "", $tmp);
            $classes[] = $tn;
        }
        global $post;
        $classes[] = 'page-'.get_post($post)->post_name;
        if (is_active_sidebar('sidebar')) {
            $classes[] = 'with_sidebar';
        }
    }
    if(is_page() && !is_front_page() || is_single()) {$classes[] = 'static-page';}
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    if($is_lynx) $classes[] = 'lynx';elseif($is_gecko) $classes[] = 'gecko';elseif($is_opera) $classes[] = 'opera';elseif($is_NS4) $classes[] = 'ns4';elseif($is_safari) $classes[] = 'safari';elseif($is_chrome) $classes[] = 'chrome';elseif($is_IE) $classes[] = 'ie';else $classes[] = 'unknown';if($is_iphone) $classes[] = 'iphone';
    return $classes;
}
add_filter( 'body_class', 'new_body_classes' );

//remove ID in menu list
add_filter('nav_menu_item_id', 'clear_nav_menu_item_id', 10, 3);
function clear_nav_menu_item_id($id, $item, $args) {
    return "";
}

//Deregister Contact Form 7 styles
add_action( 'wp_print_styles', 'voodoo_deregister_styles', 100 );
function voodoo_deregister_styles() {
    wp_deregister_style( 'contact-form-7' );
}


//custom SEO title
function seo_title(){
    global $post;
    if($post->post_parent) {
        $parent_title = get_the_title($post->post_parent);
        echo wp_title('-', true, 'right') . $parent_title.' - ';
    } elseif(class_exists('Woocommerce') && is_shop()) {
        echo get_the_title(SHOP_ID) . ' - ';
    } else {
        wp_title('-', true, 'right');
    }
    bloginfo('name');
}


//Custom jQuery
function tt_add_scripts() {
    if (!is_admin()) {
        wp_deregister_script( 'jquery' );
    }

    wp_enqueue_script('jquery',  theme(). '/js/jquery.js', false, null, false);
    wp_enqueue_script('font_js', theme().'/style/font/font.js', array('jquery'), '', true );
	
    wp_enqueue_script('fancybox',  'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js');	
    wp_enqueue_script('lib_min', theme().'/js/lib.js', array('jquery'), '', true );
    wp_enqueue_script('js_init', theme().'/js/init.js', array('jquery'), '', true );
	
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('tt_style', theme().'/style/style.css');
    wp_enqueue_style('fancybox', '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css');
    wp_enqueue_style('font_style', theme().'/style/font/font.css');
}
add_action('wp_enqueue_scripts', 'tt_add_scripts');

//Style login page
function custom_login_css()
{
    echo '<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri('template_directory') . '/style/login.css" />';
}

add_action('login_head', 'custom_login_css');


$bar = array(
    'name'          => 'Blog Sidebar',
    'id'            => 'blogbar',
    'description'   => 'Sidebar for news section',
    'before_widget' => '<div class="widget cfx %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<div class="widgettitle">',
    'after_title'   => '</div>'
);
register_sidebar($bar);

function remove_default_description($bloginfo) {
    $default_tagline = 'Just another WordPress site';
    return ($bloginfo === $default_tagline) ? '' : $bloginfo;
}
add_filter('get_bloginfo_rss', 'remove_default_description');

//Wordpress ?s= redirect to /search/
function tt_search_redirect() {
    global $wp_rewrite;
    if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) { return; }
    $search_base = $wp_rewrite->search_base;
    if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
        wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
        exit();
    }
}
add_action('template_redirect', 'tt_search_redirect');

//Fix for empty search queries redirecting to home page
function tt_request_filter($query_vars) {
    if (isset($_GET['s']) && empty($_GET['s']) && !is_admin()) {
        $query_vars['s'] = ' ';
    }
    return $query_vars;
}
add_filter('request', 'tt_request_filter');

function tt_dashboard_widgets() {
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'normal');
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
}
add_action('admin_init', 'tt_dashboard_widgets');

function transliterate($textcyr = null, $textlat = null) {
    $cyr = array(
        'ы', ' ', 'є', 'ї', 'ж',  'ч',  'щ',   'ш',  'ю',  'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'і', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ь', 'я',
        'Ы','Є', 'Ї', 'Ж',  'Ч',  'Щ',   'Ш',  'Ю',  'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'І', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ь', 'Я');
    $lat = array(
        'y', '_', 'ye', 'yi', 'zh', 'ch', 'sht', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'y', 'x', 'ya',
        'Y','Ye', 'Yi', 'Zh', 'Ch', 'Sht', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'c', 'Y', 'X', 'Ya');
    if($textcyr) return str_replace($cyr, $lat, $textcyr);
    else if($textlat) return str_replace($lat, $cyr, $textlat);
    else return null;
}

//return header 403 for wrong login
function my_login_failed_403() {
    status_header( 403 );
}
add_action( 'wp_login_failed', 'my_login_failed_403' );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'acf-theme-settings',
        'capability' => 'edit_posts',
        'redirect' => false,
        'icon_url' => 'dashicons-shield-alt',
    ));
    acf_add_options_sub_page(array(
        'page_title' => 'Header',
        'menu_title' => 'Header',
        'parent_slug' => 'acf-theme-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title' => 'Footer',
        'menu_title' => 'Footer',
        'parent_slug' => 'acf-theme-settings',
    ));
}

//register menus
register_nav_menus(array(
    'head_menu' => 'Main navigation',
    'foot_menu' => 'Footer navigation'
));

//svg
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function custom_admin_head() {

    $css = '';

    $css = 'td.media-icon img[src$=".svg"] { width: 100% !important; height: auto !important; }';

    echo '<style type="text/css">'.$css.'</style>';
}
add_action('admin_head', 'custom_admin_head');

//remove p tag > image
function filter_ptags_on_images($content){
    return preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '\1', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

//light function fo wp_get_attachment_image_src()
function image_src($id, $size = 'full', $background_image = false, $height = false) {
    if ($image = wp_get_attachment_image_src($id, $size, true)) {
        return $background_image ? 'background-image: url('.$image[0].');' . ($height?'min-height:'.$image[2].'px':'') : $image[0];
    }
}

//images sizes
//add_image_size( 'example_name', '960', '540', true );
