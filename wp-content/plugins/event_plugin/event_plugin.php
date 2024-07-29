<?php
/**
* Plugin Name: Event Plugin
* Plugin URI: https://picrew.me/en
* Description: Deployed
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

function enqueue_custom_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-ajax-script', plugin_dir_url(__FILE__) . 'custom-ajax.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-ajax-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

function events_plugin_create_custom_post(){
    register_post_type('booking_details', [
        'labels' => 
        [
            'name' => 'Booking Details',
            'singular_name' => 'Booking Detail',
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'booking_detail'],
        'supports' => ['title', 'revisions', 'thumbnail'],
        'menu_icon' => 'dashicons-email'
    ]);
}

add_action('init','events_plugin_create_custom_post');


function route_table() {
    ob_start();
    include(plugin_dir_path(__FILE__).'content.php');
    return ob_get_clean();
}
add_shortcode('route-table', 'route_table');


function create_page(){ 

    $page_name = "Route chart";
    $query = new WP_Query([
        'post_type' => 'page',
        'title' =>  $page_name,
        'post_status' => 'publish',
        'posts_per_page' => 1,
    ]);

    $check_page_exist = $query->have_posts() ? $query->posts[0] : null;

    if(empty($check_page_exist)){ 
        wp_insert_post(
            array(
            'comment_status' => 'close',
            'ping_status'    => 'close',
            'post_author'    => 1,
            'post_title'     => ucwords($page_name),
            'post_name'      => strtolower(str_replace(' ', '-', trim($page_name))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => do_shortcode('[route-table]')
            )
        );
    }else{
        $updated_post = [
            'ID' =>  $check_page_exist->ID,
            'post_content'   => do_shortcode('[route-table]')
        ];
        wp_update_post( $updated_post );
    }

}


//Create a page where user's registered entries are about to be stored

function users_table(){
    ob_start();
    include(plugin_dir_path(__FILE__).'users_table.php');
    return ob_get_clean();
}
add_shortcode('users-table','users_table');

/**
 * Create a page to show User's table
 */
function create_users_page(){ 

    $page_name = "User Page";
    $query = new WP_Query([
        'post_type' => 'page',
        'title' =>  $page_name,
        'post_status' => 'publish',
        'posts_per_page' => 1,
    ]);

    $check_page_exist = $query->have_posts() ? $query->posts[0] : null;

    if(empty($check_page_exist)){ 
        wp_insert_post(
            array(
            'comment_status' => 'close',
            'ping_status'    => 'close',
            'post_author'    => 1,
            'post_title'     => ucwords($page_name),
            'post_name'      => strtolower(str_replace(' ', '-', trim($page_name))),
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_content'   => do_shortcode('[users-table]')
            )
        );
    }else{
        $updated_post = [
            'ID' =>  $check_page_exist->ID,
            'post_content'   => do_shortcode('[users-table]')
        ];
        wp_update_post( $updated_post );
    }

}

//Create a Table

function events_plugin_create_database_table() {
    
    global $wpdb;

    $table_name = $wpdb->prefix . 'user_route_details';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255),
        phone_number INT,
        email varchar(255),
        bus_name varchar(255),
        starting_route varchar(255),
        ending_route varchar(255),
        seats_alloted INT,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}

function prefix_mb_callback($post_id) {
    global $post;

    $IDs = [
        'Start Route: ' => ['mb_start_route', 'starting_route'],
        'End Route: ' => ['mb_end_route', 'ending_route'],
        'Available Seats: ' => ['mb_available_seats', 'available_seats'],
    ];
    
    foreach ($IDs as $key => $values) {
        $field_id = $values[0];
        $value = get_post_meta($post_id, $field_id, true);
        ?>
        <label for="<?php echo esc_attr($field_id); ?>"><?php echo esc_html($key); ?></label>
        <input type="text" class="regular-text" value="<?php echo get_post_meta($post->ID,$values[0],true); ?>" name="<?php echo esc_attr($field_id); ?>" id="<?php echo esc_attr($field_id); ?>"><br><br>
        <?php
    }
}

