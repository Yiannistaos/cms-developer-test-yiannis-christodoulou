<?php
/**
 * Import Data
 * Write a script that imports the events from the JSON file below into WordPress. The events should be stored in a custom post type. The script should be triggerable with the WordPress CLI. Running the import multiple times, should update the imported events and not create new entries each time.
 * You can assume that the ID attribute inside the JSON file for each event will not change and is a unique identifier. Do not import the data as one JSON object - create seperate fields for each attribute inside WordPress. You may use a plugin that makes custom fields in WordPress easy to work with.
 * After the import, please send an automated email to logging@agentur-loop.com with some details about it (how many events where imported, how many events were updated and so on).
 * 
 * Usage: wp mytest import_sample_data_into_custom_post_type --json_url="https://temp.web357.com/sample-data.json"
 */
class MYTEST_CLI {

	/**
     * Method to import sample data into a custom post type.
     *
     * @param [type] $args
     * @param [type] $assoc_args
     * @return void
     */
    public function import_sample_data_into_custom_post_type( $args, $assoc_args ) 
    {
        // Ge the url from 'json_url' argument
        $json_url = isset($assoc_args['json_url']) ? ($assoc_args['json_url']) : '';
        
        // WP_CLI::line( "Parse JSON data from: " . $json_url );
       
        if (!empty($json_url))
        { 
            $json_url_data = file_get_contents($json_url);
            $json_data_into_array = json_decode($json_url_data, true);
          
            $count_json_data_into_array = count($json_data_into_array);
            $progress = \WP_CLI\Utils\make_progress_bar( 'Generating Posts', $count_json_data_into_array);

			$posts_created = 0;
			$posts_updated = 0;
            foreach ($json_data_into_array as $i => $item)
            {				
                $args = array(
                    'orderby'   => 'menu_order',
                    'order' => 'ASC',
                    'post_type' => 'mytest_events',
                    'post_status' => array( 'any' ),
                    'meta_query' => array(
                        array(
                            'key'     => 'mytest_id',
                            'value'   => intval($item['id']),
                            'compare' => '=',
                            'type'    => 'numeric',
                        ),
                    ),
				);
       
				$my_query = new WP_Query( $args );

				// Set the status of inactive events to draft
				$date_now = date("Y-m-d H:i:s");
				if ($date_now >= $item['timestamp']) {
					$post_status = 'draft';
				}
				else
				{
					$post_status = 'publish';
				}

				// if the id does not exist, create a new post
				if ( empty($my_query->have_posts()) ) 
				{					
                    // Code used to generate a new post.
                    $mytest_post = array(
                        'post_title'  => $item['title'],
                        'post_content' => $item['about'],
                        'post_excerpt' => $item['about'],
                        'post_status' => $post_status,
                        'post_author' => 1,
                        'post_type'   => 'mytest_events',
                    );
                
                    // Insert the post into the database.
                    $my_new_post_id = wp_insert_post($mytest_post);

					// Add terms
					wp_set_object_terms( $my_new_post_id, $item['tags'], 'tags' );

                    // Add meta
                    update_post_meta($my_new_post_id, 'mytest_id', (int) $item['id']);
                    update_post_meta($my_new_post_id, 'mytest_about', $item['about']);
                    update_post_meta($my_new_post_id, 'mytest_organizer', $item['organizer']);
                    update_post_meta($my_new_post_id, 'mytest_timestamp', $item['timestamp']);
                    update_post_meta($my_new_post_id, 'mytest_email', $item['email']);
                    update_post_meta($my_new_post_id, 'mytest_address', $item['address']);
                    update_post_meta($my_new_post_id, 'mytest_latitude', $item['latitude']);
                    update_post_meta($my_new_post_id, 'mytest_longitude', $item['longitude']);

					$posts_created++;
                }
                else
                {
					$my_query->the_post();
					// Code used to update a post.
					$mytest_post = array(
						'ID'  => get_the_ID(),
						'post_title'  => $item['title'],
						'post_content' => $item['about'],
						'post_excerpt' => $item['about'],
						'post_status' => $post_status,
						'post_author' => 1,
						'post_type'   => 'mytest_events',
					);

					// Insert the post into the database.
					wp_update_post($mytest_post);

					// Add terms
					wp_set_object_terms( get_the_ID(), $item['tags'], 'tags' );

					// Add meta
					update_post_meta(get_the_ID(), 'mytest_id', (int) $item['id']);
                    update_post_meta(get_the_ID(), 'mytest_about', $item['about']);
                    update_post_meta(get_the_ID(), 'mytest_organizer', $item['organizer']);
                    update_post_meta(get_the_ID(), 'mytest_timestamp', $item['timestamp']);
                    update_post_meta(get_the_ID(), 'mytest_email', $item['email']);
                    update_post_meta(get_the_ID(), 'mytest_address', $item['address']);
                    update_post_meta(get_the_ID(), 'mytest_latitude', $item['latitude']);
                    update_post_meta(get_the_ID(), 'mytest_longitude', $item['longitude']);

					$posts_updated++;
				}

                $progress->tick();
            }

            $progress->finish();

            // Display a success message
            WP_CLI::success( $posts_created. ' posts have been created!' );
            WP_CLI::success( $posts_updated. ' posts have been updated!' );

            // Send email
            $mail_to = 'logging@agentur-loop.com';
            $mail_subject = 'WP Cli Email Notification for New/Updated Posts';
            $mail_body = '';
			$mail_body .= '<p>' .$posts_created. ' posts have been created!</p>';
			$mail_body .= '<p>' .$posts_updated. ' posts have been updated!</p>';
            $mail_headers = array('Content-Type: text/html; charset=UTF-8');
            $mail_headers[] = 'From: Yiannis Christodoulou <yiannis@web357.com>';
			$mail_headers[] = 'Cc: Yiannis Christodoulou <yiannis@web357.com>';
            wp_mail( $mail_to, $mail_subject, $mail_body, $mail_headers );
            WP_CLI::success( 'Email sent to: ' . $mail_to );
        }
    }
}

/**
* Registers our command when cli get's initialized.
*/
add_action( 'cli_init', 'mytest_cli_register_commands' );
function mytest_cli_register_commands() {
    WP_CLI::add_command( 'mytest', 'MYTEST_CLI' );
}