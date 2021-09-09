<?php
/**
 * Export Data
 * Finally, write a script that can be accessed through a URL which outputs all events - also sorted by timestamps (closest events at the top) as JSON.
 * Usage: https://wordpress.test/export-data
 */
add_filter('query_vars', 'mytest_event_add_query_vars', 0);
function mytest_event_add_query_vars($vars)
{
    $vars[] = '__export_data';
    return $vars;
}


add_action('init', 'mytest_event_add_endpoint', 0);
function mytest_event_add_endpoint()
{
    add_rewrite_rule('^export-data/?$','index.php?__export_data=1','top');
}

add_action('parse_request', 'mytest_event_sniff_requests', 0);
function mytest_event_sniff_requests()
{
    global $wp;
    if(isset($wp->query_vars['__export_data'])){

        mytest_event_handle_request();
        exit;
    }
}

function mytest_event_handle_request()
{
    global $wp, $wpdb;

    $args = array(
        'post_type'         => 'mytest_events',
        'post_status'       => array( 'publish' ),
        'posts_per_page'    => -1,
        'meta_key'          => 'mytest_timestamp',
        'orderby'           => 'meta_value',
        'order'             => 'DESC'
    );

    $query = new WP_Query( $args );

    $posts = [];

    while( $query->have_posts() ) : $query->the_post();

    $posts[] = array(
        'ID' => get_the_ID(),
        'title' => get_the_title(),
        'excerpt' => get_the_excerpt(),
        'author' => get_the_author(),
        'status' => get_post_status(),
        'mytest_id' => get_post_meta(get_the_ID(), 'mytest_id', true),
        'mytest_about' => get_post_meta(get_the_ID(), 'mytest_about', true),
        'mytest_organizer' => get_post_meta(get_the_ID(), 'mytest_organizer', true),
        'mytest_timestamp' => get_post_meta(get_the_ID(), 'mytest_timestamp', true),
        'mytest_email' => get_post_meta(get_the_ID(), 'mytest_email', true),
        'mytest_address' => get_post_meta(get_the_ID(), 'mytest_address', true),
        'mytest_latitude' => get_post_meta(get_the_ID(), 'mytest_latitude', true),
        'mytest_longitude' => get_post_meta(get_the_ID(), 'mytest_longitude', true),
    );

    endwhile;

    wp_reset_query();

    header('Content-Type: application/json'); 
    echo json_encode($posts);
}