/**
 * Save metabox data
 */
function prefix_save_meta_data($post_id) {
    if (!current_user_can('edit_post', $post_id) || 'booking_details' != get_post_type($post_id)) {
        return $post_id;
    }

    $meta_values = [
        'mb_start_route',
        'mb_end_route',
        'mb_available_seats',
    ];

    foreach ($meta_values as $field_id) {
        if (isset($_POST[$field_id])) {
            $value = sanitize_text_field($_POST[$field_id]);
            update_post_meta($post_id, $field_id, $value);
        }
    }

    $page_name = "Route chart";
    $query = new WP_Query([
        'post_type' => 'page',
        'title' =>  $page_name,
        'post_status' => 'publish',
        'posts_per_page' => 1,
    ]);
    
    $check_page_exist = $query->have_posts() ? $query->posts[0] : null;
    if ($check_page_exist) {
        $updated_post = [
            'ID' =>  $check_page_exist->ID,
            'post_content'   => do_shortcode('[route-table]')
        ];
        wp_update_post($updated_post);
    }
}
add_action('save_post', 'prefix_save_meta_data');

/**
 * Add Meta field
 */
function create_custom_meta_box() {
    add_meta_box(
        'prefix_custom_meta_box',
        'Custom Meta Box',
        'prefix_mb_callback',
        'booking_details',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'create_custom_meta_box');


// print_r($_POST);

function handle_register_route() {
    check_ajax_referer('register_route_nonce', 'security');

    global $wpdb;
    $table_name = $wpdb->prefix . 'user_route_details';

    $route_id = isset($_POST['route_id']) ? intval($_POST['route_id']) : 0;
    $seat_number = isset($_POST['number_of_seats_allocated']) ? intval($_POST['number_of_seats_allocated']) : 0;

    if ($route_id && $seat_number) {
        $available_seats = get_post_meta($route_id, 'mb_available_seats', true);
        
        if ($available_seats !== '') {
            $remaining_seats = intval($available_seats) - $seat_number;
            if ($remaining_seats >= 0) {
                update_post_meta($route_id, 'mb_available_seats', $remaining_seats);

                // Save user details to the custom table
                $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
                $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
                $email = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
                $bus = isset($_POST['bus_name']) ? sanitize_text_field($_POST['bus_name']) : '';
                $starting_route = isset($_POST['starting_route']) ? sanitize_text_field($_POST['starting_route']) : '';
                $ending_route = isset($_POST['ending_route']) ? sanitize_text_field($_POST['ending_route']) : '';

                $wpdb->insert(
                    $table_name,
                    array(
                        'name' => $name,
                        'phone_number' => $phone,
                        'email' => $email,
                        'bus_name' => $bus,
                        'starting_route' => $starting_route,
                        'ending_route' => $ending_route,
                        'seats_alloted' => $seat_number,
                    ),
                    array('%s', '%d', '%s', '%s', '%s', '%s', '%d')
                );

                // Update the Route chart page and User page
                create_page();
                create_users_page();
                
                wp_send_json_success(array('message' => 'Registration successful'));
            } else {
                wp_send_json_error(array('message' => 'Not enough seats available'));
            }
        } else {
            wp_send_json_error(array('message' => 'Route not found'));
        }
    } else {
        wp_send_json_error(array('message' => 'Invalid route or seat number'));
    }
    wp_die();
}

add_action('wp_ajax_register_route', 'handle_register_route');
add_action('wp_ajax_nopriv_register_route', 'handle_register_route');

function Update_user_table() {
    create_users_page();
}

function myplugin_activate(){
 
    events_plugin_create_database_table();
    create_page();
    create_users_page();
}
register_activation_hook( __FILE__, 'myplugin_activate' );

