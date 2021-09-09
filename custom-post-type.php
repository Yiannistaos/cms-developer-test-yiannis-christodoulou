<?php
/*
* Creating a function to create our CPT
*/
add_action( 'init', 'mytest_events_custom_post_type', 0 ); 
function mytest_events_custom_post_type() {

    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Events', 'Post Type General Name', 'mytest' ),
        'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'mytest' ),
        'menu_name'           => __( 'Events', 'mytest' ),
        'parent_item_colon'   => __( 'Parent Event', 'mytest' ),
        'all_items'           => __( 'All Events', 'mytest' ),
        'view_item'           => __( 'View Event', 'mytest' ),
        'add_new_item'        => __( 'Add New Event', 'mytest' ),
        'add_new'             => __( 'Add New', 'mytest' ),
        'edit_item'           => __( 'Edit Event', 'mytest' ),
        'update_item'         => __( 'Update Event', 'mytest' ),
        'search_items'        => __( 'Search Event', 'mytest' ),
        'not_found'           => __( 'Not Found', 'mytest' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'mytest' ),
    );
            
    // Set other options for the Custom Post Type
    $args = array(
        'label'               => __( 'mytest_events', 'mytest' ),
        'description'         => __( 'Event news and reviews', 'mytest' ),
        'labels'              => $labels,
        'supports'            => array('title', 'editor'), // array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        'taxonomies'          => array( 'genres' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-site-alt2',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    
    );
        
    // Registering the Custom Post Type
    register_post_type( 'mytest_events', $args );
    register_taxonomy_for_object_type( 'genres', 'mytest_events' );
}

// Add new taxonomy (tags), make it hierarchical like categories
add_action( 'init', 'mytest_create_tags_hierarchical_taxonomy', 0 );
function mytest_create_tags_hierarchical_taxonomy() {
 
    $labels = array(
        'name' => _x( 'Tags', 'taxonomy general name' ),
        'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Tags' ),
        'all_items' => __( 'All Tags' ),
        'parent_item' => __( 'Parent Tag' ),
        'parent_item_colon' => __( 'Parent Tag:' ),
        'edit_item' => __( 'Edit Tag' ), 
        'update_item' => __( 'Update Tag' ),
        'add_new_item' => __( 'Add New Tag' ),
        'new_item_name' => __( 'New Tag Name' ),
        'menu_name' => __( 'Tags' ),
    );    

    // Register the taxonomy
    register_taxonomy('tags',
        array('mytest_events'), 
        array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'tag' )
        )
    );
 
}