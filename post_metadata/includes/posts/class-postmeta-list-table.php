<?php

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class PostsMetaData_List_Table extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'Post Meta',
            'plural'   => 'Post Metas',
            'ajax'     => false
        ) );
    }

    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items() {
        _e( 'No Post MetaFound', '' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $item, $column_name ) {

        switch ( $column_name ) {
            case 'meta_id':
                return $item->meta_id;

            case 'post_id':
                return $item->post_id;

            case 'meta_key':
                return $item->meta_key;

            case 'meta_value':
                return $item->meta_value;

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_hidden_columns() {
        $columns = array(
            //'meta_id'      => __( 'Meta Id', '' ),
        );

        return $columns;
    }
    function get_columns() {
        $columns = array(
            'cb'           => '<input type="checkbox" />',
            'meta_id'      => __( 'Meta Id', '' ),
            'post_id'      => __( 'Post Id', '' ),
            'meta_key'      => __( 'Meta Key', '' ),
            'meta_value'      => __( 'Meta Value', '' ),

        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_meta_id( $item ) {

        $actions           = array();
        $actions['edit']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=postsmetadata&action=edit&meta_id=' . $item->meta_id ), $item->meta_id, __( 'Edit this item', '' ), __( 'Edit', '' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=postsmetadata&action=delete&meta_id=' . $item->meta_id ), $item->meta_id, __( 'Delete this item', '' ), __( 'Delete', '' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=postsmetadata&action=view&meta_id=' . $item->meta_id ), $item->meta_id, $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'meta_id' => array( 'Meta Id', true ),
            'post_id' => array( 'Post Id', true ),
            'meta_key' => array( 'Meta Key', true ),
            'meta_value' => array( 'Meta Value', true ),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            //'trash'  => __( 'Move to Trash', '' ),
        );
        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="Post Meta_id[]" value="%d" />', $item->meta_id
        );
    }

    public function extra_tablenav($which)
    {
        $meta_id = sanitize_text_field( $_POST['meta_id'] );
        $post_id = sanitize_text_field( $_POST['post_id'] );
        $meta_key = sanitize_text_field( $_POST['meta_key'] );
        $meta_value = sanitize_text_field( $_POST['meta_value'] );
    ?>
        <div class="alignleft actions daterangeactions">
            <form name='searchfilter'>
                <label for="daterange-actions-picker" class="screen-reader-text"><?=__('Filter', 'iw-stats')?></label>
                <input type="textfield" name="meta_id" id="meta_id" placeholder="Meta Id" value="<?php echo $meta_id ?>"/>
                <input type="textfield" name="post_id" id="post_id" placeholder="Post Id" value="<?php echo $post_id ?>"/>
                <input type="textfield" name="meta_key" id="meta_key" placeholder="Meta Key" value="<?php echo $meta_key ?>"/>
                <input type="textfield" name="meta_value" id="meta_value" placeholder="Meta Value" value="<?php echo $meta_value ?>"/>
                <?php wp_nonce_field( '' ); ?>
            <?php submit_button(__('Apply', 'iw-stats'), 'action', 'dodate', false); ?>
            </form>
        </div>
        <?php
    }
    /**
     * Set the views
     *
     * @return array
     */
    public function get_views() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=sample-page' );

        foreach ($this->counts as $key => $value) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( array( 'status' => $key ), $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {

        /*if ( ! isset( $_POST['Post_Submit_Option'] ) ) {
            return;
        }*/

        if (!empty($_POST) && ! wp_verify_nonce( $_POST['_wpnonce'], '' ) ) {
            die( __( 'Are you cheating?', '' ) );
        }

        $columns               = $this->get_columns();
        $hidden                = $this->get_hidden_columns();
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        if ( isset( $_REQUEST['s'] ) && !empty( $_REQUEST['s'] ) ) {
            $args['s'] = sanitize_text_field($_REQUEST['s']);
        }

        if ( isset( $_POST['meta_id'] ) && !empty( $_POST['meta_id'] ) ) {
            $args['meta_id'] = sanitize_text_field($_POST['meta_id']);
        }
        if ( isset( $_POST['post_id'] ) && !empty( $_POST['post_id'] ) ) {
            $args['post_id'] = sanitize_text_field($_POST['post_id']);
        }
        if ( isset( $_POST['meta_key'] ) && !empty( $_POST['meta_key'] ) ) {
            $args['meta_key'] = sanitize_text_field($_POST['meta_key']);
        }
        if ( isset( $_POST['meta_value'] ) && !empty( $_POST['meta_value'] ) ) {
            $args['meta_value'] = sanitize_text_field($_POST['meta_value']);
        }
        
        $this->items  = pm_get_all_post_meta( $args );

        $this->set_pagination_args( array(
            'total_items' => pm_get_post_meta_count(),
            'per_page'    => $per_page
        ) );
    }
}