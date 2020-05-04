<?php

/**
 * Get all Post Meta
 *
 * @param $args array
 *
 * @return array
 */
function pm_get_all_post_meta( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'meta_id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'Post Meta-all';
    $items     = wp_cache_get( $cache_key, '' );

    if ( false === $items ) { 
        if(empty($args['s'])){
            $query = 'SELECT * FROM ' . $wpdb->prefix . 'postmeta where 1=1 ';

            if(!empty($args['meta_id'])){
                $query  .='and meta_id="'.$args['meta_id'].'" ';
            }
            if(!empty($args['post_id'])){
                $query  .='and post_id="'.$args['post_id'].'" ';
            }
            if(!empty($args['meta_key'])){
                $query  .='and meta_key="'.$args['meta_key'].'" ';
            }
            if(!empty($args['meta_value'])){
                $query  .='and meta_value="'.$args['meta_value'].'" ';
            }

            $query  .='ORDER BY meta_id ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'];
            
            $items = $wpdb->get_results( $query );
        }else{
            $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'postmeta where post_id like "%'.$args['s'].'%" or meta_key like "%'.$args['s'].'%" or meta_value like "%'.$args['s'].'%" ORDER BY meta_id ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );
        }
        wp_cache_set( $cache_key, $items, '' );
    }

    return $items;
}

/**
 * Fetch all Post Meta from database
 *
 * @return array
 */
function pm_get_post_meta_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'postmeta' );
}

/**
 * Fetch a single Post Meta from database
 *
 * @param int   $id
 *
 * @return array
 */
function pm_get_post_meta( $meta_id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'postmeta WHERE meta_id = %d', $meta_id ) );
}


function pm_delete_post_meta( $metaid = 0 ) {
    global $wpdb;
    $wpdb->delete( $wpdb->prefix.'postmeta',array('meta_id'=>$metaid));
}


/**
 * Insert a new Postmeta
 *
 * @param array $args
 */
function pm_insert_post_meta( $args = array() ) {
    global $wpdb;

    $defaults = array(
        //'id'         => null,
        //'meta_id' => '',
        'post_id' => '',
        'meta_key' => '',
        'meta_value' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'postmeta';

    // some basic validation

    // remove row id to determine if new or update
    $row_id = (int) $args['meta_id'];
    unset( $args['meta_id'] );

    if ( ! $row_id ) {

        

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'meta_id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}