<?php
/**
 * Show Data
 * After the import, it is now time to show the events sorted by their timestamps (closest events at the top) on the website. Create some basic HTML and CSS that will show the events in a simple list. Each event should show the time remaining in relative time formats such as "in 20 minutes" or in "5 days".
 * Shortcode usage: [mytest-events]
 */
add_action( 'init', 'mytest_events_register_shortcode' );
function mytest_events_register_shortcode()
{
    add_shortcode('mytest-events', 'mytest_events_register_shortcode_fun');
}

/**
 * Get the time elapsed string from  a give date
 * Usage: echo mytest_time_elapsed_string('2021-10-10 00:22:35');
 *
 * @param [type] $datetime
 * @param boolean $full
 * @return void
 */
function mytest_time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? 'in ' . implode(', ', $string) . '' : 'just now';
}

function mytest_events_register_shortcode_fun() 
{
    $args = array(
        'post_type'         => 'mytest_events',
        'posts_per_page'    => -1,
        'meta_key'          => 'mytest_timestamp',
        'orderby'           => 'meta_value',
        'order'             => 'DESC',
        'post_status'       => array( 'publish' ),
    );
    
    $query = new WP_Query( $args );
    $html = '';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $mytest_id = get_post_meta(get_the_ID(), 'mytest_id', true);
            $mytest_about = get_post_meta(get_the_ID(), 'mytest_about', true);
            $mytest_organizer = get_post_meta( get_the_ID(), 'mytest_organizer', true );
            $mytest_timestamp = get_post_meta( get_the_ID(), 'mytest_timestamp', true );
            $mytest_email = get_post_meta( get_the_ID(), 'mytest_email', true );
            $mytest_address = get_post_meta( get_the_ID(), 'mytest_address', true );
            $mytest_latitude = get_post_meta( get_the_ID(), 'mytest_latitude', true );
            $mytest_longitude = get_post_meta( get_the_ID(), 'mytest_longitude', true );

            $html .= '<h3>'.$mytest_id.'. '.esc_attr(get_the_title()).'</h3>';
            $html .= '<h5>Content</h5>';
            $html .= '<p>'.get_the_content().'</p>';
            $html .= '<h5>Data</h5>';
            $html .= '<ul>';
            $html .= '<li>mytest_about: '.$mytest_about.'</li>';
            $html .= '<li>mytest_organizer: '.$mytest_organizer.'</li>';
            $html .= '<li>mytest_timestamp: '.$mytest_timestamp.'</li>';
            $html .= '<li>mytest_timestamp time elapsed: '.mytest_time_elapsed_string($mytest_timestamp).'</li>';
            $html .= '<li>mytest_email: '.$mytest_email.'</li>';
            $html .= '<li>mytest_address: '.$mytest_address.'</li>';
            $html .= '<li>mytest_latitude: '.$mytest_latitude.'</li>';
            $html .= '<li>mytest_longitude: '.$mytest_longitude.'</li>';
            $html .= '</ul>';
        }
    }

    return $html;
}