<?php 
/**
 * Import every attribute in a separate field. For tags you can also make use of WordPress taxonomies. Also make sure to import inactivate events as drafts that are not displayed on the website and are not part of the export.
 */
add_action( 'add_meta_boxes', 'mytest_fields_metabox' );
function mytest_fields_metabox() {
    add_meta_box(
        'mytest_fields_metabox', // $id
        'My Custom Fields for the Events', // $title
        'show_mytest_fields_metabox', // $callback
        'mytest_events', // $screen
        'normal', // $context
        'high' // $priority
    );
}
function show_mytest_fields_metabox() {
    global $post;  
    $mytest_id = get_post_meta( $post->ID, 'mytest_id', true );
    $mytest_about = get_post_meta( $post->ID, 'mytest_about', true );
    $mytest_organizer = get_post_meta( $post->ID, 'mytest_organizer', true );
    $mytest_timestamp = get_post_meta( $post->ID, 'mytest_timestamp', true );
    $mytest_email = get_post_meta( $post->ID, 'mytest_email', true );
    $mytest_address = get_post_meta( $post->ID, 'mytest_address', true );
    $mytest_latitude = get_post_meta( $post->ID, 'mytest_latitude', true );
    $mytest_longitude = get_post_meta( $post->ID, 'mytest_longitude', true ); ?>

    <input type="hidden" name="mytest_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
    
    <!-- All fields -->
    <p>
    	<label for="mytest_id">ID *</label><br>
    	<input type="number" required="true" name="mytest_id" id="mytest_id" value="<?php  if (isset($mytest_id)){ echo $mytest_id; } ?>">
    </p>

    <p>
    	<label for="mytest_about">About:</label><br>
        <textarea id="mytest_about" name="mytest_about" rows="4" cols="50"><?php  if (isset($mytest_about)){ echo $mytest_about; } ?></textarea>
    </p>

    <p>
    	<label for="mytest_organizer">Organizer</label><br>
    	<input type="text" name="mytest_organizer" id="mytest_organizer" value="<?php  if (isset($mytest_organizer)){ echo $mytest_organizer; } ?>">
    </p>

    <p>
    	<label for="mytest_timestamp">Timestamp</label><br>
    	<input type="text" name="mytest_timestamp" id="mytest_timestamp" value="<?php  if (isset($mytest_timestamp)){ echo $mytest_timestamp; } ?>">
    </p>

    <p>
    	<label for="mytest_email">Email</label><br>
    	<input type="text" name="mytest_email" id="mytest_email" value="<?php  if (isset($mytest_email)){ echo $mytest_email; } ?>">
    </p>

    <p>
    	<label for="mytest_address">Address</label><br>
    	<input type="text" name="mytest_address" id="mytest_address" value="<?php  if (isset($mytest_address)){ echo $mytest_address; } ?>">
    </p>

    <p>
    	<label for="mytest_latitude">Latitude</label><br>
    	<input type="text" name="mytest_latitude" id="mytest_latitude" value="<?php  if (isset($mytest_latitude)){ echo $mytest_latitude; } ?>">
    </p>

    <p>
    	<label for="mytest_longitude">Longitude</label><br>
    	<input type="text" name="mytest_longitude" id="mytest_longitude" value="<?php  if (isset($mytest_longitude)){ echo $mytest_longitude; } ?>">
    </p>
    
<?php 
}

add_action( 'save_post', 'mytest_save_fields_meta' );
function mytest_save_fields_meta( $post_id ) {   
    // verify nonce
    if ( !wp_verify_nonce( (isset($_POST['mytest_meta_box_nonce']) ? $_POST['mytest_meta_box_nonce'] : ''), basename(__FILE__) ) ) {
        return $post_id; 
    }
    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
    // check permissions
    if ( 'page' === $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) ) {
            return $post_id;
        } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }  
    }
    
    // Field: mytest_id
    $old = get_post_meta( $post_id, 'mytest_id', true );
    $new = $_POST['mytest_id'];
    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'mytest_id', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'mytest_id', $old );
    }

    // Field: mytest_about
    $old = get_post_meta( $post_id, 'mytest_about', true );
    $new = $_POST['mytest_about'];
    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'mytest_about', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'mytest_about', $old );
    }

    // Field: mytest_organizer
    $old = get_post_meta( $post_id, 'mytest_organizer', true );
    $new = $_POST['mytest_organizer'];
    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'mytest_organizer', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'mytest_organizer', $old );
    }

    // Field: mytest_timestamp
    $old = get_post_meta( $post_id, 'mytest_timestamp', true );
    $new = $_POST['mytest_timestamp'];
    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'mytest_timestamp', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'mytest_timestamp', $old );
    }

    // Field: mytest_email
    $old = get_post_meta( $post_id, 'mytest_email', true );
    $new = $_POST['mytest_email'];
    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'mytest_email', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'mytest_email', $old );
    }

    // Field: mytest_address
    $old = get_post_meta( $post_id, 'mytest_address', true );
    $new = $_POST['mytest_address'];
    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'mytest_address', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'mytest_address', $old );
    }

    // Field: mytest_latitude
    $old = get_post_meta( $post_id, 'mytest_latitude', true );
    $new = $_POST['mytest_latitude'];
    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'mytest_latitude', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'mytest_latitude', $old );
    }

    // Field: mytest_longitude
    $old = get_post_meta( $post_id, 'mytest_longitude', true );
    $new = $_POST['mytest_longitude'];
    if ( $new && $new !== $old ) {
        update_post_meta( $post_id, 'mytest_longitude', $new );
    } elseif ( '' === $new && $old ) {
        delete_post_meta( $post_id, 'mytest_longitude', $old );
    }
}