<div class="wrap">
    <h1><?php _e( 'Delete Option', '' ); ?></h1>

    <?php $post_det = pm_get_post_meta( $meta_id ); ?>
    <?php 
        pm_delete_post_meta($meta_id);
        //swp_redirect(admin_url( 'admin.php?page=optionsmetadata' ));
        echo "<script>window.location.href='".admin_url( 'admin.php?page=postsmetadata&message=deleted' )."';</script>";
    ?>
</div>