<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Postmeta_Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the Postmeta new and edit form
     *
     * @return void
     */
    public function handle_form() {


        if ( ! isset( $_POST['Post_Submit_Option'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], '' ) ) {
            die( __( 'Are you cheating?', '' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', '' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=postsmetadata' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $meta_id = isset( $_POST['meta_id'] ) ? sanitize_text_field( $_POST['meta_id'] ) : '';
        $post_id = isset( $_POST['post_id'] ) ? sanitize_text_field( $_POST['post_id'] ) : '';
        $meta_key = isset( $_POST['meta_key'] ) ? sanitize_text_field( $_POST['meta_key'] ) : '';
        $meta_value = isset( $_POST['meta_value'] ) ? sanitize_text_field( $_POST['meta_value'] ) : '';

        // some basic validation
        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'meta_id' => $meta_id,
            'post_id' => $post_id,
            'meta_key' => $meta_key,
            'meta_value' => $meta_value,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = pm_insert_post_meta( $fields );

        } else {

            $fields['meta_id'] = $field_id;

            $insert_id = pm_insert_post_meta( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}

new Postmeta_Form_Handler();