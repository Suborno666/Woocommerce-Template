<?php
/**
 * Template Name: Functions
 */

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page();

}

function eshopper_theme_support(){

    add_theme_support('post-thumbnails');
    add_theme_support('category-thumbnails');
    add_theme_support('woocommerce');

    add_theme_support('title-tag');

}
add_action('after_setup_theme','eshopper_theme_support');

function eshopper_enqueue_links() {

    /**
     * Header
     */
    wp_enqueue_style('css-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css', [], '5.10.0', 'all');
    wp_enqueue_style('css-OwlCarousel', get_template_directory_uri().'/assets/lib/owlcarousel/assets/owl.carousel.min.css', [], '2.2.1', 'all');
    wp_enqueue_style('css-stylesheet', get_template_directory_uri().'/assets/css/style.css', [], '4.5.3', 'all');

    /**
     * Footer
     */
    wp_enqueue_script('js-jquery', 'https://code.jquery.com/jquery-3.4.1.min.js', [], '3.4.1', true);
    wp_enqueue_script('js-bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js', [], '4.4.1', true);
    wp_enqueue_script('js-easing', get_template_directory_uri().'/assets/lib/easing/easing.min.js', [], '1.0.0', true);
    wp_enqueue_script('js-owlCarousel', get_template_directory_uri().'/assets/lib/owlcarousel/owl.carousel.min.js', [], '2.1.6', true);
    wp_enqueue_script('js-mail', get_template_directory_uri().'/assets/mail/jqBootstrapValidation.min.js', [], '', true);
    wp_enqueue_script('js-mailContact', get_template_directory_uri().'/assets/mail/contact.js', [], '', true);
    wp_enqueue_script('js-main', get_template_directory_uri().'/assets/js/main.js', [], '1.0', true);

}
add_action('wp_enqueue_scripts', 'eshopper_enqueue_links');


/** Removing certain elements from the template */
add_filter('woocommerce_sale_flash', 'avada_hide_sale_flash');
function avada_hide_sale_flash()
{
    return false;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

add_filter('woocommerce_show_page_title', 'bbloomer_hide_shop_page_title');
 
function bbloomer_hide_shop_page_title($title) {
   if (is_shop()) $title = false;
   return $title;
}

// Remove breadcrumbs from all pages

remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

/**
 * Adding Widgets
 */

function wpb_widgets_init() {
 
    register_sidebar( array(
        'name' => __( 'Filter Sidebar', 'wpb' ),
        'id' => 'sidebar-1',
        'description' => __( 'The main sidebar appears on the right on each page except the front page template', 'wpb' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
 
    register_sidebar( array(
        'name' =>__( 'Top page sidebar', 'wpb'),
        'id' => 'sidebar-2',
        'description' => __( 'Appears on the top page template', 'wpb' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    }
 
add_action( 'widgets_init', 'wpb_widgets_init' );

function my_custom_wc_get_rating_html($rating, $count) {
    $rating_html = '<div class="text-primary mb-2">';
    $full_stars = floor($rating);
    $half_star = ceil($rating) - $full_stars;

    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $full_stars) {
            $rating_html .= '<i class="fas fa-star"></i>';
        } elseif ($i == $full_stars + 1 && $half_star) {
            $rating_html .= '<i class="fas fa-star-half-alt"></i>';
        } else {
            $rating_html .= '<i class="far fa-star"></i>';
        }
    }

    $rating_html .= '</div>';

    return $rating_html;
}
add_filter('woocommerce_product_get_rating_html', 'my_custom_wc_rating_html', 10, 2);

function my_custom_wc_rating_html($html, $rating) {
    return my_custom_wc_get_rating_html($rating, 0);
}

add_action('wp_ajax_get_cart_count', 'get_cart_count');
add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count');

function get_cart_count() {
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}
?>