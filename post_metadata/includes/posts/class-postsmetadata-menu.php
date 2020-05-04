<?php

/**
 * Admin Menu
 */
class PostsMetaData_Menu {

    /**
     * Kick-in the class
     */
    public function __construct() {
        global $current_user;

        // check captability
        if($current_user->roles[0]=='administrator'){
            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        }
        
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

         add_menu_page( __( 'Posts Meta Data', '' ), __( 'Posts Meta Data', '' ), 'manage_options', 'postsmetadata', array( $this, 'plugin_page' ), 'dashicons-groups', null );
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $meta_id     = isset( $_GET['meta_id'] ) ? intval( $_GET['meta_id'] ) : 0;

        switch ($action) {
            case 'view':

                $template = dirname( __FILE__ ) . '/views/postsmeta-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/postsmeta-edit.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/postsmeta-new.php';
                break;

            case 'delete':
                $template = dirname( __FILE__ ) . '/views/postsmeta-delete.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/postsmeta-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}