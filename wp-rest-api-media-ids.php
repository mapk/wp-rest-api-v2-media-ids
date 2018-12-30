<?php 
/*
Plugin Name: WP-REST-API Media IDs
Version: 0.2
Description: Adding an endpoint to show all media IDs on WP REST API
Author: Mark Uraine
Author URI: http://markuraine.com
*/

/**
 * Get all media IDs
 * @return array List of media IDs
 */
// Return all media IDs
function dt_get_all_media_ids() {
    if ( false === ( $all_media_ids = get_transient( 'dt_all_media_ids' ) ) ) {
        $all_media_ids = get_posts( array(
            'post_type'   => 'attachment',
            'post_mime_type' => 'image',
            'post_status'    => 'inherit', 
            'posts_per_page' => -1,
            'fields'      => 'ids',
        ) );
        // cache for 2 hours
        set_transient( 'dt_all_media_ids', $all_media_ids, 60*60*2 );
    }

    return $all_media_ids;
}


add_action( 'rest_api_init', function () {
    register_rest_route( 'media-ids/v1', '/get-all-media-ids', array(
        'methods' => 'GET',
        'callback' => 'dt_get_all_media_ids',
    ) );
} );
