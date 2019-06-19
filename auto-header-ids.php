<?php
/**
 * Plugin Name: Auto-Header Ids
 * Description: Automatically adds ID tags onto all headers in post content. Props https://jeroensormani.com/automatically-add-ids-to-your-headings/
 * Author: Michael Nelson
 * Author URI:
 * Version: 0.1
 */
/**
 * Automatically add IDs to headings such as <h2></h2>
 */
function auto_id_headings( $content ) {
    $content = preg_replace_callback( '/(\<h[1-6](.*?))\>(.*)(<\/h[1-6]>)/i', function( $matches ) {
        if ( ! stripos( $matches[0], 'id=' ) ) :
            $heading_link = '<a href="#' . sanitize_title( $matches[3] ) . '" class="heading-link"><span class="dashicons dashicons-admin-links"></span></a>';
            $matches[0] = $matches[1] . $matches[2] . ' id="' . sanitize_title( $matches[3] ) . '">' . $heading_link . $matches[3] . $matches[4];
        endif;
        return $matches[0];
    }, $content );
    return $content;
}
add_filter( 'the_content', 'auto_id_headings' );

function auto_header_ids_scripts(){
    wp_enqueue_style(
        'auto-header-ids',
        plugin_dir_url(__FILE__) . 'auto-header-ids.css',
        array('dashicons'),
        '0.1',
        'all'
    );
}
add_action('wp_enqueue_scripts', 'auto_header_ids_scripts');